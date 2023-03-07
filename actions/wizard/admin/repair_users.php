<?php

/* @var $batch \ElggBatch */
$batch = elgg_get_entities([
	'type' => 'user',
	'limit' => false,
	'batch' => true,
	'batch_inc_offset' => false,
	'metadata_name_value_pairs' => [
		[
			'name' => 'last_login',
			'value' => 0,
			'operand' => '>',
		],
		[
			'name' => 'plugin:user_setting:wizard:check_first_login_wizards',
			'value' => true,
		],
	],
]);

/* @var $user \ElggUser */
foreach ($batch as $user) {
	if (!$user->removePluginSetting('wizard', 'check_first_login_wizards')) {
		$batch->reportFailure();
	}
}

return elgg_ok_response('', elgg_echo('wizard:action:admin:repair_users:success'));
