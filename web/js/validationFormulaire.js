function validateForm()
{
	var valid = true;
				// PRENOM
    if ($("#prenom").val().length <= 3 )
    {
        $("#prenom").css("border-color","#DC3545");
        valid = false;
	}
				// NOM
	if ($('#nom').val().length <= 3 )
	{
		$('#nom').css("border-color","#DC3545");
		valid = false;
	}
				// TELEPHONE
	if ($('#tel').val().length != 10 )
	{
		$('#tel').css("border-color","#DC3545");
		valid = false;
	}
				// MOT DE PASSE
	if ($('#mdp').val().length <= 7 ) 
	{
		$('#mdp').css("border-color","#DC3545");
		valid = false;
	}
				// CONFIMATION DE MOT DE PASSE
				console.log($('#cmdp').val());
				console.log($('#mdp').val());
	if ($('#cmdp').val() !== $('#mdp').val()) 
	{
		$('#cmdp').css("border-color","#DC3545");	
		valid = false;
	}						
				// ALERT MESSAGE D'ERREUR
	if (!valid) {
		alert("Attention : Vous avez pas remplis totalement le formulaire !")
		return false;
	}
}
			    // LES CHIFFRES UNIQUEMENT POUR INPUT TEL
$("#tel").keyup(function() {
     var input = $(this).val();
     var regex = new RegExp("^[0-9]+$");
     if (regex.test(input)) {
     } else {
          $(this).val(input.substr(0, input.length-1));
     }
});	
