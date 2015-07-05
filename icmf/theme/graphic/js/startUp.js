
$(document).ready(function(){
	// Dont edit this
	commands = $('commands').attr('value');
	if (typeof commands !== "undefined"){
		setTimeout(commands, 100);
	}
	/////////////////
	
	$('.tip').tipTip();

//	$('#temp').farajax('loader', '/pageLoader/v_load/announce');
	$('#layerSlider').layerSlider({
		skinsPath : 'theme/graphic/style/layerSlider/skins/',
		skin : 'defaultskin'
	});
	$('#da-thumbs > li').each( function() { $(this).hoverdir(); } );
	
	// settings
	var $slider = $('.postSlider'); // class or id of carousel slider
	var $slide = 'li'; // could also use 'img' if you're not using a ul
	var $transition_time = 1000; // 1 second
	var $time_between_slides = 10000; // 10 seconds

	function slides() {
		return $slider.find($slide);
	}

	slides().fadeOut();

	// set active classes
	slides().first().addClass('active');
	slides().first().fadeIn($transition_time);

	// auto scroll 
	$interval = setInterval(function() {
		var $i = $slider.find($slide + '.active').index();

		slides().eq($i).removeClass('active');
		slides().eq($i).fadeOut($transition_time);

		if (slides().length == $i + 1)
			$i = -1; // loop to start

		slides().eq($i + 1).fadeIn($transition_time);
		slides().eq($i + 1).addClass('active');
	}, $transition_time + $time_between_slides);
});