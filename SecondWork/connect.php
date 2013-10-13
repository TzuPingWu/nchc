<?php
	header("Content-Type: text/html; charset=utf-8");
	$db_link=@mysql_connect("dbhome.cs.nctu.edu.tw","tzpwu_cs","judy7839");
	if(!$db_link) die("連線失敗");
	if(!@mysql_select_db("tzpwu_cs")) die("資料庫選擇失敗"); 
	mysql_query("SET NAMES 'utf8'"); 
?>