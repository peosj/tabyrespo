<?php include("../../config/variables.php"); ?>
<?php include("../../config/config.php"); ?>
<?php
if(isset($_POST['phone_id']))
{
    $plan_id = $_POST['phone_id'];
    $r = mysql_query("select * from user where phone = '".$plan_id."'");
    if(mysql_num_rows( $r)>0)
    {
        echo "failure";exit;
    }
    else
    {
       echo "success";exit; 
    }
    
}


?>