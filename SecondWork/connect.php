<?php
	header("Content-Type: text/html; charset=utf-8");
	$db_link=@mysql_connect("dbhome.cs.nctu.edu.tw","tzpwu_cs","judy7839");
	if(!$db_link) die("�s�u����");
	if(!@mysql_select_db("tzpwu_cs")) die("��Ʈw��ܥ���"); 
	mysql_query("SET NAMES 'utf8'"); 
?>