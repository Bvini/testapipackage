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