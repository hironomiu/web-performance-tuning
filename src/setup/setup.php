<?php
set_time_limit(9900);

$app->get('/memcache_setup',function() use($app) {
    $con = $app['db'];
    $sql = 'select id,password from users';
    $sth = $con->prepare($sql);
    $sth->execute();
    while($result = $sth->fetch(PDO::FETCH_ASSOC)){
        $mem = $app['memcached'];
        $mem->set($result['id'],$result['password'] );
    }
    $message = 'finished';
    return $message;
});

$app->get('/mysql_setup',function() use($app) {
    $con = $app['db'];
    $sql = 'select count(*) as count from users';
    $sth = $con->prepare($sql);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_BOTH);
    if($result['count'] > 0){
        $message = 'データが存在します。';
    }else{
        $sql = 'insert into users values(null,?,?,?,?,?,?,?,now(),now())';
        $sth = $con->prepare($sql);
        for($l = 0;$l < 1000000; $l++){
        //for($l = 0;$l < 100; $l++){
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
        }
        $sth->execute(array('hironomiu','hironomiu@example.com',sha1('password'),0,'1971/02/26',$profile1,$profile1));
        $message = "finished";
    }
    return $message;
});

$app->get('/exercise_mysql_setup',function() use($app) {
    $con = $app['db'];
    $sql = 'insert into messages values(null,?,?,?,now(),now())';
    $sth = $con->prepare($sql);
    for($i = 0;$message = null,$i < 10000000; $i++){
        $user = mt_rand(1,100000);
        $title = $user . 'title' . $user;
        $num = mt_rand(0x31,0x7A);
        if((0x30 <= $num && $num <= 0x3b) || (0x41 <= $num && $num <= 0x5A) || (0x61 <= $num && $num <= 0x7A)){
            $message .= chr($num);
        }
        for($l = 0;$l < 50; $l++){
            $message .= $user;
        }
        $sth->execute(array($user,$title,$message));
    }
    $message = "finished";
    return $message;
});

