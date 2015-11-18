<?php

$app->get('/chapter1/read',function() use($app) {
    $sql = 'select * from  user where id = ?';
    $con = $app['db'];
    $sth = $con->prepare($sql);
    $sth->execute(array(mt_rand(1,100000)));
    $result = $sth->fetch(PDO::FETCH_BOTH);
    return $app['twig']->render('chapter1.twig',['user' => $result['name']]);
});

$app->post('/chapter1/write',function() use($app) {
    $con = $app['db'];
    $sql = 'insert into message values(null,?,?,?,now(),now())';
    $sth = $con->prepare($sql);
    $id = mt_rand(1,1000007);
    $sth->execute(array($id,'title',$_POST['message'].'by '.$id));
    return $app->redirect('/chapter1/read');
});

