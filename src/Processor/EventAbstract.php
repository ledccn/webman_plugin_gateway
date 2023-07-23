<?php

namespace David\Gateway\Processor;

/**
 * 事件的抽象类
 */
abstract class EventAbstract
{
    /**
     * 处理事件
     * @param int|string $client_id 长连接客户端id
     * @param array $data 长连接发来的报文
     * @return void
     */
    abstract public function process(int|string $client_id, array $data): void;
}
