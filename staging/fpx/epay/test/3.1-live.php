<?php

$date = date("Ymdhis");
$requestMsg = new RequestMsg;
$requestMsg->amount="5";
$requestMsg->merchantId="202599";
$requestMsg->operatorId="OTR";
$requestMsg->orgTransRef=1;
$requestMsg->retTransRef="";
$requestMsg->terminalId="80037656";
$requestMsg->productCode="CELCOMAIRTIMEST";
$requestMsg->msisdn='0191234567';
$requestMsg->transDateTime=$date;
$requestMsg->transTraceId=$date;
$requestMsg->customField1="Custom1";
$requestMsg->customField2="Custom2";
$requestMsg->customField3="Custom3";
$requestMsg->customField4="Custom4";
$requestMsg->customField5="Custom5";

var_dump($requestMsg);

$params1 = array('in0' => $requestMsg);
/*
$soapclient = new SoapClient('https://ws.oriongateway.com:33832/averni/services/oglws', array(
'trace' => true, 
"local_cert"    => '/home/qykpay11/ssl/certs/epay/live/epaylivekey.pem', 
"passphrase"         => 'qykpay@11'
));
*/
$soapclient = new SoapClient(null, array(
'location' => 'https://ws.oriongateway.com:33832/averni/services/oglws',
'uri' => 'EPAYIBWS',
'trace' => true, 
"local_cert"    => '/home/qykpay11/ssl/certs/epay/live/epaylivekey.pem', 
"passphrase"         => 'qykpay@11',
'soap_version' => '1.2'
));


$response = $soapclient->__soapCall('etopup', array($params1), array(
            'uri' => 'urn:EPAYIBWS',
            'soapaction' => ''
           ));
var_dump($response);


//print_r($response);

class RequestMsg {
  public $amount; // string
  public $merchantId; // string
  public $operatorId; // string
  public $orgTransRef; // string
  public $retTransRef; // string
  public $terminalId; // string
  public $productCode; // string
  public $msisdn; // string
  public $transDateTime; // string
  public $transTraceId; // int
  public $customField1; // string
  public $customField2; // string
  public $customField3; // string
  public $customField4; // string
  public $customField5; // string
}
?>