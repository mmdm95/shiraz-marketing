<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

use Admin\AbstractController\AbstractController;
use Apfelbox\FileDownload\FileDownload;
use HAuthentication\Auth;
use HAuthentication\HAException;
use HForm\Form;
use HPayment\PaymentClasses\PaymentBehPardakht;
use HPayment\PaymentClasses\PaymentIDPay;
use HPayment\PaymentClasses\PaymentMabna;
use HPayment\PaymentClasses\PaymentZarinPal;
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
        if (!$this->auth->isAllow('report', AUTH_ACCESS_READ)) {
            $this->error->access_denied();
            die();
        }
        //-----
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

        $this->data['users'] = $userModel->getUsers('r.id IN (:r1, :r2)', ['r1' => AUTH_ROLE_USER, 'r2' => AUTH_ROLE_MARKETER]);
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
        $this->_order_export_excel();
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

    public function walletReportAction()
    {
        if (!$this->auth->isAllow('report', AUTH_ACCESS_READ)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();
        $userModel = new UserModel();
        $orderModel = new OrderModel();

        $this->data['_where'] = '';
        $this->data['_params'] = [];

        $this->data['users'] = $userModel->getUsers('r.id IN (:r1, :r2)', ['r1' => AUTH_ROLE_USER, 'r2' => AUTH_ROLE_MARKETER]);

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('exportFilterWallet');
        $form->setFieldsName(['user', 'from_date', 'to_date', 'deposit_type'])
            ->setMethod('post')
            ->clearVariablesOnSuccess(false);
        try {
            $form->afterCheckCallback(function ($values) use ($model, $form) {
                $where = '';
                $params = [];

                //user
                if ($values['user'] != -1 && in_array($values['user'], array_column($this->data['users'], 'id'))) {
                    $where .= 'ud.user_id=:uId AND ';
                    $params['uId'] = $values['user'];
                }
                // date
                if (!empty($values['from_date'])) {
                    $where .= 'ud.deposit_date>=:fd AND ';
                    $params['fd'] = (int)$values['from_date'];
                }
                if (!empty($values['to_date'])) {
                    $where .= 'ud.deposit_date<=:td AND ';
                    $params['td'] = (int)$values['to_date'];
                }
                // deposit type
                if ($values['deposit_type'] != -1 && in_array($values['deposit_type'], [DEPOSIT_TYPE_SELF, DEPOSIT_TYPE_OTHER, DEPOSIT_TYPE_REWARD])) {
                    $where .= 'ud.deposit_type=:dt AND ';
                    $params['dt'] = $values['deposit_type'];
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
        $this->_wallet_export_excel();
        //-----
        $this->session->set('wallet_report_sess', ['where' => $this->data['_where'], 'params' => $this->data['_params']]);
        //-----
        $this->data['transactions'] = $orderModel->getUserDeposit($this->data['_where'], $this->data['_params']);
        unset($this->data['_where']);
        unset($this->data['_params']);

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'گزارش کیف پول');

        // Extra css
        $this->data['css'][] = $this->asset->css('be/css/persian-datepicker-custom.css');

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-date.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-datepicker.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/be/Report/walletReport');
    }

    //-----

    private function _order_export_excel()
    {
        if (!$this->auth->isAllow('report', AUTH_ACCESS_READ)) {
            $this->error->access_denied();
            die();
        }
        //-----
        // Spreadsheet name
        $name = 'order-report-' . time();
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
                    $spreadsheetArray[($k + 1)][] = number_format(convertNumbersToPersian($order['shipping_price'], true));
                    $spreadsheetArray[($k + 1)][] = number_format(convertNumbersToPersian($order['amount'], true));
                    $spreadsheetArray[($k + 1)][] = number_format(convertNumbersToPersian($order['discount_price'], true));
                    $spreadsheetArray[($k + 1)][] = number_format(convertNumbersToPersian($order['final_price'], true));
                    try {
                        $spreadsheetArray[($k + 1)][] = jDateTime::date('j F Y در ساعت H:i', $order['payment_date']);
                    } catch (Exception $e) {
                        $spreadsheetArray[($k + 1)][] = '-';
                    }
                    try {
                        $spreadsheetArray[($k + 1)][] = jDateTime::date('j F Y در ساعت H:i', $order['order_date']);
                    } catch (Exception $e) {
                        $spreadsheetArray[($k + 1)][] = '-';
                    }
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
        $mask = PUBLIC_PATH . 'order-report-*.xlsx';
        array_map('unlink', glob($mask));
        $mask = PUBLIC_PATH . '*.xlsx';
        array_map('unlink', glob($mask));
    }

    private function _wallet_export_excel()
    {
        if (!$this->auth->isAllow('report', AUTH_ACCESS_READ)) {
            $this->error->access_denied();
            die();
        }
        //-----
        // Spreadsheet name
        $name = 'wallet-report-' . time();
        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token_export'] = $form->csrfToken('exportExcelWallet');
        $form->setFieldsName(['excelExport'])
            ->setMethod('post');
        try {
            $form->afterCheckCallback(/**
             *
             */
                function () use ($form, $name) {
                    $this->load->library('PhpSpreadsheet/vendor/autoload');
                    // Create empty xlsx file
                    fopen(PUBLIC_PATH . $name . '.xlsx', "w");
                    //-----
                    $model = new Model();
                    $orderModel = new OrderModel();
                    //-----
                    $info = $this->session->get('wallet_report_sess');
                    $transactions = $orderModel->getUserDeposit($info['where'], $info['params']);
                    //-----
                    // Create IO for file
                    $spreadsheet = IOFactory::load(PUBLIC_PATH . $name . '.xlsx');
                    $spreadsheetArray = [
                        0 => [
                            '#',
                            'کاربر',
                            'واریز کننده',
                            'مبلغ تراکنش',
                            'توضیح تراکنش',
                            'وضعیت پرداخت',
                            'تاریخ تراکنش',
                        ]
                    ];
                    $totalPayedAmount = 0;
                    $totalAmount = 0;
                    $totalWallet = count($transactions);
                    foreach ($transactions as $k => $transaction) {
                        $spreadsheetArray[($k + 1)][] = $k + 1;
                        //-----
                        $uName = '';
                        if ($transaction['deposit_type'] == DEPOSIT_TYPE_OTHER) {
                            if (!empty($transaction['first_name']) || !empty($transaction['last_name'])) {
                                $uName = $transaction['first_name'] . ' ' . $transaction['last_name'];
                                $uName .= '-';
                            }
                        }
                        $uName .= convertNumbersToPersian($transaction['mobile']) ?? '';
                        $spreadsheetArray[($k + 1)][] = $uName;
                        //-----
                        $payer = '';
                        if ($transaction['deposit_type'] == DEPOSIT_TYPE_OTHER) {
                            if (!empty($transaction['payer_name'])) {
                                $payer = $transaction['payer_name'];
                                $payer .= '-';
                            }
                            $payer .= convertNumbersToPersian($transaction['payer_mobile']) ?? '';
                        } elseif ($transaction['deposit_type'] == DEPOSIT_TYPE_SELF) {
                            $payer = 'کاربر';
                        } elseif ($transaction['deposit_type'] == DEPOSIT_TYPE_REWARD) {
                            $payer = 'پاداش خرید';
                        } else {
                            $payer = '-';
                        }
                        $spreadsheetArray[($k + 1)][] = $payer;
                        //-----
                        $spreadsheetArray[($k + 1)][] = number_format(convertNumbersToPersian($transaction['deposit_price'], true));
                        $spreadsheetArray[($k + 1)][] = $transaction['description'] ?: '-';
                        // check if it is bank operation and if it's successful or not
                        $idPayStatus = $model->select_it(null, self::PAYMENT_TABLE_IDPAY, ['status'],
                            'order_code=:oc AND user_id=:uId AND exportation_type=:et', [
                                'oc' => $transaction['deposit_code'],
                                'uId' => $transaction['user_id'],
                                'et' => FACTOR_EXPORTATION_TYPE_DEPOSIT,
                            ]);
                        $mabnaStatus = $model->select_it(null, self::PAYMENT_TABLE_MABNA, ['status'],
                            'order_code=:oc AND user_id=:uId AND exportation_type=:et', [
                                'oc' => $transaction['deposit_code'],
                                'uId' => $transaction['user_id'],
                                'et' => FACTOR_EXPORTATION_TYPE_DEPOSIT,
                            ]);
                        $zarinpalStatus = $model->select_it(null, self::PAYMENT_TABLE_ZARINPAL, ['status'],
                            'order_code=:oc AND user_id=:uId AND exportation_type=:et', [
                                'oc' => $transaction['deposit_code'],
                                'uId' => $transaction['user_id'],
                                'et' => FACTOR_EXPORTATION_TYPE_DEPOSIT,
                            ]);
                        $behPardakhtStatus = $model->select_it(null, self::PAYMENT_TABLE_BEH_PARDAKHT, ['status'],
                            'order_code=:oc AND user_id=:uId AND exportation_type=:et', [
                                'oc' => $transaction['deposit_code'],
                                'uId' => $transaction['user_id'],
                                'et' => FACTOR_EXPORTATION_TYPE_DEPOSIT,
                            ]);
                        $status = null;
                        if (count($idPayStatus)) {
                            $status = $idPayStatus[0]['status'];
                            if ($status == PaymentIDPay::PAYMENT_STATUS_OK_IDPAY) {
                                $status = 'پرداخت شده';
                            } else {
                                $status = 'پرداخت نشده';
                            }
                        } elseif (count($mabnaStatus)) {
                            $status = $mabnaStatus[0]['status'];
                            if ($status == PaymentMabna::PAYMENT_STATUS_OK_MABNA) {
                                $status = 'پرداخت شده';
                            } else {
                                $status = 'پرداخت نشده';
                            }
                        } elseif (count($zarinpalStatus)) {
                            $status = $zarinpalStatus[0]['status'];
                            if ($status == PaymentZarinPal::PAYMENT_STATUS_OK_ZARINPAL) {
                                $status = 'پرداخت شده';
                            } else {
                                $status = 'پرداخت نشده';
                            }
                        } elseif (count($behPardakhtStatus)) {
                            $status = $behPardakhtStatus[0]['status'];
                            if ($status == PaymentBehPardakht::PAYMENT_STATUS_OK_BEH_PARDAKHT) {
                                $status = 'پرداخت شده';
                            } else {
                                $status = 'پرداخت نشده';
                            }
                        }
                        if (empty($status)) {
                            $status = '-';
                        }
                        $spreadsheetArray[($k + 1)][] = $status;
                        //-----
                        try {
                            $spreadsheetArray[($k + 1)][] = jDateTime::date('j F Y در ساعت H:i', $transaction['deposit_date']);
                        } catch (Exception $e) {
                            $spreadsheetArray[($k + 1)][] = '-';
                        }

                        //-----
                        if ($status == '-' || $status == 'پرداخت شده') {
                            $totalPayedAmount += (int)convertNumbersToPersian($transaction['deposit_price'], true);
                        }
                        $totalAmount += (int)convertNumbersToPersian($transaction['deposit_price'], true);
                    }
                    $spreadsheetArray[$totalWallet + 1][] = '';
                    $spreadsheetArray[$totalWallet + 1][] = 'مجموع پرداختی‌ها (تومان)';
                    $spreadsheetArray[$totalWallet + 1][] = number_format(convertNumbersToPersian($totalPayedAmount, true));
                    $spreadsheetArray[$totalWallet + 1][] = '';
                    $spreadsheetArray[$totalWallet + 1][] = 'هزینه کل (تومان)';
                    $spreadsheetArray[$totalWallet + 1][] = number_format(convertNumbersToPersian($totalAmount, true));

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
        $mask = PUBLIC_PATH . 'wallet-report-*.xlsx';
        array_map('unlink', glob($mask));
        $mask = PUBLIC_PATH . '*.xlsx';
        array_map('unlink', glob($mask));
    }
}