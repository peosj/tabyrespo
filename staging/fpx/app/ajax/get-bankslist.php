<?php
$curl_url="bank_list.php";
              
      $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $curl_url);
       curl_setopt($ch, CURLOPT_HEADER, 0);
       curl_setopt($ch, CURLOPT_POST, 1);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       $output = curl_exec($ch);
        curl_close($ch);
        //$output=true;
       var_dump($output);
?>