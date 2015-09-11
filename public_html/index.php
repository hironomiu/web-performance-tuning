<?php
require_once __DIR__ . '/../src/bootstrap.php';
require_once __DIR__ . '/../src/app/setup.php';

require_once __DIR__ . '/../src/app/chapter1.php';
require_once __DIR__ . '/../src/app/chapter2.php';
require_once __DIR__ . '/../src/app/chapter3.php';

require_once __DIR__ . '/../src/app/exercise.php';

$app->get('/',function() use($app) {
    return $app['twig']->render('index.twig');
});

$app->get('/info',function() use($app) {
    return phpinfo();
});

$app->run();
