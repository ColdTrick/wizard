<?php
/**
 * Main plugin file
 */

require_once(dirname(__FILE__) . '/lib/functions.php');
require_once(dirname(__FILE__) . '/lib/events.php');
require_once(dirname(__FILE__) . '/lib/hooks.php');
require_once(dirname(__FILE__) . '/lib/page_handlers.php');

// register default Elgg events
elgg_register_event_handler('init', 'system', 'wizard_init');

/**
 * Called during system init
 *
 * @return void
 */
function wizard_init() {
	
	// page handler for nice urls
	elgg_register_page_handler('wizard', 'wizard_page_handler');
	
	// CSS/JS
	elgg_extend_view('css/admin', 'css/wizard/admin');
	elgg_extend_view('css/elgg', 'css/wizard/site');
	elgg_extend_view('js/admin', 'js/wizard/admin');
	elgg_extend_view('js/elgg', 'js/wizard/site');
	
	elgg_extend_view('page/default', 'wizard/check_wizards', 200);
	
	// register plugin hooks
	elgg_register_plugin_hook_handler('register', 'menu:page', 'wizard_register_admin_page_menu');
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'wizard_register_wizard_entity_menu');
	
	// register events
	elgg_register_event_handler('upgrade', 'system', 'wizard_upgrade_system_handler');
	
	// register actions
	elgg_register_action('wizard/edit', dirname(__FILE__) . '/actions/edit.php', 'admin');
	elgg_register_action('wizard/delete', dirname(__FILE__) . '/actions/delete.php', 'admin');
	elgg_register_action('wizard/steps', dirname(__FILE__) . '/actions/steps.php');
	elgg_register_action('wizard/reset', dirname(__FILE__) . '/actions/reset.php', 'admin');
}
