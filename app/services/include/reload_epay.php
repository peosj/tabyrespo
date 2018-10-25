<?php
class ReloadEpay{
    
    private $db;
    function __Construct(){
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        date_default_timezone_set("Asia/Kuala_Lumpur");
        require_once 'DBConnect.php';
        $this->db = new DBConnect();
        $this->db->connect();
    }
    
    function __Destruct(){
    }
    
    public function reloadEpay($user_id,$reloadNumber,$reloadAmountPayable,$reloadAmount,$reloadAmountGST,$reloadOperatorID,$reloadOperator){
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        $discount ="0" ;
        $promo_code = "";
        $product_description = 'Your reload for +60-'.$reloadNumber.' of Amount RM.'.$reloadAmount.' has been done.';
        $date = date('Y-m-d');
        $status=0;
        $fpx_sellerOrderNo = date('QYK-YmdHis');
        $transaction_type = "Reload";
        $transDateTime = date("Ymdhis");
        
        $query = "insert into orders (reload_amt, gst, operator, coupon_code, discount_amt,total,product_description,user_id,order_id,status,date,seller_order_no, source, transaction_type) values('".$reloadAmount."', '".$reloadAmountGST."', '".$reloadOperator."','".$promo_code."', '".$discount."','".$reloadAmountPayable."','".$product_description."','".$user_id."','".$fpx_sellerOrderNo."','".$status."', '".$date."', '".$fpx_sellerOrderNo."' , 'App' , '".$transaction_type."')";
        
        $r1 = mysql_query($query);
        
        
        $order_id = mysql_fetch_array(mysql_query("select transaction_id,operator,reload_amt, product_description,order_id,batch_lower_date,batch_upper_date,source from orders where seller_order_no = '".$fpx_sellerOrderNo."'"));
                                
        
        $q = "insert into orders_epay(orders_id,amount,rettransref,productcode,date) values(
            '".$order_id['transaction_id']."',
            '".$order_id['reload_amt']."',
            '".$fpx_sellerOrderNo."',
            '".$order_id['operator']."',
            '".$date."'
            )";
            
        mysql_query($q);
        $orders_epay_id=mysql_insert_id();
        
        
        
        
        //$url='https://qykpay.com/epay/index.php'; // Live url
        
        $url='https://qykpay.com/epay/uat.php'; // UAT url
        
        $reloadAmount_cents = $reloadAmount*100;
        $reloadOperator_epay='CELCOMAIRTIMEST';
        
        $data= array('amount'=>$reloadAmount_cents,'retTransRef'=>$fpx_sellerOrderNo,'productCode'=>$reloadOperator_epay,'transDateTime'=>$transDateTime,'date'=>$date,'msisdn'=>$reloadNumber);
        
        //$url='https://qykpay.com/epay/test/3.1-staging.php'; // Specify your url
        //$data= array('amount'=>$order_id['reload_amt'],'retTransRef'=>$_SESSION['seller_order_no'],'productCode'=>$order_id['operator'],'transDateTime'=>$transDateTime,'date'=>$date);
        
        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $epayResponse = curl_exec($ch);                                
        curl_close($ch);
        
         if($epayResponse == "failed")
        {
            mysql_query("update orders_epay set responsecode = '011', responsemsg = 'Mendatory Fields Missing.' where orders_epay_id = '".$orders_epay_id."'");
            $epayResponseMessage = "Failed";
            
            return false;
        }
        else
        {
            $epayResponse = json_decode($epayResponse);
            
            //var_dump($epayResponse);
             //$epayResponseCode = $epayResponse->etopupReturn->responseCode;
            
            //echo"<br>code[<br>".$epayResponseCode."<br>]<br><br>";
            
           //echo $epayResponse->responseCode;
            
            $amount = $epayResponse->amount;
            $pin = $epayResponse->pin;
            $pinExpiryDate = $epayResponse->pinExpiryDate;
            $productCode = $epayResponse->productCode;
            $responseCode = $epayResponse->responseCode;
            $responseMsg = $epayResponse->responseMsg;
            $retTransRef = $epayResponse->retTransRef;
            $terminalId = $epayResponse->terminalId;            
            $transRef = $epayResponse->transRef;
            $customField1 = $epayResponse->customField1;
            
             mysql_query("update orders_epay set responsecode = '".$responseCode."', responsemsg = '".$responseMsg."', 
                pin = '".$pin."',
                pinexpirydate = '".$pinExpiryDate."',
                terminalid = '".$terminalId."',
                transref = '".$transRef."' where orders_epay_id = '".$orders_epay_id."'");
                
                return $amount."qykpay11".$pin."qykpay11".$pinExpiryDate."qykpay11".$productCode."qykpay11".$responseCode."qykpay11".$responseMsg."qykpay11".$retTransRef."qykpay11".$terminalId."qykpay11".$transRef."qykpay11".$customField1."qykpay11".$reloadNumber;
            
        }
            
        
        return false;
        
        
    }
}    
?>