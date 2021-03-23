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
	display:inline-block;
    align-items:center;
    justify-content:center;
	vertical-align: middle;
	text-align: center;
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


/* Border styles */
.Table tr {
border-top-width: 1px;
border-top-style: solid;
border-top-color: rgb(211, 202, 221);
}
.Table {
border-bottom-width: 1px;
border-bottom-style: solid;
border-bottom-color: rgb(211, 202, 221);
margin: 0 auto;
text-align:center;
table-layout: fixed;
}

/* Padding and font style */
.Table td, .Table th {
padding: 5px 10px;
font-size: 20px;
font-family: 微軟正黑體, Arial;
color: rgb(95, 74, 121);
}

/* Alternating background colors */
.Table tr:nth-child(even) {
background: rgb(223, 216, 232)
}
.Table tr:nth-child(odd) {
background: #FFF
}

</style>


</head>

<body>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="funct.js"></script>

<?php
    $link = mysqli_connect("localhost", "root", "nptu", "db_ta");
	mysqli_query($link, 'SET NAMES utf8'); 
	
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
			<?php
			    $records_per_page = 5; #record the records in per page
			
			    if(isset($_GET["Pages"])){
				    $pages = $_GET["Pages"];
			    }else{
				    $pages = 1;
			    }
			
				$sql = "select cname, time, place, amount from courseinfo where TAID = \"" . $_SESSION["ID"] . "\" order by time desc";
				$result = mysqli_query($link, $sql);
				$num = mysqli_num_fields($result);
			    $records_amount = mysqli_num_rows($result);
			    $total_pages = ceil($records_amount/$records_per_page);
			    $offset = ($pages - 1) * $records_per_page;
			    mysqli_data_seek($result, $offset);
			    $total = $offset + 1;
			    $j = 1;
				echo "<table class=\"Table\">";
				echo "<tr><td>項次</td><td>課程名稱</td><td>上課時間</td><td>上課地點</td><td>目前人數</td><td>刪除課程</td></tr>";
				while($row = mysqli_fetch_array($result) and $j <= $records_per_page){
					echo "<tr>";
					for($i = 0; $i < $num; $i++){
						if($i == 0){
							echo "<td>" . (string)($total) . "</td>";
						}
						echo "<td>" . $row[$i] . "</td>";
					}
					echo "<td><p style=\"cursor: pointer;\" onclick=\"delCourse('" . $_SESSION["ID"] . "'," . (string)($total) .")\">刪除</p></td></tr>";
					$total++;
					$j++;
				}
				echo "</table>";
				
				if($pages > 1){
				    echo "<a href='ModCourse.php?Pages=" . ($pages-1) ."'>上一頁</a>| ";
			    }
			    for($i = 1; $i <= $total_pages; $i++){
				    if($i != $pages){
					    echo "<a href='ModCourse.php?Pages=" . $i . "'>" . $i . "</a>";
				    }
				    else{
					    echo $i . "";
				    }	
			    }
			    if($pages < $total_pages){
				    echo "|<a href='ModCourse.php?Pages=" . ($pages+1) ."'>下一頁</a> ";
			    }
			?>
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