<?php
include('config/config.php');
session_start();
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
<aside class="col-lg-4 col-md-7 col-sm-6"> 
<div class="top1">
<div class="row">
<aside class="col-lg-12 col-md-12 col-sm-12"><a class="login-link" data-id="login" style="cursor:pointer">Log In</a> / <a class="login-link" data-id="signup" style="cursor:pointer" >Register</a></aside>
</div>
</div>
<div class="innertab innertab2">
<div class="Cart-signup">
<div class="form-group">
 <h2 style="text-align: center; font-size: 18px;">Login</h2>
</div>
<div class="form-group">
<label for="email">&nbsp;</label>
</div>
<form role="form" class="show-grid" action="<?php echo $base_url;?>app/action/login.php" method="post" >
<div id="guestresponse" style="display:none" class="alert alert-info"></div>
<div class="form-group">
<label for="email">Phone No <span style="color:#F00909;">*</span></label>
<input type="number" class="form-control" name="login_phone" value="" >
</div>
<div class="form-group">
<label for="loginpassword">Password <span style="color:#F00909;">*</span></label>
<input class="form-control" type="password" name="password">
</div>
<div class="form-group">By clicking Continue you agree our terms &amp; conditions
</div>
<div class="row" style="padding-top: 75px;">

    <div class="col-md-6 col-md-6 col-sm-12">
        <button class="btn btn-primary btn-lg offset-top15" style="margin-top: 0px !important;" type="submit">Log In</button>
    </div>
    
    <div class="col-md-6 col-md-6 col-sm-12">
        <a class="offset-top15" href="social_login/login.php"><img src="images/fb.png"/></a>
    </div>
    
</div> 
</form>
</div>
</div>
<span class="lightOr">or</span>
</aside>
<aside class="col-lg-8 col-md-8 col-sm-6" id="fbdiv">
<div class="facebookB">
<div class="innertab innertab2">
<div class="Cart-signup">
<div class="form-group">
 <h2 style="text-align: center; font-size: 18px;">Register User</h2>
</div>
<form role="form" class="show-grid" action="<?php echo $base_url;?>app/action/register.php" method="post" >
<div class="col-md-6 col-md-6 col-sm-12">
<div class="form-group">
<label for="name">First Name <span style="color:#F00909;">*</span></label>
<input type="text" class="form-control" name="f_name" value="" placeholder="First Name"  required="true" tabindex="1">
</div>
<div class="form-group">
<label for="email">Password <span style="color:#F00909;">*</span></label>
<input class="form-control" type="password" name="password" id="pass" required="true" tabindex="3">
</div>
<div class="form-group">
<label for="phone">Phone No <span style="color:#F00909;">*</span></label>
<input type="number" class="form-control" name="login_phone" value="" onchange="check_phone()" id="phone_no" required="true" tabindex="5" >
</div>
</div>
<div class="col-md-6 col-md-6 col-sm-12">
<div class="form-group">
<label for="name">Last Name <span style="color:#F00909;">*</span></label>
<input type="text" class="form-control" name="l_name" value="" placeholder="Last Name" required="true" tabindex="2" >
</div>
<div class="form-group">
<label for="loginpassword">Confirm Password <span style="color:#F00909;">*</span></label>
<input class="form-control" type="password" id="confirm_pass" onchange="check_conf_pass();" required="true" tabindex="4">
</div>
<div class="form-group">
<label for="email">Email <span style="color:#F00909;">*</span></label>
<input type="email" class="form-control" name="email" value="" required="true" tabindex="6">
</div>
</div>
<button class="btn btn-primary btn-lg offset-top15 pull-right" type="submit" id="btnregister">Register</button> 
</form>
</div>
</div>
</div>
</aside> 
<aside class="col-lg-5 col-md-5 col-sm-5" id="fbmobilerequest" style="display:none;" >
<h3>Update Information</h3>
<form action="#" method="post" name="updatefbform" id="updatefbform"> 
<div id="fbupdateresponse" style="display:none" class="alert alert-info"></div>
<input name="fbemail" id="fbemail" placeholder="Email Address" class="form-control" type="text">
<input name="fbmobile" id="fbmobile" placeholder="Mobile Number" class="form-control" type="text">
<button type="submit" class="sub">Update Information</button>
</form>
</aside> 
</div>
</section>
</div>
</div>
<script>
function  check_conf_pass()
{
    var pass=document.getElementById('pass').value;
    var pass1=document.getElementById('confirm_pass').value;
    //alert(pass+"=="+pass1);
    if(pass==pass1)
    {
       document.getElementById('btnregister').disabled=false;
    }
    else
    {
        alert("Confirm password and Password miss match...");
        document.getElementById('btnregister').disabled=true;
    }
}
function check_phone()
{
    var phone=document.getElementById('phone_no').value;
    alert(phone);
     $.ajax
                            ({
                                type: "POST",
                                url: "app/ajax/check_phone.php",
                                data: "phone_id="+phone,
                                success: function(msg)
                                    { 
                                        if(msg=="failure")
                                        {
                                        alert("Phone no already registered....");
                                        document.getElementById('phone_no').style.background="#f6b9b9";
                                        document.getElementById('btnregister').disabled=true;
                                        } 
                                        else
                                        {
                                        document.getElementById('btnregister').disabled=false;
                                        }                                                                                                                                                                                                                   
                                    }
                            });
}
</script>
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