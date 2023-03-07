<?php

namespace ColdTrick\Wizard;

use Elgg\Exceptions\Http\PageNotFoundException;
use Elgg\Exceptions\HttpException;
use Elgg\Http\ResponseBuilder;

/**
 * Route controller for /wizard/{title}
 */
class Router {
	
	/**
	 * Check if we can serve a wizard page
	 *
	 * @param \Elgg\Request $request the current page request /wizard/{title}
	 *
	 * @throws HttpException
	 * @return ResponseBuilder
	 */
	public function __invoke(\Elgg\Request $request) {
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
