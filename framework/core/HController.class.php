<?php

defined('BASE_PATH') OR exit('No direct script access allowed');

use HSession\Session\Session;

class HController
{
    private static $instance = null;

    // Base Controller has a property called $loader, it is an instance of Loader class(introduced later)

    public $config;
    public $load;
    /**
     * @var Session $session
     */
    protected $session;
    protected $asset;
    protected $error;

    public function __construct()
    {

        self::$instance =& $this;

        $this->config = getConfig('config');

        $this->load = new Loader();

        $this->load->library('HSession/vendor/autoload');

        $this->session = Session::getInstance();
        $this->asset = new Asset();
        $this->error = new Exceptions();

    }

    public function redirect($url, $message = '', $wait = 0)
    {

        if ($wait == 0) {

            header("Location: $url");

        } else {
            header('Refresh: ' . $wait . '; URL=' . $url);
            include VIEW_PATH . "templates/message.php";

        }

        exit;

    }

    /**
     * Get the H singleton
     *
     * @static
     * @return    object
     */
    public static function &get_instance()
    {
        if(is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}