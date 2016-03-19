window.onload=function(){
	function liigutaEnd(){
		if (this.style.cssFloat == 'left'){
			this.style.cssFloat = 'right';
		}
		else if (this.style.cssFloat == 'right'){
			this.style.cssFloat = 'left';
		}	
	}
	var pallid=document.getElementsByClassName('bead');
	for (var i=0; i <pallid.length; i++){
		var element = pallid[i].style.id;
		if (element == "vasak") {
			pallid[i].style.cssFloat = 'right';
		}
		else {
			pallid[i].style.cssFloat = 'left';
		}
		pallid[i].onclick = liigutaEnd;		
	}
}





