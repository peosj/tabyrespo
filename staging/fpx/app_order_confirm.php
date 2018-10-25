<?php
include('config/config.php');
session_start();
if((isset($_GET['user_id']) && isset($_GET['lower_date']) && isset($_GET['upper_date']) && isset($_GET['TxnAmount'])))
{
    
    $user_id = $_GET['user_id'];
    
    $user_data = mysql_fetch_array(mysql_query("select email from users where user_id = ".$user_id));
    
    $fpx_buyerEmail = $user_data['email'];
    $number = "";
    $operator = "";
    $reload = $_GET['TxnAmount'];
    $rec_type="Batch Payment";
    $lower_date = $_GET['lower_date'];
    $upper_date = $_GET['upper_date'];
    $gst =0;
    $total = $reload+$gst;
    $transaction_type = "Batch";
}
else
{
    //header("location:index.php?msg=error");
    //exit;
}



$discount ="" ;
$promo_code = "";
$product_description = 'Batch Payment ('.$lower_date.' to '.$upper_date.') for RM'.$reload." has been processed !";
$date = date('Y-m-d');
$status=0;
$fpx_sellerOrderNo = date('QYK-YmdHis');
$query = "insert into orders (reload_amt, gst, operator, coupon_code, discount_amt,total,product_description,user_id,order_id,status,date,seller_order_no,batch_lower_date, batch_upper_date, source, transaction_type) values('".$reload."', '".$gst."', '".$operator."','".$promo_code."', '".$discount."','".$total."','".$product_description."','".$user_id."','".$fpx_sellerOrderNo."','".$status."', '".$date."', '".$fpx_sellerOrderNo."', '".$lower_date."', '".$upper_date."' , 'App' , '".$transaction_type."')";
//echo $query; exit;
$r1 = mysql_query($query);//exit;

 //echo $number." $operator ".$operator." $reload ".$reload."  $rec_type ".$rec_type."  $total  ".$total." ";

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
</head>
<body onload="test();" style="padding-bottom: 0px !important;background: url(../../images/main-bg.jpg) center top !important;">
<section class="orderSummary" style="width: 100%;">
<div class="container">
<div class="row">
<aside class="col-lg-12 col-md-12 col-sm-12">
<div class="orderBlockLeft" style=" margin-top: 10px;">
<h2>Order Review</h2>
<div class="scrollbar1">
<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
<div class="viewport" style="height: 102px !important;">
<div class="overview">
<ul class="orderList orderList">
<li>
<span><?php echo $product_description;?></span>
<span class="listLeft2" style="width: 72px;"><small>Rm. </small><?php echo $reload;?></span>
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
<form name="form1" method="post" action="app_order_confirm1.php" >
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

<input type=hidden value="<?php print $reload; ?>" name="fpx_txnAmount"/>
<input type=hidden value="<?php print $operator; ?>" name="operator"/>
<input type=hidden value="<?php print $number; ?>" name="number"/>
<input type=hidden value="<?php print $fpx_sellerOrderNo; ?>" name="fpx_sellerOrderNo"/>
<input type=hidden value="<?php print $product_description; ?>" name="product_description"/>
<input id="txnstatus" type=hidden value="1" name="sbmt"/>	
</form>
</div>
</aside>
</div>
</div>
</section>

</body>
</html>