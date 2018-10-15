<?php
/**
 * All helper functions can be found here
 */

use Elgg\Database\QueryBuilder;
use Elgg\Database\Clauses\JoinClause;

/**
 * Apply all text replacements in wizard steps
 *
 * @param string $text the wizard step text
 *
 * @return false|string
 */
function wizard_replacements($text) {
	
	if (!is_string($text) || elgg_is_empty($text)) {
		return false;
	}
	
	$text = wizard_replace_profile_fields($text);
	$text = wizard_replace_user_fields($text);
	$text = wizard_replace_exit($text);
	
	return elgg_trigger_plugin_hook('replacements', 'wizard', ['text' => $text], $text);
}

/**
 * Replace profile field placeholders with input fields
 *
 * @param string $text the text to replace in
 *
 * @return false|string
 */
function wizard_replace_profile_fields($text) {
	
	if (!is_string($text) || elgg_is_empty($text)) {
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
 * Replace user field placeholders with user data
 *
 * @param string $text the text to replace in
 *
 * @return false|string
 */
function wizard_replace_user_fields($text) {
	
	if (!is_string($text) || elgg_is_empty($text)) {
		return false;
	}
	
	$user = elgg_get_logged_in_user_entity();
	if (empty($user)) {
		return $text;
	}
	
	$regex = '/{{user_([a-z0-9_-]+)}}/i';
	$matches = [];
	preg_match_all($regex, $text, $matches);
	
	if (empty($matches)) {
		return $text;
	}
	
	$placeholders = $matches[0];
	$user_fields = $matches[1];
	
	foreach ($placeholders as $index => $placeholder) {
		if (strpos($text, $placeholder) === false) {
			// already replaced
			continue;
		}
		
		$replacement = false;
		switch ($user_fields[$index]) {
			case 'name':
				$replacement = $user->name;
				break;
			case 'username':
				$replacement = $user->username;
				break;
			case 'guid':
				$replacement = $user->guid;
				break;
		}
		
		if ($replacement === false) {
			continue;
		}
		
		if (empty($replacement)) {
			elgg_log("Wizard unable to replace user placeholder: {$placeholder}", 'WARNING');
		} else {
			elgg_log("Wizard replace user placeholder: {$placeholder}");
		}
		
		$text = str_replace($placeholder, $replacement, $text);
	}
	
	return $text;
}

/**
 * Replace user field placeholders with user data
 *
 * @param string $text the text to replace in
 *
 * @return false|string
 */
function wizard_replace_exit($text) {
	
	if (!is_string($text) || elgg_is_empty($text)) {
		return false;
	}
	
	$regex = '/{{exit(\?\S+)?}}/i';
	$matches = [];
	preg_match_all($regex, $text, $matches);
	if (empty($matches)) {
		return $text;
	}
	
	$placeholders = $matches[0];
	$exit_config = $matches[1];
	
	foreach ($placeholders as $index => $placeholder) {
		if (strpos($text, $placeholder) === false) {
			// already replaced
			continue;
		}
		
		$replacement = elgg_normalize_url('action/wizard/steps');
		if (!empty($exit_config[$index])) {
			$config = $exit_config[$index];
			$config = ltrim($config, '?');
			
			$forward_url = elgg_normalize_url($config);
			
			$replacement = elgg_http_add_url_query_elements('action/wizard/steps', [
				'forward_url' => $forward_url,
			]);
			$replacement = elgg_normalize_url($replacement);
		}
		
		if (empty($replacement)) {
			elgg_log("Wizard unable to replace exit placeholder: {$placeholder}", 'WARNING');
		} else {
			elgg_log("Wizard replace exit placeholder: {$placeholder}");
		}
		
		$text = str_replace($placeholder, $replacement, $text);
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
	
	if (elgg_is_xhr()) {
		// only check on regular pages
		return;
	}
	if (elgg_in_context('wizard') || elgg_in_context('admin')) {
		// deadloop prevention and /admin is allowed
		return;
	}
	
	$SESSION = elgg_get_session();
	if ($SESSION->has('wizards')) {
		if ($SESSION->get('wizards') === true) {
			return;
		} else {
			foreach ($SESSION->get('wizards', []) as $index => $guid) {
				$wizard = get_entity($guid);
				if (!$wizard instanceof Wizard) {
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
	
	$join_on = function(QueryBuilder $qb, $joined_alias, $main_alias) {
		return $qb->compare("{$joined_alias}.entity_guid", '=', "{$main_alias}.guid");
	};
	
	$entities = elgg_get_entities([
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
			new JoinClause('metadata', 'mde', $join_on),
		],
		'wheres' => [
			function (QueryBuilder $qb, $main_alias) {
				$name = $qb->compare('mde.name', '=', 'endtime', ELGG_VALUE_STRING);
				
				$value1 = $qb->compare('mde.value', '=', 0, ELGG_VALUE_INTEGER);
				$value2 = $qb->compare('mde.value', '>', time(), ELGG_VALUE_INTEGER);
				
				$value = $qb->merge([$value1, $value2], 'OR');
				
				return $qb->merge([$name, $value]);
			},
			function (QueryBuilder $qb, $main_alias) use ($user) {
				
				$rel = $qb->subquery('entity_relationships')
					->select('guid_one')
					->where($qb->compare('relationship', '=', 'done', ELGG_VALUE_STRING))
					->andWhere($qb->compare('guid_two', '=', $user->guid, ELGG_VALUE_GUID));
				
				return $qb->compare("{$main_alias}.guid", 'NOT IN', $rel->getSQL());
			},
		],
	]);
	
	if (empty($entities)) {
		$SESSION->set('wizards', true);
		return;
	}
	
	$guids = [];
	$new_users_guids = [];
	$user_need_new_user_wizards = $user->getPrivateSetting('wizard_check_first_login_wizards');
	foreach ($entities as $e) {
		if ($e->show_users == 'new_users') {
			if ($user_need_new_user_wizards) {
				$new_users_guids[] = $e->guid;
			}
		} else {
			$guids[] = $e->guid;
		}
	}
	
	if (($user_need_new_user_wizards || $user_need_new_user_wizards === null) && empty($new_users_guids)) {
		// there are no more new user wizards to show, so report the user as done
		$user->setPrivateSetting('wizard_check_first_login_wizards', false);
	}
	
	if (empty($new_users_guids) && empty($guids)) {
		$SESSION->set('wizards', true);
		return;
	}
	
	if (!empty($new_users_guids)) {
		$SESSION->set('wizards', $new_users_guids);
	} else {
		$SESSION->set('wizards', $guids);
	}
	$wizards = $SESSION->get('wizards');
	return get_entity($wizards[0]);
}
