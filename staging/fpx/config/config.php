<?php

date_default_timezone_set("Asia/Kolkata");

date_default_timezone_set("Asia/Kolkata");

//$con = mysql_connect("localhost", "qykpay11_qykpay", "Qykpay@11");

$con = mysqli_connect("localhost", "root", "");


$db = mysqli_select_db($con,"qykpay11_qykpay");
/*
$conn = new mysqli("localhost", "qykpay11_qykpay", "Qykpay@11", "qykpay11_qykpay");
    if ($conn->connect_errno) {
        echo "Failed to connect to MySQL: " . $conn->connect_error;
    }
    
   $con = mysql_connect("localhost", "root", "");
$db = mysql_select_db("qykpay", $con);
 */
 
//$base_url = "https://taby.app/staging/fpx/";


$base_url = "http://localhost/taby/staging/fpx/";

?>
