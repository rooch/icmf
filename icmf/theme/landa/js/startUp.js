$(document).ready(function(){
	// Dont edit this
	commands = $('commands').attr('value');
	if (typeof commands !== "undefined"){
		setTimeout(commands, 100);
	}
	/////////////////
	
	//newsTicker();
	$('#slider').nivoSlider();
	//$('#massMail').farajax('loader', '/mta/c_massMail');
	//$('#temp').farajax('loader', '/pageLoader/v_load/announce');
});