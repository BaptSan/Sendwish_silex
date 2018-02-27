$(document).ready( function(){
  initFlick();
  updateCart();
  generateCarousel('menu');
  ajaxHisto();
      //Envoie des différents id des différentes image + 
  $('.addProductFromPageImpair, .addProductFromPagePair').click(function(event) {  
    idCarrousel = $(this).attr('data-id');
    cart = $('#idPanier');
    mousX = event.pageX;
    mousY = event.pageY;
    imgPosition = $(this).parent().children().eq(0).offset();
    imgWidth = $(this).parent().children().eq(0).width();
    imgHeight = $(this).parent().children().eq(0).height();
    btnHeight = $(this).height();
    btnWidth = $(this).width();
    btnPosition = $(this).offset();

    $(this).clone()
    .text("+ 1 !")
    // width = $(testBadge).outerWidth();
    // height = $(testBadge).eight();
    .removeClass('w-50')
    .addClass('badge badge-white')
    // console.log(width);
    // console.log(height);
    .css({
      'position':'absolute',
      'font-size':'0.8em',
      'background-color':'black',
      'color':'white',
      'left':btnPosition.left,
      'top':btnPosition.top,
      'width':"40px",
      'height':"20px",
      'opacity':"0",
    }).appendTo($('body')).
    animate({
      'top':"-=40",
      'opacity':"1",
    },"slow").
    delay(750).animate({
      'top':cart.offset().top,
      'left':cart.offset().left,
      'opacity':'0'
    },"fast",function(){
          $.ajax({
      type:'GET',
      data: {
        'carrousel': idCarrousel
      }, 
      url: '/addToCart'
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
  });


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
        $('#addHisto').prepend('<tr><td>'+data[i].orderDate+'</td><td>'+data[i].priceDf+'</td><td>'+data[i].price+'</td>'+
          '<td>'+data[i].orderNum+'</td><td>'+eatIn+'</td><td>'+takeOut+'</td><td>'+data[i].orderAddress+'</td></tr>');
      }
      setTimeout(ajaxHisto, 30000);
    });
  
  }

 function initFlick(){
  $('.carousel-main').flickity({
    pageDots: true,
    contain:true,
    // On ajoute des produits!
    freeScroll: true,
    wrapAround: true
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
                  '<div class="productInfo"><p><a href="'+redirect+'#'+product.id+'">En savoir plus</a></p></div>'+
                  "<div class='productPriceCarousel'><h2><small class='text-muted'>"+product.price.toFixed(2)+" €</small></h2></div>"+
                '</div>';
        }
      string+="</div>";
      $('#secondCar').html(string);
      initFlick();

      //Envoie des différents id des différentes image + 
  $('#secondCar .btnBMenus').click(function(event) {  
    idCarrousel = $(this).attr('data-id');
    console.log(idCarrousel);
    cart = $('#idPanier');
    mousX = event.pageX;
    mousY = event.pageY;
    imgPosition = $(this).parent().children().eq(0).offset();
    imgWidth = $(this).parent().children().eq(0).width();
    imgHeight = $(this).parent().children().eq(0).height();
    btnHeight = $(this).height();
    btnWidth = $(this).width();
    btnPosition = $(this).offset();

    $(this).clone()
    .text("+ 1 !")
    .removeClass('w-50')
    .addClass('badge badge-white')
    .css({
      'position':'absolute',
      'left':btnPosition.left+(btnWidth/2),
      'top':btnPosition.top+(btnHeight/2.5),
      'width':"40px",
      'height':"20px",
      'opacity':"0",
    }).appendTo($('body')).
    animate({
      'top':"-=40",
      'opacity':"1",
    },"slow").delay(700).
    animate({
      'top':cart.offset().top,
      'left':cart.offset().left,
      'opacity':'0'
    },"fast");

      $.ajax({
      type:'GET',
      data: {
        'carrousel': idCarrousel
      }, 
      url: '/addToCart'

    }).done(function(data){
      console.log(data);
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
    // });
  });

    });
 }





