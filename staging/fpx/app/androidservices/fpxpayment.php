<?php

$input = file_get_contents("php://input");
$_POST = json_decode($input, true);

//echo 'test';
//print_r($_POST);  

    $operator          = $_POST['prpdoperator'];
    $number            = $_POST['prpdmobile'];
    $gst               = "";
    $reload            = $_POST['TxnAmount'];
    $rec_type          = $_POST['rec_type'];
    
    $qykpay_loggedin   = $_POST['qykpay_loggedin'];
    $logid             = $_POST['logid'];
   
    $email             = $_POST['email'];
    $bankid             = $_POST['bankid'];
     
    $total      = $reload+$gst;
    
    $discount   = "";
    $promo_code = "";
    
    $product_description  = 'Recharge of '.$operator.' GSM Mobile '.$number;

/// $number             =$_GET['number'];
$operator           =$operator;
$fpx_txnAmount      =$reload;
$fpx_buyerEmail     =$email;
$fpx_buyerBankId    =$bankid;
$fpx_sellerOrderNo  =$seller_order_no;

$fpx_msgType="AR";
$fpx_msgToken="01";
$fpx_sellerExId="EX00005331";
$fpx_sellerExOrderNo=date('QYKTXN-YmdHis');
$fpx_sellerTxnTime=date('YmdHis');

$fpx_sellerId="SE00006118";
$fpx_sellerBankCode="01";
$fpx_txnCurrency="MYR";

$fpx_checkSum="";
$fpx_buyerName="";

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


// echo "order_confirm.php 1";


// header("location:../../mobile_order_confirm1.php?number=".$number."&operator=".$operator."&fpx_txnAmount=".$gst."&fpx_buyerEmail=".$email."&fpx_buyerBankId=".$bankId."&fpx_sellerOrderNo=".$seller_order_no."");

// header("location:../../mobile_order_confirm1.php?number=123&operator=123456789&fpx_txnAmount=12&fpx_buyerEmail=2&fpx_buyerBankId=TEST0021&fpx_sellerOrderNo=Q2018K-20181024152640");

?>

<form name="form1" method="post" action="https://uat.mepsfpx.com.my/FPXMain/seller2DReceiver.jsp" >
     <input class="form-control" value="<?php print $fpx_buyerEmail; ?>" name="fpx_buyerEmail" type="email"/>
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
</form>
<script>
function fromAutoSubmit()
{
    alert('test');
    document.form1.submit();
}
    fromAutoSubmit();
</script>