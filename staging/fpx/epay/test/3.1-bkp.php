<?php
$date = date("Ymdhis");
$requestMsg = new RequestMsg;
$requestMsg->amount="500";
$requestMsg->merchantId="201993";
$requestMsg->operatorId="IBS";
$requestMsg->orgTransRef=1;
$requestMsg->retTransRef="100610Test12070";
$requestMsg->terminalId="10000177";
$requestMsg->productCode="CELCOMAIRTIMEST";
$requestMsg->msisdn='0191234567';
    $requestMsg->transDateTime=$date;
    $requestMsg->transTraceId=1;
$requestMsg->customField1="Custom1";
$requestMsg->customField2="Custom2";
$requestMsg->customField3="Custom3";
$requestMsg->customField4="Custom4";
$requestMsg->customField5="Custom5";

//var_dump($requestMsg);

$params1 = array('in0' => $requestMsg);
//$soapclient = new SoapClient('http://wstest.oriongateway.com:22835/willani/services/oglws?wsdl');
//$soapclient = new SoapClient('https://wstest.oriongateway.com:22831/willani/services/oglws?wsdl');
$soapclient = new SoapClient('https://wstest.oriongateway.com:22832/willani/services/oglws?wsdl', array(
'trace' => true, 
"local_cert"    => '/home/qykpay11/ssl/certs/epay/yourcert.pem', 
"passphrase"         => 'qykpay@11'
));
//echo"<br><br><br><br>";
//var_dump($params1);
//echo"<br><br><br><br>";
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