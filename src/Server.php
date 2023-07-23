<?php

namespace David\Gateway;

use GatewayWorker\BusinessWorker;
use GatewayWorker\Gateway;
use GatewayWorker\Register;
use RuntimeException;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;

/**
 * 启动GatewayWorker服务
 * - @link https://www.workerman.net/doc/gateway-worker/
 */
class Server
{
    /**
     * 运行
     * @return void
     */
    public static function run(): void
    {
        /**
         * 初始化默认的配置
         */
        $config = config('plugin.ledc.gateway.app.default', []);
        Worker::$pidFile = $config['pid_file'] ?? '';
        Worker::$stdoutFile = $config['stdout_file'] ?? '/dev/null';
        Worker::$logFile = $config['log_file'] ?? '';
        Worker::$eventLoopClass = $config['event_loop'] ?? '';
        TcpConnection::$defaultMaxPackageSize = $config['max_package_size'] ?? 10 * 1024 * 1024;
        if (property_exists(Worker::class, 'statusFile')) {
            Worker::$statusFile = $config['status_file'] ?? '';
        }
        if (property_exists(Worker::class, 'stopTimeout')) {
            Worker::$stopTimeout = $config['stop_timeout'] ?? 2;
        }

        /**
         * 启动进程
         */
        $process = config('plugin.ledc.gateway.app.process');
        foreach ($process as $name => $config) {
            if ($config['enable'] ?? false) {
                $handler = $config['handler'];
                $listen = $config['listen'] ?? '';
                $properties = $config['properties'] ?? [];
                /** @var Worker $worker */
                $worker = new $handler($listen);
                $worker->name = $name;
                foreach ($properties as $property => $value) {
                    $worker->{$property} = $value;
                }
            }
        }

        Worker::runAll();
    }
}
