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
    public function orderReportAction($param)
    {
        $model = new Model();
        $userModel = new UserModel();
        $orderModel = new OrderModel();

        $this->data['_where'] = '';
        $this->data['_params'] = [];

        if (isset($param[0]) && $param[0] == 'send_status') {
            if (isset($param[1]) && is_numeric($param[1])) {
                $this->data['_where'] .= 'send_status=:ss';
                $this->data['_params']['ss'] = $param[1];
            }
        }

        $this->data['users'] = $userModel->getUsers();
        $this->data['status'] = $model->select_it(null, self::TBL_SEND_STATUS, ['id', 'name'],
            null, [], null, ['priority ASC']);

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('exportFilterOrders');
        $form->setFieldsName(['user', 'from_date', 'to_date', 'send_status', 'payment_status', 'payment_method', 'province', 'city'])
            ->setMethod('post')
            ->clearVariablesOnSuccess(false);
        try {
            $form->afterCheckCallback(function ($values) use ($model, $orderModel, $form) {
                $where = '';
                $params = [];

                //user
                if ($values['user'] != -1 && in_array($values['user'], array_column($this->data['users'], 'id'))) {
                    $where .= 'user_id=:uId AND ';
                    $params['uId'] = $values['user'];
                }
                // date
                if (!empty($values['from_date'])) {
                    $where .= 'order_date>=:fd AND ';
                    $params['fd'] = (int)$values['from_date'];
                }
                if (!empty($values['to_date'])) {
                    $where .= 'order_date<=:td AND ';
                    $params['td'] = (int)$values['to_date'];
                }
                // send status
                if ($values['send_status'] != -1) {
                    $where .= 'send_status=:ss AND ';
                    $params['ss'] = $values['send_status'];
                }
                // payment status
                if ($values['payment_status'] != -100) {
                    $where .= 'payment_status=:ps AND ';
                    $params['ps'] = $values['payment_status'];
                }
                // payment method
                if ($values['payment_method'] != -100) {
                    $where .= 'payment_method=:pm AND ';
                    $params['pm'] = $values['payment_method'];
                }
                // province and city
                if (!empty($values['province'])) {
                    $where .= 'province LIKE :province AND ';
                    $params['province'] = '%' . $values['province'] . '%';

                }
                if (!empty($values['city'])) {
                    $where .= 'city LIKE :city AND ';
                    $params['city'] = '%' . $values['city'] . '%';
                }
                //-----
                $where = trim(trim($where), 'AND');
                //-----
                $this->data['_where'] = $where;
                $this->data['_params'] = $params;
            });
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $res = $form->checkForm()->isSuccess();
        if ($form->isSubmit()) {
            if ($res) {
                $this->data['hasFilter'] = true;
                $this->data['filters'] = $form->getValues();
            }
        }

        //-----
        $this->_export_excel();
        //-----
        $this->session->set('order_report_sess', ['where' => $this->data['_where'], 'params' => $this->data['_params']]);
        //-----
        $this->data['orders'] = $orderModel->getOrders($this->data['_where'], $this->data['_params']);
        unset($this->data['_where']);
        unset($this->data['_params']);

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'گزارش سفارشات');

        // Extra css
        $this->data['css'][] = $this->asset->css('be/css/persian-datepicker-custom.css');

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-date.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-datepicker.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/be/Report/orderReport');
    }

    //-----

    private function _export_excel()
    {
        // Spreadsheet name
        $name = 'report-' . time();
        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token_export'] = $form->csrfToken('exportExcelOrders');
        $form->setFieldsName(['excelExport'])
            ->setMethod('post');
        try {
            $form->afterCheckCallback(function () use ($form, $name) {
                $this->load->library('PhpSpreadsheet/vendor/autoload');
                // Create empty xlsx file
                fopen(PUBLIC_PATH . $name . '.xlsx', "w");
                //-----
                $orderModel = new OrderModel();
                //-----
                $info = $this->session->get('order_report_sess');
                $orders = $orderModel->getOrders($info['where'], $info['params']);
                //-----
                // Create IO for file
                $spreadsheet = IOFactory::load(PUBLIC_PATH . $name . '.xlsx');
                $spreadsheetArray = [
                    0 => [
                        '#',
                        'کد سفارش',
                        'نام و نام خانوادگی خریدار',
                        'موبایل خریدار',
                        'نام گیرنده',
                        'شماره تماس گیرنده',
                        'استان',
                        'شهر',
                        'کد پستی',
                        'آدرس',
                        'محصولات خریداری شده',
                        'وضعیت سفارش',
                        'وضعیت پرداخت',
                        'هزینه ارسال',
                        'مبلغ کل سفارش',
                        'مبلغ تخفیف',
                        'مبلغ سفارش',
                        'تاریخ پرداخت',
                        'تاریخ ثبت سفارش',
                    ]
                ];
                $totalPayedAmount = 0;
                $totalAmount = 0;
                $totalOrders = count($orders);
                foreach ($orders as $k => $order) {
                    $spreadsheetArray[($k + 1)][] = $k + 1;
                    $spreadsheetArray[($k + 1)][] = $order['order_code'];
                    $spreadsheetArray[($k + 1)][] = $order['first_name'] . ' ' . $order['last_name'];
                    $spreadsheetArray[($k + 1)][] = convertNumbersToPersian($order['mobile']);
                    $spreadsheetArray[($k + 1)][] = $order['receiver_name'];
                    $spreadsheetArray[($k + 1)][] = convertNumbersToPersian($order['receiver_phone']);
                    $spreadsheetArray[($k + 1)][] = $order['province'];
                    $spreadsheetArray[($k + 1)][] = $order['city'];
                    $spreadsheetArray[($k + 1)][] = $order['postal_code'];
                    $spreadsheetArray[($k + 1)][] = $order['address'];
                    //-----
                    $productInfo = '';
                    $products = $orderModel->getOrderProducts('oi.order_code=:oc', ['oc' => $order['order_code']]);
                    foreach ($products as $product) {
                        $productInfo .= $product['title'] . ' - ' . 'تعداد:' . convertNumbersToPersian(number_format($product['product_count'])) .
                            ' - ' . 'قیمت واحد:' . convertNumbersToPersian(number_format(convertNumbersToPersian($product['product_unit_price'], true))) .
                            ' - ' . 'مجموع قیمت' . convertNumbersToPersian(number_format(convertNumbersToPersian($product['product_price'], true))) . PHP_EOL;
                    }
                    $spreadsheetArray[($k + 1)][] = $productInfo;
                    //-----
                    $spreadsheetArray[($k + 1)][] = $order['send_status_name'];
                    $spreadsheetArray[($k + 1)][] = OWN_PAYMENT_STATUSES[$order['payment_status']] ?? 'نامشخص';
                    $spreadsheetArray[($k + 1)][] = convertNumbersToPersian(number_format(convertNumbersToPersian($order['shipping_price'], true)));
                    $spreadsheetArray[($k + 1)][] = convertNumbersToPersian(number_format(convertNumbersToPersian($order['amount'], true)));
                    $spreadsheetArray[($k + 1)][] = convertNumbersToPersian(number_format(convertNumbersToPersian($order['discount_price'], true)));
                    $spreadsheetArray[($k + 1)][] = convertNumbersToPersian(number_format(convertNumbersToPersian($order['final_price'], true)));
                    $spreadsheetArray[($k + 1)][] = jDateTime::date('j F Y در ساعت H:i', $order['payment_date']);
                    $spreadsheetArray[($k + 1)][] = jDateTime::date('j F Y در ساعت H:i', $order['order_date']);
                    //-----
                    if ($order['payment_status'] == OWN_PAYMENT_STATUS_SUCCESSFUL) {
                        $totalPayedAmount += (int)convertNumbersToPersian($order['final_price'], true);
                    }
                    $totalAmount += (int)convertNumbersToPersian($order['final_price'], true);
                }
                $spreadsheetArray[$totalOrders + 1][] = '';
                $spreadsheetArray[$totalOrders + 1][] = 'مجموع پرداختی‌ها (تومان)';
                $spreadsheetArray[$totalOrders + 1][] = number_format(convertNumbersToPersian($totalPayedAmount, true));
                $spreadsheetArray[$totalOrders + 1][] = '';
                $spreadsheetArray[$totalOrders + 1][] = 'هزینه کل (تومان)';
                $spreadsheetArray[$totalOrders + 1][] = number_format(convertNumbersToPersian($totalAmount, true));

                // Add whole array to spreadsheet
                $spreadsheet->getActiveSheet()->fromArray($spreadsheetArray);
                // Create writer
                $writer = new Xlsx($spreadsheet);
                $writer->save(PUBLIC_PATH . $name . ".xlsx");

                $this->load->library('File-Download/vendor/autoload');
                $download = FileDownload::createFromFilePath(PUBLIC_PATH . $name . '.xlsx');
                $download->sendDownload($name . '.xlsx');
            });
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $res = $form->checkForm()->isSuccess();
        if ($form->isSubmit()) {
            if ($res) {
                // Do nothing
            }
        }

        // Remove excel file
        $mask = PUBLIC_PATH . 'report-*.xlsx';
        array_map('unlink', glob($mask));
    }
}