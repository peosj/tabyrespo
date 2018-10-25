<?php
include('config/config.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>QYKPAY</title>
<meta name="description" content="" />
<meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,initial-scale=1.0,user-scalable=no"/>
<link rel="icon" href="" type="image/x-icon">
<script type="text/javascript" src="themes/s3.ap-south-1.amazonaws.com/reloadv2/assets/js/jquery-1.7.min_v1.js"></script>
<link rel="stylesheet" href="themes/s3.ap-south-1.amazonaws.com/reloadv2/assets/css/reloadv1.5.9.css">
    <link href="<?php echo $base_url; ?>css/style.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $base_url; ?>css/responsive.css" rel="stylesheet" type="text/css">
	<!-- Roboto Font stylesheet -->
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700' rel='stylesheet' type='text/css'>
	<!-- FontAwesome stylesheet -->
	<link href="https://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<!-- LayerSlider stylesheet 
	<link rel="stylesheet" href="layerslider/css/layerslider.css" type="text/css">
    -->
	<link href="<?php echo $base_url; ?>css/lightbox.css" rel="stylesheet" />
<meta name="theme-color" content="#0d6ea8">
<script>
function reloadsValidate()
{
    var amnt = document.getElementById('prpdamount').value;
    amnt = parseFloat(amnt);
    if(amnt>30000) 
    {
        document.getElementById('amnterror').style.display = "block";
        document.getElementById('amnterror1').style.display = "none";
        document.getElementById('prpdamount').style.backgroundColor = "#fdf4f4";
        return false;
    }
    else if(amnt<1)
    {
        document.getElementById('amnterror').style.display = "none";
        document.getElementById('amnterror1').style.display = "block";
        document.getElementById('prpdamount').style.backgroundColor = "#fdf4f4";
        return false;
    }
    else
    {
        document.getElementById('amnterror').style.display = "none";
        document.getElementById('amnterror1').style.display = "none";
        document.getElementById('prpdamount').style.backgroundColor = "#ffffff";
        return true;
    }
    return false;
}

function reloadsValidate_b2b()
{
    var amnt = document.getElementById('prpdamount_b2b').value;
    amnt = parseFloat(amnt);
    if(amnt>1000000) 
    {
        document.getElementById('amnterror_b2b').style.display = "block";
        document.getElementById('amnterror1_b2b').style.display = "none";
        document.getElementById('prpdamount_b2b').style.backgroundColor = "#fdf4f4";
        return false;
    }
    else if(amnt<2)
    {
        document.getElementById('amnterror_b2b').style.display = "none";
        document.getElementById('amnterror1_b2b').style.display = "block";
        document.getElementById('prpdamount_b2b').style.backgroundColor = "#fdf4f4";
        return false;
    }
    else
    {
        document.getElementById('amnterror_b2b').style.display = "none";
        document.getElementById('amnterror1_b2b').style.display = "none";
        document.getElementById('prpdamount_b2b').style.backgroundColor = "#ffffff";
        return true;
    }
    return false;
}
</script>
</head>
<body >
<div class="Scroll">
<?php  include('blocks/header.php');?>
<section id="main"><div class="homeContent home"><div class="container">
<div class="recharge-page" data-id="prepaid" data-value="0"></div>
<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6">
<div class="tabBlock">
<ul class="nav nav-tabs" id="mainTab" role="tablist">
<li class="active"><a href="#Prepaid" class="mobile" role="tab" data-toggle="tab" id="mobile1">B2C Reloads</a></li>
<li ><a href="#Postpaid" class="mobile" role="tab" data-toggle="tab" id="dth1">B2B Payments</a></li>
</ul>
<div class="tab-content">
<div class="tab-pane fade in active" id="Prepaid">
<div class="tabContent1">
<form action="<?php echo $base_url;?>app/action/save_order.php" method="post" class="show-grid" name="" id="" onsubmit="return reloadsValidate();">
<div class="fRow">
<div class="selectBlock" >
<div id="prpdrctype" style="font-size: 18px;text-align: center;">Fill your details bellow</div>
</div>
</div>
<input type="hidden" name="rec_type" value="prepaid">
<div class="fRow">
<div class="form-group">
<div class="input-group">
<div class="input-group-addon ">+601</div>
<input type="tel" placeholder="Enter Prepaid Mobile Number" value="123456789" maxlength="9" id="prpdmobile" name="prpdmobile" value="" autocomplete ="off" class="form-control numeric-textbox" autofocus >
</div>
</div>
</div>
<input type="hidden" id="ServiceTypeID" name="ServiceTypeID" value="1">
<div class="fRow">
<div class="selectBlock">
<select name="prpdoperator" id="prpdoperator" class="form-control">
<option value="CELCOMAIRTIMEST">CELCOMAIRTIMEST</option>
<option value="MERCHANTST">MERCHANTST</option>
<option value="DIGIST">DIGIST</option>
<option value="CELCOMAIR">CELCOMAIR</option>
<option value="ASTRO">ASTRO</option>
<option value="CELCOMBILL">CELCOMBILL</option>

</select>
</div>
</div>
<div class="fRow" style="display: none;">
<div class="selectBlock" >
<div id="prpdrctype">
</div>
</div>
</div>

<div class="fRow">
<div class="selectBlock">
<select name="TxnAmount" id="prpdamount" class="form-control">
<option value="500">RM 500</option>
<option value="10">RM 10</option>
<option value="20"> RM 20</option>
<option value="30"> RM 30</option>
<option value="35">RM 35</option>
<option value="50">RM 50</option>
<option value="100">RM 100</option>
<option value="00">RM 500</option>
</select>
</div>
</div>
<!--<div class="fRow">
<div class="form-group">
<div class="input-group">
<div class="input-group-addon"> 
RM
</div>
<input class="form-control numeric-textbox" id="prpdamount" name="TxnAmount" type="tel"  autocomplete ="off" placeholder="Enter Recharge Amount" value="100"> 
</div>
<span class="" style="font-size: 10px; color: #ff0000;display: none;" id="amnterror">Maximum Transaction Limit Exceeded</span>
<span class="" style="font-size: 10px; color: #ff0000;display: none;" id="amnterror1">Transaction Amount is Lower than the Minimum Limit</span>
</div>
</div>-->
<div class="fRow rechargetext">
<p class="bg-success " style="padding:14px;"></p> </div><div class="space">&nbsp;</div><span class="Recharge-btn"><cite></cite>
<button type="submit" class="sub">Reload</button><!--<a href="javascript:void(0);"  onclick="recharge_prepaid();" class="sub" style="text-align: center;">Recharge</a>--></span>
</form>
</div>
</div>
<div class="tab-pane fade " id="Postpaid">
<div class="tabContent1 tabContent2">
<form action="<?php echo $base_url;?>app/action/b2b_save_order.php" method="post" class="show-grid" name="" id="" onsubmit="return reloadsValidate_b2b();">
<div class="fRow">
<div class="selectBlock" >
<div id="prpdrctype" style="font-size: 18px;text-align: center;">Fill your details bellow</div>
</div>
</div>
<input type="hidden" name="rec_type" value="prepaid">
<div class="fRow">
<div class="form-group">
<div class="input-group">
<div class="input-group-addon plus91"></div>
<input type="tel" placeholder="Enter Prepaid Mobile Number" maxlength="10" id="prpdmobile" name="prpdmobile" value="8802103824" autocomplete ="off" class="form-control numeric-textbox" autofocus >
</div>
</div>
</div>
<input type="hidden" id="ServiceTypeID" name="ServiceTypeID" value="1">
<div class="fRow">
<div class="selectBlock">
<select name="prpdoperator" id="prpdoperator" class="form-control">
<option value="DIGI">DIGI</option><option value="HOT LINK">HOT LINK</option><option value="PLATCOM">PLATCOM</option>
</select>
</div>
</div>
<div class="fRow" style="display: none;">
<div class="selectBlock" >
<div id="prpdrctype">
</div>
</div>
</div>
<div class="fRow">
<div class="form-group">
<div class="input-group">
<div class="input-group-addon"> 
RM
</div>
<input class="form-control numeric-textbox" id="prpdamount_b2b" name="TxnAmount" type="tel"  autocomplete ="off" placeholder="Enter Recharge Amount" value="100000"> 
</div>
<span class="" style="font-size: 10px; color: #ff0000;display: none;" id="amnterror_b2b">Maximum Transaction Limit Exceeded</span>
<span class="" style="font-size: 10px; color: #ff0000;display: none;" id="amnterror1_b2b">Transaction Amount is Lower than the Minimum Limit</span>
</div>
</div>
<div class="fRow rechargetext">
<p class="bg-success " style="padding:14px;"></p> </div><div class="space">&nbsp;</div><span class="Recharge-btn"><cite></cite>
<button type="submit" class="sub">Recharge</button><!--<a href="javascript:void(0);"  onclick="recharge_prepaid();" class="sub" style="text-align: center;">Recharge</a>--></span>
</form>
</div>
</div>


</div></div></div><div class="col-lg-6 col-md-6 col-sm-6 hidden-xs" id="Default-block">
<div class="slider"><ul class="bxslider">
<!--<li><a href="" ><img src="themes/s3.ap-south-1.amazonaws.com/reloadv2/assets/images/bus-booking.jpg" width="648" height="357" alt="Bus Booking Offers" /></a></li>
<li><div class="sliderPart2"><aside class="part1"><p class="toptext"><small>First </small><strong>Multi Recharge</strong> System!</p><p class="bottomText">Multiple Recharges in <strong>one go!</strong></p></aside><aside class="part2"><figure><img width="349" height="347" src="../s3.ap-south-1.amazonaws.com/reloadv2/assets/images/banner-image1.png" alt="Multiple Recharge"></figure></aside></div></li>--><li><div class="sliderPart2 sliderPart3"><aside class="part1"><p class="toptext"><small>Keep your</small><strong>fears at bay,</strong><small>QykPay is </small><strong>Hacker Proof </strong><strong class="secure">&amp;Secure</strong></p></aside><aside class="part2"><figure><img width="315" height="204" src="<?php echo $base_url;?>themes/s3.ap-south-1.amazonaws.com/reloadv2/assets/images/secure-recharge.png" alt="Secure Online Recharge"></figure></aside>	</div></li></ul></div>
</div>
</div></div>
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
        <p style="padding-top: 20px; color: #1f2c5c;"> A real-time payment solution from your  internet banking account. <a href="www.myclear.org.my/business-fpx.html" target="_blank">Read More</a></p> 
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
<li>* Please ensure that your browser's pop up blocker has been disabled to avoid any interruption during making transaction.<a href="pop-up.html" target="_blank">Get Details</a></li>
<li>* Do not close browser / refresh page until you receive response.</li>
</ul> </p>
</div>
</div>
</div>
</section>
<div class="OperatorDesc hidden-xs">
<div class="container">
<h1  style="color: #666;text-align: center; font-size: 35px !important; width:100%!important; padding-bottom: 20px;" >Pay Bills</h1>
          <!--<img class="triangleTop" src="img/tri-white-top.png" alt="" />-->
            <div class="row" style="margin: 35px auto;">
              <div class="four-col">
                 <div style="text-align: center;">
                  	<img  src="<?php echo $base_url;?>themes/qykpay/assets/images/1.png" alt="" style="display: inline !important;" />
                   <h2 style="font-size: 20px;">128 bit EV SSL secured</h2>
                   <p style="margin: 5px 0; line-height: 22px;">Don't worry. All your personal card details are safe with us. All of our browser and application connections are 128bit SSL secured.</p>
                </div>
             </div>
            <div class="four-col">
                <div style="text-align: center;">
                	<img  src="<?php echo $base_url;?>themes/qykpay/assets/images/2.png" alt="" style="display: inline !important;" />
                 <h2 style="font-size: 20px;">Norton Secured</h2>
                 <p>Everyday QYK is scanned and secured by Norton for any vulnerability. Means every transaction that you make is secure and reliable.</p>
               </div>
          </div>
        <!--  <div class="three-col">
              <div class="iconColWrap">
              	<img  src="img/3.png" alt="" />
               <h2>PCI-DSS compliant</h2>
               <p>We conform to the top industry standards for card payments. This means that we adhere to the highest level off safety and security standards in cards payment industry.</p> 
              </div>
          </div>-->
          <div class="four-col last-col">
              <div style="text-align: center;">
             	<img  src="<?php echo $base_url;?>themes/qykpay/assets/images/4.png" alt="" style="display: inline !important;" />
              <h2 style="font-size: 20px;">Personal PIN</h2>
            <p>Apart from the standard card PIN, we provide an extra layer of security by additional PIN before you make any transaction. So even if you lose your phone, nobody can make a transaction without your personal secure PIN by QYK.</p>
          </div>
        </div>
  <div class="clear"> </div>
      </div></section>
		<!--END Security CONTAINER-->
</div>
</div>
<div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title "></h4>
</div>
<div class="modal-body">
<p></p>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php include('blocks/footer.php');?>
<?php
if(isset($_GET['msg']) && $_GET['msg']=='0')
{
    ?>
        <script>
            alert("Transaction Amount not allowed.");
        </script>
    <?php
}
if(isset($_GET['msg']) && $_GET['msg']=='00')
{
    ?>
        <script>
            alert("Transaction Amount not allowed.");
        </script>
    <?php
}
?>
</body>
</html>