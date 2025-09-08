import 'jquery';
import 'jquery-ui';
import Ajax from 'elgg/Ajax';

$('.wizard-manage-steps').sortable({
	handle: '.elgg-icon-arrows-alt',
	axis: 'y',
	containment: 'parent',
	update: function(event, ui) {
		var guids = [];
		var guidString = '';
		$(this).find('> li').each(function(list_item) {
			guidString = $(this).attr('id');
			guidString = guidString.replace('elgg-object-', '');
			guids.push(guidString);
		});
		
		var ajax = new Ajax();
		ajax.action('wizard_step/reorder', {
			data: {
				guids: guids
			}
		});
	}
});
