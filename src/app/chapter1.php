<?php

$app->get('/chapter1/read',function() use($app) {
    $sql = 'select * from  user where id = ?';
    $con = $app['db'];
    $sth = $con->prepare($sql);
    $sth->execute(array(mt_rand(1,100000)));
    $result = $sth->fetch(PDO::FETCH_BOTH);
    return $app['twig']->render('chapter1.twig',['user' => $result['name']]);
});

$app->get('/chapter1/write',function() use($app) {
    $sql = 'insert into user values(null,?,?,?,?,?,?,?,now(),now())';
    $con = $app['db'];
    $sth = $con->prepare($sql);

    for($i = 0,$str = null;$i < 15;){
        $num = mt_rand(0x31,0x7A);
        if((0x30 <= $num && $num <= 0x3b) || (0x41 <= $num && $num <= 0x5A) || (0x61 <= $num && $num <= 0x7A)){
            $str .= chr($num);
            $i++;
        }
    }
    $user = $str;
    $mail = $str . "@example.com";
    $pass = sha1($str);
    for($c = 0,$profile1 = null;$c < 101; $c++){
        $profile1 .= $str;
    }
    $sex = rand(0,1);
    $days = rand(5475,29200);
    $birthday = date("Y/m/d",strtotime("-$days day"));
    $sth->execute(array($user,$mail,$pass,$sex,$birthday,$profile1,$profile1));
    return $app['twig']->render('chapter1.twig',['user' => $user]);
});

