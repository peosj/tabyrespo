<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('soap.wsdl_cache_enabled',0);
ini_set('soap.wsdl_cache_ttl',0);
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

print_r($reponseMsg);
 

?>
