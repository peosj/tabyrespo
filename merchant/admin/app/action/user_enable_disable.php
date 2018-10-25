<?php include("../../../config/config.php"); ?>
<?php
session_start();

$user_id = $_GET['id'];
$status = $_GET['status'];
if($status=='1')
{
   echo $statuss = '0';
    
}
if($status=='0')
{
  echo  $statuss = '1';
}
//echo $query = "UPDATE users set status = '".$statuss."' where user_id='".$user_id."'";
//exit;
if(isset($user_id))
{
     
    $query = "UPDATE users set status = '".$statuss."' where user_id='".$user_id."'";
    $query_result = mysql_query($query);//exit;
    if($query_result)
    {
        header("location:../../view-users.php?msg=enable_disable_success&user_id=$user_id");
    }
    else
    {
        header("location:../../view-users.php?msg=enable_disable_error&user_id=$user_id");
    }
    
}
else
{
     header("location:../../view-users.php?msg=enable_disable_error&user_id=$user_id");
}

?>