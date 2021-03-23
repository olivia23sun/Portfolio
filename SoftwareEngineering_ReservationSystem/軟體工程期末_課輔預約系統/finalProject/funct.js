var del = function (id,num){
	if(confirm("確定刪除此筆預約紀錄?")){
		$(document).ready(function(){
			$.ajax({
				type: 'POST',
				url: 'Del.php',
				data: { ID : id,
				        Num : num
				}, 
			}).done(function(data){
				    console.log(data);
					location.reload();
			})
		});
	}
	
}


var delCourse = function (id,num){
    if(confirm("確定刪除此筆上課紀錄?")){
		$(document).ready(function(){
			$.ajax({
				type: 'POST',
				url: 'DelCourse.php',
				data: { ID : id,
				        Num : num
				}, 
			}).done(function(data){
				    console.log(data);
					location.reload();
			})
		});
	}
	
}



var logout = function (){
    if(confirm("確定登出?")){
		$(document).ready(function(){
			$.ajax({
				type: 'POST',
				url: 'Logout.php', 
			})
		});
	}
	location.href = "login.php";
}