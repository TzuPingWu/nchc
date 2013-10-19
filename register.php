<?php
header("Content-Type: text/html; charset=utf-8");
if(isset($_POST["action"])&&($_POST["action"]=="add"))
{
	include("connect.php");
	if(!empty($_POST['account'])&&!empty($_POST['pwd'])){
		$sql_query = "INSERT INTO `member`(`account`,`password`) VALUES(";
		$sql_query .= "'".$_POST['account']."',";
		$sql_query .= "'".$_POST['pwd']."')";
		$result = mysql_query($sql_query);
	}
		header("Location: index.php");
	
}	
?>
<html>
<head>
<title>會員註冊</title>
<link rel="stylesheet" type="text/css" href="index_css.css">
<!--註冊檢查-->
<script src="jquery-1.7.2.min"></script>
<script type="text/javascript">
	  function password_len(){
		  var msg=document.getElementById('pwd_msg');
		   if(register_form.pwd.value.length<6){	
		 		msg.innerHTML="密碼長度至少六位元!請重新輸入密碼";
		  		register_form.pwd.value="";
		  	}
			else if(register_form.pwd.value.length>10){
				msg.innerHTML="密碼長度不能超過十位元!請重新輸入密碼";
				register_form.pwd.value=""
			}
			else{
				msg.innerHTML="";
				}
		  }
  	  
	  function passwordCheck(){	  
	  var msg=document.getElementById('pwd2_msg');
	  if(register_form.pwd.value!=register_form.pwd2.value){	  
		  msg.innerHTML="和原密碼不合!請再輸入一次"
		  register_form.pwd2.value="";
		  }
	  else{
			msg.innerHTML="";
			}
	  }//check if the repeated password is the same as the original one.
	  function accountCheck(){			
	  var accountText=document.getElementById('warning');
		if(!register_form.account.value){
			accountText.innerHTML="帳號不能是空白的喔!";
			}
	    else{	
        	accountText.innerHTML="";
			jQuery.ajax({
      		url: 'validate.php',
      		type: 'POST',
      			data:{
        			account: jQuery('#account').val()
				},
      			error: function(xhr) {
      			},
      			success: function(response) {
          			jQuery('#warning').html(response);
          			jQuery('#warning').fadeIn();
     	    	}
    		});
		}
		
	  };//the account can't be duplicated	  
	  function submit_register(){		
		if(!(register_form.pwd.value)||!(register_form.pwd2.value)||(register_form.account_msg.value))
		{
		  	alert('註冊失敗!請將資料重新填妥');
		}<!--register failed because of account,pwd,pwd2 is empty!-->
		else
		{
			alert('註冊成功!歡迎你的加入:)');	
		}<!--register success!!-->
	  }
</script>
<!--註冊檢查結束-->
</head>
<body>
<div id="wrapper">
	<!--網頁圖片素材-->
	<div id = "top_left"></div>
	<div id = "top_right"></div>
	<div = id = "top_middle"></div>
	<!--網頁圖片素材-->
	<!--網頁主畫面開始-->
	<div id="main">
		<!--主畫面標題開始-->
		<div id="main_top">
			<p>行動式水利災害全景影像生成系統
			<p style="font-size:25px;">會員註冊
		</div>
		<!--主畫面標題結束-->
		<p>註冊為會員，請輸入帳號密碼。
		<hr></hr>
		<!--主畫面內容開始-->
		<div id="main_contents">	
			<form method="POST" action="register.php" name="register_form">
				帳號:<input type="text" id="account" name="account" onblur="accountCheck()"/><div id="warning" name="warning"></div>
				<br/>密碼:<input type="password" name="pwd" onblur="password_len()"/><div id="pwd_msg"></div>
				<br/>再次輸入密碼:<input type="password" name="pwd2" onblur="passwordCheck()"/><div id="pwd2_msg"></div>
				<input type="hidden" name="action" value="add"/>
				<div id="loginButton"><input type="submit" value="加入會員" onclick="submit_register()"></input>
				<input type="submit" value="返回首頁" onclick="window.location='index.php';" /></div>
			</form>
		</div>
		<!--主畫面內容結束-->
	</div>
	<!--網頁主化面結束-->
</div>
</body>
</html>