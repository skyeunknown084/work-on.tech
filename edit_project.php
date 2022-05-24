<?php
include 'db_connect.php';
// Decrypt ID Param
$decrypt_1 = base64_decode($_GET['id']);
// Get ID on url
$p_id = ($decrypt_1 / 9234123120);

$projectqry = $conn->query("SELECT * FROM project_list where id = ".$p_id)->fetch_array();
foreach($projectqry as $k => $v){
	$$k = $v;
}
include 'new_project.php';
?>