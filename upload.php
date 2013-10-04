<?php

header("Content-Type: text/html; charset=utf-8");
session_start();
$uploaddir = md5($_SESSION['id'])."/";
$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);

echo '<pre>';
if(is_dir($uploaddir)){
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
		echo "File is valid, and was successfully uploaded.\\\\n";
	} else {
		echo "Possible file upload attack!\\\\n";
	}
}
else{
	mkdir(md5($_SESSION['id']),0777,true);
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
		echo "File is valid, and was successfully uploaded.\\\\n";
	} else {
		echo "Possible file upload attack!\\\\n";
	}
}
echo 'Here is some more debugging info:';
print_r($_FILES);

print "</pre>";

?>