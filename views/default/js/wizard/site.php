<?php

?>
//<script>
elgg.provide('elgg.wizard');

elgg.wizard.step = function(step) {

	$('.wizard-step:visible .wizard-step-required').removeClass('wizard-step-required');
	
	var $inputs = $('.wizard-step:visible *[required][value=""]');
	if ($inputs.length) {
		$inputs.addClass('wizard-step-required');
		return false;
	}
		
	$('.wizard-step').hide();
	$('.wizard-step-' + step).show();
};
