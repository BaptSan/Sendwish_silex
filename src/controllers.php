<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
//Request::setTrustedProxies(array('127.0.0.1'));
$app->get('/', function () use ($app) {
return $app['twig']->render('index.html.twig', array());
})
->bind('homepage')
;
$app->get('/inscription', function (Request $request) use ($app) {
    if (isset($request->get('inscripValid'))) {
//Connexion à la base de donnée : sendwish_test
        $bdd = new PDO('mysql:host=localhost; dbname=sendwish_test;charset=utf8','root','');
        if (isset($request->get('firstname')) && !empty($request->get('firstname')) &&
            isset($request->get('lastname')) && !empty($request->get('lastname')) &&
            isset($request->get('address')) && !empty($request->get('address')) &&
            isset($request->get('email')) && !empty($request->get('email')) &&
            isset($request->get('tel')) && !empty($request->get('tel')) &&
            isset($request->get('birthday')) && !empty($request->get('birthday')) &&
            isset($request->get('password')) && !empty($request->get('password')) &&
            isset($request->get('passwordConf')) && !empty($request->get('passwordConf')) &&
            $request->get('password') === $request->get('passwordConf')) {
            $varFirstName = htmlspecialchars($request->get('firstname'));
            $varLastName = htmlspecialchars($request->get('lastname'));
            $varAddress = htmlspecialchars($request->get('address'));
            $varEmail = htmlspecialchars($request->get('email'));
            $varTel = htmlspecialchars($request->get('tel'));
            $varBrithday = htmlspecialchars($request->get('birthday'));
            $varPassWord = htmlspecialchars($request->get('password'));
            $varPassWordConf = htmlspecialchars($request->get('passwordConf'));;
            $addAddress = $bdd->prepare("INSERT INTO address (formatted, telephone)
                                        VALUES (:add, :phone)
                                        ");
            $addAddress->execute(array(
                        'add' => $varAddress,
                        'phone' => $varTel,
                        ));
            $addAccess = $bdd->prepare("INSERT INTO access (password, mail)
                                        VALUES (:passW, :em)
                                        ");
            $addAccess->execute(array(
                        'passW' => $varPassWord,
                        'em' => $varEmail,
                        ));
            $addUsers = $bdd->prepare("INSERT INTO users (lastname, firstname)
                                    VALUES (:lastN, :firstN)
                                    ");
            $addUsers->execute(array(
                        'lastN' => $varLastName,
                        'firstN' => $varFirstName,
                        ));
        }
        return // revois 'félicitation votre inscription est validéé !'
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