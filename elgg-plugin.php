<?php

use ColdTrick\Wizard\Bootstrap;
use Elgg\Router\Middleware\AdminGatekeeper;
use \Elgg\Router\Middleware\Gatekeeper;

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
		'wizard/reset' => [
			'access' => 'admin',
		],
		'wizard/steps' => [],
		'wizard_step/edit' => [
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
			'middleware' => [
				Gatekeeper::class,
			],
		],
		'add:object:wizard' => [
			'path' => '/wizard/add/{guid?}',
			'resource' => 'wizard/add',
			'middleware' => [
				AdminGatekeeper::class,
			],
		],
		'edit:object:wizard' => [
			'path' => '/wizard/edit/{guid}',
			'resource' => 'wizard/edit',
			'middleware' => [
				AdminGatekeeper::class,
			],
		],
		'default:object:wizard' => [
			'path' => '/wizard/{title}',
			'controller' => '\ColdTrick\Wizard\Router::wizardRewrite',
			'middleware' => [
				Gatekeeper::class,
			],
		],
		'view:object:wizard_step' => [
			'path' => '/wizard_step/view/{guid}/{title?}',
			'resource' => 'wizard_step/view',
		],
		'add:object:wizard_step' => [
			'path' => '/wizard_step/add/{container_guid}',
			'resource' => 'wizard_step/add',
			'middleware' => [
				AdminGatekeeper::class,
			],
		],
		'edit:object:wizard_step' => [
			'path' => '/wizard_step/edit/{guid}',
			'resource' => 'wizard_step/edit',
			'middleware' => [
				AdminGatekeeper::class,
			],
		],
	],
];
