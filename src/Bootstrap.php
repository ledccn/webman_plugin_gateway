<?php

namespace David\Gateway;

use GatewayWorker\Lib\Gateway;
use RuntimeException;
use Workerman\Worker;

/**
 * 初始化\GatewayWorker\Lib\Gateway::class
 */
class Bootstrap implements \Webman\Bootstrap
{
    /**
     * @param Worker|null $worker
     * @return void
     */
    public static function start(?Worker $worker): void
    {
        //密钥
        $gatewaySecret = getenv('GATEWAY_SECRET') ?: '';
        //注册中心地址
        $registerAddress = getenv('GATEWAY_REGISTER_ADDRESS') ?: '127.0.0.1';
        //注册中心端口
        $registerPort = getenv('GATEWAY_REGISTER_PORT') ?: '1236';
        //读取配置时，自动设置注册中心地址和通信密钥
        if (class_exists('\GatewayWorker\Lib\Gateway')) {
            Gateway::$registerAddress = $registerAddress . ':' . $registerPort;
            Gateway::$secretKey = $gatewaySecret;
        } else {
            throw new RuntimeException('\GatewayWorker\Lib\Gateway 不存在');
        }
    }
}
