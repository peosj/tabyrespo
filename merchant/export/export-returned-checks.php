<?php include('../config/config.php');?>
<?php
$time = time();
$filename = "returned-checks-".$time.".csv";
$fp = fopen('php://output', 'w');
$query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='echeque' AND TABLE_NAME='cheque'";
$result = mysql_query($query);
while ($row = mysql_fetch_row($result)) {
	$header[] = $row[0];
}	
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
fputcsv($fp, $header);
$query = "SELECT * FROM cheque where cheque_status = 'Declined'";
$result = mysql_query($query);
while($row = mysql_fetch_row($result)) {
	fputcsv($fp, $row);
}
exit;
?>