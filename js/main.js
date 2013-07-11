(function(){


	
	var buyBtn = document.getElementById("buyBtn");
	var buyInput = document.getElementById("buyInput");
	var	alert = document.getElementById("alert");

	buyBtn.onclick = function(){
		if (buyInput.value > 10 || buyInput.value == 0){
			$(document.getElementById("alert")).modal();
		} else{
			buyBtn.innerHTML = "purchased";
			document.getElementById("buyBtn").classList.add("btn-danger");
			this.disabled = true;
		}
	};




}())