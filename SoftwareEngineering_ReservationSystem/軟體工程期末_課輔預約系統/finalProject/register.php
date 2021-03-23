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
$ID = ""; $Password = ""; $Name = ""; 
$Classno = "";  $Phone = ""; $Email = "";

function ResetVar($post, $num){
	global $Name, $Classno, $Phone, $Email;
    if ($num == 0){
		$Name = ""; $Classno = ""; $Phone = ""; $Email = "";
	}
	else{
		$Name = $post["name"]; 
		$Classno = $post["classno"]; 
		$Phone = $post["phone"];
	    $Email = $post["email"];
		
	}
	
}

if(isset($_POST["id"]) && isset($_POST["password"])){
	// check whether the account exists or not
	$ID = $_POST["id"]; $Password = $_POST["password"];
	$link = mysqli_connect("localhost", "root", "nptu", "db_ta");
    mysqli_query($link, 'SET NAMES utf8'); 
    $sql = "select * from student where id = '" . $ID . "' and password = '" . $Password . "'"; 
    $result = mysqli_query($link, $sql);
    $total_records = mysqli_num_rows($result);
    //if the account already exist
	if ( $total_records > 0 ) {
        $_SESSION["login_session"] = true;
	    echo "<script>";
	    echo "alert(\"帳號已經存在，請重新註冊\")";
	    echo "</script>";
	    //unset($_POST["account"]); unset($_POST["password"]);
		ResetVar($_POST, 0);
    } else {  
        ResetVar($_POST, 1);
        $sql = "insert into student (id, password, name, classno, phone, email) values (\"" ;
		$sql.= $ID . "\",\"" . $Password . "\",\"" . $Name . "\",\"" . $Classno . "\"," . $Phone . ",\"" . $Email . "\")";
		mysqli_query($link, 'SET NAMES utf8');
		if(mysqli_query($link, $sql)){
			echo "<script>";
	        echo "alert(\"完成註冊\")";
	        echo "</script>";
		}
		else{
			die("錯誤<br/>");
		}
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
	<form action="register.php" method="post">
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
		    <div class="css_td">輸入姓名</div>
			<div class="css_td"><input type="text" name="name" required="required" placeholder="姓名" class="Input"></div>
		</div>
		<div class="css_tr">
		    <div class="css_td">輸入班級</div>
			<div class="css_td"><input type="text" name="classno" required="required" placeholder="班級" class="Input"></div>
		</div>
		<div class="css_tr">
		    <div class="css_td">輸入電話</div>
			<div class="css_td"><input type="tel" name="phone" required="required" placeholder="電話" class="Input" pattern="[0]{1}[9]{1}[0-9]{8}"></div>
		</div>
		<div class="css_tr">
		    <div class="css_td">輸入信箱</div>
			<div class="css_td"><input type="email" name="email" required="required" placeholder="信箱" class="Input" ></div>
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