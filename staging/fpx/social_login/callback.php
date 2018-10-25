<?php
session_start();
include("../config/config.php");
require_once( 'src/Facebook/autoload.php' );
//require_once( 'db.php' );

$fb = new Facebook\Facebook([
  'app_id' => '436674993352607',
  'app_secret' => '175286cba570a928aff71ced7553ca1e',
  'default_graph_version' => 'v2.5',
]);  
  
$helper = $fb->getRedirectLoginHelper();  
  
try {  
  $accessToken = $helper->getAccessToken();  
} catch(Facebook\Exceptions\FacebookResponseException $e) {  
  // When Graph returns an error  
  
  //echo 'Graph returned an error: ' . $e->getMessage();
  header("location:../recharge-login.php?msg=error1");          
  exit;  
} catch(Facebook\Exceptions\FacebookSDKException $e) {  
  // When validation fails or other local issues  

  //echo 'Facebook SDK returned an error: ' . $e->getMessage();
  header("location:../recharge-login.php?msg=error2");  
  exit;  
}  


try {
  // Get the Facebook\GraphNodes\GraphUser object for the current user.
  // If you provided a 'default_access_token', the '{access-token}' is optional.
  $response = $fb->get('/me?fields=id,name,email,first_name,last_name', $accessToken->getValue());
//  print_r($response);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  //echo 'ERROR: Graph ' . $e->getMessage();
  header("location:../recharge-login.php?msg=error3");
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  //echo 'ERROR: validation fails ' . $e->getMessage();
  header("location:../recharge-login.php?msg=error4");
  exit;
}

$me = $response->getGraphUser();

//print_r($me);

$first_name = $me->getProperty('first_name');
$last_name = $me->getProperty('last_name');
$email = $me->getProperty('email');
$fbid = $me->getProperty('id');


////login
$login_query = "select * from users where email = '".$email."' AND signup_id = '".$fbid."' AND status = '1'";
$mysql_login = mysql_query($login_query);
$cnt_login = mysql_num_rows($mysql_login);
$login_success_array = mysql_fetch_array($mysql_login);
if($cnt_login > 0)
{               
    
    $login_username = $login_success_array['firstname'];
    $login_email = $login_success_array['email'];
    $login_phone = $login_success_array['phone'];
    $login_city = $login_success_array['city'];
    $login_id = $login_success_array['user_id'];
    $login_date = $login_success_array['date'];
    $_SESSION['logname'] = $login_username;
    $_SESSION['logid'] = $login_id;
    $_SESSION['logemail'] = $login_email;
    $_SESSION['logphone'] = $login_phone;
    $_SESSION['logcity'] = $login_city;
    $_SESSION['logdate'] = $login_date;
    $_SESSION['loggedin'] = "true";
    $_SESSION['qykpay_loggedin'] = "true";
    
    ////setting reload//////
        
    ////setting reload//////
    header("location:../app/action/save_order.php");
    exit;
}
else
{
   ///////signp logic
   
    $insert_qry="INSERT INTO users(user_type, firstname, lastname, email, status, timestamp, source, signup_id) VALUES ('user','$first_name','$last_name','$email','1','".date('Y-m-d h:i:s')."', 'Facebook', '".$fbid."')";
    $res=mysql_query($insert_qry);
    $id=mysql_insert_id();
    $login_query = "select * from users where user_id=".$id;
    $mysql_login = mysql_query($login_query);
    $cnt_login = mysql_num_rows($mysql_login);
    $login_success_array = mysql_fetch_array($mysql_login);
        
    //echo $insert_qry; echo $login_query; exit;
    
    if($cnt_login == 1)
    {               
        $login_username = $login_success_array['firstname'];
        $login_email = $login_success_array['email'];
        $login_phone = $login_success_array['phone'];
        $login_city = $login_success_array['city'];
        $login_id = $login_success_array['user_id'];
        $login_date = $login_success_array['date'];
        $_SESSION['logname'] = $login_username;
        $_SESSION['logid'] = $login_id;
        $_SESSION['logemail'] = $login_email;
        $_SESSION['logphone'] = $login_phone;
        $_SESSION['logcity'] = $login_city;
        $_SESSION['logdate'] = $login_date;
        $_SESSION['loggedin'] = "true";
        $_SESSION['qykpay_loggedin'] = "true";
        header("location:../app/action/save_order.php");
        exit;
    }
    else
    {
       header("location:../recharge-login.php?msg=error5"); 
       exit;
    }

   ///////signp logic end
}

///login end
?>