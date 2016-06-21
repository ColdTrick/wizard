<?php

$title = elgg_echo('wizard:add:title');

$form = elgg_view_form('wizard/edit', ['action' => 'action/wizard/edit']);

echo elgg_view_module('inline', $title, $form);
