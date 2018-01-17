function validateForm()
{
	var valid = true;
				// PRENOM
    if ($("#prenom").val().length <= 3 )
    {
        $("#prenom").css("background-color","#cc2828");
        valid = false;
	}
				// NOM
	if ($('#nom').val().length <= 3 )
	{
		$('#nom').css("background-color","#cc2828");
		valid = false;
	}
				// TELEPHONE
	if ($('#tel').val().length != 10 )
	{
		$('#tel').css("background-color","#cc2828");
		valid = false;
	}
				// MOT DE PASSE
	if ($('#mdp').val().length <= 7 ) 
	{
		$('#mdp').css("background-color","#cc2828");
		valid = false;
	}
				// CONFIMATION DE MOT DE PASSE
	if ($('#cmdp').val() === $('#mdp').val()) 
	{
		$('#cmdp').css("background-color","#cc2828");	
		valid = false;
	}						
				// ALERT MESSAGE D'ERREUR
	if (!valid) {
		alert("Attention : Vous avez pas remplis totalement le formulaire !")
		return false;
	}
}	

