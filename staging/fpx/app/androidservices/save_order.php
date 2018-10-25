<?php @session_start();
include("../../config/config.php"); 
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

$input = file_get_contents("php://input");
$_POST = json_decode($input, true);

//echo 'test';
//print_r($_POST);  



if($_POST['prpdmobile'])
{
    $operator          = $_POST['prpdoperator'];
    $number            = $_POST['prpdmobile'];
    $gst               = "";
    $reload            = $_POST['TxnAmount'];
    $rec_type          = $_POST['rec_type'];
    
    $qykpay_loggedin   = $_POST['qykpay_loggedin'];
    $logid             = $_POST['logid'];
   
    $email             = $_POST['email'];
    $bankid             = $_POST['bankid'];
     
    $total      = $reload+$gst;
    
    $discount   = "";
    $promo_code = "";
    
    $product_description  = 'Recharge of '.$operator.' GSM Mobile '.$number;
    
    $date                  = date('Y-m-d');
     
    if($_POST['qykpay_loggedin'])
    {
        $status=0;
        $seller_order_no = date('QYK-YmdHis');
        
        $query = "insert into orders (reload_amt, gst, operator, coupon_code, discount_amt,total,product_description,user_id,order_id,status,date,seller_order_no) values('".$reload."', '".$gst."', '".$operator."','".$promo_code."', '".$discount."','".$total."','".$product_description."','".$logid."','".$seller_order_no."','".$status."', '".$date."', '".$seller_order_no."')";
        
        //echo $query;
        
        $r1 = mysql_query($query);
          

        if($r1)
        {
          $response['order_status'] = "Order added in Taby";
          $response['reload_amt'] = $reload;
          $response['gst'] = $reload;
          $response['operator'] = $operator;
          $response['coupon_code'] = $promo_code;
          $response['discount_amt'] = $discount;
          $response['total'] = $total;
          $response['product_description'] = $product_description;
          $response['user_id'] = $logid;
          $response['order_id'] = $seller_order_no;
          $response['status'] = $status;
          $response['date'] = $date;
          $response['seller_order_no'] = $seller_order_no;
            
          $response['email'] = $email;
          $response['bankid'] = $bankid;
                
          echo json_encode($response); 
        }
    }
    else
    {
        $response['error'] = TRUE;
        $response['error_msg'] = "Please login";
        $response['login_status'] = "Not Logged In";
        echo json_encode($response);
        //echo "recharge-login.php";
        //header("location:../../recharge-login.php");
    }
}

?>


