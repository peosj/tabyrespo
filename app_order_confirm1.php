<?php
include('config/config.php');
session_start();


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
  $product_description=$_POST['product_description'];
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
$priv_key = file_get_contents('/home/qykpay11/ssl/keys/e75d3_06ded_7dd44f86a92c8d8fc5a1b6001e11c722.key');
$pkeyid = openssl_get_privatekey($priv_key);
openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
$fpx_checkSum = strtoupper(bin2hex( $binary_signature ) );
?>
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
<script>
fromAutoSubmit();
function fromAutoSubmit()
{
    document.form1.submit();
}
</script>

</head>
<body style="padding-bottom: 0px !important;background: url(../../images/main-bg.jpg) center top !important;">
<section class="orderSummary" style="width: 100%;">
<div class="container">
<div class="row">
<aside class="col-lg-12 col-md-12 col-sm-12">
<div class="orderBlockLeft" style=" margin-top: 10px;">
<h2>Order Review 1</h2>
<div class="scrollbar1">
<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
<div class="viewport" style="height: 102px !important;">
<div class="overview">
<ul class="orderList orderList">
<li>
<span><?php echo $product_description;?></span>
<span class="listLeft2" style="width: 72px;"><small>Rm. </small><?php echo $fpx_txnAmount;?></span>
</li>
</ul>
</div>
</div>
</div>

</div>
</aside>
<aside class="col-lg-12 col-md-12 col-sm-12">
<div class="orderBlockLeft">
<h2>Payment Mode</h2>
<ul class="orderList orderList ">
<li style="height: 47px;background: #ebebeb;">
<span>Internet Banking</span>
<span class="listLeft2" style="width: 72px;"><img src="images/fpx-logo.png" style="margin: 10px 4px 0 0;" /></span>
</li>
</ul>
<div class="scrollbar1">
<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
<div class="viewport">
<div class="overview">
<ul class="orderList orderList" style="margin-right: 25px;">
<li style="border-bottom: 0px!important;">
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
<?php $bank_data=mysql_query("Select display_name, bank_id from bank_list order by bank_name");
    while($bank=mysql_fetch_array($bank_data))
    {
    ?>
    <option value='<?php echo $bank['bank_id'];?>' <?php if($bank['bank_id']==$fpx_buyerBankId){ echo "selected='selected'"; } ?> ><?php echo $bank['display_name'];?></option>
    <?php       
    }
    ?>
    <!--
  <option <?php if($fpx_buyerBankId == "TEST0021"){ echo "selected='selected'"; } ?> value="TEST0021">SBI Bank A</option> 
  <option <?php if($fpx_buyerBankId == "TEST0022"){ echo "selected='selected'"; } ?> value="TEST0022">SBI Bank B</option>
  <option <?php if($fpx_buyerBankId == "TEST0023"){ echo "selected='selected'"; } ?> value="TEST0023">SBI Bank C</option>
  <option <?php if($fpx_buyerBankId == "TEST0001"){ echo "selected='selected'"; } ?> value="TEST0001">Test Bank A</option>
  <option <?php if($fpx_buyerBankId == "TEST0002"){ echo "selected='selected'"; } ?> value="TEST0002">Test Bank B</option>
  <option <?php if($fpx_buyerBankId == "TEST0003"){ echo "selected='selected'"; } ?> value="TEST0003">Test Bank C</option>
  <option <?php if($fpx_buyerBankId == "TEST0004"){ echo "selected='selected'"; } ?> value="TEST0004">Test Bank D</option>
  <option <?php if($fpx_buyerBankId == "TEST0005"){ echo "selected='selected'"; } ?> value="TEST0005">Test Bank E</option>
  <option <?php if($fpx_buyerBankId == "ABB0233"){ echo "selected='selected'"; } ?> value="ABB0233">Affin Bank</option>
  <option <?php if($fpx_buyerBankId == "ABMB0212"){ echo "selected='selected'"; } ?> value="ABMB0212">Alliance Bank</option>
  <option <?php if($fpx_buyerBankId == "AMBB0209"){ echo "selected='selected'"; } ?> value="AMBB0209">AmBank</option>
  <option <?php if($fpx_buyerBankId == "BIMB0340"){ echo "selected='selected'"; } ?> value="BIMB0340">Bank Islam</option>
  <option <?php if($fpx_buyerBankId == "BKRM0602"){ echo "selected='selected'"; } ?> value="BKRM0602">Bank Rakyat</option>
  <option <?php if($fpx_buyerBankId == "BMMB0341"){ echo "selected='selected'"; } ?> value="BMMB0341">Bank Muamalat</option>
  <option <?php if($fpx_buyerBankId == "BSN0601"){ echo "selected='selected'"; } ?> value="BSN0601">BSN</option>
  <option <?php if($fpx_buyerBankId == "BCBB0235"){ echo "selected='selected'"; } ?> value="BCBB0235">CIMB Clicks</option>
  <option <?php if($fpx_buyerBankId == "HLB0224"){ echo "selected='selected'"; } ?> value="HLB0224">Hong Leong Bank</option>
  <option <?php if($fpx_buyerBankId == "KFH0346"){ echo "selected='selected'"; } ?> value="KFH0346">KFH</option>
  <option <?php if($fpx_buyerBankId == "MB2U0227"){ echo "selected='selected'"; } ?> value="MB2U0227">Maybank2U</option>
  <option <?php if($fpx_buyerBankId == "MBB0227"){ echo "selected='selected'"; } ?> value="MBB0227">Maybank2e.net</option>
  <option <?php if($fpx_buyerBankId == "MBB0228"){ echo "selected='selected'"; } ?> value="MBB0228">Maybank2E</option>
  <option <?php if($fpx_buyerBankId == "OCBC0229"){ echo "selected='selected'"; } ?> value="OCBC0229">OCBC Bank</option>
  <option <?php if($fpx_buyerBankId == "PBB0233"){ echo "selected='selected'"; } ?> value="PBB0233">Public Bank</option>
  <option <?php if($fpx_buyerBankId == "RHB0218"){ echo "selected='selected'"; } ?> value="RHB0218">RHB Bank</option>
  <option <?php if($fpx_buyerBankId == "SCB0216"){ echo "selected='selected'"; } ?> value="SCB0216">Standard Chartered</option>
  <option <?php if($fpx_buyerBankId == "UOB0226"){ echo "selected='selected'"; } ?> value="UOB0226">UOB Bank</option> -->
</select>
</div>
<div class="form-group">
<label for="email" style="padding-top: 10px;padding-bottom: 10px;">Email Id</label>
<input class="form-control" value="<?php print $fpx_buyerEmail; ?>" name="fpx_buyerEmail" type="email"/>
</div>
</li>
</ul>
</div>
</div>
</div>

<button type="button" value="Back" onclick="history.go(-1);" class=" col-lg-6 col-md-6 col-sm-6" style="background: #ffffff;padding-top: 3px;padding-bottom: 3px; height: 67px;" >
    <div class="orderError" style="padding:0px !important; background: none; border-radius:10px;">
        <p><span  class="subOver btn btn-default" style=" background: #5a5a5a; color: #ffffff;border-radius: 0 5px 5px 0;"> < Back</span></p>
    </div>
</button>
<button type="submit" name="proceed" class=" col-lg-6 col-md-6 col-sm-6" style="background: #ffffff;padding-top: 3px;padding-bottom: 3px;height: 67px;" >
    <div class="orderError" style="padding:0px !important; background: none; border-radius:10px;">
         <p><span  class="subOver btn btn-default" style=" color: #ffffff; background: #105d8b;border-radius: 0 5px 5px 0;"> Proceed ></span></p>
    </div>
</button>
<br />

<h3 style="font: 11px/45px open_sansregular!important;text-align: center;line-height: 17px !important;padding: 5px 0px !important;">By clicking on the "Proceed" button below,you agree to <a href="https://www.mepsfpx.com.my/FPXMain/termsAndConditions.jsp" target="_blank"><span style="font-size: 10px;">FPX Terms & Conditions</span></a></h3>

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
</div>
</aside>
</div>
</div>
</section>

</body>
</html>