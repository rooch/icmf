function render() {
	$(".background").fullBg();
}

$(document).ready(function(){
	// Dont edit this
	commands = $('commands').attr('value');
	if (typeof commands !== "undefined"){
		setTimeout(commands, 100);
	}
	/////////////////
	
	newsTicker();
	//$('#temp').farajax('loader', '/pageLoader/v_load/announce');
	$(".background").fullBg();
	$('#background').cycle({ 
	    fx:     'fade', 
	    delay:  -4000,
	    timeout: 0, 
	    pager:  '#nav',
	    pagerAnchorBuilder: function(idx, slide) { 
	        return '<li id="selected"><h3><a href="' + slide.title + '">' + slide.alt + '</a></h3></li>'; 
	    },
	    after: render
	});
	$('#nav').spasticNav();
	
});