<?php include("../../config/config.php"); ?>
<?php
session_start();
$login_id = $_SESSION['logid'];
if(isset($_POST['submit']))
{
    
    $fname = $_POST['fname'];             
    $lname = $_POST['lname'];
    $company_name = $_POST['cname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address']; 
    $business_type = $_POST['business_type'];
    $login_id = $_POST['emp_id'];
    $password = $_POST['password'];
    $billing_cycle = $_POST['billing_cycle'];
    $bank_name = $_POST['bank_name'];
    $bank_address = $_POST['bank_address'];
    $name_on_bank_account = $_POST['name_on_bank'];
    $ifsc_code = $_POST['ifsc_code'];
    $swift_code = $_POST['swift_code'];
    $date = date('Y-m-d');
                
        $query = "insert into users (f_name, l_name, company_name, email, contact_number,address, business_type, login_id,password,billing_cycle,bank_name,bank_address,name_on_bank_account,ifsc_code,swift_code,date,status) values('".$fname."', '".$lname."', '".$company_name."', '".$email."', '".$phone."','".$address."', '".$business_type."','".$login_id."','".$password."','".$billing_cycle."','".$bank_name."','".$bank_address."','".$name_on_bank_account."','".$ifsc_code."','".$swift_code."','".$date."','1')";
        
        $r1 = mysql_query($query);
        
        //echo $query;
        //exit;     
    
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
//echo $path;
        //exit;    
    header("location:../../create-user.php?msg=success");        
}
else
{
    header("location:../../create-user.php?msg=error");
}

?>