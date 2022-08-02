<?php
namespace AnonWallet;

class AnonWallet {

    /**
     * 
     * @var string endpoint of api
     */
    private $url = 'https://anonwallet.net/api/';
    /**
     * 
     * @var string api of version
     */
    private $version = 'v1';
    /**
     * 
     * @var string currency, BTC is default
     */
    private $default_currency = 'BTC';
    /**
     * 
     * @var string api key from anonwallet payment gateway
     */
    private $api_key;

    public function __construct($api_key) {

        if(isset($api_key)) {
            $this->api_key = $api_key;
        } else {
            throw new \Exception('Api key is required');
        }

        //PHP Curl must be installed in your system
        
    }

    /**
     * 
     * Get balance of specified coin from your wallet
     * Example string BTC, BCH, LTC, DOGE
     * @return json response with success or error message
     */
    public function balance($currency = '') {
        $url = $this->url.$this->version.'/balance';
    
        $payload = [
            'currency'=>(isset($currency)) ? $currency : $this->default_currency
        ];

        $res = $this->curl_call($url, $payload);
        return $res;
    }

    /**
     * 
     * Get balances of all coins from your wallet
     * @return json response with success or error message
     */
    public function balances() {
        $url = $this->url.$this->version.'/balances';
        $res = $this->curl_call($url);
        return $res;
    }

    /**
     * 
     * Generate new callback address of specific coin, default is BTC
     * @return json response with success or error message
     */
    public function callback_address($currency, $forward_address = '', $ipn_url = '', $label = '') {
        $url = $this->url.$this->version.'/callback_address';

        $payload = [
            'currency'=>(isset($currency)) ? $currency : $this->default_currency,
            'forward_address' => $forward_address,
            'ipn_url' => $ipn_url,
            'label' => $label
        ];

        $res = $this->curl_call($url, $payload);
        return $res;
    }

    /** 
     * 
     * Generate an invoice with callback address and hosted payment page
     * @return json response with success or error message
    */
    public function create_invoice($currency, $amount, $forward_address = '', $ipn_url = '', $invoice_id = '', $hosted_invoice = false, $product_title = '', $product_description = '', $cancel_url = '', $success_url = '', $buyer_email = '') {
        $url = $this->url.$this->version.'/create_invoice';

        if($amount == 0) {
            throw new \Exception('The amount cannot be zero or negative number');
        }

        if(!is_numeric($amount)) {
            throw new \Exception('The amount should be numeric double');
        }

        $payload = [
            'amount'=>$amount,
            'currency'=>(isset($currency)) ? $currency : $this->default_currency,
            'forward_address'=>$forward_address,
            'ipn_url'=>$ipn_url,
            'invoice_id'=>$invoice_id,
            'hosted_invoice'=>$hosted_invoice,
            'product_title'=>$product_title,
            'product_description'=>$product_description,
            'cancel_url'=>$cancel_url,
            'success_url'=>$success_url,
            'buyer_email'=>$buyer_email
        ];

        $res = $this->curl_call($url, $payload);
        return $res;
    }

    /**
     * 
     * Create a withdrawal request from your wallet
     * @return json response with success or error message
     */
    public function create_withdrawal($amount, $currency, $address, $ipn_url = '') {
        $url = $this->url.$this->version.'/create_withdrawal';

        if($amount == 0) {
            throw new \Exception('The amount cannot be zero or negative number');
        }

        if(!is_numeric($amount)) {
            throw new \Exception('The amount should be numeric double');
        }

        if(!isset($address)) {
            throw new \Exception('The receiver address is required');
        }

        $payload = [
            'amount'=>$amount,
            'currency'=>(isset($currency)) ? $currency : $this->default_currency,
            'address'=>$address,
            'ipn_url'=>$ipn_url
        ];

        $res = $this->curl_call($url, $payload);
        return $res;
    }

    /**
     * 
     * @param string $url
     * @param array $payload parameters
     * @return json
     */
    public function curl_call($url, $payload = '') {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_HTTPHEADER => [
              "Content-Type: application/json",
              "Authorization: Bearer ".$this->api_key.""
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_URL => "".$url."",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if($error) {
            return json_decode($error);
        } else {
            return json_decode($response);
        }
    }

}
