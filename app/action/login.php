<?php
session_start();
include("../../config/config.php");
$password = $_POST['password'];
$login_phone = $_POST['login_phone'];
$number = $_POST['number'];
$operator = $_POST['operator'];
$reload = $_POST['reload'];
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
        $login_id = $login_success_array['uid'];
        $login_date = $login_success_array['date'];
        $_SESSION['logname'] = $login_username;
        $_SESSION['logid'] = $login_id;
        $_SESSION['logemail'] = $login_email;
        $_SESSION['logphone'] = $login_phone;
        $_SESSION['logcity'] = $login_city;
        $_SESSION['logdate'] = $login_date;
        $_SESSION['loggedin'] = "true";
        ////setting reload//////
            $_SESSION['number'] = $number;
            $_SESSION['operator'] = $operator;
            $_SESSION['reload'] = $reload;
        ////setting reload//////
        header("location:../../confirm_bills.php");
        exit;
    }
    else
    {
       header("location:../../confirm_bills.php?msg=error"); 
       exit;
    }
}
else
    {
       header("location:../../confirm_bills.php?&msg=merror"); 
       exit;
    }
?>