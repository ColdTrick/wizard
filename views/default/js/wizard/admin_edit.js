define(['jquery', 'elgg/Ajax', 'jquery-ui/widgets/sortable'], function ($, Ajax) {

	var ajax = new Ajax();

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

			ajax.action('wizard_step/reorder', {
				data: {
					guids: guids
				}
			});
		}
	});
});
