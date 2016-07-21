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
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerEntityMenu($hook, $type, $returnvalue, $params) {

		$entity = elgg_extract('entity', $params);
		if ($entity instanceof \Wizard) {
			return self::wizardEntityMenu($returnvalue, $entity);
		} elseif ($entity instanceof \WizardStep) {
			return self::wizardStepEntityMenu($returnvalue, $entity);
		}
	}
	
	/**
	 * change menu items for Wizard entities
	 *
	 * @param \ElggMenuItem[] $returnvalue current menu items
	 * @param \Wizard         $entity      wizard entity
	 *
	 * @return \ElggMenuItem[]
	 */
	protected static function wizardEntityMenu($returnvalue, \Wizard $entity) {
		
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
								
				$menu_item->setHref('admin/administer_utilities/wizard/manage?guid=' . $entity->guid);
			}
		}
		
		if (!$entity->canEdit()) {
			return $returnvalue;
		}
		
		$returnvalue[] = \ElggMenuItem::factory([
			'name' => 'copy',
			'text' => elgg_echo('wizard:copy'),
			'href' => "action/wizard/copy?guid={$entity->getGUID()}",
			'is_action' => true,
			'priority' => 100,
		]);

		$returnvalue[] = \ElggMenuItem::factory([
			'name' => 'reset',
			'text' => elgg_echo('reset'),
			'href' => "action/wizard/reset?guid={$entity->getGUID()}",
			'confirm' => elgg_echo('wizard:reset:confirm'),
			'priority' => 100,
		]);
		
		$returnvalue[] = \ElggMenuItem::factory([
			'name' => 'manage_steps',
			'text' => elgg_echo('admin:administer_utilities:wizard:manage_steps'),
			'href' => "admin/administer_utilities/wizard/manage_steps?guid={$entity->getGUID()}",
			'priority' => 150,
		]);
		
		return $returnvalue;
	}
	
	/**
	 * change menu items for WizardStep entities
	 *
	 * @param \ElggMenuItem[] $returnvalue current menu items
	 * @param \WizardStep     $entity      wizard entity
	 *
	 * @return \ElggMenuItem[]
	 */
	protected static function wizardStepEntityMenu($returnvalue, \WizardStep $entity) {
		
		$allowed_menu_items = [
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
				$menu_item->addLinkClass('elgg-lightbox');
				
				$colorboxOpts = 'data-colorbox-opts';
				$menu_item->$colorboxOpts = json_encode([
					'width' => '650px;',
				]);
			}
		}
		
		return $returnvalue;
	}
}
