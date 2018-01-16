$(document).ready( function(){ 
initFlick();

 });
 function initFlick(){
 	$('.carousel-main').flickity({
    pageDots: true,
    });
  
  // 2nd carousel, navigation
 $('.carousel-nav').flickity({
    contain: true,
    pageDots: false,
    });
}
 
$( "#card1" ).click(function() {
	console.log('test');
$('#secondCar').html('<div class="carousel carousel-main">'+'<div class="carousel-cell card img1">'+
          '<img src="../img/boisson/fanta.png" alt="" class="w-25 align-self-center" >'+'<p>craquez pour ce gout mythique</p>'+
        '</div>'+
        '<div class="carousel-cell card img2">'+
          '<img src="../img/boisson/coca.png" alt="" class="w-25 align-self-center">'+
        '</div>'+
        '<div class="carousel-cell card img3">'+
          '<img src="../img/boisson/cocalight.png" alt="" class="w-25 align-self-center">'+
        '</div>'+
        '<div class="carousel-cell card img4">'+
          '<img src="../img/boisson/nestea.png" alt="" class="w-25 align-self-center">'+
        '</div>'+
        '<div class="carousel-cell card img5">'+
          '<img src="../img/boisson/sprite.png" alt="" class="w-25 align-self-center">'+
        '</div>'+'</div>');
initFlick();

});

$( "#card2" ).click(function() {
	console.log('test');
$('#secondCar').html('<div class="carousel carousel-main">'+'<div class="carousel-cell card img1">'+
          '<img src="../img/menu/bigking.png" alt="" class="w-25 align-self-center" >'+
        '</div>'+
        '<div class="carousel-cell card img2">'+
          '<img src="../img/menu/chickeneggburger.png" alt="" class="w-25 align-self-center">'+
        '</div>'+
        '<div class="carousel-cell card img3">'+
          '<img src="../img/menu/doubleeggburger.png" alt="" class="w-25 align-self-center">'+
        '</div>'+
        '<div class="carousel-cell card img4">'+
          '<img src="../img/menu/egg burger.png" alt="" class="w-25 align-self-center">'+
        '</div>'+
        '<div class="carousel-cell card img5">'+
          '<img src="../img/menu/whopper.png" alt="" class="w-25 align-self-center">'+
        '</div>'+'</div>');
initFlick();

});


$( "#card3" ).click(function() {
	console.log('test');
$('#secondCar').html('<div class="carousel carousel-main">'+
        '<div class="carousel-cell card img2">'+
          '<img src="../img/accompagnement/chilicheese.png" alt="" class="w-25 align-self-center">'+
        '</div>'+
        '<div class="carousel-cell card img3">'+
          '<img src="../img/accompagnement/frites.png" alt="" class="w-25 align-self-center">'+
        '</div>'+
        '<div class="carousel-cell card img4">'+
          '<img src="../img/accompagnement/nuggets.png" alt="" class="w-25 align-self-center">'+
        '</div>'+
        '<div class="carousel-cell card img5">'+
          '<img src="../img/accompagnement/ognionring.png" alt="" class="w-25 align-self-center">'+
        '</div>'+'</div>');
initFlick();

});

$( "#card4" ).click(function() {
	console.log('test');
$('#secondCar').html('<div class="carousel carousel-main">'+'<div class="carousel-cell card img1">'+
          '<img src="../img/menu enfant/kingjunior.png" alt="" class="w-25 align-self-center" >'+
        '</div>');
initFlick();

});

$( "#card5" ).click(function() {
	console.log('test');
$('#secondCar').html('<div class="carousel carousel-main">'+'<div class="carousel-cell card img1">'+
          '<img src="../img/sandwich/cheeseburgerenfant.png" alt="" class="w-25 align-self-center" >'+
        '</div>'+
        '<div class="carousel-cell card img2">'+
          '<img src="../img/sandwich/hamburgerenfant.png" alt="" class="w-25 align-self-center">'+
        '</div>');
initFlick();

});

