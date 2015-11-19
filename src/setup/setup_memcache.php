<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../config.php';
use Silex\Application;
ini_set('memory_limit', '256M');

$app = new Application();

$app['db'] = function() use($app,$host,$mysqldConfig){
    try{
        $con = new PDO(sprintf('mysql:host=%s;dbname=%s;charset=utf8', $host, $mysqldConfig['database']), $mysqldConfig['user'], $mysqldConfig['password'], array(PDO::ATTR_EMULATE_PREPARES => false));
    }catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        die;
    }
    return $con;
};

$app['memcached'] = function() use($app,$host,$memcachedConfig){
    $mem = new Memcached();
    $mem->addServer($host,$memcachedConfig['port']);
    return $mem;
};

$con = $app['db'];
$sql = 'select id,name from users order by id';
$sth = $con->prepare($sql);
$sth->execute();
while($result = $sth->fetch(PDO::FETCH_ASSOC)){
    $mem = $app['memcached'];
    $mem->set($result['id'],$result['name'] );
    if($result['id'] % 10000 === 0){
        echo $result['id']."\n";
    }
}
$message = 'finished';
echo  $message;
