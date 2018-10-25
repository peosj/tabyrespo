<?php
session_start();
include("../../config/config.php");
 


//ECHO $_POST['fpx_buyerBankId'];  EXIT;
//var_dump($_SESSION);
//exit;
 //echo $number." $operator ".$operator." $reload ".$reload."  $rec_type ".$rec_type."  $total  ".$total." ";

//Merchant will need to edit the below parameter to match their environment.
error_reporting(E_ALL);
/* Generating String to send to fpx */
/*For B2C, message.token = 01
 For B2B1, message.token = 02 */
$number=$_POST['number'];
$operator=$_POST['operator'];
$fpx_msgType="AR";
$fpx_msgToken="01";
$fpx_sellerExId="EX00005331";
$fpx_sellerExOrderNo=date('QYKTXN-YmdHis');
$fpx_sellerTxnTime=date('YmdHis');
$fpx_sellerOrderNo=$_POST['fpx_sellerOrderNo'];
$fpx_sellerId="SE00006118";
$fpx_sellerBankCode="01";
$fpx_txnCurrency="MYR";
$fpx_txnAmount=$_POST['fpx_txnAmount'];
$fpx_buyerEmail=$_POST['fpx_buyerEmail'];
$fpx_checkSum="";
$fpx_buyerName="";
$fpx_buyerBankId=$_POST['fpx_buyerBankId'];
$fpx_buyerBankBranch="";
$fpx_buyerAccNo="";
$fpx_buyerId="";
$fpx_makerName="";
$fpx_buyerIban="";
$fpx_productDesc = 'Prepaid Reload';
$fpx_version="6.0";



if($fpx_txnAmount >30000 || $fpx_txnAmount<1)
{
    header("location:index.php?msg=0");
}

mysql_query("update orders set fpx_sellerExOrderNo = '".$fpx_sellerExOrderNo."', fpx_sellerTxnTime = '".$fpx_sellerTxnTime."', fpx_buyerBankId = '".$fpx_buyerBankId."', fpx_buyerEmail = '".$fpx_buyerEmail."' where seller_order_no = '".$fpx_sellerOrderNo."'"); 


/* Generating signing String */
$data=$fpx_buyerAccNo."|".$fpx_buyerBankBranch."|".$fpx_buyerBankId."|".$fpx_buyerEmail."|".$fpx_buyerIban."|".$fpx_buyerId."|".$fpx_buyerName."|".$fpx_makerName."|".$fpx_msgToken."|".$fpx_msgType."|".$fpx_productDesc."|".$fpx_sellerBankCode."|".$fpx_sellerExId."|".$fpx_sellerExOrderNo."|".$fpx_sellerId."|".$fpx_sellerOrderNo."|".$fpx_sellerTxnTime."|".$fpx_txnAmount."|".$fpx_txnCurrency."|".$fpx_version;
/* Reading key */
//$priv_key = file_get_contents('FPX2015cert-and-key/e35fa_31dab_a82cdc20bbb7ae28329ed145316e9dea.key');
#$priv_key = file_get_contents('/home/qykpay11/ssl/keys/e75d3_06ded_7dd44f86a92c8d8fc5a1b6001e11c722.key');
$priv_key = file_get_contents('/EX00005331.key');
$pkeyid = openssl_get_privatekey($priv_key);
openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
$fpx_checkSum = strtoupper(bin2hex( $binary_signature ) );
?>
 
function fromAutoSubmit()
{
    document.form1.submit();
}


<?php  include('blocks/header.php');?>
 
<!-- AE Message
<form name="form1" method="post" action="https://uat.mepsfpx.com.my/FPXMain/sellerNVPTxnStatus.jsp" >
-->

<!-- BE Message for bank list
<form name="form1" method="post" action="https://uat.mepsfpx.com.my/FPXMain/RetrieveBankList" >
-->

<!-- AR Message
<form name="form1" method="post" action="https://uat.mepsfpx.com.my/FPXMain/seller2DReceiver.jsp" >
-->

<form name="form1" method="post" action="https://uat.mepsfpx.com.my/FPXMain/seller2DReceiver.jsp" >
<div class="form-group">
<label for="bankname" style="padding-top: 10px;padding-bottom: 10px;">Select Bank</label>
<select name="fpx_buyerBankId" class="form-control" id="fpx_buyerBankId" required>
 
<input type=hidden value="<?php print $fpx_msgType; ?>" name="fpx_msgType"/>
<input type=hidden value="<?php print $fpx_msgToken; ?>" name="fpx_msgToken"/>
<input type=hidden value="<?php print $fpx_sellerExId; ?>" name="fpx_sellerExId"/>
<input type=hidden value="<?php print $fpx_sellerExOrderNo; ?>" name="fpx_sellerExOrderNo"/>
<input type=hidden value="<?php print $fpx_sellerTxnTime; ?>" name="fpx_sellerTxnTime"/>
<input type=hidden value="<?php print $fpx_sellerOrderNo; ?>" name="fpx_sellerOrderNo"/>
<input type=hidden value="<?php print $fpx_sellerId; ?>" name="fpx_sellerId"/>
<input type=hidden value="<?php print $fpx_sellerBankCode; ?>" name="fpx_sellerBankCode"/>
<input type=hidden value="<?php print $fpx_txnCurrency; ?>" name="fpx_txnCurrency"/>
<input type=hidden value="<?php print $fpx_txnAmount; ?>" name="fpx_txnAmount"/>
<input type=hidden value="<?php print $fpx_checkSum; ?>" name="fpx_checkSum"/>
<input type=hidden value="<?php print $fpx_buyerName; ?>" name="fpx_buyerName"/>
<input type=hidden value="<?php print $fpx_buyerBankBranch; ?>" name="fpx_buyerBankBranch"/>
<input type=hidden value="<?php print $fpx_buyerAccNo; ?>" name="fpx_buyerAccNo"/>
<input type=hidden value="<?php print $fpx_buyerId; ?>" name="fpx_buyerId"/>
<input type=hidden value="<?php print $fpx_makerName; ?>" name="fpx_makerName"/>
<input type=hidden value="<?php print $fpx_buyerIban; ?>" name="fpx_buyerIban"/>
<input type=hidden value="<?php print $fpx_version; ?>" name="fpx_version"/>
<input type=hidden value="<?php print $fpx_productDesc; ?>" name="fpx_productDesc"/>	
 
    </select>
    </div>
</form>