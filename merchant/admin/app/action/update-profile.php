<?php include("../../../config/config.php"); ?>
<?php
session_start();
//exit;
$admin_id = $_POST['admin_id'];
if(isset($_POST['submit']))
{
   $emp_id = $_POST['emp_id'];             
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $address = $_POST['address']; 
    $state = $_POST['state'];
     
   $query = "UPDATE admin set name = '".$name."',email = '".$email."',phone = '".$phone."',address = '".$address."',city = '".$city."',state = '".$state."' where admin_id='".$admin_id."'";//exit;
    $query_result = mysql_query($query);
    if($query_result)
    {
        header("location:../../profile.php?msg=success");
    }
    else
    {
        header("location:../../profile.php?msg=error");
    }
    
}
else
{
     header("location:../../user-details.php?msg=error");
}



?>