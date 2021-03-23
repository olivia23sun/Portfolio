<!DOCTYPE html>
<html>
<head>
<?php
    session_start();
	if(!isset($_SESSION["login_session"]) || $_SESSION["login_session"] != true){
        echo "<script>";
	    echo "alert(\"***請重新登入***\")";
	    echo "</script>";
	    header("Location: login.php");
    }
	if($_SESSION["identity"] != "teacher"){
		echo "<script>";
	    echo "alert(\"***權限不足***\");";
		unset($_SESSION["ID"]);
		unset($_SESSION["identity"]);
		$_SESSION["login_session"] = false;
		echo "location.href='login.php';";
	    echo "</script>";
	}
?>
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

.nav ul {
    float: left;
}

.nav li {
    margin: 0 20px 0 15px;
    font-size: 1rem;
    line-height: 2rem;
    float: left;
}

ul, ul li {
    margin: 0;
    padding: 0;
    list-style: none;
}

ul {
    display: block;
    list-style-type: disc;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    padding-inline-start: 40px;
}

li {
    display: list-item;
    text-align: -webkit-match-parent;
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
<script src="js/jquery-3.2.1.min.js"></script>
<script src="funct.js"></script>

<?php
    #in order to check whether the user login or not

    if(isset($_POST["CourseName"]) && isset($_POST["Time"])){
		$link = mysqli_connect("localhost", "root", "nptu", "db_ta");
		mysqli_query($link, 'SET NAMES utf8'); 
		#$NewCourseName = $_POST["CourseSem"] . $_POST["Course"];
		$sql = "select * from courseinfo where cname = \"" . $_POST["CourseName"] . "\" and time = cast(\"" . $_POST["Time"] . "\" as datetime)";
		$result = mysqli_query($link, $sql);
        $total_records = mysqli_num_rows($result);
		if($total_records > 0){
			echo "<script>";
	        echo "alert(\"***上課時間已存在***\")";
	        echo "</script>";
		}else{ #inseret a new reservation.
		    $Amountsql = "select COUNT(*) from courseinfo";
			$result = mysqli_query($link, $Amountsql);
			$tmp = mysqli_fetch_array($result);
			if($tmp[0] == 0){
			    $sql = "insert into courseinfo (no, cname, TAID, time, place) values (1, \"" . $_POST["CourseName"] . "\", \"" . $_SESSION["ID"] . "\", cast(\"" . $_POST["Time"] . "\" as datetime), \"" . $_POST["place"] . "\")";	
			}else{
			    $sql = "insert into courseinfo (no, cname, TAID, time, place) values ( (select Max(no) from(select * from courseinfo) as T) +1, \"" . $_POST["CourseName"] . "\", \"" . $_SESSION["ID"] . "\", cast(\"" . $_POST["Time"] . "\" as datetime), \"" . $_POST["place"] . "\")";
			}
			if(mysqli_query($link, $sql)){
				echo "<script>";
	            echo "alert(\"***新增課程成功***\")";
	            echo "</script>";
		    }
		}
		
	}
	unset($_POST["CourseName"]);
	unset($_POST["Time"]);
	unset($_POST["place"]);


?>


<div class="pageHead">
		<img src="img/logoTitle.png" id="logoPic">
		<a href="login.php" id="login">Log in</a>
		<a href="register.php" id="register">Register</a>
	</div>

	<!--標頭下方menu-->
	<div id="menubar">

<div class="nav_area">
    <div class="nav">
	    <ul>
		    <li><a href="AddCourse.php">新增課程</a></li>
			<li><a href="AddTime.php">新增上課時段與資訊</a></li>
			<li><a href="ModCourse.php">檢視與修改課程資訊</a></li> 
			<li onclick="logout()" style="cursor: pointer;">登出</li> 
		</ul>
     </div>
</div>

	</div>

<div class="constraint">
    <div class="DivClass2">
	<form action="AddTime.php" method="post">
	<div id="css_table">
	    <div class="css_tr">
		    <div class="css_td">老師帳號</div>
			<div class="css_td"><?php echo $_SESSION["ID"] ?></div>
		</div>
			<div class="css_tr">
		    <div class="css_td">課程</div>
			<div class="css_td">
			    <select id="CourseName" name="CourseName" style="width:200px;">
		            <option>選擇課程</option>
		            <?php
		                $link = mysqli_connect("localhost", "root", "nptu", "db_ta");
			            mysqli_query($link, 'SET NAMES utf8'); 
			            $sql = "select distinct cname from course where taname1 = ( select name from (select * from teacher where ID = \"" . $_SESSION["ID"] . "\") as T )";
		                $result = mysqli_query($link, $sql);
			            while($data = mysqli_fetch_assoc($result)){
		            ?>
		                <option value="<?php echo $data['cname'];?>"><?php echo $data['cname'];?></option>
	                <?php
			            }
		            ?>
		        </select>
			</div>
		</div>
		<div class="css_tr">
		    <div class="css_td">上課時間</div>
			<div class="css_td">
			    <?php $today = date("Y-m-d"); ?>
				<input type="datetime-local" name="Time" required="required" class="Input" min="<?php echo $today?>T00:00">
			</div>
		</div>
		<div class="css_tr">
		    <div class="css_td">上課地點</div>
			<div class="css_td">
				<input type="text" name="place" required="required" class="Input">
			</div>
		</div>
		<div class="css_tr">
		    <div class="css_td"></div>
		    <div class="css_td"><input type="submit" name="submit"></div>
		</div>

	</div>
	</form>

</div>
</div>
		<div id="pageBottom">
		<div>
			<br>©Design by
			<p>CBE105004 孫浩倫<br>CBE105044 孫芷榆</p>
			
		</div>
	</div>

</body>

</html>