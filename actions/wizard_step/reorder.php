<?php

$guids = get_input('guids');

if (!is_array($guids)) {
	forward(REFERER);
}

$order = 1;
foreach ($guids as $guid) {
	$step = get_entity($guid);
	if (!($step instanceof \WizardStep)) {
		continue;
	}
	
	$step->order = $order;
	$order++;
}

forward(REFERER);
