<?php

if(isset($_POST['msisdn']) && isset($_POST['amount']) && isset($_POST['retTransRef']) && isset($_POST['productCode']) && isset($_POST['transDateTime']))
{

/*
    $amount = "500";//$_POST['amount'];

    $retTransRef = "100610Test1207012";//$_POST['retTransRef'];

    $productCode = "CELCOMAIRTIMEST";//$_POST['productCode'];

    $transDateTime = date("Ymdhis");//$_POST['transDateTime'];

    $msisdn = "0191234567";//$_POST['msisdn'];
*/    
    
    
    $amount = $_POST['amount'];

    $retTransRef = $_POST['retTransRef'];

    $productCode = $_POST['productCode'];

    $transDateTime = $_POST['transDateTime'];

    $msisdn = $_POST['msisdn'];

    

    

    //$amount = $_POST['amount'];//$_POST['amount'];

    //$retTransRef = $_POST['retTransRef'];//$_POST['retTransRef'];

    //$productCode = $_POST['productCode'];//$_POST['productCode'];

    //$transDateTime = date("Ymdhis");//$_POST['transDateTime'];

    //$msisdn = $_POST['msisdn'];

    require_once 'uat-service.php';

    $id = rand(1,999999);

    $requestMsg = new RequestMsg;



    $date = date("Ymdhis");

    $requestMsg = new RequestMsg;

    $requestMsg->amount=$amount; // amount in cents variable

    $requestMsg->merchantId="201993"; //fix

    $requestMsg->operatorId="IBS"; // fix

    $requestMsg->retTransRef=$retTransRef; // id autoincreament

    $requestMsg->terminalId="10000177"; // fix

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

echo json_encode($reponseMsg);

//var_dump($reponseMsg->responseMsg);

//var_dump($reponseMsg->onlinePINReturn->responseMsg);

}
else
{
    echo "failed";
}



?>

