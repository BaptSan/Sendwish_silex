// $('#submit').click(function(){
// 	console.log('coucou');
// 	return false;
// });


$("#contactForm").submit(function(){
    $.ajax({type:"POST", data: $(this).serialize(), url:"/contact",
        success: function(data){
        },
        error: function(){
        	console.log('Une erreur est survenue dans l\'envoi du mail.');
        }
    });
    return false;
});
