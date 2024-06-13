<?php
/**
 * Check if the user needs to do a wizard
 */

$wizard = wizard_check_wizards();
if (!$wizard instanceof \Wizard) {
	return;
}

$can_close = 'false';
if ($wizard->user_can_close) {
	// remove check from session... if user aborts the wizard will not trigger again during session
	$wizards = elgg_get_session()->get('wizards');
	$index = array_search($wizard->guid, $wizards);
	unset($wizards[$index]);
	if (empty($wizards)) {
		elgg_get_session()->set('wizards', true);
	} else {
		elgg_get_session()->set('wizards', $wizards);
	}
	
	$can_close = 'true';
}

if ($wizard->display_mode !== 'overlay') {
	_elgg_services()->responseFactory->redirect($wizard->getURL(), 'wizard');
	exit;
}

?>
<script type="module">
	import Ajax from 'elgg/Ajax';
	import lightbox from 'elgg/lightbox';
	
	var options = {
		width: '80%',
		height: '90%',
		maxWidth: '990px',
		trapFocus: false,
		open: true,
		overlayClose: <?= $can_close; ?>,
		escKey: <?= $can_close; ?>,
		closeButton: <?= $can_close; ?>
	};
	
	// so we get a loader
	lightbox.open(options);

	var ajax = new Ajax(false);
	ajax.view('wizard/lightbox', {
		data: {
			guid: <?= $wizard->guid; ?>
		},
		success: function(data) {
			options.html = data;
			lightbox.open(options);
		},
		error: function() {
			lightbox.close();
		}
	});
</script>
