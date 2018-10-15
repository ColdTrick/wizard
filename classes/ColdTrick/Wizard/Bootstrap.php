<?php

namespace ColdTrick\Wizard;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritDoc}
	 * @see \Elgg\DefaultPluginBootstrap::init()
	 */
	public function init() {
		
		$this->extendViews();
		$this->registerHooks();
	}
	
	/**
	 * {@inheritDoc}
	 * @see \Elgg\DefaultPluginBootstrap::upgrade()
	 *
	 * @todo still needed???
	 */
	public function upgrade(\Elgg\Event $event) {
		
		Upgrade::migrateSteps($event);
	}
	
	/**
	 * Extend views helper
	 *
	 * @return void
	 */
	protected function extendViews() {
		
		elgg_extend_view('admin.css', 'css/wizard/admin.css');
		elgg_extend_view('core.css', 'css/wizard/site.css');
		
		elgg_extend_view('page/elements/header', 'wizard/check_wizards');
	}
	
	/**
	 * Register event handlers helper
	 *
	 * @return void
	 */
	protected function registerEvents() {
		$events = $this->elgg()->events;
		
		$events->registerHandler('login:before', 'user', __NAMESPACE__ . '\User::login');
	}
	
	/**
	 * Register plugin hooks helper
	 *
	 * @return void
	 */
	protected function registerHooks() {
		$hooks = $this->elgg()->hooks;
		
		$hooks->registerHandler('register', 'menu:page', __NAMESPACE__ . '\Menus::registerAdminPageMenu');
		$hooks->registerHandler('register', 'menu:entity', __NAMESPACE__ . '\Menus::registerEntityMenu');
	}
}
