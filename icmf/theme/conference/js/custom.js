/* Footer Slide */
$('#footer').hover(function() {
	$('#footer').animate({ height:'280px' }, { queue:false, duration:500 });
	$(this).hover(function() {
	}, function() {
		$('#footer').animate({ height:'40px' }, { queue:false, duration:500 });
	});
});

/* News Slide */
$('#marquee').hover(function() {
	$('#newsBox').fadeIn('slow');
	$('#marquee').animate({ height:'380px' }, { queue:false, duration:500 });
	$(this).hover(function() {
	}, function() {
		$('#marquee').animate({ height:'22px' }, { queue:false, duration:500 });
	});
});