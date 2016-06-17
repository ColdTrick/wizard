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
		
		$include_file = false;
		$pages_base = elgg_get_plugins_path() . 'wizard/pages/';

		switch ($page[0]) {
			case 'view':
				if (!empty($page[1]) && is_numeric($page[1])) {
					echo elgg_view_resource('wizard/view', ['guid' => $page[1]]);
					return true;
				}
				break;
			default:
				// try to find a wizard
				if (!empty($page[0])) {

					$entities = elgg_get_entities_from_metadata([
						'type' => 'object',
						'subtype' => \Wizard::SUBTYPE,
						'limit' => 1,
						'metadata_name_value_pairs' => ['friendly_title' => $page[0]],
					]);
					
					if (!empty($entities)) {
						echo elgg_view_resource('wizard/view', ['guid' => $entities[0]->getGUID()]);
						return true;
					}
				}
				
				break;
		}
	}
}