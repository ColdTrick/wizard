<?php

use Elgg\Database\Delete;

$delete = Delete::fromTable('private_settings');

$e = $delete->subquery('entities');
$e->select('guid')
	->where($delete->compare('type', '=', 'user', ELGG_VALUE_STRING));

$md = $delete->subquery('metadata');
$md->select('entity_guid')
	->where($delete->compare('name', '=', 'last_login', ELGG_VALUE_STRING))
	->andWhere($delete->compare('value', '>', 0, ELGG_VALUE_INTEGER));

$delete->where($delete->compare('name', '=', 'wizard_check_first_login_wizards', ELGG_VALUE_STRING))
	->andWhere($delete->compare('entity_guid', 'in', $e->getSQL()))
	->andWhere($delete->compare('entity_guid', 'in', $md->getSQL()));

$delete->execute();

return elgg_ok_response('', elgg_echo('wizard:action:admin:repair_users:success'));
