<?php

use Elgg\Router\Middleware\AdminGatekeeper;
use \Elgg\Router\Middleware\Gatekeeper;

require_once(dirname(__FILE__) . '/lib/functions.php');

return [
	'plugin' => [
		'version' => '8.1',
	],
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'wizard',
			'class' => Wizard::class,
			'capabilities' => [
				'commentable' => false,
			],
		],
		[
			'type' => 'object',
			'subtype' => 'wizard_step',
			'class' => WizardStep::class,
			'capabilities' => [
				'commentable' => false,
			],
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
		'wizard/admin/repair_users' => [
			'access' => 'admin',
		],
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
			'controller' => \ColdTrick\Wizard\Router::class,
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
	'events' => [
		'form:prepare:fields' => [
			'wizard/edit' => [
				\ColdTrick\Wizard\Forms\PrepareWizardFields::class => [],
			],
			'wizard_step/edit' => [
				\ColdTrick\Wizard\Forms\PrepareWizardStepFields::class => [],
			],
		],
		'login:first' => [
			'user' => [
				'ColdTrick\Wizard\User::firstLogin' => [],
			],
		],
		'register' => [
			'menu:admin_header' => [
				'ColdTrick\Wizard\Menus\AdminHeader::register' => [],
			],
			'menu:entity' => [
				'ColdTrick\Wizard\Menus\Entity::register' => [],
			],
		],
	],
	'upgrades' => [
		\ColdTrick\Wizard\Upgrades\MigrateFirstLogin::class,
	],
	'view_extensions' => [
		'admin.css' => [
			'css/wizard/admin.css' => [],
			'css/wizard/site.css' => [],
		],
		'elgg.css' => [
			'css/wizard/site.css' => [],
		],
		'page/elements/header' => [
			'wizard/check_wizards' => [],
		],
	],
	'view_options' => [
		'wizard/lightbox' => ['ajax' => true],
	],
];
