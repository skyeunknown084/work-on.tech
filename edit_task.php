<?php
include 'db_connect.php';
// Decrypt ID Param
$decrypt_1 = base64_decode($_GET['id']);
// Get ID on url
$t_id = ($decrypt_1 / 9234123120);

$taskqry = $conn->query("SELECT * FROM task_list where id = ".$t_id)->fetch_array();
foreach($taskqry as $k => $v){
	$$k = $v;
}
include 'manage_task.php';
?>