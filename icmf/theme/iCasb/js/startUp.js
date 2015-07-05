$(document).ready(function(){	
	// Dont edit this
	commands = $('commands').attr('value');
	if (typeof commands !== "undefined"){
		setTimeout(commands, 100);
	}
	/////////////////
	$('.tip').tipTip();
//	$('#temp').farajax('loader', '/payPerClick/c_addObject');

	$(window).scroll(function() {

		if ($(this).scrollTop() > 200) {
			$("#relatedContent").css({
				right : "10px",
				bottom : "10px",
				display : "block",
				position : "fixed"
			});
			$('#relatedContent').fadeIn("slow");
		} else {
			$('#relatedContent').fadeOut("slow");
		}
	});
	
	$(function() {
		$("#tagCloud").jQCloud(word_array);
	});
});