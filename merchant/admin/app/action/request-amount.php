<?php include("../../config/config.php"); ?>
<?php
session_start();
//echo $_POST['amount'];exit;
if(isset($_POST['submit']))
{
    $amount = $_POST['amount'];
    $date = date('Y-m-d');
    
    $balance_query = mysql_query("select * from balance where user_id = '".$_SESSION['logid']."'");
    $balance_row = mysql_fetch_array($balance_query);
    $total_amt = $balance_row['total'];    
    $balance_id = $balance_row['balance_id'];   
    $balance = $balance_row['balance'];   
    //if($total_amt>=400)
    //{
        $main_balance = $total_amt-$amount;
        //echo "UPDATE balance set total = '".$main_balance."' where balance_id = '".$balance_id."'";
        $update_query = mysql_query("UPDATE balance set total = '".$main_balance."' where balance_id = '".$balance_id."'");
        if($update_query)
        {
            
            $billing_query = "INSERT into billing (user_id,description,debits,balance,reserved_balance,billing_type,date) values('".$_SESSION['logid']."','Main balance debited for withdrawal request of amount ".$amount."','".$amount."','".$balance."','".$balance."','Withdrawal Request', '".$date."')";
            $billing_querys = mysql_query($billing_query);
            //echo $billing_query;
        }
    //} 
             
    $query = "insert into withdrawal_request (amount,user_id,date) values('".$amount."' ,'".$_SESSION['logid']."', '".$date."')";
    $r1 = mysql_query($query);
    //echo $query;exit;
    header("location:../../billing.php?msg=success");        
}
else
{
    header("location:../../billing.php?msg=error");
}
?>