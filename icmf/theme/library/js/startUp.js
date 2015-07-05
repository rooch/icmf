function startUp(op, mode, RefNum, MID, State, ResNum){

	loader('POST', '', 'login', 'op=userMan&mode=c_loginContent', 1);
//	loader('POST', '', 'slider', 'op=slider&mode=c_lastSlide', 1);
	loader('POST', '', 'k3dCarousel', 'op=shop&mode=c_carousel', 1);
	loader('POST', '', 'simpleStat', 'op=stat&mode=c_simpleStat', 1);
	loader('POST', '', 'activePoll', 'op=poll&mode=c_showActive', 1);
	loader('POST', '', 'links', 'op=pageLoader&mode=v_load&page=links', 1);
//	loader('POST', '', 'productCategory', 'op=shop&mode=c_productHierarchicalListCategory', 1);
	
	if(op == 'financial' && mode == 'c_transControl'){
		loader('POST', '', 'content', 'op=' + op + '&mode=' + mode + '&RefNum=' + RefNum + '&MID=' + MID + '&State=' + State + '&ResNum=' + ResNum, 1);
	}
		
	$('ul.sf-menu').superfish();
	setTimeout("$('#productTreeMenu').simpleTreeMenu();", 2000);
	$('#slider').nivoSlider();
	//$('#menu').stickyfloat({duration: 400, easing:'easeInQuad', offsetY: 10});
}