<?php

namespace ColdTrick\Wizard;

class Menus {
	
	/**
	 * Add menu items to the page menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:page'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerAdminPageMenu(\Elgg\Hook $hook) {
		
		if (!elgg_is_admin_logged_in() || !elgg_in_context('admin')) {
			return;
		}
		
		$result = $hook->getValue();
		
		$result[] = \ElggMenuItem::factory([
			'name' => 'wizard',
			'text' => elgg_echo('wizard:menu:admin'),
			'href' => 'admin/administer_utilities/wizard',
			'parent_name' => 'administer_utilities',
			'section' => 'administer',
		]);
		
		return $result;
	}
	
	/**
	 * Add menu items to the entity menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:entity'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerEntityMenu(\Elgg\Hook $hook) {

		$result = $hook->getValue();
		
		$entity = $hook->getEntityParam();
		if ($entity instanceof \Wizard) {
			return self::wizardEntityMenu($result, $entity);
		} elseif ($entity instanceof \WizardStep) {
			return self::wizardStepEntityMenu($result, $entity);
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
		
		foreach ($returnvalue as $index => $menu_item) {
			if ($menu_item->getName() !== 'edit') {
				continue;
			}
			
			$menu_item->addLinkClass('elgg-lightbox');
			
			$colorboxOpts = 'data-colorbox-opts';
			$menu_item->$colorboxOpts = json_encode([
				'width' => '800px;',
			]);
			
			break;
		}
		
		if (!$entity->canEdit()) {
			return $returnvalue;
		}
		
		$returnvalue[] = \ElggMenuItem::factory([
			'name' => 'copy',
			'icon' => 'copy',
			'text' => elgg_echo('wizard:copy'),
			'href' => elgg_generate_action_url('wizard/copy', [
				'guid' => $entity->guid,
			]),
		]);

		$returnvalue[] = \ElggMenuItem::factory([
			'name' => 'reset',
			'icon' => 'redo',
			'text' => elgg_echo('reset'),
			'href' => elgg_generate_action_url('wizard/reset', [
				'guid' => $entity->guid,
			]),
			'confirm' => elgg_echo('wizard:reset:confirm'),
		]);
		
		$returnvalue[] = \ElggMenuItem::factory([
			'name' => 'manage_steps',
			'icon' => 'shoe-prints',
			'text' => elgg_echo('admin:administer_utilities:wizard:manage_steps'),
			'href' => "admin/administer_utilities/wizard/manage_steps?guid={$entity->guid}",
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
		
		foreach ($returnvalue as $index => $menu_item) {
			if ($menu_item->getName() !== 'edit') {
				continue;
			}
			
			$menu_item->addLinkClass('elgg-lightbox');
			
			$colorboxOpts = 'data-colorbox-opts';
			$menu_item->$colorboxOpts = json_encode([
				'width' => '650px;',
				'trapFocus' => false,
			]);
			
			break;
		}
		
		return $returnvalue;
	}
}
