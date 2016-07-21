<?php

namespace ColdTrick\Wizard;

class User {
	
	/**
	 * Listen to login event
	 *
	 * @param string $event the name of the event
	 * @param string $type  the type of the event
	 * @param mixed  $user  the user that is logged in
	 *
	 * @return void
	 */
	public static function login($event, $type, $user) {
		if (!($user instanceof \ElggUser)) {
			return;
		}
		if (!empty($user->last_login)) {
			return;
		}

		// set flag to check for first login wizards
		$user->setPrivateSetting('wizard_check_first_login_wizards', true);
	}
}
