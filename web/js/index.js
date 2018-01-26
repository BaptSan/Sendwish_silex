$(document).ready( function(){
initFlick();
updateCart();
  generateCarousel('menu');
ajaxHisto();
 });

  function ajaxHisto() {
    
    $.ajax({
      type:'GET',
      data: {
        'historique': true
      }, 
      url: '/backOfficeRefresh'
    }).done(function(data) {
      
      $('#addHisto').html('');
      for( var i = 0 ; i < data.length ; i++ ) {
        if (data[i].eatIn == true ) {
          eatIn = '1';
          takeOut = '0';
        } else {
          eatIn = '0';
          takeOut = '1';
        }
        $('#addHisto').append('<tr><td>'+data[i].orderDate+'</td><td>'+data[i].priceDf+'</td><td>'+data[i].price+'</td>'+
          '<td>'+data[i].orderNum+'</td><td>'+eatIn+'</td><td>'+takeOut+'</td></tr>');
      }
      setTimeout(ajaxHisto, 30000);
    });
  
  }

 function initFlick(){
 	$('.carousel-main').flickity({
    pageDots: true,
    contain:true,
    // On ajoute des produits et on décommente !
    // freeScroll: true,
    // wrapAround: true
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

         $('#idPanier').addClass('badge badge-light badgetest').animate({opacity:'1'});
         $('#idPanier').addClass('badge badge-light badgetest').fadeIn(150);
         $('#idPanier').text('1');
      }else{
        Pbadge = parseInt($('#idPanier').text());
        $('#idPanier').fadeOut(100,function(){
 
          $('#idPanier').removeClass('badge badge-light badgetest');
 
          Pbadge++;
 
          $('#idPanier').text(Pbadge);
 
          $('#idPanier').addClass('badge badge-light badgetest').fadeIn(150);
 
        });
      }
       updateCart();
 
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
  generateCarousel($(this).attr('data-cat'));
 });
 
 function generateCarousel(cat='menu'){

  category = cat;

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
       if(product.category =='menu'){
        redirect = '/nosMenus';
       }
       if(product.category =='drink'){
        redirect = '/boissons';
       }
       if(product.category =='sandwich'){
        redirect = '/sandwichs';
       }
       if(product.category =='suppl'){
        redirect = '/petitesFaims';
       }
       if(product.category =='child'){
        redirect = '/nosMenus';
       }

       string +='<div class="carousel-cell card img'+i+'">'+
                  '<img data-id="'+product.id+'" src="../'+product.imagePath+'" class="imgCard w-50 align-self-left">'+
                  btnBoisson+  
                  "<div class='productNameCarousel'><h3>"+product.name+"</h3></div>"+
                  "<div class='productPriceCarousel'><h2><small class='text-muted'>"+product.price+" €</small></h2></div>"+
                  '<div class="productInfo"><p><a href="'+redirect+'#'+product.id+'">En savoir plus</a></p></div>'+
                '</div>';
        }
      string+="</div>";
      $('#secondCar').html(string);
      initFlick();
    });
 }