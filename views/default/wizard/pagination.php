<?php

$entity = elgg_extract('entity', $vars);
$steps = (array) elgg_extract('steps', $vars);

$count = count($steps);

echo '<div ' . elgg_format_attributes(array('class' => 'elgg-foot')) . '>';
if ($count > 1) {
	
	echo '<ul class="elgg-pagination float man">';
	foreach ($steps as $index => $step) {
		$attrs = array(
			'data-step' => $index
		);
		
		if ($index === 0) {
			$attrs['class'] = 'elgg-state-selected';
		} else {
			$attrs['class'] = 'elgg-state-disabled';
		}
		
		echo '<li ' . elgg_format_attributes($attrs) . '>';
		echo '<a href="#" onclick="elgg.wizard.step(' . $index . ')">' . ($index + 1) . '</a>';
		echo '<span>' . ($index + 1) . '</span>';
		echo '</li>';
	}
	echo '</ul>';
	
	echo elgg_view('input/button', array(
		'value' => elgg_echo('next'),
		'class' => 'elgg-button-action float-alt',
		'onclick' => "elgg.wizard.nextStep();"
	));
	
	echo elgg_view('input/submit', array(
		'value' => elgg_echo('wizard:finish'),
		'class' => 'elgg-button-submit float-alt hidden',
	));
} else {
	echo elgg_view('input/submit', array(
		'value' => elgg_echo('wizard:finish'),
		'class' => 'elgg-button-submit float-alt',
	));
}
echo '</div>'; // end navigation