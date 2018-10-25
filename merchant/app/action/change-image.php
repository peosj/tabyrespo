<?php include("../../config/config.php"); ?>
<?php
session_start();
$login_id = $_SESSION['logid'];
if(isset($_POST['submit']))
{
   $path = "../../admin/app/ajax/profile/user";
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
        header("location:../../profile.php?msg=success"); 
}
else
{
     header("location:../../profile.php?msg=error"); 
}
?>