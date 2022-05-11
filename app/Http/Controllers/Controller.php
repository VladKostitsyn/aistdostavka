<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use InfyOm\Generator\Utils\ResponseUtil;
use Illuminate\Support\Facades\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct(){
        // config(['app.timezone' => setting('timezone')]);

        $debug = config('app.debug');
        if ($debug && substr($_SERVER['REQUEST_URI'], 0, 4) ==  '/api') {
            $ppp = explode('?', $_SERVER['REQUEST_URI']);
            $ppp_0 = str_replace(array('/','?'),'_', $ppp[0]);
            $path = str_replace(array('/','?'),'_', $_SERVER['REQUEST_URI']);
            $putdata = fopen("php://input", "r");
            $put = '';
            while ($data = fread($putdata, 1024)) {
                $put .= $data;
            }

            file_put_contents(__DIR__ . '/Debug.logs/'.$ppp_0.'-'.md5($path).'.txt', "$path\r\n".print_r($_POST, true) ."\r\n". print_r($_SERVER, true) . "\r\n PUT->" . $put);
        }

    }

    /**
     * @param $result
     * @param $message
     * @return mixed
     */
    public function sendResponse($result, $message)
    {
        $debug = config('app.debug');
        if ($debug && substr($_SERVER['REQUEST_URI'], 0, 4) ==  '/api') {
            $ppp = explode('?', $_SERVER['REQUEST_URI']);
            $ppp_0 = str_replace(array('/','?'),'_', $ppp[0]);
            $path = str_replace(array('/','?'),'_', $_SERVER['REQUEST_URI']);
            $putdata = fopen("php://input", "r");
            $put = '';
            while ($data = fread($putdata, 1024)) {
                $put .= $data;
            }

            file_put_contents(__DIR__ . '/Debug.logs/'.$ppp_0.'-'.md5($path).'.output.txt', "$path\r\n".print_r($_POST, true) ."\r\n". print_r($_SERVER, true) . "\r\n PUT->" . $put . "\r\n OUTPUT->" . print_r(ResponseUtil::makeResponse($message, $result), true));
        }

        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    /**
     * @param $error
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }
}
