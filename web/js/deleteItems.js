$('#binCase svg').click(function() {
	idCartBin = $(this).parent().attr('data-id');
	$.ajax({
		url:"/suppPanier",
		type:'GET',
		data: {
			"cartItemId" : idCartBin
		}
	}).done()
});