<?php
/**
 * Register classes
 */

if (!get_subtype_id('object', \Wizard::SUBTYPE)) {
	// new installation
	add_subtype('object', \Wizard::SUBTYPE, 'Wizard');
} else {
	update_subtype('object', \Wizard::SUBTYPE, 'Wizard');
}

if (!get_subtype_id('object', \WizardStep::SUBTYPE)) {
	// new installation
	add_subtype('object', \WizardStep::SUBTYPE, 'WizardStep');
} else {
	update_subtype('object', \WizardStep::SUBTYPE, 'WizardStep');
}
