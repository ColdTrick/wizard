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
	$matches = [];
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
		
		$input = elgg_view('input/profile_field', [
			'name' => $profile_names[$index],
		]);
		
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
 * @return void|Wizard
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
	
	$SESSION = elgg_get_session();
	
	if (!$SESSION->has('wizards')) {
		if ($SESSION->get('wizards') === true) {
			return;
		} else {
			foreach ($SESSION->get('wizards', []) as $index => $guid) {
				$wizard = get_entity($guid);
				if (!($wizard instanceof Wizard)) {
					unset($SESSION['wizards'][$index]);
					continue;
				}
				return $wizard;
			}
			
			if ($SESSION->get('wizards')) {
				$SESSION->set('wizards', true);
			}
		}
	}
	
	$dbprefix = elgg_get_config('dbprefix');
	$endtime_id = elgg_get_metastring_id('endtime');
	
	$entities = elgg_get_entities_from_metadata([
		'type' => 'object',
		'subtype' => \Wizard::SUBTYPE,
		'limit' => false,
		'metadata_name_value_pairs' => [
			[
				'name' => 'starttime',
				'value' => time(),
				'operand' => '<=',
			],
		],
		'joins' => [
			"JOIN {$dbprefix}metadata mde ON e.guid = mde.entity_guid",
			"JOIN {$dbprefix}metastrings mse ON mde.value_id = mse.id",
		],
		'wheres' => [
			"(e.guid NOT IN (SELECT guid_one
				FROM {$dbprefix}entity_relationships
				WHERE relationship = 'done'
				AND guid_two = {$user->getGUID()}
			))",
			"(mde.name_id = {$endtime_id} AND mse.string = 0 OR mse.string > " . time() . ")",
		],
	]);
	
	if (empty($entities)) {
		$SESSION->set('wizards', true);
		return;
	}
	
	$guids = [];
	foreach ($entities as $e) {
		$guids[] = $e->getGUID();
	}
	$SESSION->set('wizards', $guids);
	
	return $entities[0];
}
