<?php

include("connect.php");
include("resizeFunc.php");

//將使用者的上傳次數從資料庫讀出+1放在count(開始)
$count_query = "SELECT count FROM `SecondWorkAdminMember_v2` WHERE 1";
$count_result = mysql_query($count_query);
if(!$count_result) die("count error!");
while($countRow = mysql_fetch_array($count_result)){
	$count = $countRow['count']+1;//time of uploading pic
}
//將使用者的上傳次數從資料庫讀出+1放在count(結束)
if(!is_dir("uploadAdminPic")){
	mkdir("uploadAdminPic");
}
if(!is_dir("uploadAdminPic/".$count)){
	mkdir("uploadAdminPic/".$count."/");
	chmod("uploadAdminPic/".$count."/",0755);
}//創建上傳資料夾

foreach($_FILES["imageFile"]["error"] as $key => $error){
	if(empty( $_FILES["imageFile"]["name"][$key])){
		header("Location: backend.php"); 
	}
	//for imageFile upload 
	$allowedExts_imageFile = array("gif", "jpeg", "jpg", "png","JPG"); //W3C standard file upload procedure
	$temp_imageFile = explode(".", $_FILES["imageFile"]["name"][$key]);
	$extension_imageFile = end($temp_imageFile);

	$typeCheck_image=0;
	$file_img = $_FILES["imageFile"]["name"][$key];  
	$fileImage_exist = 1;

	$descriptionText = $_POST['descriptionText']; // for descriptionText 

	//檢查圖片副檔名是否正確
	if ((($_FILES["imageFile"]["type"][$key] == "image/gif")
		||($_FILES["imageFile"]["type"][$key] == "image/jpeg")
		||($_FILES["imageFile"]["type"][$key] == "image/jpg")
		|| ($_FILES["imageFile"]["type"][$key] == "image/pjpeg")
		|| ($_FILES["imageFile"]["type"][$key] == "image/x-png")
		|| ($_FILES["imageFile"]["type"][$key] == "image/png"))
		&& in_array($extension_imageFile, $allowedExts_imageFile)){
			$typeCheck_image=1;	 
	}

	if($fileImage_exist && !empty($descriptionText) && $typeCheck_image){


	//圖片上傳
	if ($_FILES["imageFile"]["error"][$key] > 0){
		echo "Upload Error !! ";
	}
	else{
	
		
		$destDir = "uploadAdminPic/".$count."/";//目標資料夾
		move_uploaded_file($_FILES["imageFile"]["tmp_name"][$key],iconv("UTF-8", "big5", $destDir.$file_img)) or die("uploaded error!");	
		//上傳原圖
		
		if($key==1){// first image: do resize 第一張照片做縮圖  
			$file =$destDir.$file_img; 
			$source_properties = getimagesize($file);
			$image_type = $source_properties[2]; 
			$resizeFileName = "resize".$count.".jpg";   
			$image_resource_id = imagecreatefromjpeg($file);  
			$target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
			imagejpeg($target_layer,$destDir.$resizeFileName);
			chmod($destDir.$resizeFileName,0644);	
		}	//resize finish	
	}

	//更改檔案權限為644
	$filename = $destDir.$file_img;   
	chmod($filename, 0644); 
	
	// 將檔案名稱存入資料庫中
	$sql_query = "INSERT INTO `SecondWorkUpload_v2`(`imageFile`,`descriptionText`,`count`) VALUES(";
	$sql_query .= "'".$_FILES["imageFile"]["name"][$key]."',";
	$sql_query .= "'".$descriptionText."',";
	$sql_query .= "'".$count."')";
	$result = mysql_query($sql_query);
	// 更新count
	$update_query = "UPDATE SecondWorkAdminMember_v2 SET count = ".$count  ;
	mysql_query($update_query) or die("update error!");
	}//end of if
	else{
		if(!$typeCheck_image){
		echo "圖片附檔名錯誤 !!";
	}
	else if(!$fileImage_exist){
		echo "圖片檔檔名不可重複 !!";
	}
	else if(empty($descriptionText)){
		echo "文字說明不可空白 !!";
	}
	else{
		echo "unknown error !!";
	}
	}//end of else
}//end of foreach
	header("Location: backend.php");     // store into database and return to backend.php
?>