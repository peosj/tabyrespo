
<footer><div class="container"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12"><p class="copy">&copy; 2017 Qykpay.com</p><nav class="hidden-xs"><ul><li><a href="javascript:void(0)" title="About Us">About Us</a></li><li><a href="javascript:void(0)" title="Contact Us">Contact Us</a></li><li><a href="javascript:void(0)" title="DTH Recharge">DTH</a></li><li><a href="javascript:void(0)" title="Electricity Bill">Electricity</a></li><li><a href="javascript:void(0)" title="Broadband">Broadband</a></li> </ul></nav></div>
</ul></nav></div></div>
</div>
</footer>
<style>
.operators>strong>a:first-child{
cursor:default;}
</style>
<div class="lightBox row white-popup mfp-with-anim hideblock" id="test-popup">
<div class="row" style="">
<aside class="col-lg-6 col-md-6 col-sm-6 leftB userlogin">
<b>Login with your account </b>
<form action="#" method="post" name="userloginform" id="userloginform">
<div id="loginresponse" style="display:none" class="alert alert-info"></div>
<input name="loginemail" id="loginemail" placeholder="Email Address" class="form-control" type="email"> 
<input name="loginpassword" id="loginpassword" maxlength="25" placeholder="Password" class="form-control" type="password"> 
<button type="submit" onclick="ga('send','event','Login', 'Popup','Login')" class="sub">Login</button>
</form>
<span class="lightOr">or</span>
</aside>
<aside class="col-lg-6 col-md-6 col-sm-6 leftB usersignup" style="display:none;" >
<b>Create a new account</b>
<form action="#" method="post" name="usersignupform" id="usersignupform">
<div id="signupresponse" style="display:none" class="alert alert-info"></div>
<input name="signupemail" id="signupemail" placeholder="Email Address" class="form-control" type="email">
<input name="signupmobile" id="signupmobile" maxlength="10" placeholder="Mobile Number" class="form-control numeric-textbox" type="text">
<input name="signupusername" id="signupusername" maxlength="20" placeholder="Name" class="form-control" type="text">
<input name="signuppassword" id="signuppassword" maxlength="25" placeholder="Password" class="form-control" type="password">
<button type="submit" onclick="ga('send','event','Signup', 'Popup','Signup')" class="sub">Signup</button>
</form>
<span class="lightOr">or</span>
</aside>
<aside class="col-lg-6 col-md-6 col-sm-6 leftB userforgot" style="display:none;" >
<b>Forgot Password. </b>
<form action="#" method="post" name="userforgotform" id="userforgotform">
<div id="forgotresponse" style="display:none" class="alert alert-info"></div>
<input name="forgotemail" id="forgotemail" placeholder="Email Address" class="form-control" type="email">
<button type="submit" class="sub">Send forgot link to my Email</button>
</form>
<span class="lightOr">or</span>
</aside>
<aside class="col-lg-6 col-md-6 col-sm-6" id="fbdiv">
<div class="facebookB">
<div onclick="authUser();" class="facebook">
<p>You can log in using Facebook.</p>
<a href="#" onclick="ga('send','event','FB', 'Popup','FB')">Login with Facebook</a>
</div><br/>
<div class="alert alert-danger" style="display:none" id="fbresponse">Your account is blocked. Contact support team</div>
</div>
</aside> 
<aside class="col-lg-6 col-md-6 col-sm-6" id="fbmobilerequest" style="display:none;" >
<div style="padding-top:60px">
<form action="#" method="post" name="updatefbform" id="updatefbform"> 
<div id="fbupdateresponse" style="display:none" class="alert alert-info"></div>
<input name="fbemail" id="fbemail" placeholder="Email Address" class="form-control" type="email">
<input name="fbmobile" maxlength="10" id="fbmobile" placeholder="Mobile Number" class="form-control numeric-textbox" type="text">
<button type="submit" class="sub">Update Information</button>
</form>
</div>
</aside>
</div>
<div class="lightboxBottom">
<p><a href="#" id="forgtlink" class="backlinks">Forgot password?</a></p>
<p><a href="#" id="loginlink" style="display:none" class="backlinks">Back to login</a></p>
</div>
</div> 
</div>
<script src="<?php echo $base_url;?>themes/connect.facebook.net/en_US/all.js" type="text/javascript"></script>
<script src="<?php echo $base_url;?>themes/s3.ap-south-1.amazonaws.com/reloadv2/assets/js/reloadv1.6.9.js" type="text/javascript"></script>
<style>.operators strong a {font-weight:bold; font-size:13px; text-decoration:none !important;}</style>