<?php

namespace HSession\Traits;


trait InstantiatorTrait
{
    /**
     * @var $instance
     */
    static private $instance = null;

    /**
     * @param mixed ...$_
     * @return static
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
     * @return static
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