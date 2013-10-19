<?php
// 管理者介面檔案刪除
include("connect.php");
$delete = $_POST ["delete"];
//刪除資料夾function

function delTree($dir) { 
		$files = array_diff(scandir($dir), array('.','..')); 
		foreach ($files as $file) { 
			(is_dir($dir."/".$file)) ? delTree($dir."/".$file) : unlink($dir."/".$file); 
		}	 
		return rmdir($dir); 
}
	 
if(empty( $delete)){
	header("Location: backend.php"); 
}
else{
	foreach ($delete as $cur){
		$destDir = "uploadAdminPic/".$cur."/";
		//目標資料夾
		$deletePic = $cur;
		$sql_query = "DELETE FROM `SecondWorkUpload_v2` WHERE count ='".$deletePic."'";
		mysql_query($sql_query) or die ("Delete Error ! ".mysql_error()); 
		delTree($destDir);
		//刪掉資料夾*/
	}
}
	header("Location: backend.php"); 
?>