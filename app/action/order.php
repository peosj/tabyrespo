<?php @session_start();

include("../../config/config.php"); ?>
<?php
if($_POST['dashboard'])
{
    $operator = $_POST['operator1'];
    $number = $_POST['number1'];
    $gst = $_POST['gst1'];
    $reload = $_POST['reload1'];
    $total = $_POST['total1'];
    $discount = $_POST['discount1'];
    $promo_code = $_POST['promo_code1'];
    $product_description = 'Recharge of HotLink GSM Mobile '."$number";
    $date = date('Y-m-d');
    $_SESSION['number'] = $number;
    $_SESSION['operator'] = $operator;
    $_SESSION['reload'] = $reload;
    //echo $discount;exit;
    if($discount>0)
    {
        $status = 0;
    }
    else
    {
        $status = 1;
    }
    
    $query = "insert into orders (reload_amt, gst, operator, coupon_code, discount_amt,total,product_description,user_id,order_id,status,date) values('".$reload."', '".$gst."', '".$operator."','".$promo_code."', '".$discount."','".$total."','".$product_description."','".$_SESSION['logid']."','100001','".$status."', '".$date."')";
        $r1 = mysql_query($query);//exit;
        if($r1)
        {
           header("location:../../order.php?msg=success");
            exit;   
        }       
}
else
{
    header("location:../../paybill.php?msg=error");
}
?>