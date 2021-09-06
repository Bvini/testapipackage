Test API Package
testapipaackage plugin for laravel

installation guide.
you can install testapipaackage plugin using composer in laraval :

composer require opensource/testplugin
Register service provider to your config/app.php like below :
Add Opensource\TestPlugin\TestPluginServiceProvider::class line at bottom in providers array

'providers' => [
   Opensource\TestPlugin\TestPluginServiceProvider::class,
]

'aliases' => [
	'TestPluginData' => Opensource\TestPlugin\TestPlugin::class,
]

Publish configuration file to config folder using following command:
php artisan vendor:publish --tag=test_plugin_config
Set credentials of all coins which you want to use from testapipackage in config/test_plugin.php like :
If this file not exist then create and set configuration like this. How to get API key and Password ?

return [

    'api_key' => '',

    'api_secret' => ''
];

Usage of library :

use TestPluginData;
after using name space you can access all the methods of library by creating object of class like,

$btc_wallet = new TestPluginData('BTC');
here "BTC" must be in config/test_plugin.php file array.

Get Balance :
you can get balance of your wallet using get_balance call.

$balance = $btc_wallet->get_balance();
this will return either success response or error response if something went wrong.like below is the success response :

{
    "msg" => 'test'
}