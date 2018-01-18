<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Entity\User;

//Request::setTrustedProxies(array('127.0.0.1'));
$app->get('/', function () use ($app) {     
    return $app['twig']->render('index.html.twig', array( 
        'isRegister' => $_GET['register'] ?? NULL  
    )); 
})
->bind('homepage');
$app->get('/contact', function () use ($app) {
    return $app['twig']->render('contact.html.twig');
});

$app->get('/nosMenus', function () use ($app) {
    return $app['twig']->render('nosMenus.html.twig');
});

$app->get('/sandwichs', function () use ($app) {
    return $app['twig']->render('sandwichs.html.twig');
});

$app->get('/boissons', function () use ($app) {
    return $app['twig']->render('boissons.html.twig');
});

$app->get('/petitesFaims', function () use ($app) {
    return $app['twig']->render('petitesFaims.html.twig');
});
$app->get('/client', function () use ($app) {
    return $app['twig']->render('espaceClient.html.twig');
});


$app->match('/connexion', function (Request $request) use ($app) {
    $user = $app['em']->getRepository(User::class)->findOneBy(array('mail' => $request->get('mailConnect')));
    if (null !== $user && $user->getPassword()) {
            dump($user->getPassword());
            dump($request->get('mdpConnect'));
            dump(password_hash($request->get('mdpConnect'), PASSWORD_DEFAULT));
        if (password_hash(htmlspecialchars($request->get('mdpConnect')), PASSWORD_DEFAULT) == $user->getPassword()) {
            dump('test');
            // return new Response(var_dump($users[0]->getPassword()));
            return $app->redirect('/');
        }        
    } return 'coucou';
});

$app->match('/inscription', function (Request $request) use ($app) {
    $thevar = new User();
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
        }
        $sd = new User();
        $em = $app['em'];
        $sd->setFirstname($varFirstName);
        $sd->setLastname($varLastName);
        $sd->setMail($varEmail);
        // $sd->setPassword($varPassWord);
        $sd->setPassword(password_hash($varPassWord, PASSWORD_DEFAULT));
        $sd->setTel($varTel);
        $sd->setFormattedAddr($varAddress);
        $sd->setBirthdate(new DateTime($varBirthday));
        $sd->setLat($varLat);
        $sd->setIsAdmin(true);
        $sd->setIsClient(false);
        $sd->setIsDelivery(false);
        $sd->setLng($varLng);
        $sd->setDistance($varDist);
        $em->persist($sd);
        $em->flush();
        return $app->redirect('/?register=true');
    }
    return $app['twig']->render('inscription.html.twig', array());
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