<?php include("../../config/config.php"); ?>
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
$user_id = $_POST['user_id'];
if(isset($_POST['submit']))
{
    $fname = $_POST['fname'];             
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    //$address = $_POST['address']; 
    //$business_type = $_POST['busines_type'];
    //$billing_cycle = $_POST['billing_cycle'];
    //$bank_name = $_POST['bank_name'];
    //$bank_address = $_POST['bank_address'];
    //$name_on_bank_account = $_POST['name_on_account'];
    //$ifsc_code = $_POST['ifsc_code'];
    //$swift_code = $_POST['swift_code'];
    $date = date('Y-m-d');
      $query = "UPDATE users set firstname = '".$fname."', lastname = '".$lname."', email = '".$email."', phone = '".$phone."',date = '".$date."' where user_id = $user_id";
        $r1 = mysql_query($query);
/*    
$path = "../ajax/profile/user";
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
        $path."/profile_pic_" .$login_id.".png");
    }*/
        //exit;    
    header("location:../../profile.php?msg=success");        
}
else
{
    header("location:../../profile.php?msg=error");
}
?>