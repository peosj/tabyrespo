<?php include("../../../config/config.php"); ?>
<?php
session_start();
if(isset($_POST['submit']))
{
    $emp_id = $_POST['emp_id'];             
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $address = $_POST['address']; 
    $state = $_POST['state'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $date = date('Y-m-d');
        $query = "insert into admin (emp_id,user_type, name, email, phone, city,state,address, password,confirm_password,status,date) values('".$emp_id."', 'admin', '".$name."', '".$email."', '".$phone."', '".$city."','".$state."','".$address."','".$password."','".$confirm_password."','1','".$date."')";
        $r1 = mysql_query($query);
        //echo $query;
        //exit;     
$path = "../ajax/profile/admin";
if ( ! is_dir($path)) 
    {
        mkdir($path);
    }
if ($_FILES["file"]["error"] > 0)
   {
        echo "Apologies, an error has occurred.";
        echo "Error Code: " . $_FILES["file"]["error"];
   }
else
   {
        move_uploaded_file($_FILES["file"]["tmp_name"],
        $path."/profile_pic_" .$emp_id.".png");
    }
        //exit;    
    header("location:../../create-admin.php?msg=success");        
}
else
{
    header("location:../../create-admin.php?msg=error");
}
?>