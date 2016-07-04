<?php
/**
 * Main plugin file
 */

require_once(dirname(__FILE__) . '/lib/functions.php');

// register default Elgg events
elgg_register_event_handler('init', 'system', 'wizard_init');

elgg_register_plugin_hook_handler('route:rewrite', 'wizard', '\ColdTrick\Wizard\PageHandler::wizardRewrite');

/**
 * Called during system init
 *
 * @return void
 */
function wizard_init() {
	
	// page handler for nice urls
	elgg_register_page_handler('wizard', '\ColdTrick\Wizard\PageHandler::wizard');
	elgg_register_page_handler('wizard_step', '\ColdTrick\Wizard\PageHandler::wizardStep');
	
	// CSS/JS
	elgg_extend_view('css/admin', 'css/wizard/admin.css');
	elgg_extend_view('css/elgg', 'css/wizard/site.css');
	elgg_extend_view('js/elgg', 'js/wizard/site.js');
	
	elgg_extend_view('page/elements/head', 'wizard/check_wizards');
	
	// register plugin hooks
	elgg_register_plugin_hook_handler('register', 'menu:page', '\ColdTrick\Wizard\Menus::registerAdminPageMenu');
	elgg_register_plugin_hook_handler('register', 'menu:entity', '\ColdTrick\Wizard\Menus::registerEntityMenu');
	
	// register events
	elgg_register_event_handler('upgrade', 'system', '\ColdTrick\Wizard\Upgrade::fixClasses');
	elgg_register_event_handler('upgrade', 'system', '\ColdTrick\Wizard\Upgrade::migrateSteps');
	
	// register actions
	elgg_register_action('wizard/edit', dirname(__FILE__) . '/actions/wizard/edit.php', 'admin');
	elgg_register_action('wizard/delete', dirname(__FILE__) . '/actions/wizard/delete.php', 'admin');
	
	elgg_register_action('wizard_step/edit', dirname(__FILE__) . '/actions/wizard_step/edit.php', 'admin');
	elgg_register_action('wizard_step/delete', dirname(__FILE__) . '/actions/wizard_step/delete.php', 'admin');
	
	elgg_register_action('wizard/reset', dirname(__FILE__) . '/actions/wizard/reset.php', 'admin');
	elgg_register_action('wizard/upgrades/migrate_wizard_steps', dirname(__FILE__) . '/actions/upgrades/migrate_wizard_steps.php', 'admin');
	
	elgg_register_action('wizard/steps', dirname(__FILE__) . '/actions/steps.php');
	
}
