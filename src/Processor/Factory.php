<?php

namespace David\Gateway\Processor;

use Exception;
use support\Container;

/**
 * 事件工厂
 */
class Factory
{
    /**
     * 事件处理类后缀
     * @var string
     */
    public static string $suffix = 'Event';

    /**
     * @param string $event
     * @return EventAbstract
     * @throws Exception
     */
    public static function make(string $event): EventAbstract
    {
        $className = static::getClassName($event);
        $class = static::getNamespace() . '\\' . $className;
        if (!class_exists($class)) {
            throw new Exception($class . ' Not Found');
        }
        if (!is_a($class, EventAbstract::class, true)) {
            throw new Exception($class . ' Not Extends ' . EventAbstract::class);
        }
        //return new $class();
        return Container::get($class);
    }

    /**
     * @param string $event
     * @return string
     */
    protected static function getClassName(string $event): string
    {
        $eventTypePart = explode('.', $event);
        $ucfirstEventTypePart = array_map('ucfirst', $eventTypePart);
        return implode('', $ucfirstEventTypePart) . static::$suffix;
    }

    /**
     * 事件处理类命名空间
     * @return string
     */
    protected static function getNamespace(): string
    {
        return __NAMESPACE__;
    }
}
