<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
//put the file information into the database
include("connect.php");

$uploaddir = md5($_SESSION['id'])."/";
//places files into md5(id) directory
$imageCount = 0;
//count the number of the image
$imageName="";
//all of the image name
$filetype = array("image/jpeg","image/gif","image/bmp","image/png");
//restriction of file type = image

$typeFlag = 0;//type flag -> 0 false 1 true
foreach ($_FILES["userfile"]["error"] as $key => $error) {
	foreach($filetype as $typeKey=>$type){
		if(!strcmp($filetype[$typeKey],$_FILES["userfile"]["type"][$key])){//check if the file is image
			if(is_dir($uploaddir)){//check if the directory is existed.
				move_uploaded_file($_FILES["userfile"]["tmp_name"][$key],$uploaddir.$_FILES["userfile"]["name"][$key])
				or die("file upload failed!");
			}else{
				mkdir(md5($_SESSION['id']));//build the new directory using md5(id) as name
				move_uploaded_file( $_FILES["userfile"]["tmp_name"][$key],$uploaddir.$_FILES["userfile"]["name"][$key])
				or die("file upload failed!");
			}
			$imageCount+=1;
			$imageName.=$_FILES["userfile"]["name"][$key]." ";
			$typeFlag = 1;
			break;
		}//end of if-directory 
	}//end of type-check loop foreach
}//end of total-file loop foreach

if(!$typeFlag){//if the type of file is not image!
	echo "<script language=\"javascript\">"."window.open('typeFailed.php ', '上傳的檔案不是圖片檔', config='height=200,width=200');"."</script>";
	// open the new warning window
	echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=index.php\"></head><body></body></html>";
	// direct to the index.php

}else{//if the type of file is image!
	$check_query = "SELECT `count` FROM  `member` WHERE  `account` =  '".$_SESSION['id']."'";
	$checkResult = mysql_query($check_query) or die('Select data failed!');
	while($checkRow = mysql_fetch_array($checkResult)){
    $count = $checkRow['count']+1;//number of the stitch photo
	}
	//select the number of stitch photo

	$update_query = "UPDATE `member` SET `count` = ".$count." WHERE `account` = '".$_SESSION['id']."'";\
	mysql_query($update_query) or die('Update data failed!');
	//update count = count+1 

	$insert_query = "INSERT INTO `imageUpload` (`account` ,`count` ,`imgaeCount` ,`imageName`)VALUES (";
	$insert_query .= "'".$_SESSION['id']."',";
	$insert_query .= "'".$count."',";
	$insert_query .= "'".$imageCount."',";
	$insert_query .= "'".$imageName."')";
	mysql_query($insert_query) or die("Error in inserting image information!"); 
	//insert the file information
    
	//execute the program start!
	$directoryName = md5($_SESSION['id']);
	$commandline="./autostitich.exe";
	$filename = "path.txt";//the path of program to execute
	$str = "http://people.cs.nctu.edu.tw/~tzpwu/nchc/".$directoryName."/";//the upload path directory
    $file = fopen($filename,"w"); //open the file
	if (flock($file,LOCK_EX)){ 
		fwrite($file,$str);//write the target path into "path.txt", and enter critical section.
		}
	else{
		echo "Error locking file!";
	}
	
	$last_line = exec($commandline);//execute the program
	
	/* Get the total-view image
	$src = imagecreatefromjpeg("./".$directoryName."/stitch.jpg");

	// get the width and height of the image
	$src_w = imagesx($src);
	$src_h = imagesy($src);

	// Supposed the image width and height doesn't exceed 50 px
	if($src_w > $src_h){
		$thumb_w = 50;
		$thumb_h = intval($src_h / $src_w * 50);
	}else{
		$thumb_h = 50;
		$thumb_w = intval($src_w / $src_h * 50);
	}

	// build the thumbnail.
	$thumbNail = imagecreatetruecolor($thumb_w, $thumb_h);

	// start to resize
	imagecopyresampled($thumbNail, $src, 0, 0, 0, 0, $thumb_w, $thumb_h, $src_w, $src_h);

	// save the thumbNail to "thumbNail" directory
	imagejpeg($thumbNail, "thumbNail/".$directoryName.".jpg");//thumbnail will put temporarily in the thumbNail directory
	*/
	$count = 0;//number of stitch photo
	$check_query = "SELECT `count` FROM  `member` WHERE  `account` = '".$_SESSION['id']."'";
	$checkResult = mysql_query($check_query);
	if(!$checkResult){
		die('Select data failed!');
	}
	while($checkRow = mysql_fetch_array($checkResult)){
      $count = $checkRow['count'];//number of the stitch photo
	}//select the number of stitch photo
	$newDirectoryName = $directoryName.$count;
	mkdir($newDirectoryName);//create the new directory, put the original file in it.
	foreach ($_FILES["userfile"]["error"] as $key => $error) {
		rename($directoryName."/".$_FILES['userfile']['name'][$key],$newDirectoryName."/".$_FILES['userfile']['name'][$key]);
	}
	
	// copy the image to the assigned directory
	//copy("stitich.jpg", $newDirectoryName."/".$count."jpg"); 
	flock($file,LOCK_UN);//critical section unlock
	fclose($file);//close the file
	echo "<html><head><meta http-equiv=\"refresh\" content=\"0;url=index.php\"></head><body></body></html>";
	//execute the program end!
}
?>
