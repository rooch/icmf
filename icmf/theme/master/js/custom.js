/* Menu */
$('#dropMenu').hover(function() {
	$('#specialMenu').fadeIn('slow');
	$(this).hover(function() {
	}, function() {
		$('#specialMenu').fadeOut('slow');
	});
});

$('#eCommerce').hover(function() {
	$('#eCommerceDropDown').fadeIn('slow');
	$(this).hover(function() {
	}, function() {
		$('#eCommerceDropDown').fadeOut('slow');
	});
});

/*Category Menu*/
$('#categoryMenuList li').hover(function () {
	$('section', this).stop().slideDown(100);
}, function () {
	$('section', this).stop().slideUp(100);
});

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
$('.shareCommentBox').hover(function() {
	$(this).animate({ height:'200px' }, { queue:false, duration:500 });
	$('>.shareBox', this).fadeIn();
//	$('>.commentBox', this).fadeIn();
	startShare();
//	$('>.commentBox', this).farajax('loader', '/comment/v_addObject');
	$(this).hover(function() {
	}, function() {
		$(this).animate({ height:'20px' }, { queue:false, duration:500 });
		$('>.shareBox', this).fadeOut();
//		$('>.commentBox', this).fadeOut();
	});
});

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
	$('>.glassOverlay', this).live('click', function(){$(this).fadeOut();});
});

/* Mansonry */
//var container = document.querySelector('#listShop');
//var msnry = new Masonry( container, {
//  // options
//  columnWidth: 227,
//  itemSelector: '.product'
//});

/* Auto Complete */
$('#searchList').keyup(function() {
	var text = $(this).val();
//    var isWordcharacter = text.match(/\w/);
	if(text.length >= 2 /*&& isWordcharacter*/){
		$("#searchResult").css('background', 'url(load.gif);');
		$('#searchResult').slideDown();
		$('#searchResult').farajax('loader', '/shop/v_searchListVitrin/base.name=' + $('#searchList').val());
	}else{
		$('#searchResult').slideUp();
	}
});

$('#searchResult').live('click', function() {
	$(this).slideUp();
});

$('#goTop').live('click', function() {
	$.scrollTo('#content', {duration:3000});
});

/* Footer */
$('#footerHandler').hover(function() {
	$('#footer').animate({ height:'490px' }, { queue:false, duration:500 });
	$('#footer').hover(function() {
	}, function() {
		$('#footer').animate({ height:'40px' }, { queue:false, duration:500 });
	});
});

/* eDelivery */
$('#state').change(function(){
	if($(this).val() != '')
	$('#citySection').farajax('loader', '/htmlElements/v_selectCity', 'name=city&sid=' + $(this).val());
});

$('#region').change(function(){
	if($(this).val() != '')
	$('#districtSection').farajax('loader', '/htmlElements/v_selectDistrict', 'name=district&city=' + $('#city').val() + '&region=' + $(this).val());
});

$('#state1').change(function(){
	if($(this).val() != '')
	$('#citySection1').farajax('loader', '/htmlElements/v_selectCity', 'name=city1&sid=' + $(this).val());
});

$('#city1').change(function(){
	if($('#region1').val() && $(this).val() != '')
	$('#districtSection1').farajax('loader', '/htmlElements/v_selectDistrict', 'name=district1&region=' + $('#region1').val() + '&city=' + $(this).val());
});

$('#region1').change(function(){
	if($('#city1').val() && $(this).val() != '')
	$('#districtSection1').farajax('loader', '/htmlElements/v_selectDistrict', 'name=district1&city=' + $('#city1').val() + '&region=' + $(this).val());
});

$('#state2').change(function(){
	if($(this).val() != '')
	$('#citySection2').farajax('loader', '/htmlElements/v_selectCity', 'name=city2&sid=' + $(this).val());
});

$('#city2').change(function(){
	if($('#region2').val() && $(this).val() != '')
	$('#districtSection2').farajax('loader', '/htmlElements/v_selectDistrict', 'name=district2&region=' + $('#region2').val() + '&city=' + $(this).val());
});

$('#region2').change(function(){
	if($('#city2').val() && $(this).val() != '')
	$('#districtSection2').farajax('loader', '/htmlElements/v_selectDistrict', 'name=district2&city=' + $('#city2').val() + '&region=' + $(this).val());
});