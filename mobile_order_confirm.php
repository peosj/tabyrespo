<?php
include('config/config.php');
session_start();
if(isset($_POST['sbmt']))
{
  $number=$_POST['number'];
  $operator=$_POST['operator'];
  $fpx_sellerOrderNo=$_POST['fpx_sellerOrderNo'];
  $fpx_txnAmount=$_POST['fpx_txnAmount'];
$fpx_buyerEmail=$_POST['fpx_buyerEmail'];
$fpx_buyerBankId=$_POST['fpx_buyerBankId'];
$fpx_productDesc=$_POST['fpx_productDesc'];
 ?>
 <script>
 document.form2.submit();
 </script>

 <?php   
}
//var_dump($_GET);
//exit;
//if(!$_SESSION['logid']){ header("location:index.php");}

if((isset($_GET['number']) && isset($_GET['operator']) && isset($_GET['TxnAmount'])))
{
    $uid = $_GET['uid'];
    $number = $_GET['number'];
    $operator = $_GET['operator'];
    $reload = $_GET['TxnAmount'];
    $rec_type=$_GET['rec_type'];
    $gst =0;
    $total = $reload+$gst;
    
    //$fpx_sellerOrderNo=$_SESSION['seller_order_no'];
    //$fpx_buyerEmail=$_SESSION['logemail'];

    $fpx_sellerOrderNo=date('QYKTXN-YmdHis');
    //$fpx_buyerEmail=$_SESSION['logemail'];


    $_SESSION['logid']              = $uid;//userid


    $user_query = "SELECT * FROM users WHERE user_id=".$uid;
    $mysql_user = mysql_query($user_query);
    $user_count = mysql_num_rows($mysql_user);
    $user_array = mysql_fetch_array($mysql_user);

    $_SESSION['logname']            = $user_array['name'];//name;
    $_SESSION['logemail']           = $user_array['email'];//email;
    $_SESSION['logphone']           = $user_array['phone'];//phone;
    $_SESSION['number']             = $number;
    $_SESSION['seller_order_no']    = $fpx_sellerOrderNo;
    

}
 




 //echo $number." $operator ".$operator." $reload ".$reload."  $rec_type ".$rec_type."  $total  ".$total." ";

?>

<!DOCTYPE html>
<html lang="en" itemscope>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>Tabypay- Payment</title>
<meta name="description" content="" />
<meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,initial-scale=1.0,user-scalable=no"/>
<link rel="icon" href="<?php echo $base_url;?>themes/s3.ap-south-1.amazonaws.com/reloadv2/assets/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="<?php echo $base_url;?>themes/s3.ap-south-1.amazonaws.com/reloadv2/assets/css/reloadv1.5.9.css">	
<meta name="theme-color" content="#0d6ea8">
<script type="text/javascript" src="<?php echo $base_url;?>themes/s3.ap-south-1.amazonaws.com/reloadv2/assets/js/jquery-1.7.min_v1.js"></script>
    
    <style>

    .orderBlockLeft h2 {
    color: #fff;
    border-radius: 5px 5px 0 0;
    padding: 0 0 0 25px;
    font: 18px/60px open_sansbold;
    background: #1fb2e8;
}
        
        .orderSummary {
    clear: both;
    padding: 37px 0 47px;
    background: #fff;
    background-size: auto 100%;
}
</style>
</head>
<body>
<div class="Scroll">
<?php  //include('blocks/header.php');?>
<section id="main">
<section class="orderSummary">
<div class="container">
<div class="row">
 
<aside class="col-lg-6 col-md-6 col-sm-6">
<div class="orderBlockLeft">
<h2>Payment Mode</h2>
<ul class="orderList orderList ">
    
    
    
<li style="height: 47px;background: #ebebeb;">
<span>Internet Banking</span>
<span class="listLeft2" style="width: 72px;"><img src="images/fpx-logo.png" style="margin: 10px 4px 0 0;" /></span>
</li>
</ul>
    
<!--<fieldset>
<form name="couponvalidateform" id="couponvalidateform" method="post">
<div id="InvalidCouponText" style="display:none" class="alert alert-info"></div>
<input class="form-control" name="Couponcode" id="Couponcode" placeholder="Coupon / Voucher Code" type="text">
<button type="button" id="couponsubmitbtn" name="couponsubmitbtn" class="btn btn-default">Apply</button>
</form>
</fieldset> -->
    
    
<span><h3>Total Cost : Rm.<?php echo $reload;?></span></h3>
<div >
<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
<div class="viewport">
<div class="overview">
<ul class="orderList orderList" style="margin-right: 25px;">
<li style="border-bottom: 0px!important;">
<form name="form1" method="post" action="order_confirm1.php" >
<div class="form-group">
<label for="bankname" style="padding-top: 10px;padding-bottom: 10px;">Select Bank</label>
<select name="fpx_buyerBankId" class="form-control" id="fpx_buyerBankId" required>


<option value="" id="bank_list">Select Bank</option> 
<?php include('bank_list.php');?>
</select>
</div>

<div class="form-group">
<label for="email" style="padding-top: 10px;padding-bottom: 10px;">Email Id</label>
<input class="form-control" value="<?php print $fpx_buyerEmail; ?>" name="fpx_buyerEmail" type="email"/>
    <br/>
</div>
</li>
</ul>
</div>
</div>
</div>
<h3 style="font: 11px/45px open_sansregular!important;height: 53px; text-align: center;">By clicking on the "Proceed" button below,you agree to <a href="https://www.mepsfpx.com.my/FPXMain/termsAndConditions.jsp" target="_blank"><span style="font-size: 10px;">FPX Terms & Conditions</span></a></h3>
 <div style="text-align:center;" >
<button type="submit" name="proceed" class=" col-lg-6 col-md-6 col-sm-6" style="background: #ffffff;padding-top: 3px;padding-bottom: 3px;height: 67px;"  >
    <div class="orderError" style="padding:0px !important;background: #1fb2e8;">
         <p><span  class="subOver btn btn-default" style=" color: #ffffff; background: #1fb2e8;border-radius: 0 5px 5px 0;"> Proceed </span></p>
    </div>
</button>
    </div>
<input type=hidden value="<?php print $reload; ?>" name="fpx_txnAmount"/>
<input type=hidden value="<?php print $operator; ?>" name="operator"/>
<input type=hidden value="<?php print $number; ?>" name="number"/>
<input type=hidden value="<?php print $fpx_sellerOrderNo; ?>" name="fpx_sellerOrderNo"/>
<input type=hidden value="1" name="sbmt"/>	
</form>
</div>
</aside>
</div>
</div>
</section>
<section id="happy-customer-banner" class="hidden-xs" style=" background: #afdbf4;">
<div class="container">
    <div class="row" style="color: #fff; text-align: center;">
    <div class="col-lg-4 col-md-4 col-sm-6">
        <img src="<?php echo $base_url;?>themes/qykpay/assets/images/fpx_banner.png" height="200px;">
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
<section id="happy-customer-banner" class="hidden-xs" style="background: #1fb2e8; padding: 20px 0px;">
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
<?php //include('blocks/footer.php');?>
</body>
</html>