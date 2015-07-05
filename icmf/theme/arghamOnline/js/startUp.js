$(document).ready(function() {
	// Dont edit this
	commands = $('commands').attr('value');
	if (typeof commands !== "undefined") {
		setTimeout(commands, 100);
	}
	/////////////////
	$('.tip').tipTip();

	newsTicker();
	// $('#temp').farajax('loader', '/pageLoader/v_load/announce');

	$('.iosSlider').iosSlider({
		desktopClickDrag : true,
		snapToChildren : true,
		navSlideSelector : '.sliderContainer .slideSelectors .item',
		onSlideComplete : slideComplete,
		onSliderLoaded : sliderLoaded,
		onSlideChange : slideChange,
		autoSlide : true,
		scrollbar : true,
		scrollbarContainer : '.sliderContainer .scrollbarContainer',
		scrollbarMargin : '0',
		scrollbarBorderRadius : '0'
	});

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
});