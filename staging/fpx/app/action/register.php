<?php
session_start();
include("../../config/config.php");

$password    = $_POST['password'];
$login_phone = $_POST['login_phone'];

//$input = file_get_contents("php://input");
//$_POST = json_decode($input, true);

//print_r($decoded_input); exit;


if($_POST['login_phone'] && strlen($_POST['login_phone'])>0 && $_POST['password'] && strlen($_POST['password'])>0)
{
    $password    = $_POST['password'];
    $login_phone = $_POST['login_phone'];
    $f_name      = $_POST['f_name'];
    $l_name      = $_POST['l_name'];
    $email       = $_POST['email'];
    
    $insert_qry="INSERT INTO users(user_type, firstname, lastname,phone, email, password, status,  timestamp) VALUES ('user','$f_name','$l_name','$login_phone','$email','$password','1','".date('Y-m-d h:i:s')."')";
     $res=mysql_query($insert_qry);
    
     $id=mysql_insert_id($con);
    //print_r($id);
    
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
         
        $response['logname'] = $login_username;
        $response['logid']   = $login_id;
        $response['logemail'] = $login_email;
        $response['logphone'] = $login_phone;
        $response['logcity'] = $login_city;
        $response['logdate'] = $login_date;
        $response['loggedin'] = "true";
        $response['qykpay_loggedin'] = "true";
        $response['registration_status'] = "Registration Success";
         
         //echo json_encode($response);
        header("location:save_order.php");
        exit;
    }
    else
    {
        $response['error'] = TRUE;
        $response['last_insert_id']  =  $id;
        $response['qry'] = $insert_qry;
        
        $response['registration_status'] = "Registartion Failed 1";
        //echo json_encode($response);
       header("location:../../recharge-login.php?msg=error"); 
       exit;
    }
}
else
{
        $response['error'] = TRUE;
        $response['registration_status'] = "Registartion Failed 2";
        //echo json_encode($response);
       header("location:../../recharge-login.php?msg=error"); 
       exit;
}
?>