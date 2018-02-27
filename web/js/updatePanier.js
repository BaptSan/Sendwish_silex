function updateCart(){
	$.ajax(
		{
			url:'/getPanier',
			type: 'GET',
		}).done(function(data){
			$('#pageSubCart').html(data);
		});
}

$('.btQtyCartMinus').click(function(){
	binActual = $(this).parent().parent().find('.binCase');
	dataId = $(this).attr('data-id');
	actualQty = $('.qtyInputCartId'+dataId).val();
	if(actualQty == 1){
		return false;
	}
	$.ajax({
		type:'get',
		url:'/removeFromCart',
		data:{
			'carrousel': dataId
		}
	}).done(function(data){
		productId = data;
		productQty = $('.qtyInputCartId'+productId).val();
		totalProductPrice = $('.priceTotalProductId'+productId).attr('data-price');
		unitPrice = totalProductPrice / productQty;
		newTotalProductPrice = totalProductPrice-unitPrice;
		newAttrPrice = parseFloat(binActual.attr('data-price')) - unitPrice;
		binActual.attr('data-price',newAttrPrice);
		$('.priceTotalProductId'+productId).attr('data-price',newTotalProductPrice.toFixed(1));
		$('.priceTotalProductId'+productId).html(newTotalProductPrice.toFixed(1)+" €");
		prixTotal-=unitPrice;
		$('#totalPriceCart').html("Prix Total : "+prixTotal.toFixed(1)+"€");
		updateCart();
		$('.qtyInputCartId'+dataId).val(--actualQty);
	});
});

$('.btQtyCartPlus').click(function(){
	binActual = $(this).parent().parent().find('.binCase');
	dataId = $(this).attr('data-id');
	actualQty = $('.qtyInputCartId'+dataId).val();
	$.ajax({
		type:'get',
		url:'/addToCart',
		data:{
			'carrousel': dataId
		}
	}).done(function(data){
		productId = data;
		productQty = parseInt($('.qtyInputCartId'+productId).val());
		totalProductPrice = parseFloat($('.priceTotalProductId'+productId).attr('data-price'));
		unitPrice = parseFloat((totalProductPrice/productQty).toPrecision(3));
		newAttrPrice = parseFloat(binActual.attr('data-price')) + unitPrice;
		binActual.attr('data-price',newAttrPrice);
		newTotalProductPrice = totalProductPrice+unitPrice;
		prixTotal = parseFloat(prixTotal)+unitPrice;
		console.log(parseFloat(prixTotal));
		console.log(prixTotal);
		$('.priceTotalProductId'+productId).attr('data-price',newTotalProductPrice.toFixed(1));
		$('.priceTotalProductId'+productId).html(newTotalProductPrice.toFixed(1)+" €");
		$('#totalPriceCart').html("Prix Total : "+prixTotal.toFixed(1)+"€");
		console.log(prixTotal.toFixed(1));
		updateCart();
		$('.qtyInputCartId'+dataId).val(++actualQty);
	});
});
