<?php
session_start();
include("../../config/config.php");
if(isset($_POST['confirm_password']) && isset($_POST['new_password']) && isset($_POST['old_password']))
{
    $oldpwd = $_POST['old_password'];
    $newpassword = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $r = mysql_query("select user_id from users where password = '".$oldpwd."' AND user_id = '".$_SESSION['logid']."'");
    
    $cnt = mysql_num_rows($r);
    if($cnt == 1)
    {
        if($newpassword == $confirm_password)
        {
            $jk = mysql_query("update users set password = '".$newpassword."' where password = '".$oldpwd."' AND user_id = '".$_SESSION['logid']."'");
            if($jk)
                {
                    echo"success";
                    header('location:../../change-password.php?msg=success');
                    exit;
                }
                else
                {
                    echo"error";
                    header('location:../../change-password.php?msg=error');
                    exit;
                }
        }
        else
        {
            echo "Confirm password does not match";
            exit;
        }
    }
    else
    {
        echo"error";
        header('location:../../change-password.php?msg=error');
        exit;
    }
exit;
}
?>