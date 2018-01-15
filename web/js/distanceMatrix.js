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
	// SendWish place (8 Cours Clémenceau Orient Kebab)
	var origin1 = new google.maps.LatLng(48.4314183, 0.08938020000005054);
	// Client Place
	var destinationA = new google.maps.LatLng(lat, lng);
	var service = new google.maps.DistanceMatrixService();
	service.getDistanceMatrix({
    	origins: [origin1],
    	destinations: [destinationA],
    	travelMode: 'DRIVING',
	    // transitOptions: TransitOptions,
	    // drivingOptions: DrivingOptions,
	    // unitSystem: UnitSystem,
	    // avoidHighways: Boolean,
	    // avoidTolls: Boolean,
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
	$("#addressMessage").html("Vous habitez à "+response.rows["0"].elements["0"].distance.text+". Il faut "+response.rows["0"].elements["0"].duration.text+" pour nous y rendre en voiture.").fadeIn();
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
			locLat = place.geometry.location.lat();
			locLng = place.geometry.location.lng()
			formatted_address = place.formatted_address;
			calcDist(locLat,locLng);
			$('#inputAddress').val(place.formatted_address);
			if (!place.geometry) {
				console.log("Returned place contains no geometry");
				return;
			}
		});
	});
}

