function pageTurn(){
	
	$(".interactive-p1").click(function () {			
				interactiveP1();
	});
	
	$(".interactive-p2").click(function () {			
				interactiveP2();
	});

	function interactiveP1(){
		
		 $(".interactiveBoxP1").show();
		 $(".interactiveBoxP2").hide();
		 
		 $(".interactive-p1").css({"background" : "url(img/interactive-btn-1.png)", "color":"#e6e457"});
		 $(".interactive-p2").css({"background" : "url(img/interactive-btn-2.png)", "color":"#ffffff"});

		 
	}
	
	function interactiveP2(){
		
		 $(".interactiveBoxP2").show();
		 $(".interactiveBoxP1").hide();
		 
		 $(".interactive-p2").css({"background" : "url(img/interactive-btn-1.png)", "color":"#e6e457"});
		 $(".interactive-p1").css({"background" : "url(img/interactive-btn-2.png)", "color":"#ffffff"});
			 
	}
	
	$(".animation-p1").click(function () {			
				animationP1();
	});
	
	$(".animation-p2").click(function () {			
				animationP2();
	});
	
	function animationP1(){
		 $(".animationBoxP1").show();
		 $(".animationBoxP2").hide();
		 
		 $(".animation-p1").css({"background" : "url(img/animation-btn-1.png)", "color":"#ffffff"});
		 $(".animation-p2").css({"background" : "url(img/animation-btn-2.png)", "color":"#000000"});

		 
	}
	
	function animationP2(){		
		 $(".animationBoxP2").show();
		 $(".animationBoxP1").hide();	
		 
		 $(".animation-p2").css({"background" : "url(img/animation-btn-1.png)", "color":"#ffffff"});
		 $(".animation-p1").css({"background" : "url(img/animation-btn-2.png)", "color":"#000000"});
	}

}