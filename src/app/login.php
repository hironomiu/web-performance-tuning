<?php

$app->get('/login',function ($request, $response, $args) use($app) {
    $req = $request->getQueryParams();
    if(!empty($req['user_id'])){
        return $app->redirect('/');
    }
    return $this->view->render($response,'login.twig',$args);
});

/*
$app->get('/logout',function() use($app) {
    $app['session']->clear();
    return $app->redirect('/');
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
*/
