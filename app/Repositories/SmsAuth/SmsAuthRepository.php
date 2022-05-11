<?php


namespace App\Repositories\SmsAuth;

use GuzzleHttp\Client as HTTP;
use Sabberworm\CSS\Settings;

class SmsAuthRepository
{
    protected $login;

    protected $password;
    protected $url;

    public function __construct(){
        $this->url = config('SmsAuth.service');
        $this->login = setting('sms_login');
        $this->password = setting('sms_password');
    }

    public function sendSMS($number){
        $http = new HTTP();
        $passcode=strval(mt_rand(1000,9999));
        $response = $http->request('GET',$this->url.'login='.$this->login.'&'.'psw='.$this->password.'&'.'phones='.$number.'&'.'mes='.'SecretCode:' . $passcode);
        $res['statusCode']=$response->getStatusCode();
        $res['SecretCode']=$passcode;
        return $res;
    }

    /*public function verification ($code){
        if( session()->has('$code')){
            return true;
        }else{
            return false;
        }
    }*/

  /*  public function HttpBuild (){

    }*/
}