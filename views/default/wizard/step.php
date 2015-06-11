<?php
/**
 * Show one step
 */

$value = elgg_extract('value', $vars);
if (empty($value)) {
	return;
}

$step = (int) elgg_extract('step', $vars);
$last = (bool) elgg_extract('last', $vars, false);

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

$attrs['class'][] = 'elgg-foot';
// navigation
echo '<div ' . elgg_format_attributes($attrs) . '>';
if (!$last) {
	echo elgg_view('input/button', array(
		'value' => elgg_echo('next'),
		'class' => 'elgg-button-action float-alt',
		'onclick' => "elgg.wizard.step({$step} + 1);"
	));
} else {
	echo elgg_view('input/submit', array(
		'value' => elgg_echo('wizard:finish'),
		'class' => 'elgg-button-submit float-alt',
	));
}
echo '</div>'; // end navigation