<?php

namespace Opensource\TestPlugin;

class TestPlugin {

    private $url = 'https://demozab.com/coinwerx/PluginAPI';

    private $coin;

    private $param;

    public function __construct($coin = '') {
        $this->param['coin'] = $coin;

        //get credential
        $credentials = $this->get_credentials($coin);
        if(isset($credentials['private_key'], $credentials['private_key'])) {
            $this->param['private_key'] = $credentials['private_key'];
            $this->param['public_key'] = $credentials['public_key'];
        }
    }

    public function get_credentials() {
        $get_details = array();

        //get details from config folder
        $credentials = config('test_plugin');
        if(count($credentials) > 0) {
            $get_details['private_key'] = $credentials['private_key'];
            $get_details['public_key'] = $credentials['public_key'];        
        }
        return $get_details;
    }

    //get balance
    public function get_balance() {
        $url = $this->url.'/get_balance';
        $res = $this->curl_call($url, $this->param);
        return $res;
    }

    //get deposit address
    public function get_deposit_address() {
        $url = $this->url.'/get_deposit_address';
        $res = $this->curl_call($url, $this->param);
        return $res;
    }

    //get payment transaction information
    public function get_tx_info($payment_id) {
        $this->param['payment_id'] = $payment_id;
        $url = $this->url.'/get_tx_info';
        $res = $this->curl_call($url, $this->param);
        return $res;
    }

    //get all payment transaction information
    public function get_tx_list() {
        $url = $this->url.'/get_tx_list';
        $res = $this->curl_call($url, $this->param);
        return $res;
    }

    //generate new payment transaction
    public function create_transaction($cmd, $amount, $currency1, $currency2, $item_name, $item_number, $invoice, $success_url, $cancel_url, $buyer_email, $address = '', $buyer_name = '', $ipn_url = '') {
        //get parameters
        $this->param['cmd'] = $cmd;
        $this->param['amount'] = $amount;
        $this->param['currency1'] = $currency1;
        $this->param['currency2'] = $currency2;
        $this->param['item_name'] = $item_name;
        $this->param['item_number'] = $item_number;
        $this->param['invoice'] = $invoice;
        $this->param['success_url'] = $success_url;
        $this->param['cancel_url'] = $cancel_url;
        $this->param['buyer_email'] = $buyer_email;
        $this->param['address'] = $address;
        $this->param['buyer_name'] = $buyer_name;
        $this->param['ipn_url'] = $ipn_url;
        $url = $this->url.'/create_transaction';
        $res = $this->curl_call($url, $this->param);
        return $res;
    }

    //make new withdrawal
    public function withdraw($address, $amount) {
        //get parameters
        $this->param['address'] = $address;
        $url = $this->url.'/withdraw';
        $res = $this->curl_call($url, $this->param);
        return $res;
    }

    //get withdrawal history
    public function get_all_withdraw_history() {
        //get parameters
        $url = $this->url.'/get_withdraw_history';
        $res = $this->curl_call($url, $this->param);
        return $res;
    }

    //get single withdrawal history
    public function get_withdraw_history($withdraw_id) {
        $this->param['withdraw_id'] = $withdraw_id;
        //get parameters
        $url = $this->url.'/get_withdraw_history';
        $res = $this->curl_call($url, $this->param);
        return $res;
    }

    public function curl_call($url, $post = '') {
        if(!isset($post['private_key']) && !isset($post['public_key'])){
            return json_decode($this->error_response('Please set private_key and public_key for '.$this->coin), true);
        }
        if($post['private_key'] == '' || $post['public_key'] == ''){
            return $this->error_response('Please set private_key and public_key for '.$this->coin);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        if($post != '') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        $headers = array();
        $headers[] = 'Content-Type: multipart/form-data;';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return $this->error_response('Error '.curl_error($ch));
        }
        curl_close($ch);
        return json_decode($result, true);
    }

    public function error_response($msg = '') {
        if($msg != '') {
            return array('status' => false, 'response' => "", 'message' => $msg);
        }
    }
}