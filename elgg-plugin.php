<?php

use ColdTrick\Wizard\Bootstrap;

require_once(dirname(__FILE__) . '/lib/functions.php');

return [
	'bootstrap' => Bootstrap::class,
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'wizard',
			'class' => Wizard::class,
		],
		[
			'type' => 'object',
			'subtype' => 'wizard_step',
			'class' => WizardStep::class,
		],
	],
	'actions' => [
		'wizard/edit' => [
			'access' => 'admin',
		],
		'wizard/copy' => [
			'access' => 'admin',
		],
		'wizard/delete' => [
			'access' => 'admin',
		],
		'wizard/reset' => [
			'access' => 'admin',
		],
		'wizard/steps' => [],
		'wizard/upgrades/migrate_wizard_steps' => [ // @todo still needed??
			'access' => 'admin',
		],
		'wizard_step/edit' => [
			'access' => 'admin',
		],
		'wizard_step/delete' => [
			'access' => 'admin',
		],
		'wizard_step/reorder' => [
			'access' => 'admin',
		],
	],
	'routes' => [
		'view:object:wizard' => [
			'path' => '/wizard/view/{guid}/{title?}',
			'resource' => 'wizard/view',
		],
		'default:object:wizard' => [
			'path' => '/wizard/{title}',
			'controller' => '\ColdTrick\Wizard\Router::wizardRewrite',
		],
		'view:object:wizard_step' => [
			'path' => '/wizard_step/view/{guid}/{title?}',
			'resource' => 'wizard_step/view',
		],
		'add:object:wizard_step' => [
			'path' => '/wizard_step/add/{container_guid}',
			'resource' => 'wizard_step/view',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],
	],
];
