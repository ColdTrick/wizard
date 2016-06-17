<?php

namespace ColdTrick\Wizard;

class Menus {
	
	/**
	 * Add menu items to the page menu
	 *
	 * @param string         $hook        the name of the hook
	 * @param string         $type        the type of the hook
	 * @param \ElggMenuItem[] $returnvalue current return value
	 * @param array          $params      supplied params
	 *
	 * @return \ElggMenuItem[]
	 */
	public static function registerAdminPageMenu($hook, $type, $returnvalue, $params) {
		
		if (!elgg_is_admin_logged_in() || !elgg_in_context('admin')) {
			return;
		}
		
		$returnvalue[] = \ElggMenuItem::factory([
			'name' => 'wizard',
			'text' => elgg_echo('wizard:menu:admin'),
			'href' => 'admin/administer_utilities/wizard',
			'parent_name' => 'administer_utilities',
			'section' => 'administer',
		]);
		
		return $returnvalue;
	}
	
	/**
	 * Add menu items to the entity menu
	 *
	 * @param string         $hook        the name of the hook
	 * @param string         $type        the type of the hook
	 * @param \ElggMenuItem[] $returnvalue current return value
	 * @param array          $params      supplied params
	 *
	 * @return \ElggMenuItem[]
	 */
	public static function registerEntityMenu($hook, $type, $returnvalue, $params) {

		$entity = elgg_extract('entity', $params);
		if (empty($entity) || !elgg_instanceof($entity, 'object', \Wizard::SUBTYPE)) {
			return;
		}
		
		$allowed_menu_items = [
			'access',
			'edit',
			'delete',
		];
		
		foreach ($returnvalue as $index => $menu_item) {
			$menu_name = $menu_item->getName();
			if (!in_array($menu_name, $allowed_menu_items)) {
				unset($returnvalue[$index]);
				continue;
			}
			
			if ($menu_name === 'edit') {
				$menu_item->setHref("admin/administer_utilities/wizard/edit?guid={$entity->getGUID()}");
			}
		}
		
		$returnvalue[] = \ElggMenuItem::factory([
			'name' => 'reset',
			'text' => elgg_echo('reset'),
			'href' => "action/wizard/reset?guid={$entity->getGUID()}",
			'confirm' => elgg_echo('wizard:reset:confirm'),
			'priority' => 100,
		]);
		
		return $returnvalue;
	}
}