<?php

include("connect.php");
include("resizeFunc.php");

if(empty( $_FILES["imageFile"]["name"]) || empty($_FILES["videoFile"]["name"]) ){
	header("Location: backend.php"); 
}

//for VideoFile upload
$allowedExts_videoFile = array("webm"); //W3C standard file upload procedure
$temp_videoFile = explode(".", $_FILES["videoFile"]["name"]);
$extension_videoFile = end($temp_videoFile);

//for imageFile upload 
$allowedExts_imageFile = array("gif", "jpeg", "jpg", "png"); //W3C standard file upload procedure
$temp_imageFile = explode(".", $_FILES["imageFile"]["name"]);
$extension_imageFile = end($temp_imageFile);

$typeCheck_image=0;
$typeCheck_video=0;
$file_img = $_FILES["imageFile"]["name"];  
$file_video = $_FILES["videoFile"]["name"];
$fileImage_exist = 1;
$fileVideo_exist = 1;

if (file_exists("uploadAdminVideo/" . $file_video )){	//檢查圖片是否重複
	$fileVideo_exist = 0;
}
if (file_exists("uploadAdminPic/" .$file_img)){			//檢查影片是否重複
	$fileImage_exist = 0;
}
$descriptionText = $_POST['descriptionText']; // for descriptionText 

//檢查影片副檔名是否正確
if (($_FILES["videoFile"]["type"] == "video/webm") || ($_FILES["videoFile"]["type"] == "audio/webm")&& in_array($extension_videoFile, $allowedExts_videoFile)){
	$typeCheck_video=1;
} 
//檢查圖片副檔名是否正確
if ((($_FILES["imageFile"]["type"] == "image/gif")
	||($_FILES["imageFile"]["type"] == "image/jpeg")
	||($_FILES["imageFile"]["type"] == "image/jpg")
	|| ($_FILES["imageFile"]["type"] == "image/pjpeg")
	|| ($_FILES["imageFile"]["type"] == "image/x-png")
	|| ($_FILES["imageFile"]["type"] == "image/png"))
	&& in_array($extension_imageFile, $allowedExts_imageFile)){
	$typeCheck_image=1;	 
}

if($fileVideo_exist && $fileImage_exist && !empty($descriptionText) && $typeCheck_image && $typeCheck_video){

	// 影像上傳
	if ($_FILES["videoFile"]["error"] > 0){
		echo "Upload Error !! ";
	}
	else{
		if(!is_dir("uploadAdminVideo")){
			mkdir("uploadAdminVideo");
		}
		move_uploaded_file($_FILES["videoFile"]["tmp_name"],"uploadAdminVideo/" . $file_video)
		or die("file upload failed!");
	}
	//圖片上傳
	if ($_FILES["imageFile"]["error"] > 0){
		echo "Upload Error !! ";
	}
	else{
		if(!is_dir("uploadAdminPic")){
			mkdir("uploadAdminPic");
		}
		// image resize  
		$file =$_FILES["imageFile"]["tmp_name"]; 
		$source_properties = getimagesize($file);
		$image_type = $source_properties[2]; 
		if( $image_type == IMAGETYPE_JPEG ) {   
			$image_resource_id = imagecreatefromjpeg($file);  
			$target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
			imagejpeg($target_layer,"uploadAdminPic/" . $file_img);
		}
		elseif( $image_type == IMAGETYPE_GIF )  {  
			$image_resource_id = imagecreatefromgif($file);
			$target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
			imagegif($target_layer,"uploadAdminPic/" . $file_img);
		}
		elseif( $image_type == IMAGETYPE_PNG ) {
			$image_resource_id = imagecreatefrompng($file); 
			$target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
			imagepng($target_layer,"uploadAdminPic/" . $file_img);
		}
		//resize finish 
	}

	//更改檔案權限為644
	$filename = "uploadAdminPic/".$file_img;   
	chmod($filename, 0644); 
	$filename = "uploadAdminVideo/".$file_video;
	chmod($filename, 0644);
	
	// 將檔案名稱存入資料庫中
	$sql_query = "INSERT INTO `SecondWorkUpload_v2`(`videoFile`,`imageFile`,`descriptionText`) VALUES(";
	$sql_query .= "'".$_FILES["videoFile"]["name"]."',";
	$sql_query .= "'".$_FILES["imageFile"]["name"]."',";
	$sql_query .= "'".$descriptionText."')";
	$result = mysql_query($sql_query);
	header("Location: backend.php");     // store into database and return to backend.php

}

else{
	if(!$typeCheck_video){
		echo "影片附檔名錯誤 !!";
	}
	else if(!$typeCheck_image){
		echo "圖片附檔名錯誤 !!";
	}
	else if(!$fileVideo_exist){
		echo "影像檔檔名不可重複 !!";
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
}

?>