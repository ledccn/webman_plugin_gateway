<?php

namespace David\Gateway\Processor;

use GatewayWorker\Lib\Gateway;

/**
 * ping事件
 */
class PingEvent extends EventAbstract
{
    public function process(int|string $client_id, array $data): void
    {
        Gateway::sendToCurrentClient('{"event":"pong"}');
    }
}