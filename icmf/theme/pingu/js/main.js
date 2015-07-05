function main(){
	
	 var newObj = new Object()

	var mainContainer = $('#main');
	
	var lineMC = $('#line');
	
	var fishBtn =  $('#fishUp');
	
	var interactiveContent = $('#interactive');
	var interactiveBtn = $('.interactiveBtn');
	var interactiveUp = false;
	
	var profileContent = $('#profile');
	var profileBtn = $('.profileBtn');
	var profileUp = false; 
	
	var animationContent = $('#animation');
	var animationBtn = $('.animationBtn');
	var animationUp = false;
	
	var showreelContent = $('#showreel');
	var showreelBtn = $('.showreelBtn');
	var showreelUp = false; 
	
	var newsContent = $('#news');
	var newsBtn = $('.newsBtn');
	var newsUp = false; 
	
	var contactContent = $('#contact');
	var contactBtn = $('.contactBtn');
	var contactUp = false;
	
	var blocker =  $('.btnBlocker');
	
	var myEye =  $('.eye');
	
	var leverBtn = $('.lever');
	
	//...video setup...//
	var videoContent = $('.vidHolder');
	
	var showreelVideo = "theme/pingu/video/Showreel";
	var showreelPoster = "theme/pingu/img/showreel.jpg";
	
	var currentVideo = "theme/pingu/video/Showreel";
	var currentPoster = "theme/pingu/img/showreel.jpg";
	
	var ua = navigator.userAgent.toLowerCase();
	var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
	
	function getVideo(){
		
		
		
		if ($.browser.msie || $.browser.mozilla){
			var flashvars = {};
			var params = {};
			params.allowscriptaccess = "always";
			var attributes = {};
			attributes.id = "as3_js";
			attributes.align = "middle";
			swfobject.embedSWF("../video/videoPlayer.swf", "vidFlash", "532", "300", "9.0.0", false, flashvars, params, attributes);

			
			window.onload = function() {
				flashVideoLoad();
			}
					
		}else if(isAndroid){
					
			var videoVar = "$('<video id='videoPlayer' width='532' height='300' controls src='"+currentVideo+".mp4' poster='"+currentPoster+"'></video>";
			$(videoVar).appendTo(".vidHolder");
			
		}else{
			
			var videoVar = "$('<video id='videoPlayer' width='532' height='300' controls src='"+currentVideo+".mp4' poster='"+currentPoster+"'></video>";
			$(videoVar).appendTo(".vidHolder");
			
		}

		
		
	}
	
	
	function flashVideoLoad(){
		
			
			var flash =	document.getElementById("as3_js");
			flash.sendVideo(currentVideo+".flv");
			flash.sendPoster(currentPoster);
	}
	
	
	
	
	getVideo();
	
	function testing(){
		alert("test");	
	}
			 
	function playPause() {
    	var myVideo = document.getElementById('videoPlayer');
		
		if ( $.browser.msie || $.browser.mozilla || isAndroid) {
  			var flash =	document.getElementById("as3_js");
			flash.pauseFlash();
		}else{
       		 myVideo.pause();
		}
    }
	
	
	
	$(interactiveContent).hide();
	$(profileContent).hide();
	$(animationContent).hide();
	$(videoContent).hide();	
	$(contactContent).hide();	
	$(newsContent).hide();		
	$(blocker).hide();
	$(myEye).show();
	$("#twitterBox").fadeTo("fast", 0);
	
	$('#penguin')
	.sprite({fps: 25, no_of_frames: 9})
	$('#penguin').spStop();
	
	
		
		$('#fishUp')
		.sprite({fps: 25, no_of_frames: 16})

	


	 $('.lever').sprite({fps: 25, start_at_frame: 8, no_of_frames: 16, on_frame: { // note - on_frame is an object not a function
		14: function(obj) { // called on frame 8
				obj.spStop();
		  }
		}
	});
	

		
	
	var leverUp = false;
	
	
	
	leverBtn.click(function () {
							 
		 $('.lever').spStart();	
		 if(leverUp==false){
			 leverUp = true;
			 $("#twitterBox").fadeTo("slow", 1);
		 }else{
			 leverUp = false;
			  $("#twitterBox").fadeTo("slow", 0);
		 }
	
    });

	<!-- fish up button -->
	 
	fishBtn.click(function () {
		playPause();
        $(mainContainer).animate({
             top:"0"
       	 },2000,'easeInOutSine')
		 $(videoContent).hide();

    });
	  
	  
	<!-- profile -->
	  
	profileBtn.click(function () {
							   
		$('#penguin').spStart();	
		$(blocker).show();
		$(myEye).hide();
		
		//if interactive up
							   
	    if(interactiveUp == true){
			$(interactiveContent).animate({
             top:"600"
        },1300,'easeInOutSine',function() {
			$(interactiveContent).hide();	
			 profileFunction();
			 interactiveUp = false;
			}
			)
			
			$(lineMC).animate({
			top:"0"
			},1300,'easeInOutSine')		
			
	   }
	   
	   //.....//
	   
	  else if(animationUp == true){
			$(animationContent).animate({
             top:"600"
       		},1300,'easeInOutSine',function() {
			
			$(animationContent).hide();	
			profileFunction();
			 animationUp = false;
			}
			)
			
			$(lineMC).animate({
			top:"0"
			},1300,'easeInOutSine')		
			
	   }
	   
	   //.....//
	   
	   else if(contactUp == true){
			$(contactContent).animate({
             top:"600"
       		},1300,'easeInOutSine',function() {
			
			$(contactContent).hide();	
			profileFunction();
			 contactUp = false;
			}
			)
			
			$(lineMC).animate({
			top:"0"
			},1300,'easeInOutSine')		
			
	   }
	   
	   //.....//
	   
	   else if(newsUp == true){
			$(newsContent).animate({
             top:"600"
       		},1300,'easeInOutSine',function() {
			
			$(newsContent).hide();	
			profileFunction();
			 newsUp = false;
			}
			)
			
			$(lineMC).animate({
			top:"0"
			},1300,'easeInOutSine')		
			
	   }else{
		   profileFunction();
	   }
	   
	   //.....//
	   
	   //main profile
	   
	   function profileFunction(){
 
		if(profileUp == true){
				 $(profileContent).animate({
				 top:"600"
			},1300,'easeInOutSine',function() {
				$(interactiveContent).hide();
				$(profileContent).hide();
				$(animationContent).hide();
				$(contactContent).hide();
				$(newsContent).hide();
				$('#penguin').spStop();
				profileUp = false;
				$(blocker).hide();
				$(myEye).show();
				}
				)
				
				 $(lineMC).animate({
				 top:"0"
				},1300,'easeInOutSine')
				 
		
			}else{
				 $(profileContent).show();
				 $(profileContent).animate({
				 top:"114"
			},1300,'easeInOutSine',function(){
				 profileUp = true;
				 $('#penguin').spStop();	
				  $(blocker).hide();
				  $(myEye).show();
			}	
			)
				 
				 $(lineMC).animate({
				 top:"-470"
				},1300,'easeInOutSine')
				 
			}
			
	    }

    }); 
	
	<!-- showreel -->
	
	showreelBtn.click(function () {
								
		 $(mainContainer).animate({
             top:"-640"
        },2000,'easeInOutSine',function(){
			 $(videoContent).show();
		});
	
		if ( $.browser.msie || $.browser.mozilla) {
			currentVideo = showreelVideo;
			currentPoster = showreelPoster;
			flashVideoLoad();
					
		}else if(isAndroid){
				
			var videoTag = document.getElementsByTagName('video')[0];

       		videoTag.setAttribute("src", showreelVideo+".mp4");
			videoTag.setAttribute("poster", showreelPoster);
														
			videoTag.load();
			
		}else{
			
			var videoTag = document.getElementsByTagName('video')[0];

       		videoTag.setAttribute("src", showreelVideo+".mp4");
			videoTag.setAttribute("poster", showreelPoster);
														
			videoTag.load();
		}
		
    });
	
	  
	<!-- interactive -->
	  
	interactiveBtn.click(function () {
								   
	   $('#penguin').spStart();	
	   $(blocker).show();
	   $(myEye).hide();
		
		//if interactive up
							   
	    if(profileUp == true){
			$(profileContent).animate({
             top:"600"
        },1300,'easeInOutSine',function() {
			
			$(profileContent).hide();	
			interactiveFunction();
			 profileUp = false;
			}
			)
			
			$(lineMC).animate({
			top:"0"
			},1300,'easeInOutSine')		
			
	   }
	   
	   //......//
	   
	   else if(animationUp == true){
			$(animationContent).animate({
             top:"600"
       },1300,'easeInOutSine',function() {
			
			$(animationContent).hide();	
			interactiveFunction();
			 animationUp = false;
			}
			)
			
			$(lineMC).animate({
			top:"0"
			},1300,'easeInOutSine')		
			
	   }
	   
	   //......//
	   
	   else if(contactUp == true){
			$(contactContent).animate({
             top:"600"
       },1300,'easeInOutSine',function() {
			
			$(contactContent).hide();	
			interactiveFunction();
			 contactUp = false;
			}
			)
			
			$(lineMC).animate({
			top:"0"
			},1300,'easeInOutSine')		
			
	   }
	   
	   //if news up
	   
	   else if(newsUp == true){
			$(newsContent).animate({
             top:"600"
       },1300,'easeInOutSine',function() {
			
			$(newsContent).hide();	
			interactiveFunction();
			 newsUp = false;
			}
			)
			
			$(lineMC).animate({
			top:"0"
			},1300,'easeInOutSine')		
			
	   }else{
		   interactiveFunction();
	   }
	   
	   //.......//
	   
	   //main interactive
	   
	   function interactiveFunction(){
       
		if(interactiveUp == true){
				 $(interactiveContent).animate({
				 top:"600"
			},1300,'easeInOutSine',function() {
				$(profileContent).hide();
				$(interactiveContent).hide();
				$(animationContent).hide();
				$(contactContent).hide();
				$(newsContent).hide();	
				$('#penguin').spStop();
				$(blocker).hide();
				$(myEye).show();
				interactiveUp = false;
				}
				)
				
				 $(lineMC).animate({
				 top:"0"
				},1300,'easeInOutSine')
				 
		
			}else{
				 $(interactiveContent).show();
				 $(interactiveContent).animate({
				 top:"114"
			},1300,'easeInOutSine',function(){
				 interactiveUp = true;
				 $('#penguin').spStop();	
				 $(blocker).hide();
				 $(myEye).show();
			}	
			)
				 
				 $(lineMC).animate({
				 top:"-470"
				},1300,'easeInOutSine')
				 
			}
	    }
    });
	

	<!-- animation -->
	  
	animationBtn.click(function () {
								   
	   $('#penguin').spStart();	
	   $(blocker).show();
	   $(myEye).hide();
		
		//if profile up
							   
	    if(profileUp == true){
			$(profileContent).animate({
             top:"600"
        },1300,'easeInOutSine',function() {
			
			$(profileContent).hide();	
			animationFunction();
			 profileUp = false;
			}
			)
			
			$(lineMC).animate({
			top:"0"
			},1300,'easeInOutSine')		
			
	   }
	   
	  //if interactive up
	   
	   else if(interactiveUp == true){
			$(interactiveContent).animate({
             top:"600"
       },1300,'easeInOutSine',function() {
			
			$(interactiveContent).hide();	
			animationFunction();
			 interactiveUp = false;
			}
			)
			
			$(lineMC).animate({
			top:"0"
			},1300,'easeInOutSine')		
			
	   }
	   
	   //if contact up
	   
	   else if(contactUp == true){
			$(contactContent).animate({
             top:"600"
       },1300,'easeInOutSine',function() {
			
			$(contactContent).hide();	
			animationFunction();
			 contactUp = false;
			}
			)
			
			$(lineMC).animate({
			top:"0"
			},1300,'easeInOutSine')		
			
	   } 
	   
	   //if news up
	   
	   else if(newsUp == true){
			$(newsContent).animate({
             top:"600"
       },1300,'easeInOutSine',function() {
			
			$(newsContent).hide();	
			animationFunction();
			 newsUp = false;
			}
			)
			
			$(lineMC).animate({
			top:"0"
			},1300,'easeInOutSine')		
			
	   }else{
		   animationFunction();
	   }
	   
	   //.......//
	   
	   //main animation
	   
	   function animationFunction(){
       
		if(animationUp == true){
				 $(animationContent).animate({
				 top:"600"
			},1300,'easeInOutSine',function() {
				$(profileContent).hide();
				$(interactiveContent).hide();
				$(animationContent).hide();
				$(newsContent).hide();	
				$('#penguin').spStop();
				$(blocker).hide();
				$(myEye).show();
				animationUp = false;
				}
				)
				
				 $(lineMC).animate({
				 top:"0"
				},1300,'easeInOutSine')
				 
		
			}else{
				 $(animationContent).show();
				 $(animationContent).animate({
				 top:"114"
			},1300,'easeInOutSine',function(){
				 animationUp = true;
				 $('#penguin').spStop();
				 $(blocker).hide();
				 $(myEye).show();
			}	
			)
				 
				 $(lineMC).animate({
				 top:"-470"
				},1300,'easeInOutSine')
				 
			}
	    }
    });
						
	<!-- contact -->
	  
	contactBtn.click(function () {
								   
	   $('#penguin').spStart();	
	   $(blocker).show();
	   $(myEye).hide();
		
		//if profile up
							   
	    if(profileUp == true){
			$(profileContent).animate({
             top:"600"
        },1300,'easeInOutSine',function() {
			
			$(profileContent).hide();	
			contactFunction();
			 profileUp = false;
			}
			)
			
			$(lineMC).animate({
			top:"0"
			},1300,'easeInOutSine')		
			
	   }
	   
	  //if interactive up
	   
	   else if(interactiveUp == true){
			$(interactiveContent).animate({
             top:"600"
       },1300,'easeInOutSine',function() {
			
			$(interactiveContent).hide();	
			contactFunction();
			 interactiveUp = false;
			}
			)
			
			$(lineMC).animate({
			top:"0"
			},1300,'easeInOutSine')		
			
	   }
	   
	   //if animation up
	   
	   else if(animationUp == true){
			$(animationContent).animate({
             top:"600"
       },1300,'easeInOutSine',function() {
			
			$(animationContent).hide();	
			contactFunction();
			 animationUp = false;
			}
			)
			
			$(lineMC).animate({
			top:"0"
			},1300,'easeInOutSine')		
			
	   }
	   
	   //if news up
	   
	   else if(newsUp == true){
			$(newsContent).animate({
             top:"600"
       },1300,'easeInOutSine',function() {
			
			$(newsContent).hide();	
			contactFunction();
			 newsUp = false;
			}
			)
			
			$(lineMC).animate({
			top:"0"
			},1300,'easeInOutSine')		
			
	   }else{
		   contactFunction();
	   }
	   
	   //.......//
	   
	   //main animation
	   
	   function contactFunction(){
       
		if(contactUp == true){
				 $(contactContent).animate({
				 top:"600"
			},1300,'easeInOutSine',function() {
				$(profileContent).hide();
				$(interactiveContent).hide();
				$(animationContent).hide();
				$(contactContent).hide();
				$(newsContent).hide();	
				$('#penguin').spStop();
				$(blocker).hide();
				$(myEye).show();
				contactUp = false;
				}
				)
				
				 $(lineMC).animate({
				 top:"0"
				},1300,'easeInOutSine')
				 
		
			}else{
				 $(contactContent).show();
				 $(contactContent).animate({
				 top:"114"
			},1300,'easeInOutSine',function(){
				 contactUp = true;
				 $('#penguin').spStop();	
				 $(blocker).hide();
				 $(myEye).show();
			}	
			)
				 
				 $(lineMC).animate({
				 top:"-470"
				},1300,'easeInOutSine')
				 
			}
	    }
    });	
	
	
	<!-- news -->
	  
	newsBtn.click(function () {
								   
	   $('#penguin').spStart();	
	   $(blocker).show();
	   $(myEye).hide();
		
		//if profile up
							   
	    if(profileUp == true){
			$(profileContent).animate({
             top:"600"
        },1300,'easeInOutSine',function() {
			
			$(profileContent).hide();	
			newsFunction();
			 profileUp = false;
			}
			)
			
			$(lineMC).animate({
			top:"0"
			},1300,'easeInOutSine')		
			
	   }
	   
	  //if interactive up
	   
	   else if(interactiveUp == true){
			$(interactiveContent).animate({
             top:"600"
       },1300,'easeInOutSine',function() {
			
			$(interactiveContent).hide();	
			newsFunction();
			 interactiveUp = false;
			}
			)
			
			$(lineMC).animate({
			top:"0"
			},1300,'easeInOutSine')		
			
	   }
	   
	   //if animation up
	   
	   else if(animationUp == true){
			$(animationContent).animate({
             top:"600"
       },1300,'easeInOutSine',function() {
			
			$(animationContent).hide();	
			newsFunction();
			 animationUp = false;
			}
			)
			
			$(lineMC).animate({
			top:"0"
			},1300,'easeInOutSine')		
			
	   }
	   //if news up
	   
	   else if(contactUp == true){
			$(contactContent).animate({
             top:"600"
       },1300,'easeInOutSine',function() {
			
			$(contactContent).hide();	
			newsFunction();
			 contactUp = false;
			}
			)
			
			$(lineMC).animate({
			top:"0"
			},1300,'easeInOutSine')		
			
	   }else{
		   newsFunction();
	   }
	   
	   //.......//
	   
	   //main animation
	   
	   function newsFunction(){
       
		if(newsUp == true){
				 $(newsContent).animate({
				 top:"600"
			},1300,'easeInOutSine',function() {
				$(profileContent).hide();
				$(interactiveContent).hide();
				$(animationContent).hide();
				$(contactContent).hide();
				$(newsContent).hide();
				$('#penguin').spStop();
				$(blocker).hide();
				$(myEye).show();
				newsUp = false;
				}
				)
				
				 $(lineMC).animate({
				 top:"0"
				},1300,'easeInOutSine')
				 
		
			}else{
				 $(newsContent).show();
				 $(newsContent).animate({
				 top:"114"
			},1300,'easeInOutSine',function(){
				 newsUp = true;
				 $('#penguin').spStop();	
				 $(blocker).hide();
				 $(myEye).show();
			}	
			)
				 
				 $(lineMC).animate({
				 top:"-470"
				},1300,'easeInOutSine')
				 
			}
	    }
    });	
	
	
	function downToVideo(video, poster){
		
		$(mainContainer).animate({
        top:"-640"
        },2000,'easeInOutSine',function(){
			$(videoContent).show();
		});
													
													
		if ( $.browser.msie || $.browser.mozilla) {
			currentVideo = video;
			currentPoster = poster;
			flashVideoLoad();
		}else if(isAndroid){
														
			var videoTag = document.getElementsByTagName('video')[0];

       		videoTag.setAttribute("src", video+".mp4");
			videoTag.setAttribute("poster", poster);
														
			videoTag.load();
			videoTag.play();
														
		}else{
														
			var videoTag = document.getElementsByTagName('video')[0];

       		videoTag.setAttribute("src", video+".mp4");
			videoTag.setAttribute("poster", poster);
														
			videoTag.load();
														
		}
		
	}
	

	// swf address //
		
		
		newObj.downToVideo = downToVideo;
   		return newObj;

		
}
	



