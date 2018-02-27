$("#btnLoc").click(getLoc);

var clientLat;
var clientLng;
var formatted_address="";

function getLoc(){
	if(navigator.geolocation){
		navigator.geolocation.getCurrentPosition(function(position){
			clientLat = position.coords.latitude;
			clientLng = position.coords.longitude;	
			calcDist(clientLat,clientLng);
		});
	}
}

function calcDist(lat,lng){
	var origin1 = new google.maps.LatLng(48.4314183, 0.08938020000005054);
	// Client Place
	var destinationA = new google.maps.LatLng(lat, lng);
	var service = new google.maps.DistanceMatrixService();
	service.getDistanceMatrix({
    	origins: [origin1],
    	destinations: [destinationA],
    	travelMode: 'DRIVING',	  
  	}, callback);
}

function callback(response, status) {	
	if (formatted_address != ""){
		$("#inputAddress").val(formatted_address);
		formatted_address="";
	}else{
		$("#inputAddress").val(response.destinationAddresses);
	}
	$("#inputLat").val(clientLat);
	$("#inputLng").val(clientLng);
	$("#inputDist").val(response.rows["0"].elements["0"].distance.text);
	console.log(parseFloat(response.rows["0"].elements["0"].distance.text));
	if(parseFloat(response.rows["0"].elements["0"].distance.text) < 20){
		$("#premierForm #addressMessage").html("Vous habitez à "+response.rows["0"].elements["0"].distance.text+". Il faut "+response.rows["0"].elements["0"].duration.text+" pour nous y rendre en voiture.").css("color","black").fadeIn();
		$("#divChoiceOrder #addressMessage").html("Vous habitez à "+response.rows["0"].elements["0"].distance.text+". Il faut "+response.rows["0"].elements["0"].duration.text+" pour nous y rendre en voiture.").css("color","white").fadeIn();
		if($("#submitOrderButton").hasClass("disabled")){
			$("#submitOrderButton").removeClass("disabled");
		}
	}else{
		if(!$("#submitOrderButton").hasClass("disabled")){
			$("#submitOrderButton").addClass("disabled");
		}
		$("#addressMessage").html("Nous sommes désolés, mais nous ne pouvons livrer au delà de 20 km. Vous habitez à "+response.rows["0"].elements["0"].distance.text).css("color","red").fadeIn();
	}
}

//Used to prevent error caused by the api google in the console when the page is loaded.
function init(){	
	// Create the search box and link it to the UI element.
	var input = document.getElementById('inputAddress');
	var searchBox = new google.maps.places.SearchBox(inputAddress);
	// Listen for the event fired when the user selects a prediction and retrieve
	// more details for that place.
	searchBox.addListener('places_changed', function() {
		var places = searchBox.getPlaces();
		if (places.length == 0) {
			return;
		}
		// For each place, get the icon, name and location.
		var bounds = new google.maps.LatLngBounds();
		places.forEach(function(place) {
			clientLat = place.geometry.location.lat();
			clientLng = place.geometry.location.lng()
			formatted_address = place.formatted_address;
			calcDist(clientLat,clientLng);
			$('#inputAddress').val(place.formatted_address);
			if (!place.geometry) {
				console.log("Returned place contains no geometry");
				return;
			}
		});
	});
}

 $('#btnLoc').tooltip();   

