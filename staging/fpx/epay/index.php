<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('soap.wsdl_cache_enabled',0);
ini_set('soap.wsdl_cache_ttl',0);

date_default_timezone_set('Asia/Kuala_Lumpur');//change zone as per need


if(isset($_POST['msisdn']) && isset($_POST['amount']) && isset($_POST['retTransRef']) && isset($_POST['productCode']) && isset($_POST['transDateTime']))
{
    $amount = $_POST['amount'];
    $retTransRef = $_POST['retTransRef'];
    $productCode = $_POST['productCode'];
    $transDateTime = $_POST['transDateTime'];
    $msisdn = $_POST['msisdn'];
    
    

    require_once 'service.php';
    $id = rand(1,999999);
    $requestMsg = new RequestMsg;
    
    
   // print_r($requestMsg); exit;

    $date = date("Ymdhis");
    $requestMsg = new RequestMsg;
    $requestMsg->amount=$amount; // amount in cents variable
    $requestMsg->merchantId="202599"; //fix
    $requestMsg->operatorId="OTR"; // fix
    $requestMsg->retTransRef=$retTransRef; // id autoincreament
    $requestMsg->terminalId="80037656"; // fix
    $requestMsg->productCode=$productCode; // operator variable
    $requestMsg->msisdn="0".$msisdn; // number to be recharge variable
    $requestMsg->transDateTime=$transDateTime;
    $requestMsg->transTraceId=$id;
    
 /*   //TEST DATA START
    //$requestMsg = new RequestMsg;
    $requestMsg->amount='500'; // amount in cents variable
    $requestMsg->merchantId="201993"; //fix
    $requestMsg->operatorId="IBS"; // fix
    $requestMsg->retTransRef=$retTransRef; // id autoincreament
    $requestMsg->terminalId="10000177"; // fix
    $requestMsg->productCode=$productCode; // operator variable
    $requestMsg->msisdn='0191234567'; // number to be recharge variable
    $requestMsg->transDateTime=$transDateTime;
    $requestMsg->transTraceId=$id;*/
    //TEST DATA END
    
   // print_r($requestMsg); exit;


$oglWsService = new OglWsService();


$reponseMsg = new ResponseMsg;
    
   // print_r($reponseMsg); exit;
$reponseMsg = $oglWsService->onlinePIN($requestMsg);

//Below is to show the request message.
//echo "The Request Message:-<br/>";
//var_dump($requestMsg);

//Below is to show the response message.
//echo "The Response Message:-<br/>";
//var_dump($reponseMsg);


}
else
{
    echo "failed";
}

?>
