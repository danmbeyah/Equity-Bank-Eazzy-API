<?php
include "Equity.php";
use Equity\Equity;
$consumer_key = "JHKAxxk5Dey75Yi6RlWLApjZv1R3rQss";
$consumer_secret = "eydMey5FK4PqdJ7A";
$equityObj = new Equity($consumer_key,$consumer_secret);

//Buy airtime
try{
    $phoneNumber = "0726306316";
    $amount = 500; //amount to buy
    $serviceProvider = "safaricom"; //service provider (airtel,equitel,safaricom)
    $reference = "airtime001";//your db transaction id
    $return = $equityObj->buyAirtime($phoneNumber,$amount,$serviceProvider,$reference);
    var_dump($return->status);
}catch(Exception $e){

}