<?php
/**
 * All event handlers are bundled here
 */

/**
 * Listen to upgrade event
 *
 * @param string $event  the name of the event
 * @param string $type   the type of the event
 * @param mixed  $object supplied params
 *
 * @return void
 */
function wizard_upgrade_system_handler($event, $type, $object) {
	
	$id = get_subtype_id('object', Wizard::SUBTYPE);
	if (empty($id)) {
		// add subtype registration
		add_subtype('object', Wizard::SUBTYPE, 'Wizard');
	} elseif (get_subtype_class_from_id($id) !== 'Wizard') {
		// update subtype registration
		update_subtype('object', Wizard::SUBTYPE, 'Wizard');
	}
}