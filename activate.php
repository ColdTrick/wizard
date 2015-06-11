<?php
/**
 * Register classes
 */

if (!get_subtype_id('object', Wizard::SUBTYPE)) {
	// new installation
	add_subtype('object', Wizard::SUBTYPE, 'Wizard');
} else {
	update_subtype('object', Wizard::SUBTYPE, 'Wizard');
}