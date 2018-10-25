<?php include("../../config/config.php"); ?>
<?php
session_start();

$id = $_POST['id'];
if(isset($_POST['submit']))
{
   $name = $_POST['name'];
   $email = $_POST['email'];
   $phone = $_POST['phone'];
   $city = $_POST['city'];
   $address = $_POST['address']; 
     
  echo  $query = "UPDATE cheque set name_on_account = '".$name."',email = '".$email."',phone = '".$phone."',city = '".$city."',address = '".$address."' where cheque_id='".$id."'";//exit;
    $query_result = mysql_query($query);
    if($query_result)
    {
        header("location:../../view-status.php?msg=success&id=$id");
    }
    else
    {
        header("location:../../view-status.php?msg=error&id=$id");
    }
    
}
else
{
     header("location:../../view-status.php?msg=error&id=$id");
}

?>