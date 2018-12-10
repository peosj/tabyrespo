<?php 
session_start();
include('config/config.php');
$epay_resp="";
?>
<?php
/// Summary description for Controller
///  ErrorCode  : Description
///  00         : Your signature has been verified successfully.  
///  06         : No Certificate found 
///  07         : One Certificate Found and Expired
///  08         : Both Certificates Expired
///  09         : Your Data cannot be verified against the Signature.
//error_reporting(E_ALL);
//var_dump($_POST);exit;
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
	$fpxcert=array($path."EX00005331.cer",$path."fpxuat-1.cer");
	$certs=checkCertExpiry($fpxcert);
	//echo count($certs) ;
	    	$signdata = hextobin($sign);
	if(count($certs)==1)
	{
	   //echo "sdfds";
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
   //error_reporting(0);
return validateCertificate('/',$sign, $toSign);
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
$fpx_buyerBankBranch=$_POST['fpx_buyerBankBranch'];
$fpx_buyerBankId=$_POST['fpx_buyerBankId'];
$fpx_buyerIban=$_POST['fpx_buyerIban'];
$fpx_buyerId=$_POST['fpx_buyerId'];
$fpx_buyerName=$_POST['fpx_buyerName'];
$fpx_creditAuthCode=$_POST['fpx_creditAuthCode'];
$fpx_creditAuthNo=$_POST['fpx_creditAuthNo'];
$fpx_debitAuthCode=$_POST['fpx_debitAuthCode'];
$fpx_debitAuthNo=$_POST['fpx_debitAuthNo'];
$fpx_fpxTxnId=$_POST['fpx_fpxTxnId'];
$fpx_fpxTxnTime=$_POST['fpx_fpxTxnTime'];
$fpx_makerName=$_POST['fpx_makerName'];
$fpx_msgToken=$_POST['fpx_msgToken'];
$fpx_msgType=$_POST['fpx_msgType'];
$fpx_sellerExId=$_POST['fpx_sellerExId'];
$fpx_sellerExOrderNo=$_POST['fpx_sellerExOrderNo'];
$fpx_sellerId=$_POST['fpx_sellerId'];
$fpx_sellerOrderNo=$_POST['fpx_sellerOrderNo'];
$fpx_sellerTxnTime=$_POST['fpx_sellerTxnTime'];
$fpx_txnAmount=$_POST['fpx_txnAmount'];
$fpx_txnCurrency=$_POST['fpx_txnCurrency'];
$fpx_checkSum=$_POST['fpx_checkSum'];
$data=$fpx_buyerBankBranch."|".$fpx_buyerBankId."|".$fpx_buyerIban."|".$fpx_buyerId."|".$fpx_buyerName."|".$fpx_creditAuthCode."|".$fpx_creditAuthNo."|".$fpx_debitAuthCode."|".$fpx_debitAuthNo."|".$fpx_fpxTxnId."|".$fpx_fpxTxnTime."|".$fpx_makerName."|".$fpx_msgToken."|".$fpx_msgType."|".$fpx_sellerExId."|".$fpx_sellerExOrderNo."|".$fpx_sellerId."|".$fpx_sellerOrderNo."|".$fpx_sellerTxnTime."|".$fpx_txnAmount."|".$fpx_txnCurrency;
//echo $data;
$val=verifySign_fpx($fpx_checkSum, $data);
// if val is 00 sucess 
$val="00";

$q = "SELECT * FROM orders WHERE seller_order_no = '".$fpx_sellerOrderNo."'";
$order_data = mysql_fetch_array(mysql_query($q));


//print_r($fpx_debitAuthCode); 
//sexit;

$txn_status = "";
if ($fpx_debitAuthCode == '00')
{
    $txn_status = 'success';
    $display_message = "Your transaction has been processed successfully !";
    $display_img = "images/txnsuccess.png";
    $payment_status = '1';
    
    
    $update_orders_query = "update orders set payment_status = '1' where user_id = '".$order_data['user_id']."' AND (date between '".$order_data['batch_lower_date']."' AND '".$order_data['batch_upper_date']."') AND transaction_type != 'Batch'";
    mysql_query($update_orders_query);
    
    //echo $update_orders_query;
        
}
elseif ($fpx_debitAuthCode == '99')
{
	$txn_status = $display_message = "PENDING FOR AUTHORIZER TO APPROVE";
    $display_img = "images/txnfailed.png";
    $payment_status = '0';
}
elseif ($fpx_debitAuthCode == '51')
{
	$txn_status = $display_message = "Insufficient Funds";
    $display_img = "images/txnfailed.png";
    $payment_status = '0';
}
elseif ($fpx_debitAuthCode == '57')
{
	$txn_status = $display_message = "Transaction Not Permitted";
    $display_img = "images/txnfailed.png";
    $payment_status = '0';
}
else
{
	$txn_status = $display_message = "UNSUCCESSFUL. ";
    $display_img = "images/txnfailed.png";
    $payment_status = '0';
} 


mysql_query("update orders set seller_txn_status = '".$fpx_debitAuthCode."', payment_status = '".$payment_status."' where seller_order_no = '".$fpx_sellerOrderNo."'");

if($order_data['source'] == "App")
{
    
?>
<script>
    function getTransactionStatus()
    {
        var status = '<?php echo $txn_status; ?>&&<?php echo $order_id['batch_lower_date']; ?>&&<?php echo $order_id['batch_upper_date']; ?>&&<?php echo $order_id['reload_amt']; ?>';
        return status;
    }
</script>
            
<!DOCTYPE html>
<html lang="en" itemscope>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>QYKPAY- Payment</title>
<meta name="description" content="" />
<meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,initial-scale=1.0,user-scalable=no"/>
<link rel="icon" href="<?php echo $base_url;?>themes/s3.ap-south-1.amazonaws.com/reloadv2/assets/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="<?php echo $base_url;?>themes/s3.ap-south-1.amazonaws.com/reloadv2/assets/css/reloadv1.5.9.css">	
<meta name="theme-color" content="#0d6ea8">
<script type="text/javascript" src="<?php echo $base_url;?>themes/s3.ap-south-1.amazonaws.com/reloadv2/assets/js/jquery-1.7.min_v1.js"></script>
</head>
<body onload="test();" style="padding-bottom: 0px !important;">
<section class="orderSummary" style="width: 100%; background: none;">
<div class="container">
<div class="row">
<aside class="col-lg-12 col-md-12 col-sm-12">
<div class="orderBlockLeft" style=" margin-top: 10px;">
<h2>Transaction Status</h2>
<div class="scrollbar1">
<div class="viewport" style="height: 350px;">
<div class="overview">
<ul class="orderList orderList" style="text-align: center; margin-top: 10px;">
<li style="line-height: 24px;">
<div style="width: 100%; text-align: center;"><img src="<?php echo $display_img; ?>" style="width: 60px;display: inline-block;"/></div>
Your transaction has been processed successfully !
</li>
<li>RM<?php echo $order_data['reload_amt']; ?></li>
<li><?php echo $order_data['batch_lower_date']; ?> to <?php echo $order_data['batch_upper_date']; ?></li>
</ul>
<div style="padding-left: 20px; color:#999; font-size:11px;line-height: 24px;padding-top: 20px; text-align: center;">Don't back or refresh this page, You will be redirected in few moments.</div>
</div>
</div>
</div>

</div>
</aside>
</div>
</div>
</section>
</body>
</html>   
<?php
exit;                      
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

<script>
    function getTransactionStatus(data)
    {        
        return data;
    }
</script>
                                
</head>
<div class="Scroll">
<?php  include('staging/fpx/blocks/header.php');?>
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
                <td align="center" style="padding: 30px; font-size: 30px;"><strong>Payment Receipt</strong></td>
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
						  //echo $fpx_debitAuthCode;
                          if ($fpx_debitAuthCode == '00')
							{
								echo "SUCCESSFUL";
                                include('staging/fpx/preview.php');
                                
                                $today = date("Y-m-d");
                                $transDateTime = date("Ymdhis");
                                //echo "timestamp:<br><br>".$transDateTime."<br><br><br>";
                                $epayResponseMessage = "";
                                
                                $qry_odr = "SELECT transaction_id,operator,reload_amt, product_description,order_id,batch_lower_date,batch_upper_date,source FROM orders WHERE seller_order_no = '".$fpx_sellerOrderNo."'";
                                
                                $res_order = mysql_query($qry_odr);
                                $order_id = mysql_fetch_array($res_order);
                                
                                //echo $res_order;
                                //echo 'order list:'; 
                                 //print_r($order_id);
                                
                                $q = "INSERT INTO  orders_epay(orders_id,amount,rettransref,productcode,date) values(
                                '".$order_id['transaction_id']."',
                                '".$order_id['reload_amt']."',
                                '".$fpx_sellerOrderNo."',
                                '".$order_id['operator']."',
                                '".$today."'
                                )";
                           // echo $q.'<br/>'; 
                                mysql_query($q);
                                $orders_epay_id=mysql_insert_id();
                                
                                
                                $user_name=$_SESSION['logname'];
                                $user_id= $_SESSION['logid'];
                                $user_email=$_SESSION['logemail'];
                                $user_phone=$_SESSION['logphone'];
                                
                                $receiver_phone     = $_SESSION['receiver_phone'];
                                $receiver_userid    = $_SESSION['receiver_userid'];
                                $receiver_name      = $_SESSION['receiver_name'];
                                $source             = $_SESSION['source'];
                                $transaction_type   = $_SESSION['transaction_type'];
                                
                                //print_r($_SESSION); 
                                
                                
        
                                /* insert into transaction Table */
                                
                                $ins_trans_qry="INSERT INTO transaction (merchant_id, merchant_name, user_id, user_name, user_phone, user_email, transaction_id, order_id, order_desc, status, amount, date, timestamp, source,receiver_phone,receiver_userid,receiver_name,transaction_type) VALUES ('1002','Tabypay','".$user_id."','".$user_name."','".$user_phone."','".$user_email."','".$order_id['transaction_id']."','".$order_id['order_id']."','".$order_id['product_description']."','successfull','".$order_id['reload_amt']."','".date('Y-m-d')."','".date('Y-m-d H:i:s')."','".$source."','".$receiver_phone."','".$receiver_userid."','".$receiver_name."','".$transaction_type."')";
                                
                               // print_r($ins_trans_qry); 
                                
                                mysql_query($ins_trans_qry);
                                
                                $recharge_no=$_SESSION['number'];
                                $url='https://taby.app/staging/fpx/epay/index.php'; // Specify your url
                                $data= array('amount'=>$order_id['reload_amt'],'retTransRef'=>$fpx_sellerOrderNo,'productCode'=>$order_id['operator'],'transDateTime'=>$transDateTime,'date'=>$today,'msisdn'=>$recharge_no);
                                
                                //print_r($data);
                                 
                                $ch = curl_init(); // Initialize cURL
                                curl_setopt($ch, CURLOPT_URL,$url);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                                $epayResponse = curl_exec($ch); 
                                $err = curl_error($ch);

                                curl_close($ch);
 

                               /*if ($err){
                                echo "cURL Error #:" . $err;
                                } else {
                                echo $epayResponse;
                                } */
                                
                                
                                
                                 if($epayResponse == "failed")
                                {
                                    mysql_query("UPDATE orders_epay SET responsecode = '011', responsemsg = 'Mendatory Fields Missing.' where orders_epay_id = '".$orders_epay_id."'");
                                    $epayResponseMessage = "Failed";
                                  }
                                else
                                {
                                     $epayResponse = json_decode($epayResponse);
                                    
                                    //var_dump($epayResponse);
                                    //$epayResponseCode = $epayResponse->etopupReturn->responseCode;
                                     
                                    // print_r($epayResponse);
                                     
                                    $epayResponseCode = $epayResponse->responseCode;
                                    $epayTransRef = $epayResponse->transRef;
                                    $epayTerminalId = $epayResponse->terminalId;
                                    $epayRettransref = $epayResponse->retTransRef;
                                    $epayResponsemsg = $epayResponse->responseMsg;
                                    $epayResponsecode = $epayResponse->responseCode;
                                    $epayProductcode = $epayResponse->productCode;
                                    $epayPinexpirydate = $epayResponse->pinExpiryDate;
                                    $epayPin = $epayResponse->customField1;
                                    $instruction="Instruction";
                                     mysql_query("update orders_epay set responsecode = '".$epayResponseCode."', responsemsg = '".$epayResponsemsg."', 
                                        pin = '".$epayPin."',
                                        pinexpirydate = '".$epayPinexpirydate."',
                                        terminalid = '".$epayTerminalId."',
                                        transref = '".$epayTransRef."' where orders_epay_id = '".$orders_epay_id."'");
                                    
                                    //echo $epayResponseCode;
                                    
                                    
                                    if($epayResponseCode == '00')
                                    {
                                        
                                        $epayResponseMessage = "SUCCESSFUL";
                                        $epay_resp='<tr>
                      <td width="44%" align="left" class="main">Pin Number</td>
                      <td width="7%" align="center" class="main">:</td> 
                      <td width="49%" align="left" class="main">'.$epayPin.'</td>
                    </tr>					
					<tr>
                      <td width="44%" align="left" class="main">Recharge Instruction</td>
                      <td width="7%" align="center" class="main">:</td> 
                      <td width="49%" align="left" class="main">'.$instruction.'</td>
                    </tr>
                          ';
                                        
                                    }
                                    else
                                    {
                                        $epayResponseMessage = "Failed";
                                        $epay_resp='';
                                        
                                    }
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
                            
                            mysql_query("update orders set seller_txn_status = '".$fpx_debitAuthCode."' where seller_order_no = '".$fpx_sellerOrderNo."'");
						
                       
                        session_destroy();
                        
                        ?>
                        
                        
                        
						</strong></td>
                    </tr>
                    <tr>
                      <td width="44%" align="left" class="main" height="30">Date & Time</td>
                      <td width="7%" align="center" class="main">:</td>
                      <td width="49%" align="left" class="main"><?php print $timetxn; ?></td>
                    </tr>
                    <tr>
                      <td width="44%" align="left" class="main" height="30">Reload Status</td>
                      <td width="7%" align="center" class="main">:</td>
                      <td width="49%" align="left" class="main"><?php print $epayResponseMessage; ?></td>
                    </tr>
                    <tr>
                      <td width="44%" align="left" class="main" height="30">FPX Txn ID</td>
                      <td width="7%" align="center" class="main">:</td>
                      <td width="49%" align="left" class="main"><?php print $fpx_fpxTxnId; ?></td>
                    </tr>
                    <tr>
                      <td width="44%" align="left" class="main" height="30">Seller Order Number</td>
                      <td width="7%" align="center" class="main">:</td>
                      <td width="49%" align="left" class="main"><?php print $fpx_sellerOrderNo; ?></td>
                    </tr>
					<tr>
                      <td width="44%" align="left" class="main" height="30">Buyer Bank Name</td>
                      <td width="7%" align="center" class="main">:</td>
                      <td width="49%" align="left" class="main"><?php print $fpx_buyerBankBranch; ?></td>
                    </tr>					
					<tr>
                      <td width="44%" align="left" class="main" height="30">Transaction Amount</td>
                      <td width="7%" align="center" class="main">:</td>
                      <td width="49%" align="left" class="main">&nbsp;RM<?php print $fpx_txnAmount; ?></td>
                    </tr>
					<tr>
					 <td width="44%" align="left" class="main" height="30">Error Code</td>
                      <td width="7%" align="center" class="main"></td>
                      <td width="49%" align="left" class="main">&nbsp;<?php print $fpx_debitAuthCode; ?> </td>
                    </tr>
					<?php
                        echo  $epay_resp; 
                      ?>
                      <?php
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
<?php include('staging/fpx/blocks/footer.php');?>
</body>
</html>
