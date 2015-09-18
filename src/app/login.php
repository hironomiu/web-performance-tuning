<?php

$app->get('/logout',function() use($app) {
    $app['session']->clear();
    return $app->redirect('/');
});

$app->get('/login',function() use($app,$redirectIfLogin) {
    if(!empty($app['session']->get('user_id'))){
        return $app->redirect('/');
    }
    return $app['twig']->render('login.twig');
});

$app->post('/login',function() use($app) {
    if(!empty($app['session']->get('user_id'))){
        return $app->redirect('/');
    }
    $app['session']->start();
    $app['session']->set('user_id', "1");
    $app['session']->set('username', "hironomiuhoge");
    return $app->redirect('/');
});
