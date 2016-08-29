<?php
/**
 * Show one step
 */

/* @var $entity WizardStep */
$entity = elgg_extract('value', $vars);
if (empty($entity)) {
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
$value = wizard_replacements($entity->description);
if ($value === false) {
	return;
}

echo '<div ' . elgg_format_attributes($attrs) . '>';

if (!empty($entity->title)) {
	echo elgg_format_element('h3', [], $entity->title);
}

echo '<div class="elgg-output">';
echo elgg_autop($value);
echo '</div>';

echo '</div>';
