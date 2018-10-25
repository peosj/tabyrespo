<?php 
session_start();
include("../../config/config.php"); ?>
<?php
if(isset($_POST['profile']) && strlen($_POST['profile'])>0)
{
    $profile = $_POST['profile'];
    $sql = "select * from user where profile IN (select value from user_hierarchy where priority > (select priority from user_hierarchy where value = '".$_POST['profile']."'))";    
    $prfl = mysql_query($sql);
    echo"<option value=''>Select Manager</option>";
    while($prfl_row = mysql_fetch_array($prfl))
    {
        echo"<option value='".$prfl_row['emp_id']."'>".$prfl_row['name']."</option>";
    }        
}
?>