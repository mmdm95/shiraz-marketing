<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

use Admin\AbstractController\AbstractController;
use Apfelbox\FileDownload\FileDownload;
use HAuthentication\Auth;
use HAuthentication\HAException;
use HForm\Form;
use HPayment\PaymentFactory;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use voku\helper\AntiXSS;

include_once 'AbstractController.class.php';

class ReportController extends AbstractController
{
    public function orderReportAction()
    {
        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'گزارش سفارشات');

        $this->data['js'][] = $this->asset->script('be/js/admin.main.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/be/report/orderReport');
    }
}