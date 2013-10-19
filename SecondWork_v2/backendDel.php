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
		
		//將使用者的上傳次數從資料庫讀出放在count(開始)
		$count_query = "SELECT count FROM `SecondWorkAdminMember_v2`";
		$count_result = mysql_query($count_query);
		while($countRow = mysql_fetch_array($count_result)){
			$count = $countRow['count'];//time of uploading pic
		}
		//將使用者的上傳次數從資料庫讀出放在count(結束)
		$destDir = "uploadAdminPic/".$count."/";
		//目標資料夾
		
		$deletePic = $cur;
		$sql_query = "DELETE FROM `SecondWorkUpload_v2` WHERE imageFile ='".$deletePic."'";
		mysql_query($sql_query) or die ("Delete Error ! ".mysql_error()); 
		unlink($destDir.$deletePic);
		if(file_exists($destDir."resize".$count.".jpg")){
			unlink($destDir."resize".$count.".jpg");
		}//刪掉縮圖	
		delTree("uploadAdminPic/".$count."/");
		//刪掉資料夾
	}
	
	header("Location: backend.php"); 
}


?>