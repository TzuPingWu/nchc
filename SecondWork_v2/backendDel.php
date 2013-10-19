<?php
// 管理者介面檔案刪除
include("connect.php");
$delete = $_POST ["delete"];
if(empty( $delete)){
	header("Location: backend.php"); 
}
else{
	foreach ($delete as $cur){
		$temp = explode("*",$cur);
		$deletePic = $temp[0];
		$deleteVideo = $temp[1];
		$sql_query = "DELETE FROM `SecondWorkUpload_v2` WHERE imageFile ='".$deletePic."'";
		mysql_query($sql_query) or die ("Delete Error ! ".mysql_error()); 
		unlink("uploadAdminPic/$deletePic");
		unlink("uploadAdminVideo/$deleteVideo");
	}
	header("Location: backend.php"); 
}


?>