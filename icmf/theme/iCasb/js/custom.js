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

/* NewsBox */
$('#newsListTitle').hover(function() {
	$(this).parent().find('#newsBox').slideDown('slow');
	$(this).parent().find('ul').fadeIn('fast');
	$('#marquee').addClass('boxShadow');
	$(this).parent().hover(function() {
	}, function() {
		$(this).parent().find('ul').fadeOut('fast');
		$(this).parent().find('#newsBox').slideUp('slow');
		$('#marquee').removeClass('boxShadow');
	});
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
	$('#voiceContent').click(function() {
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
	$('>.glassOverlay', this).click(function(){$(this).fadeOut();});
});