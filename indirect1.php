<?php 
session_start();
    include("config/config.php"); 
?>
<?php
/// Summary description for Controller
///  ErrorCode  : Description
///  00         : Your signature has been verified successfully.  
///  06         : No Certificate found 
///  07         : One Certificate Found and Expired
///  08         : Both Certificates Expired
///  09         : Your Data cannot be verified against the Signature.
error_reporting(E_ALL);
var_dump($_POST);exit;
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
	echo count($certs) ;
	    	$signdata = hextobin($sign);
			
	
	if(count($certs)==1)
	{
	   echo "sdfds";
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
                <td align="center" style="padding: 30px; font-size: 30px;"><strong>SAMPLE FPX MERCHANT PAGE</strong></td>
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
				<p class="normal" style="text-align: center;font-size: 20px;">
                    Thanks For Order With Us! </p>
                  <p>&nbsp;</p>				  
				  
				  <p class="normal"><b>TRANSACTION DETAILS</b></p><br />
				<!-- Display details for Receipt -->
				  <table width="100%" align="center" style="font-size: 17px;">
				  <?php
				  if($val=="00")
				  {
					?>
					<tr>
                      <td width="44%" align="left" class="main">Transaction Status</td>
                      <td width="7%" align="center" class="main">:</td>
                      <td width="49%" align="left" class="main"><strong>
					  <!-- Comparing Debit Auth Code and Credit Auth Code to cater SUCCESSFUL and UNSUCCESSFUL result -->	
						<?php
						  if ($fpx_debitAuthCode == '00' && $fpx_debitAuthCode == '00')
							{
								echo "SUCCESSFUL";
                                
                                
                                include('preview.php');
                                
                                
                                					
							}
							elseif ($fpx_debitAuthCode == '99')
							{
								echo "PENDING FOR AUTHORIZER TO APPROVE";
							}
							elseif ($fpx_debitAuthCode != '00' || $fpx_debitAuthCode != '' || $fpx_debitAuthCode != '99' )
							{
								echo "UNSUCCESSFUL.";
							} 
						?>
						</strong></td>
                    </tr>
                    <tr>
                      <td width="44%" align="left" class="main">FPX Txn ID</td>
                      <td width="7%" align="center" class="main">:</td>
                      <td width="49%" align="left" class="main"><?php print $fpx_fpxTxnId; ?></td>
                    </tr>
                    <tr>
                      <td width="44%" align="left" class="main">Seller Order Number</td>
                      <td width="7%" align="center" class="main">:</td>
                      <td width="49%" align="left" class="main"><?php print $fpx_sellerOrderNo; ?></td>
                    </tr>
					<tr>
                      <td width="44%" align="left" class="main">Buyer Bank</td>
                      <td width="7%" align="center" class="main">:</td>
                      <td width="49%" align="left" class="main"><?php print $fpx_buyerBankId; ?></td>
                    </tr>					
					<tr>
                      <td width="44%" align="left" class="main">Transaction Amount</td>
                      <td width="7%" align="center" class="main">:</td>
                      <td width="49%" align="left" class="main">&nbsp;RM<?php print $fpx_txnAmount; ?></td>
                    </tr>
					<tr>
					 <td width="44%" align="left" class="main"></td>
                      <td width="7%" align="center" class="main"></td>
                      <td width="49%" align="left" class="main">&nbsp;<?php print $ErrorCode; ?> </td>
                    </tr>
					
					<?php
					}
					else
					{
					?>
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
<section id="happy-customer-banner" class="hidden-xs" style=" background: #203758;">
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