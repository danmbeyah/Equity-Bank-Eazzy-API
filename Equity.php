<?php

/**
*  Developer:
 * Daniel Mbeyah (danmbeyah@gmail.com)
 * Sep 2017
 */
 
namespace Equity;

class Equity
{
    protected $access_token;
    protected $default_header = [
        'Content-Type: application/json'
    ];
    protected  $base_identity_url = 'https://api.equitybankgroup.com/identity/v1-sandbox';
    protected  $base_transaction_url = 'https://api.equitybankgroup.com/transaction/v1-sandbox';

    function __construct($consumer_key,$secret,$username="user",$password="pass",$grant_type="password") //change to merchant details for production
    {
        $this->setAccessToken($consumer_key,$secret,$username,$password,$grant_type);
    }

    public function sendMoney($destination= array(),$transfer = array(),$transaction_reference,$sender_name){
            $data = [];
            $data['transactionReference'] = $transaction_reference;
            $data['source'] = [
                'senderName'=>$sender_name
            ];
            $data['destination']=$destination;
            $data['transfer'] = $transfer;
            $data = json_encode($data);
            $url = $this->base_transaction_url.'/remittance';
            $response = $this->post($url,$data);
            
            return $response;
    }


    public function buyAirtime($phone,$amount,$provider,$reference = null){
        $data = [];
        $data['customer'] = [
            'mobileNumber'=>$phone
        ];
        $data['airtime']=[
            'amount'=>$amount,
            'reference'=>$reference,
            'telco'=>$provider
        ];
        $data = json_encode($data);
        $url = $this->base_transaction_url.'/airtime';
        $response = $this->post($url,$data);
        return $response;
    }

    protected function getDefaultHeader(){
        $header = $this->default_header;
        $header[] = 'Authorization: Bearer '.$this->access_token;
        return $header;
    }

    protected function setAccessToken($consumer_key,$secret,$username="user",$password="pass",$grant_type="password"){
        $url = $this->base_identity_url.'/token';
        $header = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic '.base64_encode("$consumer_key:$secret")
        ];
        $data = [
            'username'=>$username,
            'password'=>$password,
            'grant_type'=>$grant_type
        ];
        $data = http_build_query($data);
        $token = $this->post($url,$data,$header)->access_token;
        $this->access_token = $token;
    }
    protected function post($url,$data=null,$header=null)
    {
        return $this->curlRequest($url,'POST',$data,$header);
    }
    protected function get($url,$data=null,$header=null){
        return $this->curlRequest($url,'GET',$data,$header);
    }
    protected  function curlRequest($url,$method,$data=null,$header=null){

        if(!$header){
            $header = $this->getDefaultHeader();
        }
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if($status>199 && $status <205){
            return json_decode($response);
        }else{
            throw new Exception($response);
        }
    }
}