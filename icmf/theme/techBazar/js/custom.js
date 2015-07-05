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

$('.product .close').live('click', function(){
//	alert($(this).parent().parent().attr('id'));
	var arr=new Array();
	arr.push($(this).parent().parent());
	$('#listShop').masonry('hide', arr); 
//	$('#listShop').masonry('bindResize')
//	$('#listShop').masonry( 'hide',  ).masonry();
});

/* Share & Comment */
$(document).on("mouseenter", "'.shareCommentBox'", function() {
	$(this).animate({ height:'100px' }, { queue:false, duration:500 });
	$('>.shareBox', this).fadeIn();
//	$('>.commentBox', this).fadeIn();
	startShare();
//	$('>.commentBox', this).farajax('loader', '/comment/v_addObject');
}).on("mouseleave", ".shareCommentBox", function () {
	$(this).animate({ height:'20px' }, { queue:false, duration:500 });
	$('>.shareBox', this).fadeOut();
//	$('>.commentBox', this).fadeOut();
});

/* Post search auto Complete */
$('#postSearchList').keyup(function() {
	var text = $(this).val();
	if(text.length >= 2){
		$("#postSearchResult").css('background', 'url(load.gif);');
		$('#postSearchResult').slideDown();
		$('#postSearchResult').farajax('loader', '/post/c_showTitleListObject/title=' + $('#postSearchList').val());
	}else{
		$('#postSearchResult').slideUp();
	}
});

/* Right side scroll panel and to side scroll panel */
$(window).scroll(function() {
	if ($(this).scrollTop() > 550) {
		$('#menu').addClass('topBar');
	}else{
		$('#menu').removeClass('topBar');
	}
	if ($(this).scrollTop() > 600) {
		$('#footer').animate({ height:'40px' }, { queue:false, duration:500 });
		$('#goTop').animate({ "right": "0px" }, { queue:false, duration:500 } );
	}else{
		$('#goTop').animate({ "right": "-40px" }, { queue:false, duration:500 } );
	}
});

$('#goTop').live('click', function() {
	$.scrollTo('header', {duration:3000});
});

/* Minimizer */
$('#minimizer').live('click', function(){
	var left = parseInt($('#leftBox').css("left"));
	if(left < 0){
		$('#footer').animate({ height:'40px' }, { queue:false, duration:500 });
		$('#leftBox').animate({ "left": "0px" }, { queue:false, duration:500 } );
		$("#minimizer").attr('class', 'minimizer minimizerSprite minimizer-tab-expanded-left');
	}else{
		$('#leftBox').animate({ "left": "-271px" }, { queue:false, duration:500 } );
		$("#minimizer").attr('class', 'minimizer minimizerSprite minimizer-tab-colapsed-left');
	}
});

/* Image gallery */
$('.otherImage').live('click', function(){
	$('.masterImage').attr('src', $(this).attr('src').replace(/80/g, "400"));
	$('.masterImage').elevateZoom({scrollZoom : true, zoomWindowPosition: 9, borderSize: 0, easing:true, responsive:true});
});

/* Order window */
$('#orderButton').live('click', function(){
	switch ($(this).attr('rel')){
	case 'order':
		$('#orderForm').farajax('loader', '/humanResource/v_addObject/order');
		break;
	case 'wordpress':
		$('#orderForm').farajax('loader', '/humanResource/v_addObject/wordpress');
		break;
	case 'webdesign':
		$('#orderForm').farajax('loader', '/humanResource/v_addObject/webdesign');
		break;
	case 'cooperation':
		$('#orderForm').farajax('loader', '/humanResource/v_addObject/cooperation');
		break;
	case 'analysis':
		$('#orderForm').farajax('loader', '/humanResource/v_addObject/analysis');
		break;
	default:
	case 'full':
		$('#orderForm').farajax('loader', '/humanResource/v_addObject/full');
		break;
	}
//	$(this).fadeOut('slow');
	$('#orderWindow').fadeIn('slow');
	$('#orderWindowClose').fadeIn('slow');
	$('#orderWindow').animate({ height:'350px' }, { queue:false, duration:500 });
});

$('#orderWindowClose').live('click', function(){
//	$('#orderButton').fadeIn('slow');
	$('#orderWindow').fadeOut('slow');
	$('#orderWindow').animate({ height:'0px' }, { queue:false, duration:500 });
});

/* Footer */
$('#footerHandler').hover(function() {
	$('#footer').animate({ height:'490px' }, { queue:false, duration:500 });
	$('#leftBox').animate({ "left": "-271px" }, { queue:false, duration:500 } );
	$("#minimizer").attr('class', 'minimizer minimizerSprite minimizer-tab-colapsed-left');
	$('#goTop').animate({ "right": "-40px" }, { queue:false, duration:500 } );
	$('#footer').hover(function() {
	}, function() {
		$('#footer').animate({ height:'40px' }, { queue:false, duration:500 });
	});
});