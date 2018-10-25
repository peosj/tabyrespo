<?php
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


$oglWsService = new OglWsService();


$reponseMsg = new ResponseMsg;
$reponseMsg = $oglWsService->onlinePIN($requestMsg);

//Below is to show the request message.
//echo "The Request Message:-<br/>";
//var_dump($requestMsg);

//Below is to show the response message.
//echo "The Response Message:-<br/>";
var_dump($reponseMsg);


}
else
{
    echo "failed";
}

?>
