<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../config.php';

ini_set('memory_limit', '256M');

$app = new \Slim\App(['settings' => ['displayErrorDetails' => true]]);

$container = $app->getContainer();

$container['pdo'] = function() use($container,$host,$mysqldConfig){
    $cfg = $container->get('settings')['db'];
    return new PDO(sprintf('mysql:host=%s;dbname=%s;charset=utf8', $host, $mysqldConfig['database']), $mysqldConfig['user'], $mysqldConfig['password'], array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_PERSISTENT => true));
};

$container['memcached'] = function() use($container,$host,$mysqldConfig){
    $mem = new Memcached();
    $mem->addServer($host,$memcachedConfig['port']);
    return $mem;
};

$con = $container['pdo'];
$sql = 'select id,name from users order by id';
$sth = $con->prepare($sql);
$sth->execute();

while($result = $sth->fetch(PDO::FETCH_ASSOC)){
    $mem = $container['memcached'];
    $mem->set($result['id'],$result['name'] );
    if($result['id'] % 10000 === 0){
        echo $result['id']."\n";
    }
}

echo "finished\n";
