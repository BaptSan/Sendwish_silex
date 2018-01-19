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
      $('#idPanier').addClass('badge badge-light');
      if($('#idPanier').text() == ""){
        $('#idPanier').text('1');
      }else{
        test = parseInt($('#idPanier').text());
        test++;
        $('#idPanier').text(test);
      }
    });
  });
/*  $('clpanier').click(function() {
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
 
$( "#card1" ).click(function() {
$('#secondCar').html('<div class="carousel carousel-main">'+'<div class="carousel-cell card img1">'+
          '<img data-id="1" src="../img/boisson/fanta.png" alt="" class="w-25 align-self-center" >'+
        '</div>'+
        '<div class="carousel-cell card img2">'+
          '<img data-id="2" src="../img/boisson/coca.png" alt="" class="w-25 align-self-center">'+
        '</div>'+
        '<div class="carousel-cell card img3">'+
          '<img data-id="3" src="../img/boisson/cocalight.png" alt="" class="w-25 align-self-center">'+
        '</div>'+
        '<div class="carousel-cell card img4">'+
          '<img data-id="4" src="../img/boisson/nestea.png" alt="" class="w-25 align-self-center">'+
        '</div>'+
        '<div class="carousel-cell card img5">'+
          '<img data-id="5" src="../img/boisson/sprite.png" alt="" class="w-25 align-self-center">'+
        '</div>'+'</div>');
initFlick();

});

$( "#card2" ).click(function() {
$('#secondCar').html('<div class="carousel carousel-main">'+'<div class="carousel-cell card img1">'+
          '<img data-id="6" src="../img/menu/bigking.png" alt="" class="w-25 align-self-center" >'+
        '</div>'+
        '<div class="carousel-cell card img2">'+
          '<img data-id="7" src="../img/menu/chickeneggburger.png" alt="" class="w-25 align-self-center">'+
        '</div>'+
        '<div class="carousel-cell card img3">'+
          '<img data-id="8" src="../img/menu/doubleeggburger.png" alt="" class="w-25 align-self-center">'+
        '</div>'+
        '<div class="carousel-cell card img4">'+
          '<img data-id="9" src="../img/menu/egg burger.png" alt="" class="w-25 align-self-center">'+
        '</div>'+
        '<div class="carousel-cell card img5">'+
          '<img data-id="10" src="../img/menu/whopper.png" alt="" class="w-25 align-self-center">'+
        '</div>'+'</div>');
initFlick();

});


$( "#card3" ).click(function() {
$('#secondCar').html('<div class="carousel carousel-main">'+
        '<div class="carousel-cell card img2">'+
          '<img data-id="11" src="../img/accompagnement/chilicheese.png" alt="" class="w-25 align-self-center">'+
        '</div>'+
        '<div class="carousel-cell card img3">'+
          '<img data-id="12" src="../img/accompagnement/frites.png" alt="" class="w-25 align-self-center">'+
        '</div>'+
        '<div class="carousel-cell card img4">'+
          '<img data-id="13" src="../img/accompagnement/nuggets.png" alt="" class="w-25 align-self-center">'+
        '</div>'+
        '<div class="carousel-cell card img5">'+
          '<img data-id="14" src="../img/accompagnement/ognionring.png" alt="" class="w-25 align-self-center">'+
        '</div>'+'</div>');
initFlick();

});

$( "#card4" ).click(function() {
$('#secondCar').html('<div class="carousel carousel-main">'+'<div class="carousel-cell card img1">'+
          '<img data-id="15" src="../img/menu enfant/kingjunior.png" alt="" class="w-25 align-self-center" >'+
        '</div>');
initFlick();

});

$( "#card5" ).click(function() {
$('#secondCar').html('<div class="carousel carousel-main">'+'<div class="carousel-cell card img1">'+
          '<img data-id="16" src="../img/sandwich/cheeseburgerenfant.png" alt="" class="w-25 align-self-center" >'+
        '</div>'+
        '<div class="carousel-cell card img2">'+
          '<img data-id="17" src="../img/sandwich/hamburgerenfant.png" alt="" class="w-25 align-self-center">'+
        '</div>');
initFlick();

});

