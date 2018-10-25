<?php 
if($_POST)
{
        $operator = $_POST['prpdoperator'];
        $number = $_POST['prpdmobile'];
        $reload = $_POST['prpdamount'];
        $total=$reload;
        
}

?>


<!DOCTYPE html>
<html lang="en" itemscope>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>QYKPAY- Payment</title>
<meta name="description" content="" />
<meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,initial-scale=1.0,user-scalable=no"/>
<link rel="icon" href="http://localhost/qykpay/themes/s3.ap-south-1.amazonaws.com/reloadv2/assets/images/favicon.ico" type="image/x-icon">

<script type="text/javascript" src="themes/s3.ap-south-1.amazonaws.com/reloadv2/assets/js/jquery-1.7.min_v1.js"></script>
<link rel="stylesheet" href="themes/s3.ap-south-1.amazonaws.com/reloadv2/assets/css/reloadv1.5.9.css">
	
<meta name="theme-color" content="#0d6ea8">

<div class="Scroll">
<?php  include('blocks/header.php');?>
<section id="main">
<section class="orderSummary">
<div class="container">
<div class="row">
<aside class="col-lg-5 col-md-5 col-sm-5">
<div class="orderBlockLeft">
<h2>Order Summary</h2>
<h3>Your Recharges (<span>1</span>)</h3>
<div class="scrollbar1">
<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
<div class="viewport">
<div class="overview">
<ul class="orderList orderList">
<li>
<span><?php echo $number;?><small>(<?php echo $operator;?>)</small></span>
<span class="listLeft2"><img src="themes/qykpay/assets/images/ru.png" alt="image"><?php echo $reload;?></span>
<span class="listLeft3 removecartitem " id="O-2195368" ><a href="javascript:void(0)">X</a></span>
</li>
</ul>
</div>
</div>
</div>
<ul class="orderList orderListTotal">
<li class="total">
<span>Total</span>
<span class="listLeft2"><img src="themes/qykpay/assets/images/ru.png" alt="image"><?php echo $reload;?></span>
</li>
</ul>
<div class="apply">
<fieldset>
<form name="couponvalidateform" id="couponvalidateform" method="post">
<div id="InvalidCouponText" style="display:none" class="alert alert-info"></div>
<input class="form-control" name="Couponcode" id="Couponcode" placeholder="Coupon / Voucher Code" type="text">
<button type="button" id="couponsubmitbtn" name="couponsubmitbtn" class="btn btn-default">Apply</button>
</form>
</fieldset>
</div>
<a href="/" class="addNewRecharge">
<div class="orderError">
<p>Add another Recharge<small>Click here to add one more number</small></p>
</div>
</a>
</div>
</aside>
<script type="text/javascript">
$(document).ready(function(){
function emptycheck(){
$(".reloadcashchecked").prop('checked', false); 
}
$('#submitrcrecharge').click(function(){
$('#submitrcrecharge').toggle();	
});
$('.reloadcashchecked').click(function(){
var $this = this;
//console.log($($this).prop('checked'));
var avb = 0 ;
if(avb >= 1200){
$('.paymentdiv').toggle();
}
else{
$('iframe').hide();
$('#NB').hide();
$.post('/payment/bindrlcash/',{cashapplied:$($this).prop('checked')},function(){
location.reload();
});
}
});
});
function validatenb(){
if($('#NBOption').val() ==''){
$("#nbselectionresponse").show().delay(4000).fadeOut(function(){
});
return false;	
}
else{
return true;	
}
}
</script>
<aside class="col-lg-7 col-md-7 col-sm-7">
<section class="mainBlock2 plansBlock">
<div class="top1 payment-tablet-head">
<div class="row">
<aside class="col-lg-6 col-md-6 col-sm-6 payment-title">Choose Payment Method</aside>
<aside class="col-lg-6 col-md-6 col-sm-6 pull-right">
<p>Total Amount:<span><?php  echo $total;?></span>
</p>
</aside>
</div>
</div>
<div class="innertab innertab2 paymentdiv" >
<ul class="nav nav-tabs" role="tablist">
<li class="active"><a href="#CreditDebit" role="tab" data-toggle="tab" title="ATM / DEBIT / CREDIT">ATM / DEBIT / CREDIT</a>
<li ><a href="#NB" role="tab" data-toggle="tab" title="Net Banking">Net Banking</a> </li>
</li>
</ul>
<div class="tab-content">
<div class="tab-pane fade in active" id="CreditDebit">
<iframe src="https://api.juspay.in/merchant/ipay?order_id=2561619&merchant_id=RL"> </iframe>
<div class="pci-complain">
<span>
<a href="http://sisainfosec.com/site/certificate/45392578453233637201" onclick="window.open(this.href,'Juspay_PCI_Certificate','height=575,width=625,scrollbar=yes,status=no,menubar=no,toolbar=no,resizable'); return false" onfocus="this.blur()" ><img src="/assets/images/pci-complian.jpg" alt="PCI Complian"/></a>
<img src="/assets/images/debit-card-icon.png" alt="Secure Card Payment"/>
</span>
</div>
</div>
<div class="tab-pane fade in " id="NB">
<form method="post" action="https://www.reload.in/payment/process/" onsubmit="return validatenb()" >
<div class="radioForm">
<div class="alert alert-danger" style="display:none" id="nbselectionresponse">Please choose your bank.</div>
<fieldset>
<div class="radioBlock">
<span><label for="sbiB" class="sbiB"><input class="NBOption" id="sbiB" type="radio" name="BankID" value="19">&nbsp;</label></span>
<span><label for="hdfcB" class="hdfcB"><input class="NBOption" id="hdfcB" type="radio" name="BankID" value="8">&nbsp;</label></span>
<span><label for="iciciB" class="iciciB"><input class="NBOption" id="iciciB" type="radio" name="BankID" value="9">&nbsp;</label></span>
<span><label for="axisB" class="axisB"><input class="NBOption" id="axisB" type="radio" name="BankID" value="1">&nbsp;</label></span>
<span><label for="kotakB" class="kotakB"><input class="NBOption" id="kotakB" type="radio" name="BankID" value="35">&nbsp;</label></span>
<span><label for="pnbB" class="pnbB"><input class="NBOption" id="pnbB" type="radio" name="BankID" value="36">&nbsp;</label></span>
</div>
<div class="moreBanks">
<input type="hidden" name="PayType" value="NB" />
<select id="NBOption" class="form-control valid" aria-required="true" aria-invalid="false" name="BankCode">
<option value="">Choose Bank</option>
<option value="1">AXIS Bank NetBanking</option>
<option value="2">Bank of India</option>
<option value="3">Bank of Maharashtra</option>
<option value="28">Canara Bank</option>
<option value="32">Catholic Syrian Bank</option>
<option value="4">Central Bank Of India</option>
<option value="27">City Union</option>
<option value="5">Corporation Bank</option>
<option value="31">Deutsche Bank</option>
<option value="6">Development Credit Bank</option>
<option value="33">Dhanlaxmi Bank</option>
<option value="7">Federal Bank</option>
<option value="8">HDFC Bank</option>
<option value="9">ICICI Netbanking</option>
<option value="10">IDBI Bank</option>
<option value="11">Indian Bank </option>
<option value="13">Indian Overseas Bank</option>
<option value="12">IndusInd Bank</option>
<option value="14">Jammu and Kashmir Bank</option>
<option value="15">Karnataka Bank</option>
<option value="16">Karur Vysya </option>
<option value="35">Kotak Mahindra Bank</option>
<option value="36">Punjab National Bank</option>
<option value="22">South Indian Bank</option>
<option value="17">State Bank of Bikaner and Jaipur</option>
<option value="18">State Bank of Hyderabad</option>
<option value="19">State Bank of India</option>
<option value="20">State Bank of Mysore</option>
<option value="29">State Bank of Patiala</option>
<option value="21">State Bank of Travancore</option>
<option value="23">Union Bank of India</option>
<option value="24">United Bank Of India</option>
<option value="25">Vijaya Bank</option>
<option value="26">Yes Bank</option>
</select>
</div>
</fieldset>
</div>
<span class="subOver"><button type="submit" name="proceed" class="sub">Proceed to Pay Rs. <?php  echo $total;?>/-</button></span>
</form>
</div>
</div>
</div>
</section>
</aside>
</div>
</div>
</section>

<?php include('blocks/footer.php');?>S

</body>
</html>
