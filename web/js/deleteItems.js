$('.binCase svg').click(function() {
	idProductBin = $(this).parent().attr('data-id');
	priceProductsBin = $(this).parent().attr('data-price');
	$.ajax({
		url:"/suppPanier",
		type:'GET',
		data: {
			"productItemId" : idProductBin,
			"productsItemPrice" : priceProductsBin
		}
	}).done(function(data){
		infos = JSON.parse(data);
		formattedPrice = "Prix total : "+ String((prixTotal - infos.productsItemPrice).toPrecision(3)) +' €';

		$('#totalPriceCart').html(formattedPrice);
		prixTotal = (prixTotal - infos.productsItemPrice).toPrecision(3); 
		$('#item'+infos.idDivItem).remove();
		if($('.itemRow').length == 0){
			$('#contentJumbotronCart').html("<h1>Il n'y a actuellement aucun produits dans votre panier !</h1>");
			$('#contentTableCart').html("");
		}
		updateCart();
	});
});