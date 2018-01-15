$("#btnLoc").click(getLoc);

var clientLat;
var clientLng;

function getLoc(){
	if(navigator.geolocation){
		navigator.geolocation.getCurrentPosition(function(position){
			clientLat = position.coords.latitude;
			clientLng = position.coords.longitude;	
			// SendWish place (8 Cours Clémenceau Orient Kebab)
			var origin1 = new google.maps.LatLng(48.4314183, 0.08938020000005054);
			// Client Place
			console.log(clientLat);
			console.log(clientLng);
			var destinationA = new google.maps.LatLng(clientLat, clientLng);
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
		});
	}
}

function callback(response, status) {
	console.log(response);
	$("#inputAddress").val(response.destinationAddresses['0']);
	$("#inputLat").val(clientLat);
	$("#inputLng").val(clientLng);
	$("#inputDist").val(response.rows["0"].elements["0"].distance.text);
	$("#addressMessage").html("Vous habitez à "+response.rows["0"].elements["0"].distance.text+". Il faut "+response.rows["0"].elements["0"].duration.text+" pour nous y rendre en voiture.").fadeIn();

}

//Used to prevent error caused by the api google in the console when the page is loaded.
function init(){	
}

