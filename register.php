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
</head>
<body>
<p>加入會員，請填入帳號密碼：
<form method="POST" action="register.php">
<p>Account:<input type="text" name="account"/>
<p>Password:<input type="password" name="pwd"/>
<input type="hidden" name="action" value="add"/>
<p><input type="submit" value="加入會員"></input>
</form>
</body>
</html>