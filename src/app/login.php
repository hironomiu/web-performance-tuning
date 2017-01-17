<?php

session_start();
$app->add($container->get('csrf'));

$app->get('/login',function ($request, $response, $args) use($app){
    $session = $this->get('session');
    $csrf = $this->get('csrf');
    if(!(is_null($session->get('user_id')))){
        return $response->withStatus(301)->withHeader('Location', '/');
    }
    $name_key = $csrf->getTokenNameKey();
    $value_key = $csrf->getTokenValueKey();
    $name = $csrf->getTokenName();
    $value = $csrf->getTokenValue();
    return $this->view->render($response,'login.twig',['name_key' => $name_key,'value_key' => $value_key,'name' => $name,'value' => $value]);
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
})->add($container->get('csrf'));

$app->get('/',function ($request, $response, $args) {
    $session = $this->get('session');
    $csrf = $this->get('csrf');
    if(is_null($session->get('user_id'))){
        return $response->withStatus(301)->withHeader('Location', '/login');
    }
    $name_key = $csrf->getTokenNameKey();
    $value_key = $csrf->getTokenValueKey();
    $name = $csrf->getTokenName();
    $value = $csrf->getTokenValue();
    echo '<input type="hidden" name="'. $name_key .'" value="'. $name .'">';
    echo '<input type="hidden" name="'. $value_key .'" value="'. $value .'">';
    echo "hello!";
    echo $request->getQueryParams()['abc'];
});
