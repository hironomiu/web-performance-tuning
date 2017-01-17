<?php

$app->post('/messages',function() use($app) {
    return $app->redirect('/');
});

$app->get('/messages',function() use($app) {
    $arr = array('message' => 'hogehoge', 'username' => 'hironomiu');
    return json_encode($arr);
});
