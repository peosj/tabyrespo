<?php session_start();
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
include("../../config/config.php"); ?>
<?php
if($_POST['login_phone'] && strlen($_POST['login_phone'])>0 && $_POST['password'] && strlen($_POST['password'])>0)
{
    $fname = $_POST['f_name'];
    $lname = $_POST['l_name'];
    $email = $_POST['email'];
    $phone = $_POST['login_phone'];
    $password = $_POST['password'];
    $date = date('Y-m-d');
    @$number = $_POST['number'];
    @$operator = $_POST['operator'];
    @$reload = $_POST['reload'];
        $query = "insert into users (firstname, lastname,phone, email, password, status,otp,date) values('".$fname."','".$lname."', '".$phone."', '".$email."', '".$password."','1','998', '".$date."')";
        $r1 = mysql_query($query);
        if($r1)
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
                    $login_username1 = $login_success_array['lastname'];
                    $login_email = $login_success_array['email'];
                    $login_phone = $login_success_array['phone'];
                    $login_id = $login_success_array['user_id'];
                    $login_date = $login_success_array['date'];
                    $_SESSION['logname'] = $login_username;
                    $_SESSION['logid'] = $login_id;
                    $_SESSION['logemail'] = $login_email;
                    $_SESSION['logphone'] = $login_phone;
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
        }       
}
else
{
    header("location:../../confirm_bills.php?msg=error");
}
?>