<?php include("../../../config/config.php"); ?>
<?php
session_start();
$user_id = $_GET['id'];
//echo $query = "DELETE from users where user_id='".$user_id."'";
//exit;
if(isset($user_id))
{
    $query = "DELETE from users where user_id='".$user_id."'";
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