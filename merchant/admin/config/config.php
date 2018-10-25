<?php
date_default_timezone_set("Asia/Kolkata");
@$con = mysql_connect("localhost", "root", "");
$res = mysql_select_db("qykpay", $con);
?>