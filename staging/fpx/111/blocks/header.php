<header>
<div class="headerTop">
<div class="container">
<div class="row">
<div class="col-lg-2 col-md-2 col-xs-6">
<div id="logo">
<div class="rlhovr1">
<a itemprop="url" title="QYKPAY" href="index.php" >
<img  itemprop="logo" src="http://localhost/qykpay1/themes/qykpay/assets/images/qyk_logo11.png" alt="QYKPAY ">
</a>
</div>
<div class="rlhovr">
<a itemprop="url" title="QYKPAY" href="index.php">
<img width="146" height ="31" src="http://localhost/qykpay1/themes/qykpay/assets/images/qyk_logo11.png" alt="QYKPAY" />

</a>
</div> 
</div>
</div>
<div class="col-lg-2 col-md-2 col-sm-3 pull-right hidden-xs"><div class="social"><ul><li><a class="facebook"  title="Follow QykPay on Facebook" href="javascript:void(0)">&nbsp;</a></li><li><a class="twitter"  title="Follow QykPay on Twitter" href="javascript:void(0)">&nbsp;</a></li><li><a class="googleplus"  title="Follow QykPay on Google Plus" href="javascript:void(0)">&nbsp;</li></ul></div></div>
<div class="signUp visible-xs">
<?php if(!$_SESSION['logid']){?>
<a class="lightboxOpen" data-effect="mfp-3d-unfold" data-id="userlogin" href="#test-popup" title="Login">Login</a>/<a class="lightboxOpen" data-effect="mfp-3d-unfold" data-id="usersignup" href="#" title="Signup">Signup</a>
<?php } else
{
  ?>
  <a href="order.php" title="Login">Order Summary</a> / <a href="app/action/logout.php" title="Signout">Signout</a>
  <?php  
}
?>
</div>
<div class="col-lg-6 col-md-6 col-sm-5 pull-right hidden-xs">
<div class="login">
<ul>
<?php if(!@$_SESSION['logid']){?>
<li><a class="lightboxOpen" data-effect="mfp-3d-unfold" data-id="userlogin" href="#test-popup" title="Login">Login</a>/<a class="lightboxOpen" data-effect="mfp-3d-unfold" data-id="usersignup" href="javascript:void(0)" title="Signup" >Signup</a></li><?php } else
{
  ?>
  <a href="order.php" title="Login">Order Summary</a>/<a href="app/action/logout.php" title="Signout">Signout</a>
  <?php } ?>

</ul>
</div>
</div>
</div>
</div>
</div>
<div class="headerBottom">
<div class="container">
<div class="row">
<div class="col-lg-7 col-md-7 col-sm-7">
<nav>
<ul>
<li><a title="Prepaid Mobile Recharge" href="index.php" class="active">Recharge</a> </li>
<li><a title="DTH Recharge" href="javascript:void(0)" >DTH</a></li>
<li ><a title="Datacards Recharge" href="javascript:void(0)" >Data Cards</a>
<li><a title="Gas Bill" href="javascript:void(0)">Gas</a></li>
<li><a title="Electricity Bill" href="javascript:void(0)" >Electricity</a></li>
<li><a title="Broadband Bill" href="javascript:void(0)" >Broadband</a></li>
</ul>
</nav>
</div>
<div class="col-lg-5 col-md-5 col-sm-5 pull-right hidden-xs">
<div class="reloadApp">
<b class="mobile-app-header">Download App</b>
<ul>
<li><a href="javascript:void(0)" title="Download Reload.in Mobile Recharge App"><img src="themes/qykpay/assets/images/mobile_apps.png" width="90 " height ="25" alt="Reload mobile apps"></a></li>
</ul>
</div>
</div>
</div>
</div>
</div>
</header>