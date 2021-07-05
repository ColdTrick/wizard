<?php

$entity = elgg_extract('entity', $vars);
$steps = (array) elgg_extract('steps', $vars);

$count = count($steps);

$result = '';

if ($count > 1) {
	
	$result .= '<ul class="elgg-pagination float man">';
	foreach ($steps as $index => $step) {
		$attrs = [
			'data-step' => $index,
		];
		
		if ($index === 0) {
			$attrs['class'] = 'elgg-state-selected';
		} else {
			$attrs['class'] = 'elgg-state-disabled';
		}
		
		$li = elgg_view('output/url', [
			'href' => false,
			'text' => $index + 1,
		]);
		$li .= elgg_format_element('span', [], $index + 1);
		
		$result .= elgg_format_element('li', $attrs, $li);
	}
	$result .= '</ul>';
	
	$result .= elgg_view('input/button', [
		'value' => elgg_echo('next'),
		'class' => 'wizard-step-next elgg-button-action float-alt',
	]);
	
	$result .= elgg_view('input/submit', [
		'value' => elgg_echo('wizard:finish'),
		'class' => 'elgg-button-submit float-alt hidden',
	]);
} else {
	$result .= elgg_view('input/submit', [
		'value' => elgg_echo('wizard:finish'),
		'class' => 'elgg-button-submit float-alt',
	]);
}

echo elgg_format_element('div', ['class' => 'elgg-foot'], $result);
