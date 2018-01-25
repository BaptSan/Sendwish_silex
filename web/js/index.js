$(document).ready( function(){
initFlick();

 });


 function initFlick(){
 	$('.carousel-main').flickity({
    pageDots: true,
    contain:true,
    });
  //Envoie des différents id des différentes image + 
  $('#secondCar .btnBMenus').click(function() {  
    var idCarrousel = $(this).attr('data-id');
    $.ajax({
      type:'GET',
      data: {
        'carrousel': idCarrousel
      }, 
      url: '/panier'
    }).done(function(data){
      //fonction ajout des produits dans le petit panier.
      $('#idPanier').addClass('badge badge-light');
      if($('#idPanier').text() == ""){
        $('#idPanier').text('1');
      }else{
        Pbadge = parseInt($('#idPanier').text());
        Pbadge++;
        $('#idPanier').text(Pbadge);
      }
    });
  });
  
  // 2nd carousel, navigation
 $('.carousel-nav').flickity({
    contain: true,
    pageDots: false,
    prevNextButtons: false,
    
    });
}
 $('#carrouselCat .card').click(function(){
  category = $(this).attr('data-cat');

  $.ajax({
      type:'GET',
      url: '/generateCarrousel',
      data: {
        'productCat': category
      } 
    }).done(function(data){
      i = 0;
      test = JSON.parse(data);
      string ='<div class="carousel carousel-main">';
      for (let product of test){
        i++;
        btnBoisson = '';
        if(product.category == 'menu' || product.category == 'drink' || product.category == 'sandwich' || product.category == 'suppl' || product.category == 'child' ) {
          btnBoisson = '<button class="btn btn-danger btnBMenus w-50 " type="submit"  data-id="'+product.id+'">Ajouter au Panier</button>'
        }
       string +='<div class="carousel-cell card img'+i+'">'+
                  '<img data-id="'+product.id+'" src="../'+product.imagePath+'" class="imgCard w-50 align-self-left">'+
                  btnBoisson+  
                '</div>';
        }
      string+="</div>";
      $('#secondCar').html(string);
      initFlick();
    });
 });
