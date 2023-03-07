<?php

namespace ColdTrick\Wizard\Forms;

/**
 * Prepare the fields for the wizard_step/edit form
 */
class PrepareWizardStepFields {
	
	/**
	 * Prepare form fields
	 *
	 * @param \Elgg\Event $event 'form:prepare:fields', 'wizard_step/edit'
	 *
	 * @return array
	 */
	public function __invoke(\Elgg\Event $event): array {
		$vars = $event->getValue();
		
		$result = [
			'title' => '',
			'description' => '',
			'container_guid' => null,
		];
		
		$container = elgg_extract('container', $vars);
		if ($container instanceof \Wizard) {
			$result['container_guid'] = $container->guid;
		}
		
		// edit
		$entity = elgg_extract('entity', $vars);
		if ($entity instanceof \WizardStep) {
			foreach ($result as $key => $value) {
				$result[$key] = $entity->$key;
			}
		}
		
		return array_merge($result, $vars);
	}
}
