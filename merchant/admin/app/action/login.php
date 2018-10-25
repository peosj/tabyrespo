<?php
session_start();
include("../../config/config.php");
if($_POST['userid'] && strlen($_POST['userid'])>0 && $_POST['password'] && strlen($_POST['password'])>0)
{
    $userid = mysql_real_escape_string($_POST['userid']);
    $password = mysql_real_escape_string($_POST['password']);
    $login_query = "select * from admin where emp_id = '".$userid."' AND password = '".$password."' AND status = '1'";
    //echo"$login_query"; exit;
    $mysql_login = mysql_query($login_query);
    $cnt_login = mysql_num_rows($mysql_login);
    //echo($cnt_login); exit;
    if($cnt_login == 1)
    {        
        $login_query_success = "select * from admin where emp_id = '".$userid."' AND password = '".$password."' AND status = '1'";        
        $mysql_login_success = mysql_query($login_query_success);
        $login_success_array = mysql_fetch_array($mysql_login_success);
        $login_username = $login_success_array['name'];
        $login_email = $login_success_array['email'];
        $login_phone = $login_success_array['phone'];
        $login_city = $login_success_array['city'];
        $login_profile = $login_success_array['profile'];
        $login_rights = $login_success_array['rights'];
        $login_manager = $login_success_array['manager'];
        $login_date = $login_success_array['date'];
        $user_type = $login_success_array['user_type'];
        
        $_SESSION['logname'] = $login_username;
        $_SESSION['logid'] = $userid;
        $_SESSION['logemail'] = $login_email;
        $_SESSION['logphone'] = $login_phone;
        $_SESSION['logcity'] = $login_city;
        $_SESSION['logprofile'] = $login_profile;
        $_SESSION['logrights'] = $login_rights;
        $_SESSION['logmanager'] = $login_manager;
        $_SESSION['logdate'] = $login_date;
        $user_type = $login_success_array['user_type'];

        
        
        header("location:../../dashboard.php");
        exit;
        
        /*
        if($login_profile == "Sales")
        {
            header("location:../../dashboard-sales.php");
            exit;
        }
        if($login_profile == "Manager")
        {
            header("location:../../dashboard-manager.php");
            exit;
        }
        if($login_profile == "Admin" && $login_rights == "Coordinator")
        {
            header("location:../../dashboard-coordinator.php");
            exit;
        }
        if($login_profile == "Admin")
        {
            header("location:../../dashboard-admin.php");
            exit;
        }
        */
        
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