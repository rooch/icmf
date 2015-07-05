function startUp(op, mode, RefNum, MID, State, ResNum){

	loader('POST', '', 'newsTicker', 'op=pageLoader&mode=v_load&page=news');
	loader('POST', '', 'list', 'op=pageLoader&mode=v_load&page=list');
	loader('POST', '', 'chain', 'op=pageLoader&mode=v_load&page=chain');
	
	if(op == 'financial' && mode == 'c_transControl'){
		loader('POST', '', 'content', 'op=' + op + '&mode=' + mode + '&RefNum=' + RefNum + '&MID=' + MID + '&State=' + State + '&ResNum=' + ResNum);
	}
		
	//$('ul.sf-menu').superfish();
	setTimeout("newsTicker();" , 5000);
	setTimeout("$('#slider').nivoSlider();", 3000);
	$('#bar').stickyfloat({duration: 400, easing:'easeInQuad', offsetY: 10});
}