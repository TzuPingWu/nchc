<?php
include("connect.php");
$sql_query = "SELECT `account` FROM `member` WHERE `account` = '".$_POST['account']."'";  
$result = mysql_query($sql_query);
$data = mysql_fetch_assoc($result);
if(!$result) die("query failed!");

if(strcmp($data["account"],$_POST["account"])){//帳號不同
  $ret = "<span style=\"color:green;\">此帳號可以使用</span><input type=\"hidden\" name=\"account_msg\" value=\"\">";
}
else//帳號相同
{
  $ret = "<span style=\"color:red\">此帳號已經有人使用</span><input type=\"hidden\" name=\"account_msg\" value=\"no\">";
}
echo $ret;
?>