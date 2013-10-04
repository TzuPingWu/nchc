<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
$uploaddir = md5($_SESSION['id'])."/";
//places files into md5(id) directory
$filetype = array("image/jpeg","image/gif","image/bmp","image/png");
print '<pre>';
foreach ($_FILES["userfile"]["error"] as $key => $error) {
	foreach($filetype as $typeKey=>$type){
		if(!strcmp($filetype[$typeKey],$_FILES["userfile"]["type"][$key])){//check if the file is image
			if(is_dir($uploaddir)){//check if the directory is existed.
				move_uploaded_file( $_FILES["userfile"]["tmp_name"][$key],$uploaddir.$_FILES["userfile"]["name"][$key]) 
			or die("Problems with upload");
			}else{
				mkdir(md5($_SESSION['id']));//build the new directory using md5(id) as name
				move_uploaded_file( $_FILES["userfile"]["tmp_name"][$key],$uploaddir.$_FILES["userfile"]["name"][$key]) 
				or die("Problems with upload");
			}
			break;
		}//end of if-directory 
		else{
			echo "Problem with file-type!";
		}
	}//end of type-check loop foreach
}//end of total-file loop foreach

echo 'Here is some more debugging info:';
print_r($_FILES);
print '</pre>';
?>