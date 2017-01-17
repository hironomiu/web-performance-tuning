<?php

$app->get('/chapter3/db',function($request,$response,$args) {
    $sql = 'select name from  users where id = ?';
    $con = $this->get('pdo');
    $sth = $con->prepare($sql);
    $sth->execute(array(mt_rand(1,100000)));
    $result = $sth->fetch(PDO::FETCH_BOTH);
    return $this->view->render($response,'chapter1.twig',['user' => $result['name']]);
});

$app->get('/chapter3/cache',function($request,$response,$args) {
    $pass = null;
    $mem = $this->get('memcached');
    $name = $mem->get(mt_rand(1,100000));
    return $this->view->render($response,'chapter1.twig',['user' => $name]);
});
