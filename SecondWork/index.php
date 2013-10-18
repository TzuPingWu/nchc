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
<title>第二網站首頁</title>
</head>
<body>
<?php
if(!isset($_SESSION["id"])){
?>
<p>管理者登入
<hr></hr>
<p>請輸入管理者帳號密碼：
<form method="POST" action="loginAdmin.php">
<p>Account:<input type="text" name="account"/>
<p>Password:<input type="password" name="pwd"/>
<p><input type="submit" value="登入"></input>
</form>
<?php }else{ ?>
<p>登入成功!!!!


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
