<?php

namespace ColdTrick\Wizard;

use Elgg\Values;

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
			'starttime' => Values::normalizeTimestamp('+1 day'),
			'endtime' => null,
			'display_mode' => 'full_screen',
			'show_users' => 'everybody',
			'user_can_close' => 0,
			'forward_url' => null,
			'days_after_account_creation' => null,
			'days_after_first_login' => null,
			'days_since_account_creation' => null,
			'account_created_after' => null,
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
