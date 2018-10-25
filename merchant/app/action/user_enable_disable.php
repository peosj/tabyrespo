<?php include("../../config/config.php"); ?>
<?php
session_start();

$emp_id = $_GET['id'];
$status = $_GET['status'];
if($status=='1')
{
   echo $statuss = '0';
    
}
if($status=='0')
{
  echo  $statuss = '1';
}
//echo $query = "UPDATE user set status = '".$statuss."' where emp_id='".$emp_id."'";
//exit;
if(isset($emp_id))
{
     
    $query = "UPDATE user set status = '".$statuss."' where emp_id='".$emp_id."'";
    $query_result = mysql_query($query);
    if($query_result)
    {
        header("location:../../view-users.php?msg=success&emp_id=$emp_id");
    }
    else
    {
        header("location:../../view-users.php?msg=error&emp_id=$emp_id");
    }
    
}
else
{
     header("location:../../view-users.php?msg=error&emp_id=$emp_id");
}

?>