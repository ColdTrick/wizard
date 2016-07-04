<?php
/**
 * Show one step
 */

/* @var $value WizardStep */
$value = elgg_extract('value', $vars);
if (empty($value)) {
	return;
}

$step = (int) elgg_extract('step', $vars);
// $last = (bool) elgg_extract('last', $vars, false);

$attrs = [
	'data-step' => $step,
	'class' => ['wizard-step', "wizard-step-{$step}"],
];
if ($step !== 0) {
	$attrs['class'][] = 'hidden';
}

// content
$value = wizard_replacements($value->description);
if ($value === false) {
	return;
}

echo '<div ' . elgg_format_attributes($attrs) . '>';

echo '<div class="elgg-output">';
echo autop($value);
echo '</div>';

echo '</div>';
