<?php
header("Content-Type: text/html; charset=utf-8");
$loginAccount = $_POST['account'];
$loginPwd = $_POST['pwd'];  
session_start();
	if ( isset($loginAccount) && isset($loginPwd) ) {
		include("connect.php");
		$query_login = "SELECT * FROM  `SecondWorkAdminMember` WHERE `AdminID`='".$loginAccount."'" or die("Delete Error !");
		$login = mysql_query($query_login); 
		$row_login = mysql_fetch_assoc($login);//取出帳密
		$userAccount = $row_login["AdminID"];
		$userPwd = $row_login["AdminPwd"];
		if( $loginPwd == $userPwd ){
				$_SESSION['id'] = $row_login["AdminID"];
		}
		header("Location:backend.php");
	}
?>
