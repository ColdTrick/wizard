define(['jquery', 'elgg'], function ($, elgg) {
	
	var init = function() {
		$('#wizard-add-step').on('click', function() {
			var $clone = $('.wizard-edit-step-template').clone();
			$clone.removeAttr('class');
		
			var new_id = 'elgg-input-' + Math.floor((Math.random() * 10000) + 1);
			var old_id = $clone.find(' > textarea').attr('id');
		
			$clone.insertBefore($('.wizard-edit-step-template').siblings('a'));
		
			$clone.find(' > textarea').attr('id', new_id);
			$clone.find('.elgg-menu-item-tinymce-toggler > a').attr('href', '#' + new_id);
		
			// add editor to cloned plain text field
			tinyMCE.execCommand('mceAddControl', false, new_id);
			
			// prevent default click behaviour
			return false;
		});
	};
	
	elgg.register_hook_handler('init', 'system', init);
});