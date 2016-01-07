<?php
require_once __DIR__ . '/../src/bootstrap.php';
require_once __DIR__ . '/../src/app/login.php';
require_once __DIR__ . '/../src/app/exercise.php';
use Symfony\Component\HttpFoundation\Request;

$app->run();
/*
require_once __DIR__ . '/../src/bootstrap.php';
require_once __DIR__ . '/../src/app/login.php';
require_once __DIR__ . '/../src/app/messages.php';
require_once __DIR__ . '/../src/app/chapter1.php';
require_once __DIR__ . '/../src/app/chapter2.php';
require_once __DIR__ . '/../src/app/chapter3.php';
require_once __DIR__ . '/../src/app/exercise.php';
use Symfony\Component\HttpFoundation\Request;

$app->before(function (Request $request) use ($app) {
    if ('GET_' === $request->attributes->get('_route') && empty($app['session']->get('user_id'))) {
        return $app->redirect('/login');
    }
});

$app->get('/', function() use($app) {
    return $app['twig']->render('index.twig',['username' => $app['session']->get('username'),'messages' => 15,'follow' => 10 ,'follower' => 20]);
})
;

$app->get('/info',function() use($app) {
    return phpinfo();
});

$app->run();
*/
