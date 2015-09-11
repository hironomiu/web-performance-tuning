<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';

use Silex\Application;

$app = new Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path'       => __DIR__ . '/views',
    'twig.class_path' => __DIR__ . '/../vendor/twig/lib',
));

$app->register(new Silex\Provider\SessionServiceProvider());

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

