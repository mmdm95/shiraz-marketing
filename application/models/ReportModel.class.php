<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

class ReportModel extends HModel
{
    public function __construct()
    {
        parent::__construct();

        $this->table = null;
        $this->db = $this->getDb();
    }
}