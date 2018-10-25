<?php @session_start();

include("../../config/config.php"); ?>
<?php
if($_POST)
    {
    $operator = $_POST['prpdoperator'];
    $number = $_POST['prpdmobile'];
    $gst = "";
    $reload = $_POST['prpdamount'];
    $rec_type = $_POST['rec_type'];
    $total = $reload+$gst;
    $discount ="" ;
    $promo_code = "";
    $product_description = 'Recharge of '.$operator.' GSM Mobile '.$number;
    $date = date('Y-m-d');
    $_SESSION['number'] = $number;
    $_SESSION['operator'] = $operator;
    $_SESSION['reload'] = $reload;
    $_SESSION['rec_type'] = $rec_type;
    
    
    if($_SESSION['logid'])
    {
    //echo $discount;exit;
    if($discount>0)
    {
        $status = 0;
    }
    else
    {
        $status = 1;
    }
    $status=0;
    $query = "insert into orders (reload_amt, gst, operator, coupon_code, discount_amt,total,product_description,user_id,order_id,status,date) values('".$reload."', '".$gst."', '".$operator."','".$promo_code."', '".$discount."','".$total."','".$product_description."','".$_SESSION['logid']."','100001','".$status."', '".$date."')";
    $r1 = mysql_query($query);//exit;
    if($r1)
    {
       
     header("location:../../order_confirm.php?msg=success");
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
    $reload =  $_SESSION['reload'] ;
    $rec_type =  $_SESSION['$rec_type'];
    $total = $reload+$gst;
    $discount ="" ;
    $promo_code = "";
    $product_description = 'Recharge of '.$operator.' GSM Mobile '.$number;
    $date = date('Y-m-d');
    $status=0;
    $query = "insert into orders (reload_amt, gst, operator, coupon_code, discount_amt,total,product_description,user_id,order_id,status,date) values('".$reload."', '".$gst."', '".$operator."','".$promo_code."', '".$discount."','".$total."','".$product_description."','".$_SESSION['logid']."','100001','".$status."', '".$date."')";
    $r1 = mysql_query($query);//exit;
    if($r1)
    {
       
     header("location:../../order_confirm.php?msg=success");
     exit;   
    }  
    }
?>