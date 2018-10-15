<?php

$guids = get_input('guids');
if (!is_array($guids)) {
	return elgg_error_response();
}

$order = 1;
foreach ($guids as $guid) {
	$step = get_entity($guid);
	if (!$step instanceof \WizardStep) {
		continue;
	}
	
	$step->order = $order;
	$order++;
}

return elgg_ok_response();
