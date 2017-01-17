<?php
$app->get('/exercise/part1',function($request,$response,$args) {
    $message_line = [];
    for($i = 0; $i <= 1000; $i++){
        $message_line[] = ['message' => 'Sunrise' . date('Y') . '　チューニングバトル！誰が栄冠の1位になるのか？0.001秒を削る熱いバトル！！！誰が？誰が？誰が？誰が栄冠の1位に！！！！！！！！！！！'];
    }
    return $this->view->render($response,'exercise_part1.twig',['message_line' => $message_line]);
});

$app->get('/exercise/part2',function($request,$response,$args) {
    $sql = 'select * from  users where id = ?';
    $id = mt_rand(1,100000);
    $con = $this->get('pdo');
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
    return $this->view->render($response,'exercise_part2.twig',['user' => $user,'messages' => $messages,'follow' => $follow,'follower' => $follower,'message_line' => $message_line]);
});

// $app->post('/exercise/part3',function($request,$response,$args) {
$app->get('/exercise/part3',function($request,$response,$args) {
    $con = $this->get('pdo');
    $sql = 'insert into messages values(null,?,?,?,now(),now())';
    $sth = $con->prepare($sql);
    $id = mt_rand(1,1000007);
    $sth->execute(array($id,'title','message by '.$id));
    return $response->withStatus(301)->withHeader('Location', '/exercise/part2');
});

$app->get('/exercise/part4',function($request,$response,$args) {
    $con = $this->get('pdo');
    $sql = 'select * from messages where title = ? order by created_at desc limit 10';
    $sth = $con->prepare($sql);
    $sth->execute(array($request->getQueryParams()['title']));
    $message_line = $sth->fetchAll();
    return $this->view->render($response,'exercise_part1.twig',['message_line' => $message_line]);
});

$app->get('/exercise/part5',function($request,$response,$args) {
    return $this->view->render($response,'exercise_part5.twig');
});

$app->get('/exercise/part6',function($request,$response,$args) {
    $con = $this->get('pdo');
    $sql = 'select * from users order by rand() limit 10';
    $sth = $con->prepare($sql);
    $sth->execute();
    $users = $sth->fetchAll();
    return $this->view->render($response,'exercise_part6.twig',['title' => 'オススメユーザ','users' => $users]);
});

$app->get('/exercise/part7',function($request,$response,$args) {
    $con = $this->get('pdo');
    $id = mt_rand(1,100000);
    $sql = 'select user_id,message,created_at from messages where user_id in (select follow_user_id from follows where user_id = ?) order by created_at desc limit 10';
    $sth = $con->prepare($sql);
    $sth->execute(array($id));
    $time_lines = $sth->fetchAll();

    return $this->view->render($response,'exercise_part7.twig',['title' => $id . 'さんのタイムライン','time_lines' => $time_lines]);
});

$app->get('/exercise/part8',function($request,$response,$args) {
    $con = $this->get('pdo');
    $id = mt_rand(1,100000);
    $message = "キャンペーン中!!";
    $sql = 'select count(*) as cnt
        from users a
        where TIMESTAMPDIFF(YEAR,a.birthday,CURDATE()) >
         (select avg(TIMESTAMPDIFF(YEAR,b.birthday,CURDATE())) AS age
           from users b
             where a.sex = b.sex)
             and a.id = ?';
    $sth = $con->prepare($sql);
    $sth->execute(array($id));
    $result = $sth->fetch(PDO::FETCH_BOTH);
    $cnt = $result['cnt'];
    if ($cnt === 0){
        $message = "キャンペーン期間外";
        return $this->view->render($response,'exercise_part8.twig',['title' => 'キャンペーン情報','id' => $id,'message' => $message]);
    }
    return $this->view->render($response,'exercise_part8.twig',['title' => 'キャンペーン情報','id' => $id,'message' => $message]);
});
