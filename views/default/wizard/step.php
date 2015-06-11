<?php
/**
 * Show one step
 */

$value = elgg_extract('value', $vars);
if (empty($value)) {
	return;
}

$step = (int) elgg_extract('step', $vars);
// $last = (bool) elgg_extract('last', $vars, false);

$attrs = array(
	'data-step' => $step,
	'class' => array('wizard-step', "wizard-step-{$step}"),
);
if ($step !== 0) {
	$attrs['class'][] = 'hidden';
}

echo '<div ' . elgg_format_attributes($attrs) . '>';

// content
$value = wizard_replace_profile_fields($value);

echo '<div class="elgg-output">';
echo autop($value);
echo '</div>';

echo '</div>';

