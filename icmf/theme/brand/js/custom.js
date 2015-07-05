function price(objectId){
	var calc;
	
	checkBoxToggle(objectId);
//	alert(document.getElementById(objectId).value);
	if(document.getElementById(objectId).value == 1){
		calc = document.getElementById(objectId + 'Count').value * parseInt(document.getElementById(objectId + 'FI').innerHTML);
		document.getElementById('totalPrice').innerHTML = parseInt(document.getElementById('totalPrice').innerHTML) + calc;
	}else if(document.getElementById(objectId).value == 0){
		calc = document.getElementById(objectId + 'Count').value * parseInt(document.getElementById(objectId + 'FI').innerHTML);
		document.getElementById('totalPrice').innerHTML = parseInt(document.getElementById('totalPrice').innerHTML) - calc;
	}
	
}

/* NewsBox */
$('#newsListTitle').hover(function() {
	$(this).parent().find('#newsBox').slideDown('slow');
	$(this).parent().find('ul').fadeIn('fast');
	$(this).parent().hover(function() {
	}, function() {
		$(this).parent().find('ul').fadeOut('fast');
		$(this).parent().find('#newsBox').slideUp('slow');
	});
});

/* Slider */
function slideChange(args) {

	$('.sliderContainer .slideSelectors .item').removeClass('selected');
	$(
			'.sliderContainer .slideSelectors .item:eq('
					+ (args.currentSlideNumber - 1) + ')').addClass('selected');

}

function slideComplete(args) {

	if (!args.slideChanged)
		return false;

	$(args.sliderObject).find('.text1, .text2').attr('style', '');

	$(args.currentSlideObject).find('.text1').animate({
		right : '100px',
		opacity : '0.8'
	}, 400, 'easeOutQuint');

	$(args.currentSlideObject).find('.text2').delay(200).animate({
		right : '50px',
		opacity : '0.8'
	}, 400, 'easeOutQuint');

}

function sliderLoaded(args) {

	$(args.sliderObject).find('.text1, .text2').attr('style', '');

	$(args.currentSlideObject).find('.text1').animate({
		right : '100px',
		opacity : '0.8'
	}, 400, 'easeOutQuint');

	$(args.currentSlideObject).find('.text2').delay(200).animate({
		right : '50px',
		opacity : '0.8'
	}, 400, 'easeOutQuint');

	slideChange(args);

}