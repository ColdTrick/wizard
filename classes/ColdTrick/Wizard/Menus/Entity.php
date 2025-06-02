<?php

namespace ColdTrick\Wizard\Menus;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the entity menu
 */
class Entity {
	
	/**
	 * Register menu items
	 *
	 * @param \Elgg\Event $event 'register', 'menu:entity'
	 *
	 * @return null|MenuItems
	 */
	public static function register(\Elgg\Event $event): ?MenuItems {
		/* @var $result MenuItems */
		$result = $event->getValue();
		
		$entity = $event->getEntityParam();
		if ($entity instanceof \Wizard) {
			return self::wizardEntityMenu($result, $entity);
		} elseif ($entity instanceof \WizardStep) {
			return self::wizardStepEntityMenu($result, $entity);
		}
		
		return null;
	}
	
	/**
	 * change menu items for Wizard entities
	 *
	 * @param MenuItems $returnvalue current menu items
	 * @param \Wizard   $entity      wizard entity
	 *
	 * @return MenuItems
	 */
	protected static function wizardEntityMenu(MenuItems $returnvalue, \Wizard $entity): MenuItems {
		if (!$entity->canEdit()) {
			return $returnvalue;
		}
		
		$edit_menu = $returnvalue->get('edit');
		if ($edit_menu instanceof \ElggMenuItem) {
			$edit_menu->addLinkClass('elgg-lightbox');
			
			$edit_menu->{'data-colorbox-opts'} = json_encode([
				'width' => '800px;',
			]);
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
	 * @param MenuItems   $returnvalue current menu items
	 * @param \WizardStep $entity      wizard entity
	 *
	 * @return MenuItems
	 */
	protected static function wizardStepEntityMenu(MenuItems $returnvalue, \WizardStep $entity): MenuItems {
		if (!$entity->canEdit()) {
			return $returnvalue;
		}
		
		$edit_menu = $returnvalue->get('edit');
		if ($edit_menu instanceof \ElggMenuItem) {
			$edit_menu->addLinkClass('elgg-lightbox');
			
			$edit_menu->{'data-colorbox-opts'} = json_encode([
				'width' => '800px;',
				'trapFocus' => false,
			]);
		}
		
		return $returnvalue;
	}
}
