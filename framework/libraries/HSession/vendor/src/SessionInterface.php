<?php

namespace HSession\Session;


interface SessionInterface
{
    /**
     * Set a session data
     *
     * @param $key
     * @param $value
     * @return SessionInterface
     */
    public function set($key, $value): SessionInterface;

    /**
     * Get a/all session/sessions
     * Note: To get all sessions, do not send any parameter to function
     *
     * @param string|null $key
     * @return mixed
     */
    public function get($key = null);

    /**
     * Unset a session data
     *
     * @param $key
     * @return SessionInterface
     */
    public function remove($key): SessionInterface;

    /**
     * Check that a session is set or not
     *
     * @param $key
     * @return bool
     */
    public function has($key): bool;

    /**
     * Set a flash session data
     *
     * @param $key
     * @param $value
     * @return SessionInterface
     */
    public function setFlash($key, $value): SessionInterface;

    /**
     * Get a flash session data
     *
     * @param $key
     * @param bool $delete
     * @return mixed
     */
    public function getFlash($key, $delete = true);

    /**
     * Get all flash sessions data
     *
     * @param bool $delete
     * @return mixed
     */
    public function getFlashes($delete = true);

    /**
     * Unset a session flash data
     *
     * @param $key
     * @return SessionInterface
     */
    public function removeFlash($key): SessionInterface;
    
    /**
     * Check if a flash session is set or not
     *
     * @param $key
     * @return bool
     */
    public function hasFlash($key): bool;

    /**
     * Start/Restart a session
     *
     * @param bool $regenerate
     * @return SessionInterface
     */
    public function start($regenerate = false): SessionInterface;

    /**
     * Destroy a started session
     *
     * @return SessionInterface
     */
    public function close(): SessionInterface;

    /**
     * Check if session is start
     *
     * @return bool|int If session was started, return session id otherwise return false
     */
    public function hasStart();
}