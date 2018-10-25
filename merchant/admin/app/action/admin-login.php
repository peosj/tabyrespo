<?php
session_start();
include("./../../../config/config.php");
if($_POST['userid'] && strlen($_POST['userid'])>0 && $_POST['password'] && strlen($_POST['password'])>0)
{
    $userid = mysql_real_escape_string($_POST['userid']);
    $password = mysql_real_escape_string($_POST['password']);
    $login_query = "select * from admin where email = '".$userid."' AND password = '".$password."' AND status = '1'";
    //echo"$login_query"; exit;
    $mysql_login = mysql_query($login_query);
    $cnt_login = mysql_num_rows($mysql_login);
    //echo($cnt_login); exit;
    if($cnt_login == 1)
    {        
        $login_query_success = "select * from admin where email = '".$userid."' AND password = '".$password."' AND status = '1'";        
        $mysql_login_success = mysql_query($login_query_success);
        $login_success_array = mysql_fetch_array($mysql_login_success);
        
        $login_username = $login_success_array['name'];
        $login_email = $login_success_array['email'];
        $login_date = $login_success_array['date'];
        $user_type = $login_success_array['user_type'];
        $_SESSION['logname'] = $login_username;
        $_SESSION['logid'] = $login_success_array['emp_id'];
        $_SESSION['logemail'] = $login_email;
        $_SESSION['logdate'] = $login_date;
        $_SESSION['user_type'] = $user_type;
        header("location:./../../admin-dashboard.php");
        exit;
    }
    else
    {
       header("location:./../../index.php?msg=error"); 
       exit;
    }
}
else
    {
       header("location:./../../index.php?msg=error"); 
       exit;
    }
?>