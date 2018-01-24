function updateCart(){
	console.log('coucou');
	$.ajax(
		{
			url:'/getPanier',
			type: 'GET',
		}).done(function(data){
			$('#pageSubCart').html(data);
		});
}