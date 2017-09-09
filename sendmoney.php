<?php
include "Equity.php";
use Equity\Equity;
$consumer_key = "JHKAxxk5Dey75Yi6RlWLApjZv1R3rQss";
$consumer_secret = "eydMey5FK4PqdJ7A";
$equityObj = new Equity($consumer_key,$consumer_secret);

//send money to business or merchant
try{

    $transactionDets = [
        "countryCode" => "KE",
        "currencyCode" => "KES",
        "amount" => "45000",
        "paymentType" => "",
        "paymentReferences" => ["ref1","ref2","ref3"],
        "remarks"=>"Thank you"
    ];
    $recipientDets = [
        "accountNumber"=>987654321,
        "bicCode"=>"KCBLKENX005",
        "mobileNumber"=>"",
        "walletName"=>"Daniel Mbeyah",
        "bankCode"=>"KCBL",
        "branchCode"=>"006"
    ];
    $reference = "JW_Black";
    $sender_name = "Daniel The Guy";
    $return = $equityObj->sendMoney($recipientDets,$transactionDets,$reference,$sender_name);
    var_dump($return);

}catch(Exception $e){
    var_dump($e->getMessage());
}


