<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
session_start();
include("../../config/config.php");
$password = $_POST['password'];
$login_phone = $_POST['login_phone'];



if($_POST['login_phone'] && strlen($_POST['login_phone'])>0 && $_POST['password'] && strlen($_POST['password'])>0)
{
    $password = $_POST['password'];
    $login_phone = $_POST['login_phone'];
    $login_query = "select * from users where phone = '".$login_phone."' AND password = '".$password."' AND status = '1'";
    $mysql_login = mysql_query($login_query);
    $cnt_login = mysql_num_rows($mysql_login);
    $login_success_array = mysql_fetch_array($mysql_login);
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
        $_SESSION['error'] = FALSE;
        $_SESSION['login_status'] = "Login Success";
             
        ////setting reload//////
       header("location:save_order.php");
      exit;
    }
    else
    {
        header("location:../../recharge-login.php?msg=error"); 
        exit;
    }
}
else
    {
         header("location:../../recharge-login.php?msg=error"); 
       exit;
    }
?>