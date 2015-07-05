$(document).ready(function() {
	// Dont edit this
	commands = $('commands').attr('value');
	if (typeof commands !== "undefined") {
		setTimeout(commands, 100);
	}
	// ///////////////

	$('.tip').tipTip();
	// $('#temp').farajax('loader', '/pageLoader/v_load/announce');
});