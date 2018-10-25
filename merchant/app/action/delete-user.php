<?php include("../../config/config.php"); ?>
<?php
session_start();

$emp_id = $_GET['id'];
//echo $query = "DELETE from user where emp_id='".$emp_id."'";
//exit;
if(isset($emp_id))
{
     
    $query = "DELETE from user where emp_id='".$emp_id."'";
    $query_result = mysql_query($query);
    if($query_result)
    {
        header("location:../../view-users.php?msg=success");
    }
    else
    {
        header("location:../../view-users.php?msg=error");
    }
    
}
else
{
     header("location:../../view-users.php?msg=error");
}

?>