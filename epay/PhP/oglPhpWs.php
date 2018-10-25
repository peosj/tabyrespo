<?php
require_once 'OglWsService.php';

$requestMsg = new RequestMsg;

$requestMsg->amount="1000";
$requestMsg->merchantId="912371";
$requestMsg->operatorId="IBS";
$requestMsg->retTransRef="100610Test1"; //Unique client transaction reference
$requestMsg->terminalId="16561011";
$requestMsg->productCode="DIGIST";
$requestMsg->msisdn="200";
$requestMsg->transDateTime="20170414144400"; //yyyyMMddHHmmss
$requestMsg->transTraceId=1; //Unique ID to identify each transaction request


$oglWsService = new OglWsService();


$reponseMsg = new ResponseMsg;
$reponseMsg = $oglWsService->onlinePIN($requestMsg);

//Below is to show the request message.
echo "The Request Message:-<br/>"
var_dump($requestMsg);

//Below is to show the response message.
echo "The Response Message:-<br/>"
var_dump($reponseMsg);


?>
