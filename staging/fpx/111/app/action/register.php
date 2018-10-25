<?php
session_start();
include("../../config/config.php");
$password = $_POST['password'];
$login_phone = $_POST['login_phone'];

if($_POST['login_phone'] && strlen($_POST['login_phone'])>0 && $_POST['password'] && strlen($_POST['password'])>0)
{
    $password = $_POST['password'];
    $login_phone = $_POST['login_phone'];
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $email = $_POST['email'];
    
    $insert_qry="INSERT INTO users( user_type, firstname, lastname,phone, email, password, status,  timestamp) VALUES ('user','$f_name','$l_name','$login_phone','$email','$password','1','".date('Y-m-d h:i:s')."')";
    
    $res=mysql_query($insert_qry);
    $id=mysql_insert_id();
    $login_query = "select * from users where user_id=".$id;
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
        
        ////setting reload//////
            
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