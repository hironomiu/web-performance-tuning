<?php

$app->get('/chapter3/db',function() use($app) {
    $sql = 'select password from  user where id = ?';
    $con = $app['db'];
    $sth = $con->prepare($sql);
    $sth->execute(array(mt_rand(1,100000)));
    $result = $sth->fetch(PDO::FETCH_BOTH);
    return $app['twig']->render('chapter1.twig',['user' => $result['password']]);
});


$app->get('/chapter3/cache',function() use($app) {
    $pass = null;
    $mem = $app['memcached'];
    $password = $mem->get(mt_rand(1,100000));
    return $app['twig']->render('chapter1.twig',['user' => $password]);
});
