<?php

/**
*  Developer:
 * Daniel Mbeyah (danmbeyah@gmail.com)
 * Sep 2017
 */
 
include "Equity.php";
use Equity\Equity;

//Get variables from our form
$recipientPhone = $_POST['recipientPhone'];
$accountNumber = $_POST['accountNumber'];
$recipientName = $_POST['recipientName'];
$amount = $_POST['amount'];

//Insert this record in DB and get record ID for your reference. You can save status as "pending"
$reference = 12345; //Get this reference after doing DB insert of this recored

$consumer_key = "Your key goes here";
$consumer_secret = "Your secret goes here";
$equityObj = new Equity($consumer_key,$consumer_secret);

try{
    $transactionDets = [
        "countryCode" => "KE",
        "currencyCode" => "KES",
        "amount" => $amount,
        "paymentType" => "",
        "paymentReferences" => ["ref1","ref2","ref3"],
        "remarks"=>"Thank you"
    ];
    $recipientDets = [
        "accountNumber"=>$accountNumber,
        "bicCode"=>"KCBLKENX005",
        "mobileNumber"=>$recipientPhone,
        "walletName"=>$recipientName,
        "bankCode"=>"KCBL",
        "branchCode"=>"006"
    ];
    $reference = $reference;
    $sender_name = "Daniel The Guy";
    $return = $equityObj->sendMoney($recipientDets,$transactionDets,$reference,$sender_name);
    
    if(strtolower($return->status)=="success"){
    	//Update DB record status to "Success"
    	//Redirect to success page
    	echo "Congratulations! You have successfully integrated Eazy APIs. Money Sent to...Display receiver details in success page for assurance and peace of mind ;) ";
    }else{
    	//Connection was successful but airtime not sent. Try again...
    	echo "Money sending failed. Try again.";
    }
}catch(Exception $e){
	echo "Error in connecting to Eazzy API";
}

?>