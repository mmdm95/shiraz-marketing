<?php

namespace HConvert\Traits;


trait InstantiatorTrait
{
    /**
     * @var $instance
     */
    static private $instance = null;

    /**
     * @param mixed ...$_
     * @return InstantiatorTrait
     */
    static public function &getInstance(...$_)
    {
        if (is_null(self::$instance)) {
            self::$instance = new static(...$_);
        }
        return self::$instance;
    }

    /**
     * Release memory from instantiated class object
     */
    static public function releaseInstance()
    {
        self::$instance = null;
    }

    /**
     * Invoke magic method
     *
     * @return InstantiatorTrait
     */
    public function __invoke(...$_)
    {
        return self::getInstance(...$_);
    }

    /**
     * Wakeup magic method
     */
    public function __wakeup()
    {
        // Do nothing
    }
}