<?php @session_start();
include("../../config/config.php"); 
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
if($_POST)
    {
    $operator = $_POST['prpdoperator'];
    $number = $_POST['prpdmobile'];
    $gst = "";
    $reload = $_POST['TxnAmount'];
    $rec_type = $_POST['rec_type'];
    $total = $reload+$gst;
    $discount ="" ;
    $promo_code = "";
    $product_description = 'Recharge of '.$operator.' GSM Mobile '.$number;
    $date = date('Y-m-d');
    $_SESSION['number'] = $number;
    $_SESSION['operator'] = $operator;
    $_SESSION['TxnAmount'] = $reload;
    $_SESSION['rec_type'] = $rec_type;
    if(isset($_SESSION['qykpay_loggedin']))
    {
        $status=0;
        $_SESSION['seller_order_no'] = date('QYK-YmdHis');
        $query = "insert into orders (reload_amt, gst, operator, coupon_code, discount_amt,total,product_description,user_id,order_id,status,date,seller_order_no) values('".$reload."', '".$gst."', '".$operator."','".$promo_code."', '".$discount."','".$total."','".$product_description."','".$_SESSION['logid']."','".$_SESSION['seller_order_no']."','".$status."', '".$date."', '".$_SESSION['seller_order_no']."')";
        //echo $query;
        $r1 = mysql_query($query);
            if($r1)
            {
             header("location:../../order_confirm.php");
             exit;   
            }
    }
    else
    {
        header("location:../../recharge-login.php");
    }
    }
else
    {
        $operator = $_SESSION['operator'];
        $number = $_SESSION['number'];
        $gst = "";
        $reload =  $_SESSION['TxnAmount'] ;
        $rec_type =  $_SESSION['rec_type'];
        $total = $reload+$gst;
        $discount ="" ;
        $promo_code = "";
        $product_description = 'Recharge of '.$operator.' GSM Mobile '.$number;
        $date = date('Y-m-d');
        $status=0;
        $_SESSION['seller_order_no'] = date('QYK-YmdHis');
        $query = "insert into orders (reload_amt, gst, operator, coupon_code, discount_amt,total,product_description,user_id,order_id,status,date,seller_order_no) values('".$reload."', '".$gst."', '".$operator."','".$promo_code."', '".$discount."','".$total."','".$product_description."','".$_SESSION['logid']."','".$_SESSION['seller_order_no']."','".$status."', '".$date."', '".$_SESSION['seller_order_no']."')";
        //echo $query; exit;
        $r1 = mysql_query($query);//exit;
        if($r1)
        {
         header("location:../../order_confirm.php");
         exit;   
        }  
        else
        {
           header("location:../../index.php?msg=error1"); 
           exit;
        }
    }
?>