<?php 
session_start();
 include("../../config/config.php");
$support_id = $_POST['support_id'];

if(isset($_POST['submit']))

{

   $registered_email = $_POST['registered_email'];

   $transaction_id = $_POST['t_id'];

   $support_type = $_POST['support_type'];

   $comment = $_POST['comment'];

   $date = date('Y-m-d'); 

    $query = "UPDATE support set registered_email = '".$registered_email."',transaction_id = '".$transaction_id."',support_type = '".$support_type."' where support_id='".$support_id."'";//exit;

    $query_result = mysql_query($query);

    

    $comment_query = "INSERT INTO support_comment (support_id,user_id,user_type, comment, date) values('".$support_id."', '".$_SESSION['logid']."', '".$_SESSION['user_type']."', '".$comment."', '".$date."')";

    $comment_query_result = mysql_query($comment_query);

    

    if($query_result)

    {

        header("location:../../view-ticket.php?msg=success&id=$support_id");

    }

    else

    {

        header("location:../../view-ticket.php?msg=error&id=$support_id");

    }

    

}

else

{

     header("location:../../view-ticket.php?msg=error&id=$support_id");

}



?>