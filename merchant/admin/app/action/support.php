<?php include("../../../config/config.php"); ?>
<?php
session_start();
if(isset($_POST['registered_email']) && isset($_POST['transaction_id']))
{
    $registered_email = $_POST['registered_email'];
    $transaction_id = $_POST['transaction_id'];             
    $support_type = $_POST['support_type']; 
    $comment = $_POST['comment'];
    $date = date('Y-m-d');
        $query = "insert into support (user_id, user_type, registered_email, transaction_id, support_type, date) values('".$_SESSION['logid']."', '".$_SESSION['user_type']."', '".$registered_email."', '".$transaction_id."', '".$support_type."', '".$date."')";
        //exit;
        $r1 = mysql_query($query);
        $support_id = mysql_insert_id();
        $comment_query = "insert into support_comment (support_id, user_id, user_type, comment, date) values('".$support_id."', '".$_SESSION['logid']."', '".$_SESSION['user_type']."', '".$comment."', '".$date."')";
    $comment_query_result = mysql_query($comment_query);
        //echo $query;
        //exit;     
    header("location:../../support-form.php?msg=success");        
}
else
{
    header("location:../../support-form.php?msg=error");
}
?>