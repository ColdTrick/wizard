<?php

namespace ColdTrick\Wizard;

class EditWizardStep {
	
	/**
	 * @var \WizardStep entity being edited
	 */
	protected $entity;
	
	/**
	 * @var \Wizard container
	 */
	protected $container;
	
	public function __construct(\Wizard $container, \WizardStep $entity = null) {
		$this->entity = $entity;
		$this->container= $container;
	}
	
	public function __invoke() {
				
		$result = [
			'title' => '',
			'description' => '',
			'container_guid' => $this->container->guid,
		];
		
		// edit
		if ($this->entity instanceof \WizardStep) {
			foreach ($result as $key => $value) {
				$result[$key] = $this->entity->$key;
			}
			
			$result['entity'] = $this->entity;
		}
		
		// sticky form
		$sticky = elgg_get_sticky_values('wizard_step/edit');
		if (!empty($sticky)) {
			foreach ($sticky as $key => $value) {
				$result[$key] = $value;
			}
			
			elgg_clear_sticky_form('wizard_step/edit');
		}
		
		return $result;
	}
}
