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
					set_input('guid', $page[1]);
					
					$include_file = "{$pages_base}view.php";
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
						set_input('guid', $entities[0]->getGUID());
						
						$include_file = "{$pages_base}view.php";
					}
				}
				
				break;
		}
		
		if (!empty($include_file)) {
			include($include_file);
			return true;
		}
		
		return false;
	}
}