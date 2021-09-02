<?php
namespace TestPlugin;

class TestPlugin {

    private $url = 'https://demozab.com/coinwerx/testapi/';

    public function __construct() {
    }
    
    public function get_balance() {
        $url = $this->url.'/test.php';
        $res = $this->curl_call($url);
        return $res;
    }

    public function curl_call($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
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