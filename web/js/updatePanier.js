function updateCart(){
	$.ajax(
		{
			url:'/getPanier',
			type: 'GET',
		}).done(function(data){
			$('#pageSubCart').html(data);
		});
}