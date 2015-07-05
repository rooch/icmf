function startUp(op, mode, RefNum, MID, State, ResNum){

	loader('POST', '', 'login', 'op=userMan&mode=c_loginContent', 1);
	if(op == 'financial' && mode == 'c_transControl'){
		alert('op:' + op + ', mode:' + mode + ', RefNum:' + RefNum + ', MID:' + MID + 'State:' + State + 'ResNum:' + ResNum);
		loader('POST', '', 'content', 'op=' + op + '&mode=' + mode + '&RefNum=' + RefNum + '&MID=' + MID + '&State=' + State + '&ResNum=' + ResNum, 1);
	}else{
		loader('POST', '', 'content', 'op=lottery&mode=c_slide', 1);
	}
	
	loader('POST', '', 'k3dCarousel', 'op=lottery&mode=c_carousel', 1);
		
	$('ul.sf-menu').superfish();
}