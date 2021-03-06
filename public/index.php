<?php

$ppp = explode('?', $_SERVER['REQUEST_URI']);
$ppp_0 = str_replace(array('/','?'),'_', $ppp[0]);
$path = str_replace(array('/','?'),'_', $_SERVER['REQUEST_URI']);
$putdata = fopen("php://input", "r");
$put = '';
while ($data = fread($putdata, 1024)) {
    $put .= $data;
}

file_put_contents(__DIR__ . '/logs/'.$ppp_0.'-'.md5($path).'.txt', "$path\r\n".print_r($_POST, true) ."\r\n". print_r($_SERVER, true) . "\r\n PUT->" . $put);

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/
header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods : GET,POST,PUT,DELETE,OPTIONS");
// header("Access-Control-Allow-Headers : Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
