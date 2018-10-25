<?php
$date = date("Ymdhis");
$requestMsg = new RequestMsg;
$requestMsg->amount="500";
$requestMsg->merchantId="201993";
$requestMsg->operatorId="IBS";
$requestMsg->orgTransRef=1;
$requestMsg->retTransRef="100610Test1207";
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



$params1 = array('in0' => $requestMsg);

$classmap = array('RequestMsg' => 'RequestMsg','ResponseMsg' => 'ResponseMsg');
                                   
$options = array(
'location' => 'https://wstest.oriongateway.com:22832/willani/services/oglws',
'stream_context' => stream_context_create(array (
    'ssl' => array (
    'verify_peer_name' => false,
    'cafile' => '/home/qykpay11/ssl/certs/epay/publicKey.cer',
    'local_cert' => '/home/qykpay11/ssl/certs/epay/yourcert.pem',
    'passphrase' => 'qykpay@11'
))),
'uri' => 'EPAYIBWS',
'trace' => true);

foreach($classmap as $key => $value) {
      if(!isset($options['classmap'][$key])) {
        $options['classmap'][$key] = $value;
      }
    }

var_dump($options);

$soapclient = new SoapClient(null, $options);

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

class ResponseMsg {
  public $amount; // string
  public $pin; // string
  public $pinExpiryDate; // string
  public $productCode; // string
  public $responseCode; // string
  public $responseMsg; // string
  public $retTransRef; // string
  public $terminalId; // string
  public $transRef; // string
  public $customField1; // string
  public $customField2; // string
  public $customField3; // string
  public $customField4; // string
  public $customField5; // string
}

?>