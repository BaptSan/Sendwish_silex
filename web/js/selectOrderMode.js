$(function(){
	$('#orderButton').click(function(){

		$.ajax({
			type:'post',
			url:'/getUserStatut'
		}).done(function(data){
			if(data == "1"){
				window.location.replace("/inscription");
			}
		});

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
			"<div id='divChoseAddress' class='row d-flex justify-content-center'>"+
			"</div>"+
			"<div id='divAppendAddress' class='mt-4 row d-flex justify-content-center'>"+
			"</div>"+
			"<div class='row  d-flex justify-content-center'>"+
				"<div class='col-md-8'>"+
					"<input id='submitOrderButton' type='button' class='mt-3 btn btn-block btn-danger disabled' value='Passer commande'>"+
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
	$('.choiceBoxes3').click(choseModeLivraison);
	$('#submitOrderButton').click(sendForm);
	$('#inputAddress').keyup(function(){
		if($('#inputAddress').val() == ""){
			checkBoxDeliveryModeNewAddress = false;
		}else{
			checkBoxDeliveryModeNewAddress = true;
		}
		checkOrderOption();

	});
}

function choseModeOrder(){
	$('#inputChoiceOrderMode').val($(this).attr('data-orderMode'));
	if($(this).attr('data-orderMode') == "eatIn"){
			$(this).css('background-color','white').css('color','black');
			$('#eatOutBox').css('background-color','rgba(0,0,0,0)').css('color','white');
			$('#divChoseAddress').html("");
			checkBoxOrderModeEatIn = true;
			checkBoxOrderModeTakeOut = false;
	}else{
			$(this).css('background-color','white').css('color','black');
			$('#eatInBox').css('background-color','rgba(0,0,0,0)').css('color','white');
			

			if($('#divChoseAddress').html() == ""){
				$.ajax({
					type: 'POST',
					url: '/getUserAddress',
				}).done(function(data){
					console.log(data);
					jsonDATA = JSON.parse(data);
					$('#inputLat').val(jsonDATA.lat);
					$('#inputLng').val(jsonDATA.lng);
					$('#inputDist').val(jsonDATA.dist);
				});

				setTimeout(function(){

					if(parseFloat(jsonDATA.dist) > 20){
						stringChoseAddressPart1 = "<div class='col-md-6 d-flex justify-content-center'>"+
							"<div id='actualAddressBox' data-orderPaiementMode='actualAddress' class='choiceBoxes3Disabled d-flex justify-content-center align-items-center'>"+
							"<p>Votre adresse d'inscription se situe à plus de 20 km.<br><br>"+
							"Nous ne livrons pas aussi loin, veuillez saisir une autre adresse s'il vous plaît.</p>"+
							"</div>"+
							"</div>";
					}else{
						stringChoseAddressPart1 = "<div class='col-md-6 d-flex justify-content-center'>"+
							"<div id='actualAddressBox' data-orderDeliveryMode='actualAddress' class='choiceBoxes3 d-flex justify-content-center align-items-center'>"+
							"<h5>Utiliser mon adresse d'inscription</h5>"+
							"<p class='boxMiniText'>("+jsonDATA.formattedAddress+")</p>"+
							"</div>"+
							"</div>";
					}

					stringChoseAddressPart2 = "<div class='col-md-6 d-flex justify-content-center'>"+
					"<div id='newAddressBox' data-orderDeliveryMode='newAddress' class='choiceBoxes3 d-flex justify-content-center align-items-center'>"+
					"<h5>Utiliser une autre adresse</h5>"+
					"</div>"+
					"</div>";
					$('#divChoseAddress').html(stringChoseAddressPart1+stringChoseAddressPart2);
					initClick();
				},800);
			}
			checkBoxOrderModeTakeOut = true;
			checkBoxOrderModeEatIn = false;
		}
	checkOrderOption();
}

function choseModePaiement(){
	console.log($(this).attr('data-orderPaiementMode'));

	$('#inputChoicePaiementMode').val($(this).attr('data-orderPaiementMode'));
	if($(this).attr('data-orderPaiementMode') == "payIn"){
			$(this).css('background-color','white').css('color','black');
			$('#payOnlineBox').css('background-color','rgba(0,0,0,0)').css('color','white');
		checkBoxPaiementModePayIn = true;
		checkBoxPaiementModePayOnline = false;
	}else{
			$(this).css('background-color','white').css('color','black');
			$('#payInBox').css('background-color','rgba(0,0,0,0)').css('color','white');
			checkBoxPaiementModePayIn = false;
			checkBoxPaiementModePayOnline = true;
	}
	checkOrderOption();
}

function choseModeLivraison(){
	$('#inputChoiceDeliveryMode').val($(this).attr('data-orderDeliveryMode'));
	if($(this).attr('data-orderDeliveryMode') == "actualAddress"){
		$(this).css('background-color','white').css('color','black');
		$('#newAddressBox').css('background-color','rgba(0,0,0,0)').css('color','white');
		checkBoxDeliveryModeActualAddress = true;
		checkBoxDeliveryModeNewAddress = false;
		$('#divAppendAddress').html("");
			addInputs = '<input type="hidden" name="inputLat" id="inputLat">'+
		'<input type="hidden" name="inputLng" id="inputLng">'+
		'<input type="hidden" name="inputDist" id="inputDist">'+
		'<input type="hidden" name="inputFormattedAddressOrder" id="inputFormattedAddressOrder">';
		$('#divAppendAddress').append(addInputs);
		$.ajax({
			url:'/getUserAddress',
			type:'post',
		}).done(function(data){
			$('#inputOrderLat').val(jsonDATA.lat);
			$('#inputOrderLng').val(jsonDATA.lng);
			$('#inputOrderDist').val(jsonDATA.dist);
			$('#inputOrderFormattedAddress').val(jsonDATA.formattedAddress);
		});

	}else{
		$(this).css('background-color','white').css('color','black');
		$('#actualAddressBox').css('background-color','rgba(0,0,0,0)').css('color','white');
		checkBoxDeliveryModeActualAddress = false;
		$('#divAppendAddress').html("");
		if($('#divAppendAddress').html()==""){
			giveNewAddress();

		}
	}
	checkOrderOption();
}

function checkOrderOption(){
	if(checkBoxOrderModeEatIn === true && (checkBoxPaiementModePayIn === true || checkBoxPaiementModePayOnline === true)){
		$('#submitOrderButton').removeClass('disabled');
	}
	else if(checkBoxOrderModeTakeOut === true && (checkBoxPaiementModePayIn === true || checkBoxPaiementModePayOnline === true) && (checkBoxDeliveryModeActualAddress === true || checkBoxDeliveryModeNewAddress === true)){
		$('#submitOrderButton').removeClass('disabled');
	}
	else{
		$('#submitOrderButton').addClass('disabled');
	}
}	

function sendForm(){
	if(!$('#submitOrderButton').hasClass('disabled')){
		if($('#inputChoiceDeliveryMode').val() === "newAddress"){
			$('#inputOrderFormattedAddress').val($('#inputAddress').val());
			$('#inputOrderLat').val($('#inputLat').val());
			$('#inputOrderLng').val($('#inputLng').val());
			$('#inputOrderDist').val($('#inputDist').val());	
		}
		$('#formOrder').submit();
	}
	return false;
}

function giveNewAddress(){
		htmlAddress='<div class="col-md-8 d-flex justify-content-center"><i id="btnLocOrder" class="fa fa-map-marker" title="Geolocalisation"  aria-hidden="true"></i>'+
		'<input class="form-control formInscriptionCo mb-3 " type="text" name="address" id="inputAddress" required="required" placeholder="Adresse">'+
		'</div>'+
		'<div class="col-md-8 d-flex justify-content-center">'+
		'<p id="addressMessage" style="display: none;"></p></div>'+
		'<input type="hidden" name="inputLat" id="inputLat">'+
		'<input type="hidden" name="inputLng" id="inputLng">'+
		'<input type="hidden" name="inputDist" id="inputDist">'+
		'<input type="hidden" name="inputFormattedAddressOrder" id="inputFormattedAddressOrder">';
		$('#divAppendAddress').append(htmlAddress).css("opacity","0");
		init();
		checkBoxDeliveryModeActualAddress = true;
		$("#btnLocOrder").click(function(){
			getLoc();
			checkOrderOption();
		});

		$('#divAppendAddress').animate({"opacity":"1"});
		initClick();
}

	var checkBoxOrderModeEatIn = false;
	var checkBoxOrderModeTakeOut = false;
	var checkBoxPaiementModePayIn = false;
	var checkBoxPaiementModePayOnline = false;
	var checkBoxDeliveryModeActualAddress = false;
	var checkBoxDeliveryModeNewAddress = false;

});
