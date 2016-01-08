<?php

$app->get('/login',function ($request, $response, $args) {
    $session = $this->get('session');
    if(!(is_null($session->get('user_id')))){
        return $response->withStatus(301)->withHeader('Location', '/');
    }
    return $this->view->render($response,'login.twig',$args);
});

$app->post('/login',function ($request, $response, $args) {
    $session = $this->get('session');
    if(!(is_null($session->get('user_id')))){
        return $response->withStatus(301)->withHeader('Location', '/');
    }
    $session->regenerate();
    $session->set('user_id', "1");
    $session->set('username', "hironomiuhoge");
    return $response->withStatus(301)->withHeader('Location', '/');
});

$app->get('/logout',function ($request, $response, $args) {
    $session = $this->get('session');
    $session->destroy();
    return $response->withStatus(301)->withHeader('Location', '/');
});

$app->get('/',function ($request, $response, $args) {
    $session = $this->get('session');
    if(is_null($session->get('user_id'))){
        return $response->withStatus(301)->withHeader('Location', '/login');
    }
    echo "hello!";
//    return $app['twig']->render('index.twig',['username' => $app['session']->get('username'),'messages' => 15,'follow' => 10 ,'follower' => 20]);
});
