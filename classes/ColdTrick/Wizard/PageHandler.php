<?php

namespace ColdTrick\Wizard;

class PageHandler {
	
	/**
	 * Handle /wizard
	 *
	 * @param array $page url elements
	 *
	 * @return bool
	 */
	public static function wizard($page) {
		
		$resource_loaded = false;
		
		switch ($page[0]) {
			case 'view':
				if (!empty($page[1]) && is_numeric($page[1])) {
					echo elgg_view_resource('wizard/view', [
						'guid' => $page[1],
					]);
					
					$resource_loaded = true;
				}
				break;
		}
		
		return $resource_loaded;
	}
	
	/**
	 * Rewrite the /wizard/<wizard title> urls
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function wizardRewrite($hook, $type, $return_value, $params) {
		
		if (!is_array($return_value)) {
			// someone did something
			return;
		}
		
		$segments = elgg_extract('segments', $return_value);
		if (!is_array($segments) || count($segments) !== 1) {
			return;
		}
		
		$friendly_title = elgg_extract(0, $segments);
		$entities = elgg_get_entities_from_metadata([
			'type' => 'object',
			'subtype' => \Wizard::SUBTYPE,
			'limit' => 1,
			'metadata_name_value_pairs' => [
				'name' => 'friendly_title',
				'value' => $friendly_title,
			],
		]);
		if (empty($entities)) {
			return;
		}
		/* @var $entity \Wizard */
		$entity = $entities[0];
		
		$segments = [
			'view',
			$entity->getGUID(),
			$friendly_title,
		];
		
		$return_value['segments'] = $segments;
		return $return_value;
	}
}
