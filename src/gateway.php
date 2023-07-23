#!/usr/bin/env php
<?php
/**
 * GatewayWorker
 * @link https://www.workerman.net/doc/gateway-worker/
 */
use David\Gateway\Server;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/support/bootstrap.php';

ini_set('display_errors', 'on');
error_reporting(E_ALL);
// 限定运行模式
if (PHP_SAPI !== 'cli') {
    exit("You must run the CLI environment\n");
}

Server::run();
