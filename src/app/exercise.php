<?php

$app->get('/exercise/part1',function() use($app) {
    return $app['twig']->render('exercise_part1.twig');
});

$app->get('/exercise/part2',function() use($app) {
    $sql = 'select * from  users where id = ?';
    $id = mt_rand(1,100000);
    $con = $app['db'];
    $sth = $con->prepare($sql);
    $sth->execute(array($id));
    $result = $sth->fetch(PDO::FETCH_BOTH);
    $user = $result['name'];

    $sql = 'select count(*) as messages from message where user_id = ?';
    $sth = $con->prepare($sql);
    $sth->execute(array($id));
    $result = $sth->fetch(PDO::FETCH_BOTH);
    $messages = $result['messages'];

    $sql = 'select count(*) as follow from  follows where user_id = ?';
    $sth = $con->prepare($sql);
    $sth->execute(array($id));
    $result = $sth->fetch(PDO::FETCH_BOTH);
    $follow = $result['follow'];

    $sql = 'select count(*) as follower from  follows where follow_user_id = ?';
    $sth = $con->prepare($sql);
    $sth->execute(array($id));
    $result = $sth->fetch(PDO::FETCH_BOTH);
    $follower = $result['follower'];

    return $app['twig']->render('exercise_part2.twig',['user' => $user,'messages' => $messages,'follow' => $follow,'follower' => $follower]);
});

$app->post('/exercise/part3',function() use($app) {
    $con = $app['db'];
    $sql = 'insert into messages values(null,?,?,?,now(),now())';
    $sth = $con->prepare($sql);
    $id = mt_rand(1,1000007);
    $sth->execute(array($id,$_POST['title'],$_POST['message'].'by '.$id));
    return $app->redirect('/exercise/part1');
});

$app->get('/exercise/part4',function() use($app) {
    $con = $app['db'];
    $sql = 'select * from messages where title = ? order by created_at desc limit 10';
    $sth = $con->prepare($sql);
    $sth->execute(array('チューニングバトル'));
    $results = $sth->fetchAll();
    return $app['twig']->render('exercise_part2.twig',['messages' => $results]);
});

$app->get('/exercise/part5',function() use($app) {
    return $app['twig']->render('exercise_part5.twig');
});
