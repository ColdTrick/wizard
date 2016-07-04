<?php
/**
 * Check if the user needs to do a wizard
 */

$wizard = wizard_check_wizards();
if (!($wizard instanceof Wizard)) {
	return;
}

if ($wizard->display_mode !== 'overlay') {
	forward($wizard->getURL());
}
?>
<script>
	require(['jquery', 'elgg', 'lightbox'], function($, elgg, lightbox){

		$.colorbox({
			href: '<?php echo $wizard->getURL(); ?>',
			width: '80%',
			height: '90%',
			iframe: true,
			scrolling: false,
			open: true,
			overlayClose: false,
			escKey: false,
			closeButton: false
		});
	});
</script>