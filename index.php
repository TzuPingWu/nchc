<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
	//按下登出所做的動作開始
if(isset($_GET["logout"])&&$_GET["logout"]=="true"){
	unset($_SESSION["id"]);
	header("Location: index.php");
	}
	//按下登出所做的動作結束
?>
<html>
<head>
<title>行動式水利災害全景影像生成系統</title>
<link rel="stylesheet" type="text/css" href="index_css.css">
</head>
<body>
<?php
if(!isset($_SESSION["id"])){
?>
<div id = "wrapper">
		<!--網頁圖片素材-->
		<div id = "top_left"></div>
		<div id = "top_right"></div>
		<div = id = "top_middle"></div>
		<!--網頁圖片素材-->
	<!--網頁主畫面開始-->
	<div id="main">
		<div id="main_top">
			<p>行動式水利災害全景影像生成系統
			<p style="font-size:25px;">登入
		</div><!--上方畫面--><span>沒有帳號密碼? >> <a href="register.php">註冊</a></span>
			<hr></hr>
			<!--主要登入畫面-->
		<div id="main_contents">
			<p>登入會員，請輸入帳號密碼：
			<form method="POST" action="login.php">
				<p>帳號:<input type="text" name="account"/>
				<p>密碼:<input type="password" name="pwd"/>
				<div id="loginButton"><input type="submit" value="登入會員"></input></div>
			</form>
		</div><!--主要登入畫面 結束-->
	</div>
</div><!--wrapper結束-->
	<?php }else{ ?>
<div id = "wrapper">
		<!--網頁圖片素材-->
		<div id = "top_left"></div>
		<div id = "top_right"></div>
		<div = id = "top_middle"></div>
		<!--網頁圖片素材-->
	<!--網頁主畫面開始-->
	<div id="main">
		<div id="main_top">
			<p>行動式水利災害全景影像生成系統
			<!--照片上傳開始!-->	
			<p style="font-size:25px;">照片上傳
		</div>
		<hr></hr>
		<div id="main_contents">
			<form action="upload.php" method="post" enctype="multipart/form-data">
				請選擇要上傳的照片:<br />
				<div id="loginButton"><input name="userfile[]" type="file" multiple="multiple"/><br /></div>
				<div id="loginButton"><input type="submit" value="上傳檔案" /></div>
			</form>
			<!--照片上傳結束!-->
	<br/>
		<!--會員登出!-->
		<form method="GET" action="index.php" name="logoutForm">
			<input type="hidden" name="logout" value="true" />
			<div id="loginButton"><input type="submit" value="會員登出" /></div>
		</form>
		<!--會員登出!-->
	</div>
	<?php } ?>	
	</div><!--網頁主化面結束-->
</div><!--wrapper 結束-->
</body>
</html>
