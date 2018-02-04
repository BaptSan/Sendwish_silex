<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Entity\User;
use Entity\CartItem;
use Entity\Product;
use Entity\Order;
use Entity\OrderItem;
use \Mailjet\Resources;

// MAIN ROUTE
//Request::setTrustedProxies(array('127.0.0.1'));
$app->get('/', function () use ($app) {     
    if(!$app['session']->get('user')){
        $guest = new User("", "Invité", "", "", "", new DateTime(), "", "", "", "", "", "", "", "", true, new DateTime());
        $em = $app['em'];
        $em->persist($guest);
        $em->flush();
        $app['session']->set('user', array('mail' => $guest->getMail(), 'admin' => $guest->getIsAdmin(), 'id'=> $guest->getId(), 'firstname' => $guest->getFirstname(),'guest'=>$guest->getIsGuest()));
    }
    return $app['twig']->render('index.html.twig', array( 
        'isRegister' => $_GET['register'] ?? NULL,
        'connect' => $_GET['connect'] ?? NULL,
        'products' => $myProducts ?? NULL,
        'theUser' => $app['session']->get('user') ?? NULL
    )); 
})
->bind('homepage');

// CONTACT ROUTE
$app->match('/contact', function (Request $request) use ($app) {

    if($request->get('firstnameContact') != null && !empty($request->get('firstnameContact')) &&
        $request->get('lastnameContact') != null && !empty($request->get('lastnameContact')) &&
        $request->get('mailContact') != null && !empty($request->get('mailContact')) &&
        $request->get('messageContact') != null && !empty($request->get('messageContact'))){

        // null !== $request->get('firstname') && !empty($request->get('firstname'))
        $firstname=htmlspecialchars($request->get('firstnameContact'));
        $lastname=htmlspecialchars($request->get('lastnameContact'));
        $mail=htmlspecialchars($request->get('mailContact'));
        $message=htmlspecialchars($request->get('messageContact'));

        $apikey = '139edea6ee06f891d9092b1196c9d385';
        $apisecret = '3119b6fa6d0ba08ad644436d2e62c486';


        $mj = new \Mailjet\Client($apikey, $apisecret,
              true,['version' => 'v3.1']);
$body = [
            'Messages' => [
                [
                    'From' => [
                            'Email' => 'contact_sendwish@smxme.fr',
                            'Name' => 'Contact Sendwish'
                    ],
                    'To' => [
                        [
                            'Name' => "redirection sendwish vers perso",
                            'Email' => "sendwish@smxme.fr"
                        ]
                    ],
                    'Subject' => "Contact depuis Sendwish.fr !",
                    'TextPart' => "<p>".strtoupper($lastname)." ".$firstname." vous a envoyé un message via le formulaire de contact sur Sendwish : </p><p>".$message."</p><p>Vous pouvez recontacter ".strtoupper($lastname)." ".$firstname." à cette adresse mail : ".$mail."</p>",
                    'HTMLPart' => "<p>".strtoupper($lastname)." ".$firstname." vous a envoyé un message via le formulaire de contact sur Sendwish : </p><p>".$message."</p><p>Vous pouvez recontacter ".strtoupper($lastname)." ".$firstname." à cette adresse mail : ".$mail."</p>"
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() && var_dump($response->getData()); 
    }



    return $app['twig']->render('contact.html.twig',array('theUser' => $app['session']->get('user') ?? NULL));
});



// MENUS ROUTE
$app->get('/nosMenus', function () use ($app) {
    $menus = $app['em']->getRepository(Product::class)->findBy(array('category' => "menu")); 
    return $app['twig']->render('nosMenus.html.twig',array(
        'theUser' => $app['session']->get('user') ?? NULL,
        'menus' => $menus ?? NULL));
});


// SANDWICHS ROUTE
$app->get('/sandwichs', function () use ($app) {
    $sandwichs = $app['em']->getRepository(Product::class)->findBy(array('category' => "sandwich")); 
    return $app['twig']->render('sandwichs.html.twig',array(
        'theUser' => $app['session']->get('user') ?? NULL,
        'sandwichs' => $sandwichs ?? NULL));
});

// DRINKS ROUTE
$app->get('/boissons', function () use ($app) {
    $drinks = $app['em']->getRepository(Product::class)->findBy(array('category' => "drink"));
    return $app['twig']->render('boissons.html.twig',array(
        'theUser' => $app['session']->get('user') ?? NULL,
        'drinks' => $drinks ?? NULL));
});

// SUPPLS ROUTE
$app->get('/petitesFaims', function () use ($app) {
     $suppls = $app['em']->getRepository(Product::class)->findBy(array('category' => "suppl"));
    return $app['twig']->render('petitesFaims.html.twig',array(
        'theUser' => $app['session']->get('user') ?? NULL,
        'suppls' => $suppls ?? NULL));
});

// ACCOUNT INFOS ROUTE
$app->get('/client', function () use ($app) {
    $userSession = $app['session']->get('user');
    $user = $app['em']->getRepository(User::class)->findOneBy(array("id"=>$userSession['id']));
    // return dump($user);
    return $app['twig']->render('espaceClient.html.twig',array(
        'theUser'=>$app['session']->get('user') ?? NULL,
        'infosUserFirstname'=>$user->getFirstname() ?? NULL,
        'infosUserLastname'=>$user->getLastname() ?? NULL,
        'infosUseremail'=>$user->getMail() ?? NULL,
        'infosUserAdress'=>$user->getFormattedAddr() ?? NULL,
        'infosUsertel'=>$user->getTel() ?? NULL,
    ));
});

// ACCOUNT INFOS ROUTE
$app->get('/orderhistory', function () use ($app) {
    $userSession = $app['session']->get('user');
    $user = $app['em']->getRepository(User::class)->findOneBy(array('id'=>$userSession['id']));
    $userOrders = $user->getOrders();
    return $app['twig']->render('clientorderhistory.html.twig',array(
            'theUser' => $app['session']->get('user') ?? NULL,
            'orders'=> $userOrders ?? NULL));
});

// GET CART ROUTE FOR UPDATE IT IN THE NAVBAR
$app->get('/getPanier', function (Request $request) use ($app) {
    $userSession = $app['session']->get('user');
    $user = $app['em']->getRepository(User::class)->findOneBy(array('id'=>$userSession['id']));
    $userCartItems = $user->getCartItems();
    $cleanCartItems=[];
    $totalPrice = 0;
    if(count($userCartItems) === 0){
        $cartHtmlGenerate = "<p class='text-center'>Votre panier est actuellement vide !</p>";
    }else{
    for ($i = 0; $i < count($userCartItems); $i++) {
        if (!array_key_exists($userCartItems[$i]->getProduct()->getId(),$cleanCartItems)){
             $cleanCartItems[$userCartItems[$i]->getProduct()->getId()]=[
                'name' => $userCartItems[$i]->getProduct()->getName(), 
                'id' => $userCartItems[$i]->getProduct()->getId(), 
                'description' => $userCartItems[$i]->getProduct()->getDescription(),
                'price' => $userCartItems[$i]->getProduct()->getPrice(),
                'imagepath' => $userCartItems[$i]->getProduct()->getImagePath(),
                'quantity'=>1
            ];
        }else{
            $cleanCartItems[$userCartItems[$i]->getProduct()->getId()]['quantity']++;          
        }
    }
    $test = "";
    foreach($cleanCartItems as $key=>$value){
        $totalPrice += $value['quantity'] * $value['price'];
    }
    $cleanCartItems['totalPrice'] = $totalPrice;
    $cartHtmlGenerate = "<table class='table table-sm text-center'>".
    "<thead>"."<tr>"."<th>Articles</th>"."<th>Quantité</th>"."<th>Prix</th>"."<th></th>"."</tr>"."</thead>"."<tbody>";

                    foreach ($cleanCartItems as $testKey=>$item) {
                        if($testKey=='totalPrice'){
                            $cartHtmlGenerate.="<tr>";
                            $cartHtmlGenerate.="<td><strong>Prix Total :</strong></td>";
                            $cartHtmlGenerate.="<td></td>";
                            $cartHtmlGenerate.="<td></td>";
                            $cartHtmlGenerate.="<td>".$item."€</td>";
                            $cartHtmlGenerate.="</tr>";
                            $cartHtmlGenerate.="</tbody>";
                            $cartHtmlGenerate.="</table>";
                            $cartHtmlGenerate.='<a href="/ajoutPanier" class="btn btn-block btn-danger w-75 ml-4">Voir le panier</a>';
                        }else{
                            $cartHtmlGenerate.="<tr>";
                            $cartHtmlGenerate.="<td>".$item['name']."</td>";
                            $cartHtmlGenerate.="<td>".$item['quantity']."</td>";
                            $cartHtmlGenerate.="<td>".$item['price']."€</td>";
                            $cartHtmlGenerate.="<td></td>";
                            $cartHtmlGenerate.="</tr>";
                        }
                    }
                }
    return ($cartHtmlGenerate);
});


// CART INFOS ROUTE
$app->get('/ajoutPanier', function () use ($app) {
    $userId = $app['session']->get('user');
    $user = $app['em']->getRepository(User::class)->findOneBy(array('id'=>$userId['id']));
    $cartItems = $user->getCartItems();
    $cleanCartItems=[];
    $totalPrice = 0;
    for ($i = 0; $i < count($cartItems); $i++) {
        if (!array_key_exists($cartItems[$i]->getProduct()->getId(),$cleanCartItems)){
             $cleanCartItems[$cartItems[$i]->getProduct()->getId()]=[
                'name' => $cartItems[$i]->getProduct()->getName(), 
                'id' => $cartItems[$i]->getProduct()->getId(), 
                'description' => $cartItems[$i]->getProduct()->getDescription(),
                'price' => $cartItems[$i]->getProduct()->getPrice(),
                'imagepath' => $cartItems[$i]->getProduct()->getImagePath(),
                'quantity'=>1
            ];
        }else{
            $cleanCartItems[$cartItems[$i]->getProduct()->getId()]['quantity']++;          
        }
    }
    $test = "";
    foreach($cleanCartItems as $key=>$value){
        $totalPrice += $value['quantity'] * $value['price'];
    }
    return $app['twig']->render('panier.html.twig',array(
                'theUser' => $app['session']->get('user') ?? NULL,
                'cartItems' => $cleanCartItems,
                'totalPrice' => $totalPrice
            ));
    });

$app->get('/suppPanier',  function (Request $request) use ($app) {
    $userSession = $app['session']->get('user');
    $userId = $userSession['id'];
    $productItemId = $request->get('productItemId');
    $productsItemPrice = $request->get('productsItemPrice');
    $cartItems = $app['em']->getRepository(CartItem::class)->findBy(array('productId'=>$productItemId,'userId'=>$userId));    
    foreach ($cartItems as $cartItem) {
        $app['em']->remove($cartItem);
    }
    $app['em']->flush();
    return json_encode(['productsItemPrice' => $productsItemPrice,'idDivItem'=>$productItemId]);
});


$app->match('/checkOrderOption', function (Request $request) use ($app) {
    if ($request->get('inputChoiceOrderMode') !== null && 
        ($request->get('inputChoiceOrderMode') === "eatIn" || $request->get('inputChoiceOrderMode') === "eatOut") &&
         $request->get('inputChoicePaiementMode') !== null &&
          ($request->get('inputChoicePaiementMode') === "payIn" || $request->get('inputChoicePaiementMode') === "payOnline")){
            if($request->get('inputChoiceOrderMode') === "eatIn"){
                if($request->get('inputChoicePaiementMode') === "payIn"){
                    return $app->redirect('/order');
                }else{
                    return $app->redirect('/payment');
                }
            }else{
                if($request->get('inputChoicePaiementMode') === "payIn"){
                        //AFFICHER LA ROUTE DE CHOIX D'ADDRESSE AVEC LE PAIEMENT EN RESTO
                    return $app->redirect('/orderAdressChoice');
                }else{
                    return $app->redirect('/payment');
                }
            }
    }else{
        return "Erreurs d'échanges dans les options de commandes entre les 2 routes";
    }
});

$app->get('/orderAdressChoice', function (Request $request) use ($app) {
    return "Page choix d'adresse"; 
});

// ORDER ROUTE
$app->get('/order', function () use ($app) {
    $userSession = $app['session']->get('user');
    if ($userSession['guest'] == true){
        return $app->redirect('/inscription');
    }
    $user = $app['em']->getRepository(User::class)->findOneBy(array('id'=>$userSession['id']));
    $cartItems = $user->getCartItems();
    $order = new Order(0*0.2, 0, 1231231, 0, 1, new DateTime(), $user);
    $total=0;
    $totalDf=0;
    foreach($cartItems as $cartItem){
        $orderItem = new OrderItem($cartItem->getProduct()->getName(), $cartItem->getProduct()->getPrice() - (($cartItem->getProduct()->getPrice() / 100) * 10), $cartItem->getProduct()->getPrice(),$order);
        $order->addOrderItem($orderItem);
        $total+=$cartItem->getProduct()->getPrice();
        $totalDf+= $cartItem->getProduct()->getPrice() - (($cartItem->getProduct()->getPrice() / 100) * 10);
        $app['em']->remove($cartItem);
    }
    $order->setPrice($total);
    $order->setPriceDf($totalDf);
    $randomNumber = 0;
    $buildOrderNumber = "";

    for ($i = 0 ; $i <= 11 ; $i++){
        if($i == 2 || $i == 6 || $i == 11){
            $buildOrderNumber.="-";
        }
        $randomNumber = rand(0,9);
        $buildOrderNumber.=strval($randomNumber);
    }
    $order->setOrderNum($buildOrderNumber);
    $app['em']->persist($order);
    $app['em']->flush();

    return $app->redirect('/ajoutPanier');
});

$app->get('/payment', function () use ($app) {
    return $app['twig']->render('payment.html.twig',array('theUser'=>$app['session']->get('user') ?? null));
});

// CONNECTION ROUTE
$app->match('/connexion', function (Request $request) use ($app) {
    $user = $app['em']->getRepository(User::class)->findOneBy(array('mail' => $request->get('email')));
    $db_password = $user->getPassword();
    if (null !== $user && $db_password) {
        $password_client = htmlspecialchars($request->get('password'));
        if (password_verify($password_client, $db_password)) {
                $app['session']->set('user', array('mail' => $user->getMail(), 'admin' => $user->getIsAdmin(), 'id'=> $user->getId(), 'firstname' => $user->getFirstname(),'guest'=>$user->getIsGuest()));
            return $app->redirect('/?connect=true');
        }        
    }
    return $app['twig']->render('errorLog.html.twig',array('theUser'=>$app['session']->get('user') ?? null));
});

// DISCONNECTION ROUTE
$app->get('/deconnexion', function (Request $request) use ($app) {
    $app['session']->clear();
    return $app->redirect('/');
});

// AJAX CART ROUTE
$app->get('/addToCart', function (Request $request) use ($app) {
    $product = $app['em']->find('Entity\Product',$request->get('carrousel'));
    $userSession = $app['session']->get('user');
    $user = $app['em']->find('Entity\User',$userSession['id']);
    $cartItem = new CartItem($userSession['id'], $request->get('carrousel'), 1, $user, $product);
    $app['em']->persist($cartItem);
    $app['em']->flush();
    return $request->get('carrousel');
});

$app->get('/removeFromCart', function (Request $request) use ($app) {
    $userSession = $app['session']->get('user');
    $user = $app['em']->find('Entity\User',$userSession['id']);
    $userCartItems = $user->getCartItems();
    foreach ($userCartItems as $key => $userCartItem) {
        $product = $userCartItem->getProduct();
        if($product->getId() == $request->get('carrousel')){
            $app['em']->remove($userCartItem);
            $app['em']->flush();
            $newCartItems = $user->getCartItems();
            return $request->get('carrousel');
        }
     } 
});

// AJAX DYNAMIC CARROUSEL ROUTE
$app->get('/generateCarrousel', function (Request $request) use ($app) {
    $test = $app['em']->getRepository(Product::class)->findBy(array('category' => $request->get('productCat'))); 
    return json_encode($test);
});


$app->match('/admin', function (Request $request) use ($app) {
    // $orders = $app['em']->getRepository(Order::class)->findAll(); 
    if (null !== $request->get('productName') && !empty($request->get('productName')) && null !== $request->get('productDescription') && !empty($request->get('productDescription')) &&  null !== $request->get('productPrice') && !empty($request->get('productPrice')) && null !== $request->get('productCal') && !empty($request->get('productCal')) && null !== $request->get('productIngredient') && !empty($request->get('productIngredient')) && null !== $_FILES['productPath'] && !empty($_FILES['productPath']) && null !== $request->get('productCategory') && !empty($request->get('productCategory'))) {

            $varProductName = htmlspecialchars($request->get('productName'));
            $varProductDescription = htmlspecialchars($request->get('productDescription'));
            $varProductPrice = htmlspecialchars($request->get('productPrice'));
            $varProductCal = htmlspecialchars($request->get('productCal'));
            $varProductIngredient = htmlspecialchars($request->get('productIngredient'));
            $varProductCategory = htmlspecialchars($request->get('productCategory'));

            $target_dir = "img/product/";
            $target_file = $target_dir . basename($_FILES["productPath"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["productPath"]["tmp_name"]);
                if($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            
            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["productPath"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["productPath"]["tmp_name"], $target_file)) {
                    echo "The file ". basename( $_FILES["productPath"]["name"]). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }

            $np = new Product($varProductName,$varProductDescription,$varProductPrice,$varProductCal,$varProductIngredient, $target_file, $varProductCategory);
            $em = $app['em'];
            $em->persist($np);
            $em->flush();
            return $app->redirect('/admin');
    } 

        if($request->get('firstname') !== null && !empty($request->get('firstname')) &&
            $request->get('lastname') !== null && !empty($request->get('lastname')) &&
            $request->get('inputGender') !== null && !empty($request->get('inputGender')) &&
            $request->get('email') !== null && !empty($request->get('email')) &&
            $request->get('tel') !== null && !empty($request->get('tel')) &&
            $request->get('birthday') !== null && !empty($request->get('birthday')) &&
            $request->get('address') !== null && !empty($request->get('address')) &&
            $request->get('password') !== null && !empty($request->get('password')) &&
            $request->get('passwordConf') !== null && !empty($request->get('passwordConf')) &&
            $request->get('inputRight') !== null && !empty($request->get('inputRight')) &&
            $request->get('inputLat') !== null && !empty($request->get('inputLat')) &&
            $request->get('inputLng') !== null && !empty($request->get('inputLng')) && 
            $request->get('inputDist') !== null && !empty($request->get('inputDist')) &&
            $request->get('password') == $request->get('passwordConf')){


            $varFirstname = htmlspecialchars($request->get('firstname'));
            $varLastname = htmlspecialchars($request->get('lastname'));
            $varGender = htmlspecialchars($request->get('inputGender'));
            $varTel = htmlspecialchars($request->get('tel'));
            $varBirthday = new DateTime(htmlspecialchars($request->get('birthday')));
            $varAddress = htmlspecialchars($request->get('address'));
            $varMail = htmlspecialchars($request->get('email'));
            $varPassword = password_hash(htmlspecialchars($request->get('password')),PASSWORD_DEFAULT);
            
            if ($request->get('inputRight') === "User") {
                $varIsClient = true;
                $varIsDelivery = false;
                $varIsAdmin = false;
                $varIsGuest = false;
            }else if($request->get('inputRight') === "DeliveryMan"){
                $varIsClient = false;
                $varIsDelivery = true;
                $varIsAdmin = false;
                $varIsGuest = false;
            }else if($request->get('inputRight') === "Admin"){
                $varIsClient = false;
                $varIsDelivery = false;
                $varIsAdmin = true;
                $varIsGuest = false;                
            }else if($request->get('inputRight') === "Guest"){
                $varIsClient = false;
                $varIsDelivery = false;
                $varIsAdmin = false;
                $varIsGuest = true;
            }
            $varLat = htmlspecialchars($request->get('inputLat'));
            $varLng = htmlspecialchars($request->get('inputLng'));
            $varDist = htmlspecialchars($request->get('inputDist'));


             $sd = new User($varLastname, $varFirstname, $varGender, $varMail, $varPassword, $varBirthday, $varAddress, $varLat, $varLng, $varDist, $varTel, $varIsAdmin, $varIsClient, $varIsDelivery, $varIsGuest, new DateTime());
                    $em = $app['em'];
                    $em->persist($sd);
                    $em->flush();
                    return $app->redirect('/admin');
        }        

    return $app['twig']->render('backOffice.html.twig', array('theUser' => $app['session']->get('user') ?? NULL,
    ));
});
$app->match('/backOfficeRefresh', function(Request $request) use ($app) {
    $ordersR = $app['em']->getRepository(Order::class)->findAll();
    
    $orders = [];
    foreach ($ordersR as $order) {
        
        $orders[] = [
            'orderDate' => date_format($order->getorderDate(), 'd/m/Y H:i:s'),
            'priceDf' => $order->getPriceDf(),
            'price' => $order->getPrice(),
            'orderNum' => $order->getorderNum(),
            'eatIn' => $order->geteatIn(),
            'takeOut' => $order->gettakeOut(),
        ];
        
    }
    return new JsonResponse($orders);
});
$app->match('/inscription', function (Request $request) use ($app) {

    $currentUserSession = $app['session']->get('user'); 
    $currentUserID = $currentUserSession['id'];
    $currentUser = $app['em']->getRepository(User::class)->findOneBy(array('id'=>$currentUserID));

    if ($request->get('inscripValid') !== NULL) {
        if (null !== $request->get('firstname') && !empty($request->get('firstname')) &&
            null !== $request->get('inputLat') && !empty($request->get('inputLat')) &&
            null !== $request->get('inputLng') && !empty($request->get('inputLng')) &&
            null !== $request->get('inputDist') && !empty($request->get('inputDist')) &&
            null !== $request->get('lastname') && !empty($request->get('lastname')) &&
            null !== $request->get('address') && !empty($request->get('address')) &&
            null !== $request->get('email') && !empty($request->get('email')) &&
            null !== $request->get('tel') && !empty($request->get('tel')) &&
            null !== $request->get('birthday') && !empty($request->get('birthday')) &&
            null !== $request->get('password') && !empty($request->get('password')) &&
            null !== $request->get('passwordConf') && !empty($request->get('passwordConf')) &&
            null !== $request->get('inputGender') && !empty($request->get('inputGender')) &&
            $request->get('password') === $request->get('passwordConf')) {

                $varFirstName = htmlspecialchars($request->get('firstname'));
                $varLastName = htmlspecialchars($request->get('lastname'));
                $varLat = htmlspecialchars($request->get('inputLat'));
                $varLng = htmlspecialchars($request->get('inputLng'));
                $varDist = htmlspecialchars($request->get('inputDist'));
                $varAddress = htmlspecialchars($request->get('address'));
                $varEmail = htmlspecialchars($request->get('email'));
                $varTel = htmlspecialchars($request->get('tel'));
                $varBirthday = htmlspecialchars($request->get('birthday'));
                $varPassWord = htmlspecialchars($request->get('password'));
                $varPassWordConf = htmlspecialchars($request->get('passwordConf'));
                $varGender = htmlspecialchars($request->get('inputGender'));

                $password = password_hash($varPassWord,PASSWORD_DEFAULT);
                if($currentUser->getIsGuest() == true){

                    $currentUser->setFirstname($varFirstName);
                    $currentUser->setLastname($varLastName);
                    $currentUser->setMail($varEmail);
                    $currentUser->setPassword($password);
                    $currentUser->setBirthdate(new DateTime($varBirthday));
                    $currentUser->setFormattedAddr($varAddress);
                    $currentUser->setLat($varLat);
                    $currentUser->setLng($varLng);
                    $currentUser->setDistance($varDist);
                    $currentUser->setTel($varTel);
                    $currentUser->setIsAdmin(false);
                    $currentUser->setIsClient(true);
                    $currentUser->setIsDelivery(false);
                    $currentUser->setIsGuest(false);
                    $currentUser->setMemberSince(new DateTime());
                    $currentUser->setGender($varGender);
                    $em = $app['em'];
                    $em->persist($currentUser);
                }
                $em->flush();
                $user = $app['em']->getRepository(User::class)->findOneBy(array('mail' => $request->get('email')));
                $app['session']->set('user', array('mail' => $user->getMail(), 'admin' => $user->getIsAdmin(), 'id'=> $user->getId(), 'firstname' => $user->getFirstname(),'guest'=>$user->getIsGuest()));
            return $app->redirect('/?register=true');
        }
    }else{
        if($currentUser->getIsGuest() && count($currentUser->getCartItems()) != 0){
        return $app['twig']->render('logForOrder.html.twig', array('theUser' => $app['session']->get('user') ?? NULL));
        }
    }
    return $app['twig']->render('inscription.html.twig', array('theUser' => $app['session']->get('user') ?? NULL));
});
$app->error(function (\Exception $e, Request $request, $code) use ($app) {
if ($app['debug']) {
return;
}

// 404.html, or 40x.html, or 4xx.html, or error.html
$templates = array(
'errors/'.$code.'.html.twig',
'errors/'.substr($code, 0, 2).'x.html.twig',
'errors/'.substr($code, 0, 1).'xx.html.twig',
'errors/default.html.twig',
);
return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});