<?php
	header("Content-Type: text/html; charset=utf-8");
	$db_link=@mysql_connect("dbhome.cs.nctu.edu.tw","","");
	if(!$db_link) die("³s½u¥¢±Ñ");
	if(!@mysql_select_db("tzpwu_cs")) die("¸ê®Æ®w¿ï¾Ü¥¢±Ñ"); 
	mysql_query("SET NAMES 'utf8'"); 
?>
