<?php


require_once 'vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

$server = new \React\Socket\Server('127.0.0.1:80', $loop);

$server->on('connection', function(ConnectionInterface $connection) {
    echo $connection->getRemoteAddress() . PHP_EOL;
    $connection->write('Hello');
});

$loop->run();

