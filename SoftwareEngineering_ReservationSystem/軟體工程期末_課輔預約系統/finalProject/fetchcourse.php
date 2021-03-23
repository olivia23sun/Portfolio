<?php

if (isset($_POST['CourseName'])){

	$link = mysqli_connect("localhost", "root", "nptu", "db_ta");

	mysqli_query($link, 'SET NAMES utf8'); 
	$sql = "select * from courseinfo where cname = " . "\"" . $_POST['CourseName'] . "\"";
	$result = mysqli_query($link, $sql);
	$times = [];
	while($data = mysqli_fetch_assoc($result)){
		$times[] = $data;
	}
	
	echo json_encode($times, JSON_UNESCAPED_UNICODE );
}
?>