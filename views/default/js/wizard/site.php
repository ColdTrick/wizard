<?php

?>
//<script>
elgg.provide('elgg.wizard');

elgg.wizard.getCurrentStep = function() {
	var cur_step = $('.wizard-step:visible').attr('data-step');

	if (!cur_step) {
		cur_step = 0;
	}

	return parseInt(cur_step);
};

elgg.wizard.nextStep = function() {
	var cur_step = elgg.wizard.getCurrentStep();

	elgg.wizard.step(cur_step + 1);
};

elgg.wizard.step = function(step) {
	$('.wizard-step:visible .wizard-step-required').removeClass('wizard-step-required');
	
	var $inputs = $('.wizard-step:visible *[required][value=""]');
	if ($inputs.length) {
		$inputs.addClass('wizard-step-required');
		return false;
	}
		
	$('.wizard-step').hide();

	var $next_step = $('.wizard-step-' + step);
	$next_step.show();
	
	if ($next_step.next('.wizard-step').length === 0) {
		$('.elgg-form-wizard-steps .elgg-foot .elgg-button-action').hide();
		$('.elgg-form-wizard-steps .elgg-foot .elgg-button-submit').show();
	} else {
		$('.elgg-form-wizard-steps .elgg-foot .elgg-button-action').show();
		$('.elgg-form-wizard-steps .elgg-foot .elgg-button-submit').hide();
	}

	// update pagination
	elgg.wizard.updatePagination();
};

elgg.wizard.updatePagination = function() {
	var $pagination = $('.elgg-form-wizard-steps .elgg-pagination');
	if (!$pagination.length) {
		return;
	}
	
	var cur_step = elgg.wizard.getCurrentStep();

	var max_step = $pagination.find('li.elgg-state-selected').attr('data-step');
	
	$pagination.find('li').each(function(index, elem) {
		if (index <= max_step) {
			$(elem).find('a').attr('style', 'display: inline-block');
			$(elem).find('span').attr('style', 'display: none');
			$(elem).removeClass('elgg-state-disabled');
		}
	});

	$pagination.find('.elgg-state-selected').removeClass('elgg-state-selected');
	$pagination.find('li[data-step="' + cur_step + '"]').addClass('elgg-state-selected').find('a, span').attr('style', '');
};
