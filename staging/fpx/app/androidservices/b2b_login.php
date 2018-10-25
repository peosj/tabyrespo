<?php
session_start();
include("../../config/config.php");
//$password = $_POST['password'];
//$login_phone = $_POST['login_phone'];

$input = file_get_contents("php://input");
$_POST = json_decode($input, true);

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
        $response['logname'] = $login_username;
        $response['logid'] = $login_id;
        $response['logemail'] = $login_email;
        $response['logphone'] = $login_phone;
        $response['logcity'] = $login_city;
        $response['logdate'] = $login_date;
        $response['loggedin'] = "true";
        $response['qykpay_loggedin'] = "true";
        
        echo json_encode($response);
        
        ////setting reload//////
            
        ////setting reload//////
       // header("location:b2b_save_order.php");
        //exit;
    }
    else
    {
         $response['error'] = TRUE;
        $response['error_msg'] = "Incorrect email or password"; 
        $response['login_status'] = "Login Failed";
        echo json_encode($response);
       //header("location:../../b2b_recharge-login.php?msg=error"); 
       //exit;
    }
}
else
    {
        $response['error'] = TRUE;
        $response['error_msg'] = "Incorrect email or password";
        $response['login_status'] = "Login Failed";
        echo json_encode($response);
       //header("location:../../b2b_recharge-login.php?msg=error"); 
       //exit;
    }
?>