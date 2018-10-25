<?php

if(isset($_POST['amount']) && isset($_POST['retTransRef']) && isset($_POST['productCode']) && isset($_POST['transDateTime']))
{
    $amount = $_POST['amount'];
    $retTransRef = $_POST['retTransRef'];
    $productCode = $_POST['productCode'];
    $transDateTime = $_POST['transDateTime'];
    
    
                $requestMsg = new RequestMsg;
                $requestMsg->amount=$amount;
                $requestMsg->merchantId="202599";
                $requestMsg->operatorId="IBS";
                $requestMsg->orgTransRef=1;
                $requestMsg->retTransRef="$retTransRef";
                $requestMsg->terminalId="80037656";
                $requestMsg->productCode="$productCode";
                $requestMsg->msisdn='S10047342';
                $requestMsg->transDateTime="$transDateTime";
                $requestMsg->transTraceId=0;
                $requestMsg->customField1="Custom1";
                $requestMsg->customField2="Custom2";
                $requestMsg->customField3="Custom3";
                $requestMsg->customField4="Custom4";
                $requestMsg->customField5="Custom5";
                
                
                //var_dump($requestMsg);
                
                
                $params1 = array('in0' => $requestMsg);
                //$soapclient = new SoapClient('http://wstest.oriongateway.com:22835/willani/services/oglws?wsdl');
                //$soapclient = new SoapClient('https://wstest.oriongateway.com:22831/willani/services/oglws?wsdl');
                $soapclient = new SoapClient('http://wstest.oriongateway.com:22835/willani/services/oglws?wsdl', array(
                'trace' => true, 
                "local_cert"    => '/home/qykpay11/ssl/certs/epay/yourcert.pem', 
                "passphrase"         => 'qykpay@11'
                ));
                
                
                $response = $soapclient->__soapCall('etopup', array($params1), array(
                            'uri' => 'urn:EPAYIBWS',
                            'soapaction' => ''
                           ));
                
                 //$responseCode = $response->etopupReturn->responseCode;
                
                echo json_encode($response);
            

}
else
{
    echo "failed";
}



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