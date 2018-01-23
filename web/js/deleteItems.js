$('.binCase svg').click(function() {
	idProductBin = $(this).parent().attr('data-id');
	$.ajax({
		url:"/suppPanier",
		type:'GET',
		data: {
			"productItemId" : idProductBin
		}
	}).done(function(data){
		infos = JSON.parse(data);
		newPrice = prixTotal - infos.substractPrice
		formattedPrice = "Prix total : "+ newPrice +' €';
		console.log(formattedPrice);
		$('#totalPriceCart').html(formattedPrice);
		prixTotal -= infos.substractPrice; 
		$('#item'+infos.idDivItem).remove();
		console.log($('.itemRow').length);
		if($('.itemRow').length == 0){
			$('#contentJumbotronCart').html("<h1>Il n'y a actuellement aucun produits dans votre panier !</h1>");
			$('#contentTableCart').html("");
		}
	});
});