// $('#submit').click(function(){
// 	console.log('coucou');
// 	return false;
// });


$("#contactForm").submit(function(){
    $.ajax({type:"POST", data: $(this).serialize(), url:"/contact",
        success: function(data){
        	console.log(data);
        },
        error: function(){
        	console.log('Une erreur est survenue.');
        }
    });
    return false;
});
