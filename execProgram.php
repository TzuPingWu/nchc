<?php

	session_start();
	$directoryName = md5($SESSION['id']);
	$commandline="./autostitich.exe ".$directoryName;
	$last_line = exec($commandline);
	
	// Get the total-view image
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
	imagejpeg($thumbNail, "thumbNail/".$directoryName.".jpg");
	
	$count = 0;//number of stitch photo
	$check_query = "SELECT `count` FROM  `member` WHERE  `account` =  '".$_SESSION['id']."'";
	$checkResult = mysql_query($check_query) or die('Select data failed!');
	while($checkRow = mysql_fetch_array($checkResult)){
      $count = $checkRow['count'];//number of the stitch photo
	}//select the number of stitch photo
	
	$newDirectoryName = $directoryName.$count;
	mkdir($newDirecotyrName);//create the new directory, put the original file in it.
	foreach ($_FILES["userfile"]["error"] as $key => $error) {
		rename($directoryName."/".$_FILES['file']['name'][$key],$newDirectoryName."/".$_FILES['file']['name'][$key]);
	}
	
	// copy the image to the assigned directory
	copy("stitich.jpg", $newDirectoryName."/".$count."jpg"); 
?>