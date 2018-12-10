<?php 
session_start();
include("config/config.php"); 
?>
<?php

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


$qyk_sellerExOrderNo="Q2017KISTX2-20170207123912";
$qyk_sellerTxnTime="20170207123912";
$qyk_sellerOrderNo="Q2017K-20170207123907";
$qyk_txnAmount=121.00;
$qyk_buyerEmail="jktech11@gmail.com";
$qyk_buyerBankId="TEST0021";


$fpx_msgType="AE";
$fpx_msgToken="01";
$fpx_sellerExId="EX00005331";
$fpx_sellerExOrderNo=$qyk_sellerExOrderNo;
$fpx_sellerTxnTime=$qyk_sellerTxnTime;
$fpx_sellerOrderNo=$qyk_sellerOrderNo;
$fpx_sellerId="SE00006118";
$fpx_sellerBankCode="01";
$fpx_txnCurrency="MYR";
$fpx_txnAmount=$qyk_txnAmount;
$fpx_buyerEmail=$qyk_buyerEmail;
$fpx_checkSum="";
$fpx_buyerName="";
$fpx_buyerBankId=$qyk_buyerBankId;
$fpx_buyerBankBranch="";
$fpx_buyerAccNo="";
$fpx_buyerId="";
$fpx_makerName="";
$fpx_buyerIban="";
$fpx_productDesc="SampleProduct";
$fpx_version="6.0";

/* Generating signing String */
$data=$fpx_buyerAccNo."|".$fpx_buyerBankBranch."|".$fpx_buyerBankId."|".$fpx_buyerEmail."|".$fpx_buyerIban."|".$fpx_buyerId."|".$fpx_buyerName."|".$fpx_makerName."|".$fpx_msgToken."|".$fpx_msgType."|".$fpx_productDesc."|".$fpx_sellerBankCode."|".$fpx_sellerExId."|".$fpx_sellerExOrderNo."|".$fpx_sellerId."|".$fpx_sellerOrderNo."|".$fpx_sellerTxnTime."|".$fpx_txnAmount."|".$fpx_txnCurrency."|".$fpx_version;

/* Reading key */
$priv_key = file_get_contents('/home/qykpay11/ssl/keys/e75d3_06ded_7dd44f86a92c8d8fc5a1b6001e11c722.key');
$pkeyid = openssl_get_privatekey($priv_key);
openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
$fpx_checkSum = strtoupper(bin2hex( $binary_signature ) );


//extract data from the post

extract($_POST);
$fields_string="";

//set POST variables
$url ='https://uat.mepsfpx.com.my/FPXMain/sellerNVPTxnStatus.jsp';


$fields = array(
						'fpx_msgType' => urlencode($fpx_msgType),
						'fpx_msgToken' => urlencode($fpx_msgToken),
						'fpx_sellerExId' => urlencode($fpx_sellerExId),
						'fpx_sellerExOrderNo' => urlencode($fpx_sellerExOrderNo),
						'fpx_sellerTxnTime' => urlencode($fpx_sellerTxnTime),
						'fpx_sellerOrderNo' => urlencode($fpx_sellerOrderNo),
						'fpx_sellerId' => urlencode($fpx_sellerId),
						'fpx_sellerBankCode' => urlencode($fpx_sellerBankCode),
						'fpx_txnCurrency' => urlencode($fpx_txnCurrency),
						'fpx_txnAmount' => urlencode($fpx_txnAmount),
						'fpx_buyerEmail' => urlencode($fpx_buyerEmail),
						'fpx_checkSum' => urlencode($fpx_checkSum),
						'fpx_buyerName' => urlencode($fpx_buyerName),
						'fpx_buyerBankId' => urlencode($fpx_buyerBankId),
						'fpx_buyerBankBranch' => urlencode($fpx_buyerBankBranch),
						'fpx_buyerAccNo' => urlencode($fpx_buyerAccNo),
						'fpx_buyerId' => urlencode($fpx_buyerId),
						'fpx_makerName' => urlencode($fpx_makerName),
						'fpx_buyerIban' => urlencode($fpx_buyerIban),
						'fpx_productDesc' => urlencode($fpx_productDesc),
						'fpx_version' => urlencode($fpx_version)
				);
$response_value=array();


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
//echo "RESULT";
echo $result;


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

$fpx_debitAuthCode=reset($response_value);
//Response Checksum Calculation String
$data=$response_value['fpx_buyerBankBranch']."|".$response_value['fpx_buyerBankId']."|".$response_value['fpx_buyerIban']."|".$response_value['fpx_buyerId']."|".$response_value['fpx_buyerName']."|".$response_value['fpx_creditAuthCode']."|".$response_value['fpx_creditAuthNo']."|".$fpx_debitAuthCode."|".$response_value['fpx_debitAuthNo']."|".$response_value['fpx_fpxTxnId']."|".$response_value['fpx_fpxTxnTime']."|".$response_value['fpx_makerName']."|".$response_value['fpx_msgToken']."|".$response_value['fpx_msgType']."|".$response_value['fpx_sellerExId']."|".$response_value['fpx_sellerExOrderNo']."|".$response_value['fpx_sellerId']."|".$response_value['fpx_sellerOrderNo']."|".$response_value['fpx_sellerTxnTime']."|".$response_value['fpx_txnAmount']."|".$response_value['fpx_txnCurrency'];

$val=verifySign_fpx($response_value['fpx_checkSum'], $data);

// val == 1 verification success

}
catch(Exception $e){
	echo 'Error :', ($e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en" itemscope>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>QYKPAY-Login</title>
<meta name="description" content="" />
<meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,initial-scale=1.0,user-scalable=no"/>
<script type="text/javascript" src="<?php echo $base_url;?>themes/s3.ap-south-1.amazonaws.com/reloadv2/assets/js/jquery-1.7.min_v1.js"></script>
<link rel="stylesheet" href="<?php echo $base_url;?>themes/s3.ap-south-1.amazonaws.com/reloadv2/assets/css/reloadv1.5.9.css">
<meta name="theme-color" content="#0d6ea8">
<div class="Scroll">
<?php  include('blocks/header.php');?>
<style>
.invalid_error{
color:red !important;
font-size:14px !important;
margin:0px !important;
}
</style>
<div class="homeContent MSignup">
<div class="container">
<section class="mainBlock2 plansBlock">
<div class="row">
<center>
  <table border="0" cellpadding="0" cellspacing="0" height="300" width="722">
    <tbody>
      <tr>
        <td colspan="3" align="left" height="111"><table cellpadding="0" cellspacing="0"  width="722" >
            <tbody>
              <tr>
                <td align="center" style="padding: 30px; font-size: 30px;"><strong>Transaction Status</strong></td>
              </tr>
            </tbody>
          </table>
		  </td>
      </tr>
      <!-- header_eof //-->
      <!-- body //-->
      <tr>
        <td style="padding-right: 1px;" align="right" valign="top" width="6"><br>
        </td>
        <td style="padding-left: 1px; padding-right: 1px;" align="left" valign="top" width="716" colspan=2>
		<table bgcolor="" border="0" cellpadding="0" cellspacing="5" class="infoBelow" width="100%" height="100%">
		  <tbody>
              <tr>
                <td height="150" valign="top">				
			<!--	<p class="normal" style="text-align: center;font-size: 20px;">
                    Thanks For Order With Us! </p>-->
                  <p>&nbsp;</p>				  
				  <p class="normal"><b>Your FPX payment has been processed </b></p><br />
				<!-- Display details for Receipt -->
				  <table width="100%" align="center" style="font-size: 17px;">
				  <?php
				  if($val=="00")
				  {
					?>
					<tr>
                      <td width="44%" align="left" class="main" height="30">Transaction Status</td>
                      <td width="7%" align="center" class="main">:</td>
                      <td width="49%" align="left" class="main"><strong style="color: #27a13b;">
					  <!-- Comparing Debit Auth Code and Credit Auth Code to cater SUCCESSFUL and UNSUCCESSFUL result -->	
						<?php
                            
                            
                            //$datetimeFormat = 'Y-m-d H:i:s';

                              //$date = new \DateTime();
                                //$date->setTimestamp($fpx_fpxTxnTime);
                                //$timetxn= $date->format($datetimeFormat);
                                
                          $timetxn=  date("d M y h:i:s", strtotime($fpx_fpxTxnTime) );
						  
                          if ($fpx_debitAuthCode == '00')
							{
								echo "SUCCESSFUL";
                                include('preview.php');
                                
                                
                                $today = date("Y-m-d");
                                $transDateTime = date("Ymdhis");
                                //echo "timestamp:<br><br>".$transDateTime."<br><br><br>";
                                $epayResponseMessage = "";
                                $order_id = mysql_fetch_array(mysql_query("select transaction_id,operator,reload_amt from orders where seller_order_no = '".$_SESSION['seller_order_no']."'"));
                                
                                $q = "insert into orders_epay(orders_id,amount,rettransref,productcode,date) values(
                                '".$order_id['transaction_id']."',
                                '".$order_id['reload_amt']."',
                                '".$_SESSION['seller_order_no']."',
                                '".$order_id['operator']."',
                                '".$today."'
                                )";
                                //echo $q;
                                mysql_query($q);
                                $orders_epay_id=mysql_insert_id();
                                $url='https://qykpay.com/epay/uat.php'; // Specify your url
                                $data= array('amount'=>$order_id['reload_amt'],'retTransRef'=>$_SESSION['seller_order_no'],'productCode'=>$order_id['operator'],'transDateTime'=>$transDateTime,'date'=>$date, 'msisdn'=>'0191234567');
                                
                                //echo $data;
                                
                                $ch = curl_init(); // Initialize cURL
                                curl_setopt($ch, CURLOPT_URL,$url);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $epayResponse = curl_exec($ch);                                
                                curl_close($ch);
                                 
                                if($epayResponse == "failed")
                                {
                                    mysql_query("update orders_epay set responsecode = '011', responsemsg = 'Mendatory Fields Missing.' where orders_epay_id = '".$orders_epay_id."'");
                                    $epayResponseMessage = "Failed";
                                }
                                else
                                {
                                    $epayResponse = json_decode($epayResponse);
                                    
                                    $epayResponseCode = $epayResponse->etopupReturn->responseCode;
                                    $epayTransRef = $epayResponse->etopupReturn->transRef;
                                    $epayTerminalId = $epayResponse->etopupReturn->terminalId;
                                    $epayRettransref = $epayResponse->etopupReturn->retTransRef;
                                    $epayResponsemsg = $epayResponse->etopupReturn->responseMsg;
                                    $epayResponsecode = $epayResponse->etopupReturn->responseCode;
                                    $epayProductcode = $epayResponse->etopupReturn->productCode;
                                    $epayPinexpirydate = $epayResponse->etopupReturn->pinExpiryDate;
                                    $epayPin = $epayResponse->etopupReturn->pin;
                                    $instruction= $epayResponse->etopupReturn->customField1;
                                    
                                     mysql_query("update orders_epay set responsecode = '".$epayResponseCode."', responsemsg = '".$epayResponsemsg."', 
                                        pin = '".$epayPin."',
                                        pinexpirydate = '".$epayPinexpirydate."',
                                        terminalid = '".$epayTerminalId."',
                                        transref = '".$epayTransRef."' where orders_epay_id = '".$orders_epay_id."'");
                                    
                                    
                                    
                                   
                                }
							}
							elseif ($fpx_debitAuthCode == '99')
							{
								echo "PENDING FOR AUTHORIZER TO APPROVE";
							}
							elseif ($fpx_debitAuthCode == '51')
							{
								echo "Insufficient Funds";
							}
							elseif ($fpx_debitAuthCode == '57')
							{
								echo "Transaction Not Permitted";
							}
							else
							{
								echo "UNSUCCESSFUL. ";
							} 
                            
                            
                            //echo $fpx_debitAuthCode;
                            
                            mysql_query("update orders set seller_txn_status = '".$fpx_debitAuthCode."' where seller_order_no = '".$_SESSION['seller_order_no']."'");
                            
                            $timetxn=  date("d M y h:i:s", strtotime($fpx_fpxTxnTime) );
						?>
						</strong></td>
                    </tr>
                    <tr>
                      <td width="44%" align="left" class="main">FPX Txn ID</td>
                      <td width="7%" align="center" class="main">:</td>
                      <td width="49%" align="left" class="main"><?php print $response_value['fpx_fpxTxnId']; ?></td>
                    </tr>
                    <tr>
                      <td width="44%" align="left" class="main">Seller Order Number</td>
                      <td width="7%" align="center" class="main">:</td>  
                      <td width="49%" align="left" class="main"><?php print $response_value['fpx_sellerOrderNo']; ?></td>
                    </tr>
					<tr>
                      <td width="44%" align="left" class="main">Buyer Bank</td>
                      <td width="7%" align="center" class="main">:</td> 
                      <td width="49%" align="left" class="main"><?php print $response_value['fpx_buyerBankId']; ?></td>
                    </tr>					
					<tr>
                      <td width="44%" align="left" class="main">Transaction Amount</td>
                      <td width="7%" align="center" class="main">:</td> 
                      <td width="49%" align="left" class="main">&nbsp;RM<?php print $response_value['fpx_txnAmount']; ?></td>
                    </tr>
                    
                    <?php
                     if($epayResponseCode == '00')
                                    {
                                        ?>
                     <tr>
                      <td width="44%" align="left" class="main">Pin Number</td>
                      <td width="7%" align="center" class="main">:</td> 
                      <td width="49%" align="left" class="main"><?php print $epayPin; ?></td>
                    </tr>					
					<tr>
                      <td width="44%" align="left" class="main">Recharge Instruction</td>
                      <td width="7%" align="center" class="main">:</td> 
                      <td width="49%" align="left" class="main">&nbsp;<?php print $instruction; ?></td>
                    </tr>
                             <?php
                                       
                                    }
                                    
					}
					else
					{
					?>
                    <tr>
                      <td width="44%" align="left" class="main" height="30">FPX Status</td>
                      <td width="7%" align="center" class="main">:</td>
                      <td width="49%" align="left" class="main">Transaction Failed</td>
                    </tr>
					<tr>
                      <td width="44%" align="left" class="main">  </td>
                      <td width="7%" align="center" class="main"></td>
                      <td width="49%" align="left" class="main"><?php print $ErrorCode; ?></td>
                    </tr>
					<?php
					}
					?>
                    <tr>
                        <td colspan="3">
                            AE Message : 
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="3">
                            <textarea style="width: 100%; height: 100px;"><?php echo trim($result);?></textarea>
                        </td>
                    </tr>
                  </table>
			    </td>
              </tr>
		  </tbody>
          </table></td>
      </tr>
      <!-- footer //-->  
    </tbody>
  </table>
  <p>&nbsp;</p>
  <hr>
  <center>
  <p class="infoBelow">&nbsp;</p>
	<p>&nbsp;</p>
	<tr>
        <td style="padding-left: 1px; padding-right: 1px;" align="left" valign="top" width="716" colspan=2>
		</td>
	</tr>
  <p>&nbsp;</p>
</center>   
<div class="clear"></div>
           </section>
</div>
</div>
<div class="modal fade" id="plans-details" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog large-md"><div class="modal-content"><div class="modal-header border0 "><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></div><div class="modal-body padding-top0"></div></div></div></div><div class="modal fade" id="Validatorbox"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title" id="ValidatorboxTitle"></h4></div><div class="modal-body" id="ValidatorBoxContent"></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div>
<section id="happy-customer-banner" class="hidden-xs" style="background: #105d8b; padding: 20px 0px;">
<div class="container">
<div class="row">
<div class="col-sm-12" style="color: #fff; text-align: center;">
<p style="text-align: center;">
<ul type="circle" start="1" style="list-style: circle !important;">
<li>* You must have Internet Banking Account in order to make transaction using FPX.</li>
<li>* Please ensure that your browser's pop up blocker has been disabled to avoid any interruption during making transaction.</li>
<li>* Do not close browser / refresh page until you receive response.</li>
</ul> </p>
</div>
</div>
</div>
</section>
<?php include('blocks/footer.php');?>
</body>
</html>
