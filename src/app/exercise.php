<?php

$app->get('/exercise/part1',function() use($app) {
    return $app['twig']->render('exercise_part1.twig');
});

$app->get('/exercise/part2',function() use($app) {
    $con = $app['db'];
    $sql = 'select birthday,sex from  user where id = ?';
    $sth = $con->prepare($sql);
    $sth->execute(array(mt_rand(1,1000007)));
    $result = $sth->fetch(PDO::FETCH_BOTH);
    return $app['twig']->render('exercise_part2.twig',['birthday' => $result['birthday'],'sex' => $result['sex']===1?'男':'女']);
});

$app->post('/exercise/part3',function() use($app) {
    $con = $app['db'];
    $sql = 'insert into message values(null,?,?,?,now(),now())';
    $sth = $con->prepare($sql);
    $id = mt_rand(1,1000007);
    $sth->execute(array($id,$_POST['title'],$_POST['message'].'by '.$id));
    return $app->redirect('/exercise/part1');
});

$app->get('/exercise/part4',function() use($app) {
    $con = $app['db'];
    $sql = 'select * from  message where title = ? order by created_at desc limit 10';
    $sth = $con->prepare($sql);
    $sth->execute(array('チューニングバトル'));
    $results = $sth->fetchAll();
    return $app['twig']->render('exercise_part4.twig',['messages' => $results]);
});
