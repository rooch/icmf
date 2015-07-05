/* Input direction set */
$('input').keyup(function(){
    $this = $(this);
    if($this.val().length == 1)    {
        var x =  new RegExp("[\x00-\x80]+"); 
        var isAscii = x.test($this.val());
        if(isAscii)
            $this.css("direction", "ltr");
        else
            $this.css("direction", "rtl");
    }
});
/* Menu */
$('#dropMenu').hover(function() {
	$('#specialMenu').fadeIn('slow');
	$(this).hover(function() {
	}, function() {
		$('#specialMenu').fadeOut('slow');
	});
});

/* Footer */
$('#footerHandler').hover(function() {
	$('#footer').animate({ height:'490px' }, { queue:false, duration:500 });
	$('#footer').hover(function() {
	}, function() {
		$('#footer').animate({ height:'40px' }, { queue:false, duration:500 });
	});
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

/* UserMan */
$('#userRegistration').live('click', function() {
	$('#coName').fadeOut(function() {
		$('#firstName').fadeIn();
	});
	$('#lastName').fadeIn();
});

$('#coRegistration').live('click', function() {
	$('#firstName').fadeOut(function() {
		$('#coName').fadeIn();
	}			
	);
	$('#lastName').fadeOut();
});

/* Auto Complete */
$('#postSearchList').keyup(function() {
	var text = $(this).val();
	if(text.length >= 2){
		$("#postSearchResult").css('background', 'url(load.gif);');
		$('#postSearchResult').slideDown();
		$('#postSearchResult').farajax('loader', '/post/c_showListObject/title=' + $('#postSearchList').val());
	}else{
		$('#postSearchResult').slideUp();
	}
});

/* Scroll pane */
$(window).scroll(function() {
	
	if ($(this).scrollTop() > 800) {
		$('#goTop').animate({ "right": "0px" }, { queue:false, duration:500 } );
	}else{
		$('#goTop').animate({ "right": "-50px" }, { queue:false, duration:500 } );
	}
});

$('#goTop').live('click', function() {
	$.scrollTo('#content', {duration:3000});
});

function postModuleInitial(){
	
//	createEditor('description', 'editorFullText');
//	$('fullText').hide();
	
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
	$('>.commentBox', this).fadeIn();
	startShare();
//	$('>.commentBox', this).farajax('loader', '/comment/v_addObject');
	$(this).hover(function() {
	}, function() {
		$(this).animate({ height:'20px' }, { queue:false, duration:500 });
		$('>.shareBox', this).fadeOut();
		$('>.commentBox', this).fadeOut();
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

/* Profile */
$('#systemInfoLink').live('click', function(){
	$('#personalInfo').hide(); 
	$('#contactInfo').hide(); 
	$('#changePassword').hide(); 
	$('#permissionInfo').hide(); 
	$('#systemInfo').show(); 
});

$('#personalInfoLink').live('click', function(){
	$('#systemInfo').hide();
	$('#contactInfo').hide();
	$('#permissionInfo').hide();
	$('#changePassword').hide(); 
	$('#personalInfo').show();
	$('#genderSelectBox').farajax('loader', '/htmlElements/v_selectGender', 'name=gender&selected=' + $('#profileId').val());
	$('#religionSelectBox').farajax('loader', '/htmlElements/v_selectReligion', 'name=religion&selected=' + $('#profileId').val());
	$('#levelSelectBox').farajax('loader', '/htmlElements/v_selectLevel', 'name=level&selected=' + $('#profileId').val());
	$('#nationalitySelectBox').farajax('loader', '/htmlElements/v_selectCountry', 'name=nationality&selected=' + $('#profileId').val());
	$('#stateSelectBox').farajax('loader', '/htmlElements/v_selectState', 'name=state&selected=' + $('#profileId').val());
	$('#statusSelectBox').farajax('loader', '/htmlElements/v_selectStatus', 'name=financialStatus&selected=' + $('#profileId').val());
});

$('#contactInfoLink').live('click', function(){
	$('#personalInfo').hide(); 
	$('#contactInfo').show(); 
	$('#changePassword').hide(); 
	$('#permissionInfo').hide(); 
	$('#systemInfo').hide(); 
});

$('#permissionInfoLink').live('click', function(){
	$('#personalInfo').hide(); 
	$('#contactInfo').hide(); 
	$('#changePassword').hide(); 
	$('#permissionInfo').show(); 
	$('#systemInfo').hide(); 
});

$('#changePasswordLink').live('click', function(){
	$('#personalInfo').hide(); 
	$('#contactInfo').hide(); 
	$('#changePassword').show(); 
	$('#permissionInfo').hide(); 
	$('#systemInfo').hide(); 
});

$('#editProfileLink').live('click', function(){
	$('.showProfile').hide(); $('.editProfile').show(); $(this).hide(); $('#showProfileLink').show();
	$('#submitProfile').fadeIn();
});

$('#showProfileLink').live('click', function(){
	$('.editProfile').hide(); $('.showProfile').show(); $(this).hide(); $('#editProfileLink').show();
});

$('#state').live('change', function(){
	if($(this).val() != ''){
		$('#citySelectBox').farajax('loader', '/htmlElements/v_selectCity', 'name=city&sid=' + $(this).val() + '&selected=' + $('#profileId').val());
	}
});

$('#wordpressSignupSeoButton').live('click', function(){
	$('#wordpressSingupSeoForm').farajax('loader', '/humanResource/v_addObject/wordpress');
	$(this).fadeOut('slow');
	$('#wordpressSingupSeo').fadeIn('slow');
	$('#wordpressSingupSeoFormClose').fadeIn('slow');
	$('#wordpressSingupSeo').animate({ height:'350px' }, { queue:false, duration:500 });
});

$('#wordpressSingupSeoFormClose').live('click', function(){
	$('#wordpressSignupSeoButton').fadeIn('slow');
	$('#wordpressSingupSeo').fadeOut('slow');
	$('#wordpressSingupSeo').animate({ height:'0px' }, { queue:false, duration:500 });
});
