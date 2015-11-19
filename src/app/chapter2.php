<?php

$app->get('/chapter2',function() use($app) {
    $sql = 'select * from messages where user_id = ?';
    $con = $app['db'];
    $sth = $con->prepare($sql);
    $sth->execute(array($app['request']->get('user_id')));
    $results = $sth->fetchAll();
    return $app['twig']->render('chapter2.twig',['messages' => $results]);
});

$app->post('/chapter2', function() use($app) {
    $sql = 'insert into messages values(null,?,?,?,now(),now())';
    $con = $app['db'];
    $sth = $con->prepare($sql);
    $sth->execute( array( $app['request']->get('user_id'),$app['request']->get('title'),$app['request']->get('message')));
    return $app->redirect('/chapter2?user_id=1000001');
});
