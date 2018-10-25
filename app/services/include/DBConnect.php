<?php
class DBConnect{
/*
    function __construct(){
		define("DB_HOST", "localhost");
		define("DB_USER", "root");
		define("DB_DATABASE", "qyk");
		define("DB_PASSWORD", "");
    }
*/
    function __construct(){
		define("DB_HOST", "localhost");
		define("DB_USER", "qykpay11_qykpay");
		define("DB_DATABASE", "qykpay11_qykpay");
		define("DB_PASSWORD", "Qykpay@11");
    }
    function __destruct(){
    }
    public function connect(){
        $con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
        mysql_select_db(DB_DATABASE)or die(mysql_error());
        return $con;                
    }
    public function close(){
        mysql_close();
    }
}
?>