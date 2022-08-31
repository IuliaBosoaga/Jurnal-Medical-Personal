<?php
header('Content-Type: application/json');
require_once('config.php');
$sqlQuery = "SELECT student_id,student_name,marks FROM tbl_marks ORDER BY student_id";
$result = mysqli_query($link,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

echo json_encode($data);
?>