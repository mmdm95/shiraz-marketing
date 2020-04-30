<?php

namespace HPayment\PaymentClasses;

use HPayment\Payment;
use HPayment\PaymentException;
use SoapClient;

defined('BASE_PATH') OR exit('No direct script access allowed');

class PaymentBehPardakht extends Payment
{
    /**
     * Variables that return from gateway after request/advice
     * @var array
     */
    protected $returnedVarsName = [
        'RefId', 'ResCode', 'SaleOrderId', 'SaleReferenceId',
        'CardHolderPAN', 'CreditCardSaleResponseDetail', 'FinalAmount'
    ];

    /**
     * Status array for bank success/error or any kind of status.
     * Must store status in this array like ---->   code => message
     * Exp. ---->
     *  array(
     *      100 => 'Payment complete.'
     *  )
     * Exp.2. ---->
     *  array(
     *      'success' =>
     *          array(
     *              100 => 'Payment complete.'
     *          )
     *  )
     * @var array
     */
    protected $_statusArr = [
        self::PAYMENT_STATUS_OK_BEH_PARDAKHT => 'تراکنش با موفقيت انجام شد',
        11 => 'شماره کارت نامعتبر است',
        12 => 'موجودی کافي نيست',
        13 => 'رمز نادرست است',
        14 => 'تعداد دفعات وارد کردن رمز بيش از حد مجاز است',
        15 => 'کارت نامعتبر است',
        16 => 'دفعات برداشت وجه بيش از حد مجاز است',
        17 => 'کاربر از انجام تراکنش منصرف شده است',
        18 => 'تاريخ انقضای کارت گذشته است',
        19 => 'مبلغ برداشت وجه بيش از حد مجاز است',
        111 => 'صادر کننده کارت نامعتبر است',
        112 => 'خطای سوييچ صادر کننده کارت',
        113 => 'پاسخي از صادر کننده کارت دريافت نشد',
        114 => 'دارنده کارت مجاز به انجام اين تراکنش نيست',
        21 => 'پذيرنده نامعتبر است',
        23 => 'خطای امنيتي رخ داده است',
        24 => 'اطلاعات کاربری پذيرنده نامعتبر است',
        25 => 'مبلغ نامعتبر است',
        31 => 'پاسخ نامعتبر است',
        32 => 'فرمت اطلاعات وارد شده صحيح نمي باشد',
        33 => 'حساب نامعتبر است',
        34 => 'خطای سيستمي',
        35 => 'تاريخ نامعتبر است',
        41 => 'شماره درخواست تکراری است',
        42 => 'تراکنش Sale يافت نشد',
        43 => 'قبلا درخواست Verify داده شده است',
        44 => 'درخواست Verify يافت نشد',
        45 => 'تراکنش Settle شده است',
        46 => 'تراکنش Settle نشده است',
        47 => 'تراکنش Settle يافت نشد',
        48 => 'تراکنش Reverse شده است',
        412 => 'شناسه قبض نادرست است',
        413 => 'شناسه پرداخت نادرست است',
        414 => 'سازمان صادر کننده قبض نامعتبر است',
        415 => 'زمان جلسه کاری به پايان رسيده است',
        416 => 'خطا در ثبت اطلاعات',
        417 => 'شناسه پرداخت کننده نامعتبر است',
        418 => 'اشکال در تعريف اطلاعات مشتری',
        419 => 'تعداد دفعات ورود اطلاعات از حد مجاز گذشته است',
        421 => 'IP نامعتبر است',
        self::PAYMENT_STATUS_DUPLICATE_BEH_PARDAKHT => 'تراکنش تکراری است',
        54 => 'تراکنش مرجع موجود نيست',
        55 => 'تراکنش نامعتبر است',
        61 => 'خطا در واريز',
        62 => 'مسير بازگشت به سايت در دامنه ثبت شده برای پذيرنده قرار ندارد',
        98 => 'سقف استفاده از رمز ايستا به پايان رسيده است',
    ];

    /**
     * @var array
     */
    public $urls = [
        self::PAYMENT_URL_PAYMENT_BEH_PARDAKHT => 'https://bpm.shaparak.ir/pgwchannel/startpay.mellat',
    ];

    protected $_client;

    /**
     * PaymentIDPay constructor.
     * @param string $terminalId
     * @param string $username
     * @param string $password
     */
    public function __construct($terminalId = '', $username = '', $password = '')
    {
        // Set credential info
        $this->_parameters['terminalId'] = $terminalId;
        $this->_parameters['userName'] = $username;
        $this->_parameters['userPassword'] = $password;
        // Start a SOAP connection for required methods
        $this->_client = new SoapClient('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
    }

    /**
     * Handle requested operation that come from bank gateway
     *
     * @return PaymentBehPardakht
     */
    public function handle_request()
    {
        // Reset result array
        $this->_result = [];
        if ($_SERVER["REQUEST_METHOD"] == self::PAYMENT_METHOD_POST) {
            foreach ($this->returnedVarsName as $name) {
                ${$name} = isset($_POST[$name]) ? $this->_escape_data($_POST[$name]) : null;
                $this->_result[$name] = ${$name};
            }
        }

        return $this;
    }

    /**
     * Create request by send a request to bank gateway
     *
     * @param $data
     * @return PaymentBehPardakht
     */
    public function create_request($data)
    {
        $data = array_merge($this->_parameters, $data);
        $res = $this->_client->bpPayRequest($data);
        $res = explode(',', $res);
        $this->_result = [
            'ResCode' => $res[0],
            'RefId' => $res[1] ?? '',
        ];
        return $this;
    }

    /**
     * Send advice/verify to bank gateway to complete payment transaction
     *
     * @param $data
     * @return PaymentBehPardakht
     */
    public function verify_request($data)
    {
        $data = array_merge($this->_parameters, $data);
        // Check request
        $this->_result = $this->_client->bpVerifyRequest($data);

        return $this;
    }

    /**
     * After verify completed, settle request to send money to owner bank deposit
     *
     * @param $data
     * @return PaymentBehPardakht
     */
    public function settle_request($data)
    {
        $data = array_merge($this->_parameters, $data);
        // Settle request
        $this->_result = $this->_client->bpSettleRequest($data);

        return $this;
    }

    /**
     * Return the result that was tracked from request/verify/advice
     *
     * @return array
     */
    public function get_result()
    {
        return $this->_result;
    }

    /**
     * Get message of a request/advice code for display purposes
     *
     * @param $code
     * @return string|bool - return <b>string</b> if there is message otherwise return <b>false</b>
     */
    public function get_message($code)
    {
        if (isset($code) && key_exists($code, $this->_statusArr)) {
            return $this->_statusArr[$code];
        }
        return false;
    }

    /**
     * Check request $data before send it to _send_request method
     *
     * @param $data
     * @throws PaymentException
     */
    protected function _request_check($data)
    {
        if (is_array($data) && count($data)) {
            // Send request to gateway
            $this->_result = json_decode($this->_send_request($data), true);
        }
    }

    /**
     * Send request/advice to bank gateway
     *
     * @param $data
     * @return array|bool|string
     * @throws PaymentException
     */
    protected function _send_request($data)
    {
        // Reset global result array
        $this->_result = [];

        // Handle error for API Key existence
        if (!isset($this->_parameters[$this->APIKeyStr])) {
            throw new PaymentException('API KEY برای درگاه بانک تعریف نشده است.', self::BANK_ERROR_BAD_API_KEY);
        }
        //  Handle error for request url existence
        if (!isset($this->_parameters[$this->urlStr])) {
            throw new PaymentException('آدرس URL برای ارسال درخواست تعریف نشده است.', self::BANK_ERROR_UNDEFINED_URL);
        }

        $headers = [
            'Content-Type: application/json',
        ];

        $handle = curl_init();

        curl_setopt_array($handle, [
            CURLOPT_URL => $this->_parameters[$this->urlStr],
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers
        ]);

        $tmpResult = curl_exec($handle);

        if (curl_errno($handle)) {
            // TODO: store handle error in a variable
//            return ['errReq' => curl_error($handle)];
        }

        curl_close($handle);

        return $tmpResult;
    }
}
