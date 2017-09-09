<?php

/**
*  Developer:
 * Daniel Mbeyah (danmbeyah@gmail.com)
 * Sep 2017
 */
 
include "Equity.php";
use Equity\Equity;

//Get variables from our form
$phone = $_POST['phone'];
$amount = $_POST['amount'];
$serviceProvider = $_POST['serviceprovider'];

//Insert this record in DB and get record ID for your reference. You can save status as "pending"
$reference = 12345; //Get this reference after doing DB insert of this recored

$consumer_key = "Your key goes here";
$consumer_secret = "Your secret goes here";
$equityObj = new Equity($consumer_key,$consumer_secret);

try{
    $phoneNumber = $phone; //Phone number to receive airtime
    $amount = $amount; //amount to buy
    $serviceProvider = $serviceProvider; //service provider (airtel,equitel,safaricom)
    $reference = $reference; //your db transaction id
    $return = $equityObj->buyAirtime($phoneNumber,$amount,$serviceProvider,$reference);
    //var_dump($return);
    if(strtolower($return->status)=="success"){
    	//Update DB record status to "Success"
    	//Redirect to success page
    	echo "Congratulations! You have successfully integrated Eazy APIs. Airtime Sent";
    }else{
    	//Connection was successful but airtime not sent. Try again...
    	echo "Airtime failed to send. Try again.";
    }
}catch(Exception $e){
	echo "Error in connecting to Eazzy API";
}

?>