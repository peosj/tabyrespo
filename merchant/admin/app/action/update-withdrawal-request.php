<?php include("../../../config/config.php"); ?>
<?php
session_start();
$cnt = $_POST['declined_comment'];
//echo $_POST['comment_'.$cnt];exit;
if(isset($_POST['submit']))
{
    $withdrawal_amount = $_POST['withdrawal_amount'];
    $date = date('Y-m-d');
    $withdrawal_status = $_POST['withdrawal_status'];
    $withdrawal_request_id = $_POST['withdrawal_request_id']; 
    $declined_comment = $_POST['comment_'.$cnt];
    //echo "select * from balance where user_id = '".$_SESSION['logid']."'";
    $balance_query = mysql_query("select * from balance where user_id = '".$_SESSION['logid']."'");
    
    $balance_row = mysql_fetch_array($balance_query);
    $balance_id = $balance_row['balance_id'];
    $total_balance = $balance_row['total'];
    $reserved_balance = $balance_row['reserved_balance'];
    $processing_fee = 50;
    $total_amt = $total_balance-$withdrawal_amount; 

     if($withdrawal_status == 'Approved')
     {
        $status = 1;
        $query = "UPDATE withdrawal_request set status = '".$status."' where withdrawal_request_id = '".$withdrawal_request_id."'"; 
        $r1 = mysql_query($query);
        $balance = "UPDATE balance set withdrawal_request = '".$withdrawal_amount."',total = '".$total_amt."' where balance_id = '".$balance_id."'"; 
        $balance_result = mysql_query($balance);
        
        
       $billing_query = "INSERT into billing (user_id,description,processing_fee,balance,reserved_balance,billing_type,date) values('".$_SESSION['logid']."','Withdrawal request for amount ".$withdrawal_amount." prcessed amount transfered => ".$total_amt."<br/>".$declined_comment."','".$processing_fee."','".$total_amt."','".$reserved_balance."','Withdrawal Processed', '".$date."')";
            $billing_querys = mysql_query($billing_query);
            //echo $billing_query; exit;
     } 
     if($withdrawal_status == 'Declined')
     {
        $status = 2;
        $query = "UPDATE withdrawal_request set status = '".$status."' where withdrawal_request_id = '".$withdrawal_request_id."'"; 
        $r1 = mysql_query($query);
        $billing_query = "INSERT into billing (user_id,description,processing_fee,balance,reserved_balance,billing_type,date) values('".$_SESSION['logid']."','Withdrawal request for amount ".$withdrawal_amount." prcessed amount transfered => ".$total_amt." Admin commented : ".$declined_comment."','".$processing_fee."','".$total_amt."','".$reserved_balance."','Withdrawal Processed', '".$date."')";
        $billing_querys = mysql_query($billing_query);
     }
           
    //echo $billing_query;exit;
    header("location:../../withdrawal-request.php?msg=success");        
}
else
{
    header("location:../../withdrawal-request.php?msg=error");
}
?>