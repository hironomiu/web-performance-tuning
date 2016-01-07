<?php

$app->get('/chapter2',function($request,$response,$args) {
    $req = $request->getQueryParams();
    $sql = 'select * from messages where user_id = ?';
    $con = $this->get('pdo');
    $sth = $con->prepare($sql);
    $sth->execute(array($req['user_id']));
    $results = $sth->fetchAll();
    return $this->view->render($response,'chapter2.twig',['messages' => $results]);
});

$app->post('/chapter2',function($request,$response,$args) {
    $req = $request->getParsedBody();
    $sql = 'insert into messages values(null,?,?,?,now(),now())';
    $con = $this->get('pdo');
    $sth = $con->prepare($sql);
    $sth->execute( array( $req['user_id'],$req['title'],$req['message']));
    return $this->view->redirect('/chapter2?user_id='.$req['user_id']);
});
