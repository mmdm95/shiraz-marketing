<?php

namespace HConvert\Traits;


trait ValidatorTrait
{
    /**
     * Check if a variable is empty or not except false that evaluate as not empty here.
     *
     * @param $variable
     * @return bool
     */
    protected function isEmptyExceptFalse($variable)
    {
        return false !== $variable && empty($variable);
    }

    /**
     * Test if $name is a good name variable
     *
     * @param $name
     * @return bool
     */
    protected function isValidName($name): bool
    {
        return preg_match('/[a-zA-Z_][a-zA-Z0-9_]*/', $name);
    }

    /**
     * Check if a url is valid or not
     *
     * @param $url
     * @return bool
     */
    protected function isValidUrl($url): bool
    {
        return (bool)filter_var($url, FILTER_VALIDATE_URL);
    }

    /**
     * Check if a timestamp is valid or not
     *
     * @param $timestamp
     * @return bool
     */
    protected function isValidTimestamp($timestamp)
    {
        return ((string)(int)$timestamp === $timestamp)
            && ($timestamp <= PHP_INT_MAX)
            && ($timestamp >= ~PHP_INT_MAX);
    }
}