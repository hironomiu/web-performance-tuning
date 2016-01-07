<?php
$app->get('/perf_exercise/part1',function() use($app) {
    $sql = 'select * from  users where id = ?';
    $id = mt_rand(1,100000);
    $con = $app['db'];
    $sth = $con->prepare($sql);
    $sth->execute(array($id));
    $result = $sth->fetch(PDO::FETCH_BOTH);
    $user = $result['name'];

    $sql = 'select count(*) as messages from messages where user_id = ?';
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

    $sql = 'select * from messages where id = ? order by created_at desc limit 10';
    $sth = $con->prepare($sql);
    $sth->execute(array($id));
    $message_line = $sth->fetchAll();
    return $app['twig']->render('exercise_part2.twig',['user' => $user,'messages' => $messages,'follow' => $follow,'follower' => $follower,'message_line' => $message_line]);
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
    $message_line = $sth->fetchAll();
    return $app['twig']->render('exercise_part2.twig',['message_line' => $message_line]);
});

$app->get('/exercise/part5',function() use($app) {
    return $app['twig']->render('exercise_part5.twig');
});
