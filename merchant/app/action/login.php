<?php
@session_start();
include("../../config/config.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if($_POST['userid'] && strlen($_POST['userid'])>0 && $_POST['password'] && strlen($_POST['password'])>0)
{
    $userid = mysql_real_escape_string($_POST['userid']);
    $password = mysql_real_escape_string($_POST['password']);
    $login_query = "select * from users where email = '".$userid."' AND password = '".$password."' AND status = '1'";
    $mysql_login = mysql_query($login_query);
    $cnt_login = mysql_num_rows($mysql_login);
    if($cnt_login == 1)
    {        
        $login_query_success = "select * from users where email = '".$userid."' AND password = '".$password."' AND status = '1'";        
        $mysql_login_success = mysql_query($login_query_success);
        $login_success_array = mysql_fetch_array($mysql_login_success);
        $login_username = $login_success_array['firstname'];
        $login_username1 = $login_success_array['lastname'];
        $login_email = $login_success_array['email'];
        $user_type = $login_success_array['user_type'];
        $merchant_id=$login_success_array['merchant_id'];
        $_SESSION['logname'] = $login_username;
        $_SESSION['logname1'] = $login_username1;
        $_SESSION['logid'] = $login_success_array['user_id'];
        $_SESSION['logemail'] = $login_email;
        $_SESSION['user_type'] = $user_type;
        $_SESSION['logname'] = $login_username;
        $_SESSION['merchantid'] = $merchant_id;
        
        header("location:../../transactions.php");
        exit;
    }
    else
    {
       header("location:../../index.php?msg=error"); 
       exit;
    }
}
else
    {
       header("location:../../index.php?msg=error"); 
       exit;
    }
?>