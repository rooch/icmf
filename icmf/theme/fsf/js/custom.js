/* Slider */
function slideChange(args) {
	$('.sliderContainer .slideSelectors .item').removeClass('selected');
	$('.sliderContainer .slideSelectors .item:eq(' + (args.currentSlideNumber - 1) + ')').addClass('selected');
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

$(document).on('click', '.product .close', function(){
//	alert($(this).parent().parent().attr('id'));
	var arr=new Array();
	arr.push($(this).parent().parent());
	$('#listShop').masonry('hide', arr); 
//	$('#listShop').masonry('bindResize')
//	$('#listShop').masonry( 'hide',  ).masonry();
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
	if ($(this).scrollTop() > 28) {
		$('#topBar').addClass('topBar');
	}else{
		$('#topBar').removeClass('topBar');
	}
});

$('#goTop').live('click', function() {
	$.scrollTo('header', {duration:3000});
});

/* Image gallery */
$(document).on('click', '.otherImage', function(){
	$('.masterImage').attr('src', $(this).attr('src').replace(/80/g, "400"));
	$('.masterImage').elevateZoom({scrollZoom : true, zoomWindowPosition: 9, borderSize: 0, easing:true, responsive:true});
});

/* Order window */
$(document).on('click', '#orderButton', function(){
	switch ($(this).attr('rel')){
		case 'order':
			$('#orderForm').farajax('loader', '/crm/v_addObject/order');
			break;
		case 'wordpress':
			$('#orderForm').farajax('loader', '/crm/v_addObject/wordpress');
			break;
		case 'webdesign':
			$('#orderForm').farajax('loader', '/crm/v_addObject/webdesign');
			break;
		case 'cooperation':
			$('#orderForm').farajax('loader', '/crm/v_addObject/cooperation');
			break;
		case 'analysis':
			$('#orderForm').farajax('loader', '/crm/v_addObject/analysis');
			break;
		case 'seoOrder':
			$('#orderForm').farajax('loader', '/crm/v_addObject/seoOrder');
			break;
		case 'full':
			$('#orderForm').farajax('loader', '/crm/v_addObject/full');
			break;
		default:
			$('#orderForm').farajax('loader', '/crm/v_addObject/unknown');
			break;
	}
//	$(this).fadeOut('slow');
	$('#orderWindow').fadeIn('slow');
	$('#orderWindowClose').fadeIn('slow');
	$('#orderWindow').animate({ height:'350px' }, { queue:false, duration:500 });
	$.scrollTo('#orderForm', {duration:3000});
});

$(document).on('click', '#orderWindowClose', function(){
//	$('#orderButton').fadeIn('slow');
	$('#orderWindow').fadeOut('slow');
	$('#orderWindow').animate({ height:'0px' }, { queue:false, duration:500 });
});

/* eDelivery */
$(document).on('change', '#state', function(){
	if($(this).val() != ''){
		var citySection = $(this).closest('.basketObject').find('.citySection');
		var random = 1 + Math.floor(Math.random() * 100000);
		citySection.attr("id", "citySection" + random);
		$('#citySection' + random).farajax('loader', '/htmlElements/v_selectCity', 'name=city&sid=' + $(this).val());
	}
});

$(document).on('change', '#region', function(){
	if($(this).closest('.basketObject').find('.citySection>select').val() && $(this).val() != ''){
		var districtionSection = $(this).closest('.basketObject').find('.districtionSection');
		var random = 1 + Math.floor(Math.random() * 100000);
		districtionSection.attr("id", "districtionSection" + random);
		$('#districtionSection' + random).farajax('loader', '/htmlElements/v_selectDistrict', 'name=district&city=' + $('#city').val() + '&region=' + $(this).val());
	}
});

$(document).on('change', '.basketObject .input', function(){
	var sum = '';
	$('.basketObject .input').each(function() {
        sum = $(this).attr('id') + '=' + $(this).val() + '-' + sum;
    });
	$('#serialize').val(sum);
//	$('#confirmButton').fadeIn();
	$('#confirmButton').prop('disabled', false);
});

$(document).on('change', '#state1', function(){
	if($(this).val() != '')
	$('#citySection1').farajax('loader', '/htmlElements/v_selectCity', 'name=city1&sid=' + $(this).val());
});

$(document).on('change', '#city1', function(){
	if($('#region1').val() && $(this).val() != '')
	$('#districtSection1').farajax('loader', '/htmlElements/v_selectDistrict', 'name=district1&region=' + $('#region1').val() + '&city=' + $(this).val());
});

$(document).on('change', '#region1', function(){
	if($('#city1').val() && $(this).val() != '')
	$('#districtSection1').farajax('loader', '/htmlElements/v_selectDistrict', 'name=district1&city=' + $('#city1').val() + '&region=' + $(this).val());
});

$(document).on('change', '#state2', function(){
	if($(this).val() != '')
	$('#citySection2').farajax('loader', '/htmlElements/v_selectCity', 'name=city2&sid=' + $(this).val());
});

$(document).on('change', '#city2', function(){
	if($('#region2').val() && $(this).val() != '')
	$('#districtSection2').farajax('loader', '/htmlElements/v_selectDistrict', 'name=district2&region=' + $('#region2').val() + '&city=' + $(this).val());
});

$(document).on('change', '#region2', function(){
	if($('#city2').val() && $(this).val() != '')
	$('#districtSection2').farajax('loader', '/htmlElements/v_selectDistrict', 'name=district2&city=' + $('#city2').val() + '&region=' + $(this).val());
});

function masonry(){
	var $container = $('#listShop');
	// initialize
	$container.masonry({
		isOriginLeft: false,
		gutter: 10,
		itemSelector: '.product'
	});
}

/************************
 * Comment              *
 ************************/
$(document).on('click', '#openCommentBox', function(){
	$('#addCommentBox').toggle('slow', function(){
//		$('#addCommentBox').farajax('loader', '/comment/v_addObject');
//		$('#listCommentBox').farajax('loader', '/comment/c_listObject');
	});
});

/************************
 * Share                *
 ************************/
$(document).on('click', '#openShareBox', function(){
	$('#shareBox').toggle('slow', function(){
		startShare();
	});
});

/************************
 * CRM                  *
 ************************/
$(document).on('click', '#taskInfoSelector', function(){
	$('#taskInfo').fadeIn();
	$('#clientInfo').fadeOut();
	$('#clientHistory').fadeOut();
});

$(document).on('click', '#clientInfoSelector', function(){
	$('#taskInfo').fadeOut();
	$('#clientInfo').fadeIn();
	$('#clientHistory').fadeOut();
});

$(document).on('click', '#clientHistorySelector', function(){
	$('#taskInfo').fadeOut();
	$('#clientInfo').fadeOut();
	$('#clientHistory').fadeIn();
});

$(document).on('click', '#commentSelector', function(){
	$('#attachBox').fadeOut();
	$('#commentBox').fadeIn();
	$('#historyBox').fadeOut();
});

$(document).on('click', '#attachSelector', function(){
	$('#attachBox').fadeIn();
	$('#commentBox').fadeOut();
	$('#historyBox').fadeOut();
});

$(document).on('click', '#historySelector', function(){
	$('#attachBox').fadeOut();
	$('#commentBox').fadeOut();
	$('#historyBox').fadeIn();
});

/************************
 * Progress Bar         *
 ************************/
$(document).on('click', '#goProgress', function(){
	$('#analysisForm').fadeOut('slow', function(){
		$('#progressbar-1').progressbar({ value: 0 });
		$('#analysisProgress').fadeIn('slow', function(){
			var progressbar = $( '#progressbar-1' );
		    $( '#progressbar-1' ).progressbar( 'option', 'max', 100 );
		    function progress() {
		    	var val = progressbar.progressbar( 'value' ) || 0;
		    	progressbar.progressbar( 'value', val + 1 );
		    	if ( val < 30 ) {
		    		setTimeout( progress, 100 );
		    	}else if ( val >= 30 ) {
		    		setTimeout( progress, 350 );
		    	}else if ( val >= 40 ) {
		    		setTimeout( progress, 150 );
		    	}else if( val >= 50 && val < 80){
		    		setTimeout( progress, 400 );
		    	}else if(val >= 80 && val < 99){
		    		setTimeout( progress, 80 );
		    	}
		    }
		    setTimeout( progress, 1000 );
		});
	});
	$('.analysisSlogon').fadeOut('slow');
	$('#errorNumber').farajax('loader', 'seo/c_w3cValidate', 'websiteUrl=' + $('#websiteUrl').val());
});

function afterAnalysis() {
	if($('#err_num').val() != '' && $('#err_num').val() > 0) {
		
        $('#SEOReport').animate({ "background-color": "#e45335" }, { queue:false, duration:500 } );
        $('#analysisSlogon').fadeOut('slow');
		
	}else{
		$('#SEOReport').animate({ "background-color": "#1abc9c" }, { queue:false, duration:500 } );
		$('#analysisSlogon').fadeOut('slow');
	}
}

/************************
 * SeoCamReg            *
 ************************/
$(document).on('click', '#seoCamp button', function(){
	$('#campRegForm').css({"display":"block","opacity":0, "height": 0}).animate({"opacity":"1", "height": "450px"}, { queue:false, duration:500 } );
	$.scrollTo('#campRegForm', {duration:3000});
});

/************************
 * Button               *
 ************************/
//$(document).on('click', 'button, .button', function(){
//	var out = '';
//	var icmf = $(this).parents('icmf');
//	$('input, select, textarea', icmf).each(function(index){  
//		var input = $(this);
//		out += input.attr('id') + ': ' + input.val() + '\n';
//	});
//	alert(out);
//});
/************************
 * Tabs codes           *
 ************************/
$(document).on('click', '#tRadio', function(){
	$('#tabContent1').farajax('loader', 'post/c_showListObject/contentType=voice');
	$('.subTab1').removeClass('subTabClick');
	$(this).addClass('subTabClick');
});

$(document).on('click', '#tCinema', function(){
	$('#tabContent1').farajax('loader', 'post/c_showListObject/contentType=video');
	$('.subTab1').removeClass('subTabClick');
	$(this).addClass('subTabClick');
});

$(document).on('click', '#tSeoBox', function(){
	$('#tabContent1').farajax('loader', 'post/c_listObject/contentType=video');
	$('.subTab1').removeClass('subTabClick');
	$(this).addClass('subTabClick');
});

$(document).on('click', '#tForum', function(){
	$('#tabContent2').farajax('loader', 'forum/c_listObject');
	$('.subTab2').removeClass('subTabClick');
	$(this).addClass('subTabClick');
});

$(document).on('click', '#tTopPost', function(){
	$('#tabContent2').farajax('loader', 'post/c_showListObject/orderBy=viewCount');
	$('.subTab2').removeClass('subTabClick');
	$(this).addClass('subTabClick');
});

$(document).on('click', '#tComment', function(){
	$('#tabContent2').farajax('loader', 'comment/c_showListObjectSimple/op=post');
	$('.subTab2').removeClass('subTabClick');
	$(this).addClass('subTabClick');
});