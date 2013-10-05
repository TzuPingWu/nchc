<!----------------------吳姿屏-------------------------->

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
<title>測試首頁</title>
</head>
<body>
<?php
if(!isset($_SESSION["id"])){
?>
<a href="register.php">註冊</a>
<p>登入
<hr></hr>
<p>登入會員，請輸入帳號密碼：
<form method="POST" action="login.php">
<p>Account:<input type="text" name="account"/>
<p>Password:<input type="password" name="pwd"/>
<p><input type="submit" value="登入會員"></input>
</form>
<?php }else{ ?>
<p>登入成功!!!!
<!--照片上傳開始!-->
<h4>照片上傳</h4>
<form action="upload.php" method="post" enctype="multipart/form-data">
  Send these files:<br />
  <input name="userfile[]" type="file" multiple="multiple"/><br />  
  <input type="submit" value="Send files" />
</form>



<!--照片上傳結束!-->
<br/>
<!--會員登出!-->
<form method="GET" action="index.php" name="logoutForm">
<input type="hidden" name="logout" value="true" />
<input type="submit" value="登出" />
</form>
<!--會員登出!-->
<?php } ?>
</body>
</html>
