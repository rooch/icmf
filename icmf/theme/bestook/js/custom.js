function my_kwicks(){
    $('.kwicks').kwicks({
		duration: 300,   
        max: 200,  
        spacing:  0  
    });
} 

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

function postModuleInitial(){
	
	$('#category').mcDropdown('#categorymenu');
	
	/* VideoContent Slide */
	$('#videoContent').hover(function() {
		$(this).animate({opacity:'1.0'});
		$(this).hover(function() {
		}, function() {
			$(this).animate({ opacity:'0.8' });
		});
	});
	
	/* ImageContent Slide */
	$('#imageContent').hover(function() {
		$(this).animate({opacity:'1.0'});
		$(this).hover(function() {
		}, function() {
			$(this).animate({ opacity:'0.8' });
		});
	});
	
	/* VoiceContent Slide */
	$('#voiceContent').hover(function() {
		$(this).animate({opacity:'1.0'});
		$(this).hover(function() {
		}, function() {
			$(this).animate({ opacity:'0.8' });
		});
	});
	
	/* TextContent Slide */
	$('#textContent').hover(function() {
		$(this).animate({opacity:'1.0'});
		$(this).hover(function() {
		}, function() {
			$(this).animate({opacity:'0.8'});
		});
	});
	
	/* VideoContent Click */
	$('#videoContent').live('click', function() {
		$('#postContentEntry').slideDown('slow'); 
		$(this).css({background: '#efc4c4'});
		$('#imageContent').css({background: '#efefef'});
		$('#voiceContent').css({background: '#efefef'});
		$('#textContent').css({background: '#efefef'});
		$('#contentType').val('video');
		$('#uploader').fadeIn('slow');
	});
	
	/* ImageContent Click */
	$('#imageContent').live('click', function() {
		$('#postContentEntry').slideDown('slow'); 
		$('#videoContent').css({background: '#efefef'});
		$(this).css({background: '#efc4c4'});
		$('#voiceContent').css({background: '#efefef'});
		$('#textContent').css({background: '#efefef'});
		$('#contentType').val('image');
		$('#uploader').fadeIn('slow');
	});
	
	/* VoiceConten Click */
	$('#voiceContent').live('click', function() {
		$('#postContentEntry').slideDown('slow'); 
		$('#videoContent').css({background: '#efefef'});
		$('#imageContent').css({background: '#efefef'});
		$(this).css({background: '#efc4c4'});
		$('#textContent').css({background: '#efefef'});
		$('#contentType').val('voice');
		$('#uploader').fadeIn('slow');
	});
	
	/* TextContent Click */
	$('#textContent').live('click', function() {
		$('#postContentEntry').slideDown('slow'); 
		$('#videoContent').css({background: '#efefef'});
		$('#imageContent').css({background: '#efefef'});
		$('#voiceContent').css({background: '#efefef'});
		$(this).css({background: '#efc4c4'});
		$('#contentType').val('text');
		$('#uploader').fadeOut('slow');
	});
	
	/* Time Slide */
	$('#setTime').live('click', function() {
		$('#sourcePanel').slideUp();
		$('#attachPanel').slideUp();
		$('#timePanel').slideDown('slow');
	});
	
	/* Source Slide */
	$('#setSource').live('click', function() {
		$('#timePanel').slideUp();
		$('#attachPanel').slideUp();
		$('#sourcePanel').slideDown('slow');
	});
	
	/* Attach Slide */
	$('#setAttach').live('click', function() {
		$('#timePanel').slideUp();
		$('#sourcePanel').slideUp();
		$('#attachPanel').slideDown('slow');
	});
}

/* Share & Comment */
//$('.shareCommentBox').hover(function() {
//	$(this).animate({ height:'200px' }, { queue:false, duration:500 });
//	$('>.shareBox', this).fadeIn();
////	$('>.commentBox', this).fadeIn();
//	startShare();
////	$('>.commentBox', this).farajax('loader', '/comment/v_addObject');
//	$(this).hover(function() {
//	}, function() {
//		$(this).animate({ height:'20px' }, { queue:false, duration:500 });
//		$('>.shareBox', this).fadeOut();
////		$('>.commentBox', this).fadeOut();
//	});
//});

/* UserMan */
$('#userRegistration').live('click', function() {
	$('#coName').fadeOut(function() {
		$('#firstName').fadeIn();
	}			
	);
	$('#lastName').fadeIn();
});

$('#coRegistration').live('click', function() {
	$('#firstName').fadeOut(function() {
		$('#coName').fadeIn();
	}			
	);
	$('#lastName').fadeOut();
});

/* Shop */
$('#shopCategoryText').hover(function() {
	$('#shopCategoryMenu').slideDown('slow');
	$('#categorySearchBox').removeClass('curvedFull');
	$('#categorySearchBox').addClass('curvedNoBottomRight');
	$(this).hover(function() {
	}, function() {
		$('#shopCategoryMenu').slideUp(function() {
			$('#categorySearchBox').removeClass('curvedNoBottomRight');
			$('#categorySearchBox').addClass('curvedFull');
		});
	});
});

$('#shopSearchText').hover(function() {
	$('#shopSearchMenu').slideDown('slow');
	$('#categorySearchBox').removeClass('curvedFull');
	$('#categorySearchBox').addClass('curvedNoBottomLeft');
	$(this).hover(function() {
	}, function() {
		$('#shopSearchMenu').slideUp(function() {
			$('#categorySearchBox').removeClass('curvedNoBottomLeft');
			$('#categorySearchBox').addClass('curvedFull');
		});
	});
});

$('.product').hover(function() {
	$('>.glassOverlay', this).fadeIn();
	$(this).hover(function() {
	}, function() {
		$('>.glassOverlay', this).fadeOut();
	});
	$('>.glassOverlay', this).click(function(){$(this).fadeOut();});
});

$('#aghsatBox').hover(function() {
	$('#aghsatYellowBox').animate({ height:'170px' }, { queue:false, duration:500 });
	$('#aghsatBox').hover(function() {
	}, function() {
		$('#aghsatYellowBox').animate({ height:'20px' }, { queue:false, duration:500 });
	});
});

$('#insuranceBox').hover(function() {
	$('#insuranceYellowBox').animate({ height:'170px' }, { queue:false, duration:500 });
	$('#insuranceBox').hover(function() {
	}, function() {
		$('#insuranceYellowBox').animate({ height:'20px' }, { queue:false, duration:500 });
	});
});

$('#shoppingBox').hover(function() {
	$('#shoppingYellowBox').animate({ height:'170px' }, { queue:false, duration:500 });
	$('#shoppingBox').hover(function() {
	}, function() {
		$('#shoppingYellowBox').animate({ height:'20px' }, { queue:false, duration:500 });
	});
});