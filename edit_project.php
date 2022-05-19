<?php
include 'db_connect.php';
// Decrypt ID Param
$decrypt_1 = base64_decode($_GET['id']);
// Get ID on url
$id = ($decrypt_1 / 9234123120);
$qry = $conn->query("SELECT * FROM project_list where id = ".$id)->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
include 'new_project.php';
?>