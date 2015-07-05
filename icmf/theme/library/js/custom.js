function price(objectId){
	var calc;
	
	checkBoxToggle(objectId);
	if(document.getElementById(objectId).value == 1){
		calc = document.getElementById(objectId + 'Count').value * parseInt(document.getElementById(objectId + 'FI').innerHTML);
		document.getElementById('totalPrice').innerHTML = parseInt(document.getElementById('totalPrice').innerHTML) + calc;
	}else if(document.getElementById(objectId).value == 0){
		calc = document.getElementById(objectId + 'Count').value * parseInt(document.getElementById(objectId + 'FI').innerHTML);
		document.getElementById('totalPrice').innerHTML = parseInt(document.getElementById('totalPrice').innerHTML) - calc;
	}
	
}