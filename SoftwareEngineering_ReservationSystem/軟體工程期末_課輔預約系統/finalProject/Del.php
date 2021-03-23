<?php
	$link = mysqli_connect("localhost", "root", "nptu", "db_ta");
    mysqli_query($link, 'SET NAMES utf8'); 
	$sql = "select no, cname, time from seats where ID = \"" . $_POST["ID"] . "\" and valid = 1 order by cname desc, time desc";
	$result = mysqli_query($link, $sql);
	$num = mysqli_num_fields($result);
	$total = 1;
	while($row = mysqli_fetch_array($result)){
		if($total == $_POST["Num"]){
		    $sql = "update seats set valid = 0 where no = " . $row[0];
			mysqli_query($link, $sql);
			$sql_get_amount = "select amount from courseinfo where cname = \"" . $row[1] . "\" and time = \"" . $row[2] . "\"";
			$result = mysqli_query($link, $sql_get_amount);
			$tmp = mysqli_fetch_array($result);
			$sql = "update courseinfo set amount = ". (string)($tmp[0]-1) . " where cname = \"" . $row[1] . "\" and time = \"" . $row[2] . "\"";
			mysqli_query($link, $sql);
			break;
		}
		$total++;
	}
?>