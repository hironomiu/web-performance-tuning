<?php

$app->get('/chapter1/read',function($request,$response,$args) {
    $session = $this->get('session');
    $csrf = $this->get('csrf');
    $sql = 'select * from  users where id = ?';
    $con = $this->get('pdo');
    $sth = $con->prepare($sql);
    $sth->execute(array(mt_rand(1,100000)));
    $result = $sth->fetch(PDO::FETCH_BOTH);
    $name_key = $csrf->getTokenNameKey();
    $value_key = $csrf->getTokenValueKey();
    $name = $csrf->getTokenName();
    $value = $csrf->getTokenValue();
    return $this->view->render($response,'chapter1.twig',['user' => $result['name'],'name_key' => $name_key,'value_key' => $value_key,'name' => $name,'value' => $value]);
});

$app->post('/chapter1/write',function($request,$response,$args) {
    $sql = 'insert into messages values(null,?,?,?,now(),now())';
    $con = $this->get('pdo');
    $sth = $con->prepare($sql);
    $id = mt_rand(1,1000007);
    $sth->execute(array($id,'title',$_POST['message'].'by '.$id));
    return $response->withStatus(301)->withHeader('Location', '/chapter1/read');
    //return "Success!";
});
