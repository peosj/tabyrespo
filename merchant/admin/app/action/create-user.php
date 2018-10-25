<?php include("../../../config/config.php"); ?>
<?php
session_start();
//$login_id = $_SESSION['logid'];
if(isset($_POST['submit']))
{
    
    $fname = $_POST['fname'];             
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $date = date('Y-m-d');
    
    
                
        $query = "insert into users (user_type,	firstname, lastname, phone, email,password, status,otp,date) values('user','".$fname."', '".$lname."','".$phone."', '".$email."', '".$password."','1','8877','".$date."')";
        
        $r1 = mysql_query($query);
        $login_id = mysql_insert_id();
         //$query;
        //exit;     
        if($r1)
        {
            $query_balance = "insert into balance (balance,reserved_balance,total,withdrawal_request,user_id) values('0','0','0','0','".$login_id."')";
            $balance_query = mysql_query($query_balance);
             
        }
    
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
    }

        //exit;    
    header("location:../../create-user.php?msg=success");        
}
else
{
    header("location:../../create-user.php?msg=error");
}

?>