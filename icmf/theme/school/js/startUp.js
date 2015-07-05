$(document).ready(function() {
	// Dont edit this
	commands = $('commands').attr('value');
	if (typeof commands !== "undefined") {
		setTimeout(commands, 100);
	}
	/////////////////
	$('.tip').tipTip();

	var dockOptions =
    { 
			capSizing: true,
			size: 30,
			sizeMax: 30
    };
//	$('#menu1').jqDock(dockOptions);
	newsTicker();
	//$('#temp').farajax('loader', '/pageLoader/v_load/announce');
	$('#slider').nivoSlider();
//	$("#category").mcDropdown("#categorymenu");
});