<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" >
<link rel=stylesheet type="text/css" href="mycss3.css">
<title>屏大資科課輔預約系統</title>
<style>


html{
	height : 100%;
}

body {

  height : 100%;
}

.DivClass2{
	height:75%;
	width:100%;
	float:left;
	margin: 0 auto;
    /*置中語法*/
	/*https://www.oxxostudio.tw/articles/201502/css-vertical-align-7methods.html*/
	display:flex;
    align-items:center;
    justify-content:center;
	vertical-align: middle;
}

.nav_area{
	background-color: #f5f5f5;
	margin: 0 auto;
	padding: 10px 0 10px 0;
	overflow: hidden;
}
.nav{
	position: relative;
	margin: 0 auto;
	max-width: 800px;
	display:flex;
    align-items:center;
    justify-content:center;
}

.constraint{
	height : 75%;
    position: relative;
	margin: 0 auto;
	max-width: 800px;
	display:flex;
    align-items:center;
    justify-content:center;
}



a{
    text-decoration : none;
}

#css_table{
	display:table;	
}
.css_tr{
	display: table-row;	

}
.css_td{
	display: table-cell;
	width: 200px;
	padding: 10px;
}


.Input{
	/*position: relative;*/
    display: table;
    margin : 0 auto;
    border : 1px solid black;
	height :48px;
    width : 500px;
	border-radius : 5px; /*圓弧*/
}

.sr_only{
	position: absolute;
    width: 1px;
    height: 1px;
    margin: -1px;
    padding: 0;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0;	
}
.btn{
	font-size: 14px;
    line-height: 1;
    border-radius: 500px;
    padding: 16px 48px 18px;
    -webkit-transition-property: background-color, border-color, color, -webkit-box-shadow, -webkit-filter;
    transition-property: background-color, border-color, color, -webkit-box-shadow, -webkit-filter;
    transition-property: background-color, border-color, color, box-shadow, filter;
    transition-property: background-color, border-color, color, box-shadow, filter, -webkit-box-shadow, -webkit-filter;
    -webkit-transition-duration: .3s;
    transition-duration: .3s;
    border-width: 0;
    letter-spacing: 2px;
    min-width: 160px;
    text-transform: uppercase;
    /*white-space: normal;*/
	display: block;
    width: 60%;
	color: #FFF;
    background-color: #1DB954;
	text-align:center;
	text-decoration:none; /*去超連結底線*/
	margin : 0px auto;
}


</style>
</head>
<body>
<?php
session_start();
$ID = ""; $Password = "";
if(isset($_SESSION["login_session"]) && $_SESSION["login_session"] == true){
    if($_SESSION["identity"] == "teacher"){
	    header("Location: AddCourse.php");
	}else if($_SESSION["identity"] == "student"){
		header("Location: reserve.php");
	}
}

if(isset($_POST["id"]) && isset($_POST["password"])){
	$ID = $_POST["id"]; $Password = $_POST["password"];
	
    $link = mysqli_connect("localhost", "root", "nptu", "db_ta");
    mysqli_query($link, 'SET NAMES utf8'); 
    $stu_sql = "select * from student where id = '" . $ID . "' and password = '" . $Password . "'"; 
    $teacher_sql = "select * from teacher where id = '" . $ID . "' and password = '" . $Password . "'"; 

    $stu_result = mysqli_query($link, $stu_sql); //search student
	$stu_records = mysqli_num_rows($stu_result);
	
	$teacher_result = mysqli_query($link, $teacher_sql); //search teacher
	$teacher_records = mysqli_num_rows($teacher_result);
	
    if ( $stu_records > 0 ) {
        $_SESSION["login_session"] = true;
	    $_SESSION["ID"] = $ID;
	    $_SESSION["identity"] = "student";
        header("Location: reserve.php");
    }else if($teacher_records > 0){
	    $_SESSION["login_session"] = true;
	    $_SESSION["ID"] = $ID;
	    $_SESSION["identity"] = "teacher";
		header("Location: AddCourse.php");
    }else {  
       $_SESSION["login_session"] = false;
	   echo "<script>";
	   echo "alert(\"帳密不正確\")";
	   echo "</script>";
	   unset($_POST["id"]); unset($_POST["password"]);
	   header("Location login.php");
   }
}
?>

<div class="pageHead">
		<img src="img/logoTitle.png" id="logoPic">
		<a href="login.php" id="login">Log in</a>
		<a href="register.php" id="register">Register</a>
</div>

	<!--標頭下方menu-->
	<div id="menubar">

	</div>
	


<div class="constraint">
    <div class="DivClass2"> 
	<form action="login.php" method="post">
	<div id="css_table">
	    <div class="css_tr">
		    <div class="css_td">輸入學號</div>
			<div class="css_td"><input type="text" name="id" required="required" placeholder="學號" class="Input"></div>
		</div>
		<div class="css_tr">
		    <div class="css_td">輸入密碼</div>
			<div class="css_td"><input type="password" name="password" required="required" placeholder="密碼" class="Input"></div>
		</div>
		<div class="css_tr">
		    <div class="css_td"></div>
		    <div class="css_td"><input type="submit" name="submit" class="btn"></div>
		</div>

	</div>
	</form>

    </div>
</div>








	
		<!--底-->
	<div id="pageBottom">
		<div>
			<br>©Design by
			<p>CBE105004 孫浩倫<br>CBE105044 孫芷榆</p>
			
		</div>
	</div>

</body>

</html>