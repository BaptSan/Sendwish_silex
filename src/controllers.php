<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Entity\User;
use Entity\CartItem;
use Entity\Product;

//Request::setTrustedProxies(array('127.0.0.1'));
$app->get('/', function () use ($app) {     
    return $app['twig']->render('index.html.twig', array( 
        'isRegister' => $_GET['register'] ?? NULL,
        'connect' => $_GET['connect'] ?? NULL,
        'products' => $myProducts ?? NULL,
        'theUser' => $app['session']->get('user') ?? NULL
    )); 
})
->bind('homepage');
$app->get('/contact', function () use ($app) {
    return $app['twig']->render('contact.html.twig',array('theUser' => $app['session']->get('user') ?? NULL));
});

$app->get('/nosMenus', function () use ($app) {
    $menus = $app['em']->getRepository(Product::class)->findBy(array('category' => "menu")); 
    return $app['twig']->render('nosMenus.html.twig',array(
        'theUser' => $app['session']->get('user') ?? NULL,
        'menus' => $menus ?? NULL));
});

$app->get('/sandwichs', function () use ($app) {
    $sandwichs = $app['em']->getRepository(Product::class)->findBy(array('category' => "sandwich")); 
    return $app['twig']->render('sandwichs.html.twig',array(
        'theUser' => $app['session']->get('user') ?? NULL,
        'sandwichs' => $sandwichs ?? NULL));
});

$app->get('/boissons', function () use ($app) {
    $drinks = $app['em']->getRepository(Product::class)->findBy(array('category' => "drink"));
    return $app['twig']->render('boissons.html.twig',array(
        'theUser' => $app['session']->get('user') ?? NULL,
        'drinks' => $drinks ?? NULL));
});

$app->get('/petitesFaims', function () use ($app) {
     $suppls = $app['em']->getRepository(Product::class)->findBy(array('category' => "suppl"));
    return $app['twig']->render('petitesFaims.html.twig',array(
        'theUser' => $app['session']->get('user') ?? NULL,
        'suppls' => $suppls ?? NULL));
});

$app->get('/client', function () use ($app) {
    return $app['twig']->render('espaceClient.html.twig',array('theUser' => $app['session']->get('user') ?? NULL));
});

$app->get('/ajoutPanier', function () use ($app) {
    return $app['twig']->render('panier.html.twig',array('theUser' => $app['session']->get('user') ?? NULL));
});

$app->match('/connexion', function (Request $request) use ($app) {
    $user = $app['em']->getRepository(User::class)->findOneBy(array('mail' => $request->get('email')));
    $db_password = $user->getPassword();
    if (null !== $user && $db_password) {
        $password_client = htmlspecialchars($request->get('password'));
        if (password_verify($password_client, $db_password)) {
            $app['session']->set('user', array('mail' => $user->getMail(), 'admin' => $user->getIsAdmin(), 'id'=> $user->getId(), 'firstname' => $user->getFirstname()));
            return $app->redirect('/?connect=true');
        }        
    }
    return $app['twig']->render('errorLog.html.twig');
});

$app->get('/deconnexion', function (Request $request) use ($app) {
    $app['session']->clear();
    return $app->redirect('/');
});


$app->get('/panier', function (Request $request) use ($app) {
    $product = $app['em']->find('Entity\Product',$request->get('carrousel'));
    $userSession = $app['session']->get('user');
    $user = $app['em']->find('Entity\User',$userSession['id']);
    $cartItem = new CartItem($userSession['id'], $request->get('carrousel'), 1, $user, $product);
    $app['em']->persist($cartItem);
    $app['em']->flush();
    return $request->get('carrousel');
});

$app->get('/admin', function () use ($app) {
    return $app['twig']->render('backOffice.html.twig', array('theUser' => $app['session']->get('user') ?? NULL));
});

$app->get('/generateCarrousel', function (Request $request) use ($app) {
    $test = $app['em']->getRepository(Product::class)->findBy(array('category' => $request->get('productCat'))); 
    return json_encode($test);
});




$app->match('/admin', function (Request $request) use ($app) {
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
    } return $app->redirect('/admin');
});

$app->match('/inscription', function (Request $request) use ($app) {
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
                $orders="";
                $orders=$cartItems="";

                $sd = new User($varLastName, $varFirstName, $varGender, $varEmail, $password, new DateTime($varBirthday), $varAddress, $varLat, $varLng, $varDist, $varTel, true, false, false, $cartItems, $orders);
                $em = $app['em'];
                $em->persist($sd);
                $em->flush();
                $user = $app['em']->getRepository(User::class)->findOneBy(array('mail' => $request->get('email')));
                $app['session']->set('user', array('mail' => $user->getMail(), 'admin' => $user->getIsAdmin(), 'id'=> $user->getId(), 'firstname' => $user->getFirstname()));
            return $app->redirect('/?register=true');
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