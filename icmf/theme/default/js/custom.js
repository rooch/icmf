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