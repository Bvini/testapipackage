<?php

namespace Opensource\TestPlugin;

class TestPlugin {

    private $url = 'https://demozab.com/coinwerx/testapi/';

    private $coin;

    private $param;

    public function __construct($coin = '') {
        $this->coin = $coin;

        //get credential
        $credentials = $this->get_credentials($coin);
        if(isset($credentials['private_key'], $credentials['private_key'])) {
            $this->param['private_key'] = $credentials['private_key'];
            $this->param['public_key'] = $credentials['public_key'];
        }
    }

    public function get_credentials() {
        $get_details = '';

        //get details from config folder
        $credentials = config('app.test_plugin');
        if(count($credentials) > 0) {
            $get_details['private_key'] = $credentials['private_key'];
            $get_details['public_key'] = $credentials['public_key'];        
        }
        return $get_details;
    }
    
    public function get_balance() {
        $url = $this->url.'/test.php';
        $res = $this->curl_call($url, $this->param);
        return $res;
    }

    public function curl_call($url, $post = '') {
        dd($post);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if($post != '') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $headers = array();
        $headers[] = "Content-Type : application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }
}