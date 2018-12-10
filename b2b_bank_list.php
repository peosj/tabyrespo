<?php
include('config/config.php');
/// Summary description for Controller
///  ErrorCode  : Description
///  00         : Your signature has been verified successfully.  
///  06         : No Certificate found 
///  07         : One Certificate Found and Expired
///  08         : Both Certificates Expired
///  09         : Your Data cannot be verified against the Signature.

function hextobin($hexstr) 
{ 
	$n = strlen($hexstr); 
	$sbin="";   
	$i=0; 
	while($i<$n) 
	{       
		$a =substr($hexstr,$i,2);           
		$c = pack("H*",$a); 
		if ($i==0){$sbin=$c;} 
		else {$sbin.=$c;} 
		$i+=2; 
	} 
	return $sbin; 
}


function validateCertificate($path,$sign, $toSign)
{
	global  $ErrorCode;

	$d_ate=date("Y");
	//validating Last Three Certificates 
	$fpxcert=array($path."FPXCERT_MERC_UAT_2015_0915.cer",$path."fpxuat_current.cer");
	$certs=checkCertExpiry($fpxcert);
	// echo count($certs) ;
	    	$signdata = hextobin($sign);
			
	
	if(count($certs)==1)
	{

	   $pkeyid =openssl_pkey_get_public($certs[0]);
   	   $ret = openssl_verify($toSign, $signdata, $pkeyid);	
	      if($ret!=1) 
	      {
	  	   $ErrorCode=" Your Data cannot be verified against the Signature. "." ErrorCode :[09]";
	  	   return "09";	  
	      }
    }
	 elseif(count($certs)==2)
	{
	 
	 $pkeyid =openssl_pkey_get_public($certs[0]);
   	 $ret = openssl_verify($toSign, $signdata, $pkeyid);	
	   if($ret!=1)
	   {
       
	    $pkeyid =openssl_pkey_get_public($certs[1]);
   	    $ret = openssl_verify($toSign, $signdata, $pkeyid);	
         if($ret!=1) 
	     {
		  $ErrorCode=" Your Data cannot be verified against the Signature. "." ErrorCode :[09]";
		  return "09";	  
	      }
	    }
		
	}
	 if($ret==1)
	 {

        $ErrorCode=" Your signature has been verified successfully. "." ErrorCode :[00]";
        return "00";	  
 	 }
		 
		 
	return $ErrorCode;

		 

}
function verifySign_fpx($sign,$toSign) 
{
   error_reporting(0);

return validateCertificate('/home/qykpay11/ssl/certs/',$sign, $toSign);
}

function checkCertExpiry($path)
{
		global  $ErrorCode;

      $stack = array();
    $t_ime= time();
    $curr_date=date("Ymd",$t_ime);
     for($x=0;$x<2;$x++)
	 {
		   error_reporting(0);
          $key_id = file_get_contents($path[$x]);
	       if($key_id==null)
	       {
			   $cert_exists++;
	      	 continue;
	       }	 
	       $certinfo = openssl_x509_parse($key_id);
           $s= $certinfo['validTo_time_t']; 
           $crtexpirydate=date("Ymd",$s-86400);
    	  if($crtexpirydate > $curr_date)
	       {
			    if ($x > 0)
				{
				 if(certRollOver($path[$x], $path[$x-1])=="true")
					 {  array_push($stack,$key_id);
						return $stack;
                      }
				}	
                array_push($stack,$key_id);
	      	  return $stack;
           }
	       elseif($crtexpirydate == $curr_date)
	       {
			     if ($x > 0 && (file_exists($path[$x-1])!=1))  
				 {	   
                       if(certRollOver($path[$x], $path[$x-1])=="true")
					   {  array_push($stack,$key_id);
						  return $stack;
					 }
				 }
				 else if(file_exists($path[$x+1])!=1)
				 {
					 	 array_push($stack,file_get_contents($path[$x]),$key_id);
                         return $stack;
				 }
            
			   
	      	    array_push($stack,file_get_contents($path[$x+1]),$key_id);
          
	      		return $stack;
	      	}
	   			
	 }
          if ($cert_exists == 2)
                $ErrorCode="Invalid Certificates.  " . " ErrorCode : [06]";  //No Certificate (or) All Certificate are Expired 
            else if ($stack.Count == 0 && $cert_exists == 1)
                $ErrorCode="One Certificate Found and Expired " . "ErrorCode : [07]";  
            else if ($stack.Count == 0 && $cert_exists == 0)
               $ErrorCode="Both Certificates Expired " . "ErrorCode : [08]";  
            return $stack;

	 
}
function certRollOver($old_crt,$new_crt)
{  

        if (file_exists($new_crt)==1)
        {
            
                rename($new_crt,$new_crt."_".date("YmdHis", time()));//FPXOLD.cer to FPX_CURRENT.cer_<CURRENT TIMESTAMP>

        }
		if ((file_exists($new_crt)!=1) && (file_exists($old_crt)==1))
        {
            rename($old_crt,$new_crt);                                 //FPX.cer to FPX_CURRENT.cer
        }

		
		return "true";
}

//Merchant will need to edit the below parameter to match their environment.
error_reporting(E_ALL);

/* Generating String to send to fpx */
/*For B2C, message.token = 01
 For B2B1, message.token = 02 */

$fpx_msgToken="02";
$fpx_msgType="BE";
$fpx_sellerExId="EX00005331";
$fpx_version="6.0";
/* Generating signing String */
$data=$fpx_msgToken."|".$fpx_msgType."|".$fpx_sellerExId."|".$fpx_version;
/* Reading key */
$priv_key = file_get_contents('/home/qykpay11/ssl/keys/e75d3_06ded_7dd44f86a92c8d8fc5a1b6001e11c722.key');
$pkeyid = openssl_get_privatekey($priv_key);
openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
$fpx_checkSum = strtoupper(bin2hex( $binary_signature ) );


//extract data from the post

extract($_POST);
$fields_string="";

//set POST variables
$url ='https://uat.mepsfpx.com.my/FPXMain/RetrieveBankList';

$fields = array(
						'fpx_msgToken' => urlencode($fpx_msgToken),
						'fpx_msgType' => urlencode($fpx_msgType),
						'fpx_sellerExId' => urlencode($fpx_sellerExId),
						'fpx_checkSum' => urlencode($fpx_checkSum),
						'fpx_version' => urlencode($fpx_version)
						
				);
$response_value=array();
$bank_list=array();

try{
//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

//open connection
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);

curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//execute post
$result = curl_exec($ch);



//close connection
curl_close($ch);


$token = strtok($result, "&");
while ($token !== false)
{
	list($key1,$value1)=explode("=", $token);
	$value1=urldecode($value1);
	$response_value[$key1]=$value1;
	$token = strtok("&");
}

$fpx_msgToken=reset($response_value);

//Response Checksum Calculation String
$data=$response_value['fpx_bankList']."|".$response_value['fpx_msgToken']."|".$response_value['fpx_msgType']."|".$response_value['fpx_sellerExId'];
$val=verifySign_fpx($response_value['fpx_checkSum'], $data);

// val == 00 verification success

$token = strtok($response_value['fpx_bankList'], ",");
while ($token !== false)
{
	list($key1,$value1)=explode("~", $token);
	$value1=urldecode($value1);
	$bank_list[$key1]=$value1;
	$token = strtok(",");
}



 $bank_data=mysql_query("Select display_name, bank_id from bank_list order by bank_name");
    while($bank=mysql_fetch_array($bank_data))
    {
        $bank_id=$bank['bank_id'];
        $bank_name=$bank['display_name'];
        $bank_status=$bank_list[$bank_id];
        
        if($bank_status=="A")
            {
                $options.="<option value='".$bank_id."'>".$bank_name."</option>";
            }
            else if($bank_status=="B")
            {
                $options.="<option value='".$bank_id."' disabled='disabled'>".$bank_name." (Offline)</option>";
            }
           else
            {
                 $options.="<option value='".$bank_id."'>".$bank_name."</option>";
            }
          //  echo $bank_id."---".$bank_name."---".$bank_status."<br>";
    }
    

echo $options;

}
catch(Exception $e){
	echo 'Error :', ($e->getMessage());
}

?>

