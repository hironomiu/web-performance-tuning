<?php

$app->get('/chapter1/read',function($request,$response,$args) {
    $sql = 'select * from  users where id = ?';
    $con = $this->get('pdo');
    $sth = $con->prepare($sql);
    $sth->execute(array(mt_rand(1,100000)));
    $result = $sth->fetch(PDO::FETCH_BOTH);
    return $this->view->render($response,'chapter1.twig',['user' => $result['name']]);
    //return $this->view->render($response,'chapter1.twig',$result['name']]);
});

$app->post('/chapter1/write',function($request,$response,$args) {
    $sql = 'insert into messages values(null,?,?,?,now(),now())';
    $con = $this->get('pdo');
    $sth = $con->prepare($sql);
    $id = mt_rand(1,1000007);
    $sth->execute(array($id,'title',$_POST['message'].'by '.$id));
    //return $app->redirect('/chapter1/read');
    return "Success!";
});
