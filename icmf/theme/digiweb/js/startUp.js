$(document).ready(function(){
	// Dont edit this
	commands = $('commands').attr('value');
	if (typeof commands !== "undefined"){
		setTimeout(commands, 100);
	}
	/////////////////
	
	$('.tip').tipTip();

//	$('#temp').farajax('loader', '/pageLoader/v_load/announce');
	$('.iosSlider').iosSlider({
		desktopClickDrag: true,
		snapToChildren: true,
		navSlideSelector: '.sliderContainer .slideSelectors .item',
		onSlideComplete: slideComplete,
		onSliderLoaded: sliderLoaded,
		onSlideChange: slideChange,
		autoSlide: true,
		scrollbar: true,
		scrollbarContainer: '.sliderContainer .scrollbarContainer',
		scrollbarMargin: '0',
		scrollbarBorderRadius: '0'
	});
	
//	$('#listShop').isotope({
//		layoutMode : 'masonry',
//		itemSelector : '.product'
//	});
	
		var elem=$('.fo1');
    		var elem2=$('.fo2');
			wi = 200;
			wi2 = 100;
            setInterval(function(){
				elem.animate({width:wi+'%'},"slow");
				wi = wi-0.3;
				if(wi <= 100){wi = 200;}
			},1);
			setInterval(function(){
				elem2.animate({width:wi2+'%'},"slow");
				wi2 = wi2+0.2;
				if(wi2 >= 200){wi2 = 100;}
			},1);
			$('article.ser2').hover(function(){
				$('article.ser3').css('display','none');
			});
			$('article.ser2').mouseout(function(){
				$('article.ser3').css('display','block');
			});
			/*$('article.ser1').mouseover(function(){
				$('.serv1_left').fadeIn(500);
			});*/
			$('article.ser1').mouseout(function(){
				$('.serv1_left').hide();
			});
			
			
			/*---start  order scroll ---*/
			
			$(function () {
                // scroll body to 0px on click
                $('#a_level1').click(function () {
                    $('#order_main').animate({
                        scrollTop: 350
                    },400);
                    return false;
                });
            });
			
				$(function () {
                // scroll body to 0px on click
                $('#a_level2').click(function () {
                    $('#order_main').animate({
                        scrollTop: 660
                    },400);
                    return false;
                });
            });
				$(function () {
                // scroll body to 0px on click
                $('#a_level3').click(function () {
                    $('#order_main').animate({
                        scrollTop: 350
                    },400);
                    return false;
                });
            });
				$(function () {
                // scroll body to 0px on click
                $('#back_lev2').click(function () {
                    $('#order_main').animate({
                        scrollTop: 0
                    },400);
                    return false;
                });
            });
			/*---end  order scroll ---*/
		/*$(function () {
         $(window).scroll(function () {
               if ($(this).scrollTop() >= 2250) {
                  $('.team_in').delay(0).fadeIn("slow");
				  $('img.posi').fadeIn('slow');
			  }else{
				  $('img.posi').fadeOut('slow');	  
			  }
    });});*/
		$(function () {
         $(window).scroll(function () {
               if ($(this).scrollTop() >= 700) {
                  $('.demo_title1').delay(200);
				  $('.demo_title1').css('width','90%');
			  }else{
				  $('.demo_title1').css('width','28%');	  
			  }
    });});
		$(function () {
         $(window).scroll(function () {
               if ($(this).scrollTop() >= 1500) {
                  $('ip.lev1').delay(200);
				  $('p.lev1').fadeIn(200);
				  $('img.idea').delay(200);
				  $('img.idea').css('margin-top','10px');
			  }else{
				  $('p.lev1').fadeOut(200);	  
				  $('img.idea').css('margin-top','300px');
			  }
    });});
	
	
	$('img.posi').click(function () {
            $('body,html').animate({
                scrollTop: 0
           }, 800);
          return false;
     });
	
	if(window.location != "http://digiwebdesign.ir" || window.location != "http://digiwebdesign.ir/"){
		if($('#leftBox').width() == 0){
			$('#rightBox').animate({ "width": "68%" }, { queue:false, duration:500 } );
			$('#content').css('padding','36px 36px 0 36px');
			$('#leftBox').fadeIn('slow');
			$('#leftBox').animate({ "width": "30%" }, { queue:false, duration:500 } );
		}
	}
});
