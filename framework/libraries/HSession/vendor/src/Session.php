<?php

namespace HSession\Session;


use HSession\Security\Crypt\Crypt;
use HSession\Traits\GeneralTrait;

class Session implements SessionInterface
{
    use GeneralTrait;

    /**
     * Session flash data identifier
     * @var $flash_prefix string
     */
    protected $flash_prefix = '__flash_data_heeva_team';

    /**
     * Hash session data then store in session global array
     * @var $encode_session bool
     */
    protected $encode_session = true;

    /**
     * Use json_encode to encode any type of parameter
     * @var bool $use_json_encode
     */
    protected $use_json_encode = true;

    public function __construct($start = true)
    {
        if (true === $start) {
            $this->start();
        }
    }

    /**
     * Set a session data
     *
     * @param $key
     * @param $value
     * @return SessionInterface
     */
    public function set($key, $value): SessionInterface
    {
        if ($this->hasStart()) {
            $_SESSION[$key] = $this->prepareSetSessionValue($value);
        }
        return $this;
    }

    /**
     * Get a/all session/sessions
     * Note:
     *    1. To get all sessions, do not send any parameter to function.
     *    2. With null parameter, it just return sessions that are not flash data
     *
     * @param string|null $key
     * @param bool $useJsonAssoc
     * @return mixed
     */
    public function get($key = null, $useJsonAssoc = true)
    {
        // To key specific session
        if ($this->hasStart() && !empty($key)) {
            if ($this->has($key)) {
                return $this->prepareGetSessionValue($_SESSION[$key], $useJsonAssoc);
            }
            return null;
        }

        // To get all sessions
        $sessions = array_diff($_SESSION, $_SESSION[$this->flash_prefix] ?? []);
        if ($this->encode_session) {
            foreach ($sessions as $k => $value) {
                $sessions[$k] = $this->prepareGetSessionValue($value, $useJsonAssoc);
            }
        }
        return $sessions;
    }

    /**
     * Unset a session data
     *
     * @param $key
     * @return SessionInterface
     */
    public function remove($key): SessionInterface
    {
        if ($this->hasStart()) {
            unset($_SESSION[$key]);
        }
        return $this;
    }

    /**
     * Check that a session is set or not
     *
     * @param $key
     * @return bool
     */
    public function has($key): bool
    {
        if ($this->hasStart()) {
            return isset($_SESSION[$key]);
        }
        return false;
    }

    /**
     * Set a flash session data
     *
     * @param $key
     * @param $value
     * @return SessionInterface
     */
    public function setFlash($key, $value): SessionInterface
    {
        if ($this->hasStart()) {
            $_SESSION[$this->flash_prefix][$key] = $this->prepareSetSessionValue($value);
        }
        return $this;
    }

    /**
     * Get a flash session data
     *
     * @param $key
     * @param bool $delete
     * @param bool $useJsonAssoc
     * @return mixed
     */
    public function getFlash($key, $delete = true, $useJsonAssoc = true)
    {
        if ($this->hasStart() && $this->hasFlash($key)) {
            $flashSess = $this->prepareGetSessionValue($_SESSION[$this->flash_prefix][$key], $useJsonAssoc = true);
            if (true == (bool)$delete) {
                $this->removeFlash($key);
            }
            return $flashSess;
        }
        return null;
    }

    /**
     * Get all flash sessions data
     *
     * @param bool $delete
     * @param bool $useJsonAssoc
     * @return mixed
     */
    public function getFlashes($delete = true, $useJsonAssoc = true)
    {
        if ($this->hasStart()) {
            $flashes = $_SESSION[$this->flash_prefix];
            if ($this->encode_session) {
                foreach ($flashes as $key => $value) {
                    $flashes[$key] = $this->prepareGetSessionValue($value, $useJsonAssoc = true);
                    if (true == (bool)$delete) {
                        $this->removeFlash($key);
                    }
                }
            }
            return $flashes;
        }
        return null;
    }

    /**
     * Unset a session flash data
     *
     * @param $key
     * @return SessionInterface
     */
    public function removeFlash($key): SessionInterface
    {
        if ($this->hasStart()) {
            unset($_SESSION[$this->flash_prefix][$key]);
        }
        return $this;
    }

    /**
     * Check if a flash session is set or not
     *
     * @param $key
     * @return bool
     */
    public function hasFlash($key): bool
    {
        if ($this->hasStart()) {
            return isset($_SESSION[$this->flash_prefix][$key]);
        }
        return false;
    }

    /**
     * Start a session is not started yet.
     * Note: By specifying $regenerate parameter, it regenerate session id and delete old sessions
     *
     * @param bool $regenerate
     * @return SessionInterface
     */
    public function start($regenerate = false): SessionInterface
    {
        if (!$this->hasStart()) {
            session_start();
        }
        if (true === $regenerate) {
            session_regenerate_id(true);
        }
        return $this;
    }

    /**
     * Destroy a started session
     *
     * @return SessionInterface
     */
    public function close(): SessionInterface
    {
        if ($this->hasStart()) {
            session_unset();
            session_destroy();
        }
        return $this;
    }

    /**
     * Check if session is start
     *
     * @return bool|int If session was started, return session id otherwise return false
     */
    public function hasStart()
    {
        if (session_id()) {
            return session_id();
        }
        return false;
    }

    /**
     * Code sessions value to store
     *
     * @param bool $answer
     * @return SessionInterface
     */
    public function encodeSessions($answer = true): SessionInterface
    {
        $this->encode_session = !(false === $answer);
        return $this;
    }

    /**
     * Use json_encode on value to store
     *
     * @param bool $answer
     * @return SessionInterface
     */
    public function useJsonEncode($answer = true): SessionInterface
    {
        $this->use_json_encode = !(false === $answer);
        return $this;
    }

    /**
     * Prepare session value to store (check if encryption need)
     *
     * @param $value
     * @return mixed
     */
    protected function prepareSetSessionValue($value)
    {
        if (is_string($value)) {
            $value = htmlspecialchars($value);
        }
        if ($this->use_json_encode) {
            $value = json_encode($value);
        }
        if ($this->encode_session) {
            $value = Crypt::getInstance()->encrypt($value);
            $value = false === $value ? "" : $value;
        }
        return $value;
    }

    /**
     * Prepare session value to retrieve (check if decryption need)
     *
     * @param $value
     * @param $useJsonAssoc
     * @return mixed
     */
    protected function prepareGetSessionValue($value, $useJsonAssoc)
    {
        if ($this->encode_session) {
            $value = Crypt::getInstance()->decrypt($value);
        }
        if (is_string($value)) {
            if ($this->use_json_encode && $useJsonAssoc) {
                $value = json_decode($value, true);
            } else {
                $value = json_decode($value);
            }
        }
        if(is_string($value)) {
            $value = htmlspecialchars_decode($value);
        }
        return $value;
    }
}