<?php

namespace ColdTrick\Wizard;

use Elgg\PageNotFoundException;
use Elgg\Http\ResponseBuilder;
use Elgg\HttpException;

class Router {
	
	/**
	 * Check if we can serve a wizard page
	 *
	 * @param \Elgg\Request $request the current page request /wizard/{title}
	 *
	 * @throws HttpException
	 * @return ResponseBuilder
	 */
	public static function wizardRewrite(\Elgg\Request $request) {
		
		$title = $request->getParam('title');
		if (elgg_is_empty($title)) {
			throw new PageNotFoundException();
		}
		
		$entities = elgg_get_entities([
			'type' => 'object',
			'subtype' => \Wizard::SUBTYPE,
			'limit' => 1,
			'metadata_name_value_pairs' => [
				'name' => 'friendly_title',
				'value' => $title,
			],
		]);
		if (empty($entities)) {
			throw new PageNotFoundException();
		}
		
		/* @var $entity \Wizard */
		$entity = $entities[0];
		
		$result = elgg_view_resource('wizard/view', [
			'guid' => $entity->guid,
		]);
		
		return elgg_ok_response($result);
	}
}
