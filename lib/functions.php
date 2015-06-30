<?php
/**
 * All helper functions can be found here
 */

/**
 * Replace profile field placeholders with input fields
 *
 * @param string $text the text to replace in
 *
 * @return false|string
 */
function wizard_replace_profile_fields($text) {
	
	if (empty($text) || !is_string($text)) {
		return false;
	}
	
	$regex = '/{{profile_([a-z0-9_-]+)}}/i';
	$matches = array();
	preg_match_all($regex, $text, $matches);
	
	if (empty($matches)) {
		return $text;
	}
	
	$placeholders = $matches[0];
	$profile_names = $matches[1];
	
	foreach ($placeholders as $index => $placeholder) {
		if (strpos($text, $placeholder) === false) {
			// already replaced
			continue;
		}
		
		$input = elgg_view('input/profile_field', array(
			'name' => $profile_names[$index],
		));
		
		if (empty($input)) {
			elgg_log("Wizard unable to replace profile placeholder: {$placeholder}", 'WARNING');
		} else {
			elgg_log("Wizard replace profile placeholder: {$placeholder}");
		}
		
		$text = str_replace($placeholder, $input, $text);
	}
	
	return $text;
}

/**
 * Make sure users follow the wizard
 *
 * @return void
 */
function wizard_check_wizards() {
	
	$user = elgg_get_logged_in_user_entity();
	if (empty($user)) {
		// only logged in users
		return;
	}
	
	if (elgg_in_context('wizard') || elgg_in_context('admin')) {
		// deadloop prevention and /admin is allowed
		return;
	}
	
	if (!empty($_SESSION['wizards'])) {
		if ($_SESSION['wizards'] === true) {
			return;
		} else {
			foreach ($_SESSION['wizards'] as $index => $guid) {
				$wizard = get_entity($guid);
				if (empty($wizard) || !elgg_instanceof($wizard, 'object', Wizard::SUBTYPE)) {
					unset($_SESSION['wizards'][$index]);
					continue;
				}
				forward($wizard->getURL());
			}
			
			if (empty($_SESSION['wizards'])) {
				$_SESSION['wizards'] = true;
			}
		}
	}
	
	$dbprefix = elgg_get_config('dbprefix');
	$endtime_id = add_metastring('endtime');
	
	$options = array(
		'type' => 'object',
		'subtype' => Wizard::SUBTYPE,
		'limit' => false,
		'metadata_name_value_pairs' => array(
			array(
				'name' => 'starttime',
				'value' => time(),
				'operand' => '<='
			)
		),
		'joins' => array(
			"JOIN {$dbprefix}metadata mde ON e.guid = mde.entity_guid",
			"JOIN {$dbprefix}metastrings mse ON mde.value_id = mse.id"
		),
		'wheres' => array(
			"(e.guid NOT IN (SELECT guid_one
				FROM {$dbprefix}entity_relationships
				WHERE relationship = 'done'
				AND guid_two = {$user->getGUID()}
			))",
			"(mde.name_id = {$endtime_id} AND mse.string = 0 OR mse.string > " . time() . ")"
		)
	);
	$entities = elgg_get_entities_from_metadata($options);
	
	if (empty($entities)) {
		$_SESSION['wizards'] = true;
		return;
	}
	
	$_SESSION['wizards'] = array();
	foreach ($entities as $e) {
		$_SESSION['wizards'][] = $e->getGUID();
	}
	forward($entities[0]->getURL());
}
