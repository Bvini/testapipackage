# opensource-testplugin
testplugin for laravel

## installation guide.
you can install testplugin plugin using composer in laraval : 
```
composer require opensource/testplugin
```
## Register service provider to your config/app.php like below : 

Add ```Opensource\TestPlugin\TestPluginServiceProvider::class ``` line at bottom in 
```providers``` array
 ```
 'providers' => [
    Opensource\TestPlugin\TestPluginServiceProvider::class,
 ]

 'aliases' => [
    'TestPluginData' => Opensource\TestPlugin\TestPlugin::class,
 ]
 ```
## Publish configuration file to config folder using following command:
 ```
 php artisan vendor:publish --tag=test_package_config
 ```

## Set credentials of all coins which you want to use from coinwerx in config/test_plugin.php like : 
If this file not exist then create and set configuration like this.  [How to get Private key and Public key ?](https://demozab.com/coinwerx/userpanel/public/getKeyList)
 ```
return [

    'public_key' => '',
    
    'private_key' => ''
];
 ```
 
## Usage of library : 
 
 you have to include namespace of package wherever you want to use this library like,
 ```
 use TestPluginData;
 ```
 after using name space you can access all the methods of library by creating object of class like,
 ```
 $btc_wallet = new TestPluginData('BTC');
 ```
 here "BTC" must be in config/test_plugin.php file array.

### Get Balance : 
you can get balance of your wallet using get_balance call.
```
$balance = $btc_wallet->get_balance();
```
this will return either success response or error response if something went wrong.like below is the success response : 
```
[
      "status" => true
      "response" => [
            "coin" => "BTC"
            "available" => "0.00000000"
            "locked" => "0.00000000"
            "total" => "0.00000000"
      ]
      "message" => ""
]
```
### Get Deposit Address : 
you can get deposit address of your wallet using get_deposit_address call.
```
$balance = $btc_wallet->get_deposit_address();
```
this will return either success response or error response if something went wrong.like below is the success response : 
```
[
      "status" => true
      "response" => [
            "address" => "15XWXXXXXXXXXXXJxbeQ3M"
      ]
      "message" => ""
]
```
### Generate Payment Transaction : 
you can generate new payment transaction using create_transaction call.
```
$balance = $btc_wallet->create_transaction($cmd, $amount, $currency1, $currency2, $item_name, $item_number, $invoice, $success_url, $cancel_url, $buyer_email, $address, $buyer_name, $ipn_url);
```
this will return either success response or error response if something went wrong.like below is the success response : 
```
[
      "status" => true
      "response" => [
            "original_amount" => "0.1"
            "original_currency" => "ETH"
            "selected_amount" => "0.10000000"
            "selected_currency" => "ETH"
            "address" => "XXXXXXXXXXXXXXXX"
            "payment_id" => "CNWRXTXXXXXXXXXXWSB9"
            "confirms_needed" => 1
            "timeout" => 18000
            "qrcode_url" => "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=&choe=UTF-8"
      ]
      "message" => ""
]
```
### Get Single Payment Transaction Details : 
you can get payment transaction details using get_tx_info call.
```
$balance = $btc_wallet->get_tx_info($payment_id);
```
this will return either success response or error response if something went wrong.like below is the success response : 
```
[
      "status" => true
      "response" => [
            "transaction_details" => [
                  "payment_id" => "CNWRXXXXXXXXXKASZEQLI"
                  "date_time" => "25-02-2021 19:11:00"
                  "status" => "Payment completed successfully"
                  "original_amount" => "0.10000000"
                  "original_currency" => "ETH"
                  "selected_amount" => "0.10000000"
                  "selected_currency" => "ETH"
                  "buyer_email" => "xxxxxx@xxxx.com"
                  "invoice" => "1234567"
                  "item_name" => "test"
                  "item_number" => "123456789"
            ]
            "payment_details" => [
                  "date_time" => "25-02-2021 19:13:06"
                  "from_address" => "0x6874XXXXXXXXXX56b782919afc85"
                  "to_address" => "0x7346fXXXXXXXXX5cfeb7f1931b8975"
                  "amount" => "0.10000000"
                  "txn_id" => "0x7bcacXXXXXXXXXXX25be3f57cea"
            ]
      ]
      "message" => ""
]
```
### Get All Transaction Details : 
you can get all payment transaction details using get_tx_list call.
```
$balance = $btc_wallet->get_tx_list();
```
this will return either success response or error response if something went wrong.like below is the success response : 
```
[
      "status" => true
      "response" => [
            "transaction_details" => [
                0 => [
                    "payment_id" => "CNWRXXXXXXXXXXASZEQLI"
                    "date_time" => "25-02-2021 19:11:00"
                    "status" => "Payment completed successfully"
                    "original_amount" => "0.10000000"
                    "original_currency" => "ETH"
                    "selected_amount" => "0.10000000"
                    "selected_currency" => "ETH"
                    "buyer_email" => "xxxxxx@xxxx.com"
                    "invoice" => "1234567"
                    "item_name" => "test"
                    "item_number" => "123456789"
                ]
            ]
      ]
      "message" => ""
]
```