<?php
/**
 * Show one step
 */

$entity = elgg_extract('value', $vars);
if (!$entity instanceof \WizardStep) {
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

$content = '';
if (!empty($entity->title)) {
	$content .= elgg_format_element('h3', [], $entity->getDisplayName());
}

$content .= elgg_view('output/longtext', [
	'sanitize' => false,
	'value' => $value,
]);

echo elgg_format_element('div', $attrs, $content);
