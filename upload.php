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

foreach ($_FILES["userfile"]["error"] as $key => $error) {
	foreach($filetype as $typeKey=>$type){
		if(!strcmp($filetype[$typeKey],$_FILES["userfile"]["type"][$key])){//check if the file is image
			if(is_dir($uploaddir)){//check if the directory is existed.
				move_uploaded_file($_FILES["userfile"]["tmp_name"][$key],$uploaddir.$_FILES["userfile"]["name"][$key])
				or die("file upload failed!");
				echo "Upload Success !!!";
			}else{
				mkdir(md5($_SESSION['id']));//build the new directory using md5(id) as name
				move_uploaded_file( $_FILES["userfile"]["tmp_name"][$key],$uploaddir.$_FILES["userfile"]["name"][$key])
				or die("file upload failed!");
				echo "Upload Success !!!";
			}
			$imageCount+=1;
			$imageName.=$_FILES["userfile"]["name"][$key]." ";
			break;
		}//end of if-directory 
		else{
			echo "Problem with file-type!";
		}
	}//end of type-check loop foreach
}//end of total-file loop foreach


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

//header("Location:execProgram.php");

?>