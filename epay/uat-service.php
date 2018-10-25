<?php
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

class onlinePIN {
  public $in0; // RequestMsg
}

class onlinePINResponse {
  public $onlinePINReturn; // ResponseMsg
}


class onlinePINReversal {
  public $in0; // RequestMsg
}

class onlinePINReversalResponse {
  public $onlinePINReversalReturn; // ResponseMsg
}

class etopup {
  public $in0; // RequestMsg
}

class etopupResponse {
  public $etopupReturn; // ResponseMsg
}

class etopupReversal {
  public $in0; // RequestMsg
}

class etopupReversalResponse {
  public $etopupReversalReturn; // ResponseMsg
}

class networkCheck {
  public $in0; // RequestMsg
}

class networkCheckResponse {
  public $networkCheck; // ResponseMsg
}

class OglWsService extends SoapClient {

  private static $classmap = array('RequestMsg' => 'RequestMsg',
                                   'ResponseMsg' => 'ResponseMsg');
	
  public function OglWsService($wsdl = null, $options = null) {
  
	$options = array(
  			'soap_version' => SOAP_1_1,
				//'location' => 'http://wstest.oriongateway.com:22835/willani/services/oglws', //no SSL
				//'location' => 'https://wstest.oriongateway.com:22831/willani/services/oglws', //1 way SSL
				'location' => 'http://wstest.oriongateway.com:22835/willani/services/oglws', //2 way SSL
				'stream_context' => stream_context_create(array (
						'ssl' => array (
							'verify_peer_name' => false, //Required by both 1 & 2 way SSL
							'cafile' => '/home/qykpay11/ssl/certs/epay/publicKey.cer', //Required by both 1 & 2 way SSL, replace with e-pay production cert in production
							'local_cert' => '/home/qykpay11/ssl/certs/epay/yourcert.pem', //Required by 2 way SSL, replace with your own private key in production
							                                          //Command to convert from p12 to pem:-
							                                          //#openssl pkcs12 -in willaniclienttest2.p12 -out willaniclienttest2.pem -clcerts
							'passphrase' => 'qykpay@11' //Required by 2 way SSL, replace by your own passphrase in production
						))),
				'uri' => 'EPAYIBWS');
    foreach(self::$classmap as $key => $value) {
      if(!isset($options['classmap'][$key])) {
        $options['classmap'][$key] = $value;
      }
    }
    parent::__construct($wsdl, $options); 
  }

  public function onlinePIN(RequestMsg $parameter)  {
    return $this->__soapCall('onlinePIN', array($parameter), array('uri' => 'urn:EPAYIBWS','soapaction' => ''));
  }	
  
  public function onlinePINReversal(onlinePINReversal $parameters) {
    return $this->__soapCall('onlinePINReversal', array($parameters), array('uri' => 'urn:EPAYIBWS','soapaction' => ''));
  }
  
  public function etopup(RequestMsg $parameters) {
    return $this->__soapCall('etopup', array($parameters), array('uri' => 'urn:EPAYIBWS','soapaction' => ''));
  }

  public function etopupReversal(etopupReversal $parameters) {
    return $this->__soapCall('etopupReversal', array($parameters), array('uri' => 'urn:EPAYIBWS','soapaction' => ''));
  }
  
  public function networkCheck(networkCheck $parameters) {
    return $this->__soapCall('networkCheck', array($parameters), array('uri' => 'urn:EPAYIBWS','soapaction' => ''));
  }
}

?>
