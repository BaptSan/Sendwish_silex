$(function(){
	$('#orderButton').click(function(){
		divSelectOrderOptions = "<div class='container-fluid pt-5' id='divChoiceOrder'>"+
			"<div class='row d-flex justify-content-center'>"+
				"<div class='col-md-4 d-flex justify-content-center'>"+
					"<div id='eatInBox' data-orderMode='eatIn' class='choiceBoxes  d-flex justify-content-center align-items-center'>"+
						"<h3>Sur place</h3>"+
					"</div>"+
				"</div>"+
				
				"<div class='col-md-4 d-flex justify-content-center'>"+
					"<div id='eatOutBox' data-orderMode='eatOut' class='choiceBoxes  d-flex justify-content-center align-items-center'>"+
						"<h3>Livraison</h3>"+
					"</div>"+
				"</div>"+
			"</div>"+
			"<hr class='hrDivOrderChoice'>"+
			"<div class='row d-flex justify-content-center'>"+
				"<div class='col-md-4 d-flex justify-content-center'>"+
					"<div id='payInBox' data-orderPaiementMode='payIn' class='choiceBoxes2  d-flex justify-content-center align-items-center'>"+
						"<h3>Espèces</h3>"+
					"</div>"+
				"</div>"+
				"<div class='col-md-4 d-flex justify-content-center'>"+
					"<div id='payOnlineBox' data-orderPaiementMode='payOnline' class='choiceBoxes2  d-flex justify-content-center align-items-center'>"+
						"<h3>En ligne</h3>"+
					"</div>"+
				"</div>"+
			"</div>"+
			"<hr class='hrDivOrderChoice'>"+
			"<div class='row  d-flex justify-content-center'>"+
				"<div class='col-md-8'>"+
					"<input id='submitOrderButton' type='button' class='btn btn-block btn-danger disabled' value='Passer commande'>"+
				"</div>"+
			"</div>"+
		"</div>";
		$("#mainDiv > .row").prepend(divSelectOrderOptions).fadeIn();
		initClick();
		return false;
	});

function initClick(){
	$('.choiceBoxes').click(choseModeOrder);
	$('.choiceBoxes2').click(choseModePaiement);
	$('#submitOrderButton').click(sendForm);
}

function choseModeOrder(){
	$('#inputChoiceOrderMode').val($(this).attr('data-orderMode'));
	if($(this).attr('data-orderMode') == "eatIn"){
			$(this).css('background-color','white').css('color','black');
			$('#eatOutBox').css('background-color','rgba(0,0,0,0)').css('color','white');
	}else{
			$(this).css('background-color','white').css('color','black');
			$('#eatInBox').css('background-color','rgba(0,0,0,0)').css('color','white');
	}
	checkBoxOrderMode = true;
	checkOrderOption();
}

function choseModePaiement(){
	$('#inputChoicePaiementMode').val($(this).attr('data-orderPaiementMode'));
	if($(this).attr('data-orderPaiementMode') == "payIn"){
			$(this).css('background-color','white').css('color','black');
			$('#payOnlineBox').css('background-color','rgba(0,0,0,0)').css('color','white');
	}else{
			$(this).css('background-color','white').css('color','black');
			$('#payInBox').css('background-color','rgba(0,0,0,0)').css('color','white');
	}
	checkBoxPaiementMode = true;
	checkOrderOption();
}

function checkOrderOption(){
	if(checkBoxOrderMode === true && checkBoxPaiementMode === true){
		$('#submitOrderButton').removeClass('disabled');
	}
}	

function sendForm(){
	if(!$('#submitOrderButton').hasClass('disabled')){
		$('#formOrder').submit();
	}
	return false;
}

	var checkBoxOrderMode = false;
	var checkBoxPaiementMode = false;

});


	
		// <input id="inputChoicePaiementMode" type="hidden">

