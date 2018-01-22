$(document).ready( function(){ 
initFlick();

 });


 function initFlick(){
 	$('.carousel-main').flickity({
    pageDots: true,
    });
  //Envoie des différents id des différentes image + 
  $('#secondCar .card img').click(function() {  
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
  // fonction suppression de badge.
 /* $('clpanier').click(function() {
    if ($('#idPanier').text() != "") {
      $('#idPanier').text() = "";
    }
  });*/
  
  // 2nd carousel, navigation
 $('.carousel-nav').flickity({
    contain: true,
    pageDots: false,
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
        if(product.category == 'menu') {
          btnBoisson = '<div class="input-group">'+
          '<form>'+
            '<select class="custom-select" id="">'+
              '<option disabled selected>--Sélectionnez Votre Boisson--</option>'+
              '<option>Coca-Cola</option>'+
              '<option>Coca-Cola Light</option>'+
              '<option>Coca-Cola Zéro</option>'+
              '<option>Fanta</option>'+
              '<option>Nestea</option>'+
              '<option>Sprite</option>'+
              '<option>Vitel</option>'+
            '</select>'+
            '</form>'+
            '<div class="input-group-append">'+
              '<button class="btn btn-outline-secondary" type="submit">Button</button>'+
            '</div>'+
          '</div>'
        }
       string +='<div class="carousel-cell card img'+i+'">'+
                  '<img data-id="'+product.id+'" src="../'+product.imagePath+'" alt="" class="w-25 align-self-center" >'+
                  btnBoisson+  
                '</div>';
        }
      string+="</div>";
      $('#secondCar').html(string);
      initFlick();
    });
 });
