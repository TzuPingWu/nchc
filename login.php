<?php
header("Content-Type: text/html; charset=utf-8");
$loginAccount = $_POST['account'];
$loginPwd = $_POST['pwd'];  
session_start();
	if ( isset($loginAccount) && isset($loginPwd) ) {
		include("connect.php");
		$query_login = "SELECT * FROM  `member` WHERE `account`='".$loginAccount."'";
		$login = mysql_query($query_login);
		$row_login = mysql_fetch_assoc($login);//取出帳密
		$userAccount = $row_login["account"];
		$userPwd = $row_login["password"];
		if( $loginPwd == $userPwd ){
				$_SESSION['id'] = $row_login["account"];
		}
		header("Location:index.php");
	}
?>
