<?php
	$link = mysqli_connect("localhost", "root", "nptu", "db_ta");
    mysqli_query($link, 'SET NAMES utf8'); 
	$sql = "select no, cname, time, place from courseinfo where TAID = \"" . $_POST["ID"] . "\" order by time desc";
	$result = mysqli_query($link, $sql);
	$num = mysqli_num_fields($result);
	$total = 1;
	while($row = mysqli_fetch_array($result)){
		if($total == $_POST["Num"]){
		    $sql = "delete from courseinfo where no = " . $row[0];
			mysqli_query($link, $sql);
		    $sql_seats = "delete from seats where cname = \"" . $row[1] . "\" and time = \"" . $row[2] . "\"";
			mysqli_query($link, $sql_seats);
			break;
		}
		$total++;
	}
	
	
?>