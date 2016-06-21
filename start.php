<?php
/**
 * Main plugin file
 */

require_once(dirname(__FILE__) . '/lib/functions.php');

// register default Elgg events
elgg_register_event_handler('init', 'system', 'wizard_init');

/**
 * Called during system init
 *
 * @return void
 */
function wizard_init() {
	
	// page handler for nice urls
	elgg_register_page_handler('wizard', '\ColdTrick\Wizard\PageHandler::wizard');
	
	// CSS/JS
	elgg_extend_view('css/admin', 'css/wizard/admin');
	elgg_extend_view('css/elgg', 'css/wizard/site');
	elgg_extend_view('js/elgg', 'js/wizard/site');
	
	elgg_extend_view('page/default', 'wizard/check_wizards', 200);
	
	// register plugin hooks
	elgg_register_plugin_hook_handler('register', 'menu:page', '\ColdTrick\Wizard\Menus::registerAdminPageMenu');
	elgg_register_plugin_hook_handler('register', 'menu:entity', '\ColdTrick\Wizard\Menus::registerEntityMenu');
	
	// register events
	elgg_register_event_handler('upgrade', 'system', '\ColdTrick\Wizard\Upgrade::fixClasses');
	
	// register actions
	elgg_register_action('wizard/edit', dirname(__FILE__) . '/actions/edit.php', 'admin');
	elgg_register_action('wizard/delete', dirname(__FILE__) . '/actions/delete.php', 'admin');
	elgg_register_action('wizard/steps', dirname(__FILE__) . '/actions/steps.php');
	elgg_register_action('wizard/reset', dirname(__FILE__) . '/actions/reset.php', 'admin');
}
