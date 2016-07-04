<?php

$messages = elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));
$body = elgg_view('page/elements/body', $vars);

$body = <<<__BODY
<div class="elgg-page elgg-page-default elgg-page-wizard">
	<div class="elgg-page-messages">
		$messages
	</div>
	<div class="elgg-page-body">
		<div class="elgg-inner">
			$body
		</div>
	</div>

</div>
__BODY;

$body .= elgg_view('page/elements/foot');

$params = [
	'head' => elgg_view('page/elements/head', $vars['head']),
	'body' => $body,
];

if (isset($vars['body_attrs'])) {
	$params['body_attrs'] = $vars['body_attrs'];
}

echo elgg_view("page/elements/html", $params);
