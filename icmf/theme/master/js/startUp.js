$(document).ready(function(){	
	// Dont edit this
	commands = $('commands').attr('value');
	if (typeof commands !== "undefined"){
		setTimeout(commands, 100);
	}
	/////////////////
	$('.tip').tipTip();

	$('#slider').nivoSlider();
	
	$(window).scroll(function() {

		if ($(this).scrollTop() > 800) {
			$("#goTop").css({
				right : "10px",
				bottom : "10px",
				display : "block",
				position : "fixed"
			});
			$('#goTop').fadeIn("slow");
		} else {
			$('#goTop').fadeOut("slow");
		}
	});
});