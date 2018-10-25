<?php
include('config/config.php');
session_start();
if(!$_SESSION['logid']){ header("location:index.php");}
if((isset($_POST['prpdmobile']) && isset($_POST['prpdoperator']) && isset($_POST['prpdamount'])))
{
    $number = $_POST['number'];
    $operator = $_POST['operator'];
    $reload = $_POST['reload'];
    $rec_type=$_POST['rec_type'];
    $gst =0;
    $total = $reload+$gst;
}
else if((isset($_SESSION['number']) && isset($_SESSION['operator']) && isset($_SESSION['reload'])))
{
   $number = $_SESSION['number'];
   $operator = $_SESSION['operator'];
   $reload = $_SESSION['reload'];
   $rec_type=$_SESSION['rec_type'];
    $gst = 0;
    $total = $reload+$gst;//exit;
}
else
{
    header("location:index.php?msg=error");
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
<aside class="col-lg-6 col-md-6 col-sm-6">
<div class="orderBlockLeft">
<h2>Confirm Order </h2>
<h3>Your Recharges (<span>1</span>)</h3>
<div class="scrollbar1">
<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
<div class="viewport">
<div class="overview">
<ul class="orderList orderList">
<li>
<span><?php echo $number;?><small>(<?php echo $operator;?>)</small></span>
<span class="listLeft2" style="width: 72px;"><small>Rm. </small><?php echo $reload;?></span>

</li>
</ul>
</div>
</div>
</div>
<ul class="orderList orderListTotal">
<li class="total">
<span>Total</span>
<span class="listLeft2" style="width: 72px;"><small>Rm. </small><?php echo $reload;?></span>
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
<button type="submit" name="proceed" class="sub" >
<div class="orderError" style="padding:0px !important;">
<p><span class="subOver" style="padding: 30px;">Proceed to Pay</span></p>
</div>
</button>
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
<div class="col-lg-6 col-md-6 col-sm-6 hidden-xs" id="Default-block">
<div class="slider"><ul class="bxslider">
<!--<li><a href="" ><img src="themes/s3.ap-south-1.amazonaws.com/reloadv2/assets/images/bus-booking.jpg" width="648" height="357" alt="Bus Booking Offers" /></a></li>
<li><div class="sliderPart2"><aside class="part1"><p class="toptext"><small>First </small><strong>Multi Recharge</strong> System!</p><p class="bottomText">Multiple Recharges in <strong>one go!</strong></p></aside><aside class="part2"><figure><img width="349" height="347" src="../s3.ap-south-1.amazonaws.com/reloadv2/assets/images/banner-image1.png" alt="Multiple Recharge"></figure></aside></div></li>--><li><div class="sliderPart2 sliderPart3"><aside class="part1"><p class="toptext"><small>Keep your</small><strong>fears at bay,</strong><small>QykPay is </small><strong>Hacker Proof </strong><strong class="secure">&amp;Secure</strong></p></aside><aside class="part2"><figure><img width="315" height="204" src="themes/s3.ap-south-1.amazonaws.com/reloadv2/assets/images/secure-recharge.png" alt="Secure Online Recharge"></figure></aside>	</div></li></ul></div>
</div>

</div>
</div>
</section>

<section id="happy-customer-banner" class="hidden-xs" style=" background: #afdbf4;">
<div class="container">
    <div class="row" style="color: #fff; text-align: center;">
    <div class="col-lg-4 col-md-4 col-sm-6">
        <img src="themes/qykpay/assets/images/fpx_banner.png" height="200px;">
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
        <p style="color: #1a8acb; font-size: 17px; font-weight: bold; padding-top: 30px;"> Benefits of FPX</p>
            <p style="padding-top: 20px; color: #1f2c5c;">
                <ul>
                    <li style="color: #1f2c5c;">SIMPLE : only in a single click.</li>
                    <li style="color: #1f2c5c;">CONVENIENT payment anytime,   anywhere.</li>
                    <li style="color: #1f2c5c;">SECURE: FPX uses authentication and   certification to ensure safe transaction.</li>
                    <li style="color: #1f2c5c;">Real-time transaction.</li>
                </ul>
            </p>
        </p>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
        <p style="color: #1a8acb; font-size: 17px; font-weight: bold; padding-top: 30px;">What is FPX?</p>            
        <p style="padding-top: 20px; color: #1f2c5c;"> A real-time payment solution from your  internet banking account.</p> 
        <p style="color: #1a8acb; font-size: 17px; font-weight: bold; padding-top: 10px;">FPX Operating Hours</p>
        <p style="padding-top: 10px; color: #1f2c5c;"> FPX operating hours is 24 hours daily subjects to bank are availability.</p>        
    </div>
    
</div>
</div>
</section>

<div class="modal fade" id="plans-details" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog large-md"><div class="modal-content"><div class="modal-header border0 "><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></div><div class="modal-body padding-top0"></div></div></div></div><div class="modal fade" id="Validatorbox"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title" id="ValidatorboxTitle"></h4></div><div class="modal-body" id="ValidatorBoxContent"></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div>
<section id="happy-customer-banner" class="hidden-xs">
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
