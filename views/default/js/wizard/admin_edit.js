define(['jquery', 'elgg'], function ($, elgg) {
	
	var init = function() {
				
		$('.wizard-manage-steps').sortable({
			handle: '.elgg-icon-arrows',
			update: function(event, ui) {
				var guids = [];
				var guidString = '';
				$(this).find('> li').each(function(list_item) {
					guidString = $(this).attr('id');
					guidString = guidString.substr(12);
					guids.push(guidString);
				});

				elgg.action('wizard_step/reorder', {
					data: {
						guids: guids
					}
				});
			
			}
		});
	};
	
	elgg.register_hook_handler('init', 'system', init);
});