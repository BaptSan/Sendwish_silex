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
    if (isset($_POST['firstname']) && !empty($_POST['firstname']) &&
        isset($_POST['lastname']) && !empty($_POST['lastname']) &&
        isset($_POST['address']) && !empty($_POST['address']) &&
        isset($_POST['email']) && !empty($_POST['email']) &&
        isset($_POST['tel']) && !empty($_POST['tel']) &&
        isset($_POST['birthday']) && !empty($_POST['birthday']) &&
        isset($_POST['password']) && !empty($_POST['password']) &&
        isset($_POST['passwordConf']) && !empty($_POST['passwordConf']) &&
        $_POST['password'] === $_POST['passwordConf']) {
        $varFirstName = htmlspecialchars($_POST['firstname']);
        $varLastName = htmlspecialchars($_POST['lastname']);
        $varAddress = htmlspecialchars($_POST['address']);
        $varEmail = htmlspecialchars($_POST['email']);
        $varTel = htmlspecialchars($_POST['tel']);
        $varBrithday = htmlspecialchars($_POST['birthday']);
        $varPassWord = htmlspecialchars($_POST['password']);
        $varPassWordConf = htmlspecialchars($_POST['passwordConf']);;
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
}else{
return $app['twig']->render('inscription.html.twig', array());
}
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