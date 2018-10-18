<?php

namespace ColdTrick\Wizard;

class EditWizard {
	
	/**
	 * @var \Wizard entity being edited
	 */
	protected $entity;
	
	public function __construct(\Wizard $entity = null) {
		$this->entity = $entity;
	}
	
	public function __invoke() {
				
		$result = [
			'title' => '',
			'starttime' => time() + (24 * 60 * 60),
			'endtime' => null,
			'display_mode' => 'full_screen',
			'show_users' => 'everybody',
			'user_can_close' => 0,
			'forward_url' => null,
		];
		
		// edit
		if ($this->entity instanceof \Wizard) {
			foreach ($result as $key => $value) {
				$result[$key] = $this->entity->$key;
			}
			
			$result['entity'] = $this->entity;
		}
		
		// sticky form
		$sticky = elgg_get_sticky_values('wizard/edit');
		if (!empty($sticky)) {
			foreach ($sticky as $key => $value) {
				$result[$key] = $value;
			}
			
			elgg_clear_sticky_form('wizard/edit');
		}
		
		return $result;
	}
}
