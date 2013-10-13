<?php 
	include("connect.php");
?>
<!DOCTYPE html>


<html>
<head>
	<meta charset="UTF-8">
	<title>後台影片上傳介面</title>
	<link rel=stylesheet type="text/css" href="backend_css.css">
</head>
<body>
	
	
	<div id = "wrapper">
		<!--網頁圖片素材-->
		<div id = "top_left">
		</div>
		<div id = "top_right">
		</div>
		<div = id = "top_middle">
		</div>
		<!--網頁圖片素材-->
		
		<div id="main">
			<div id = "main_top">
				後端管理者介面
			</div>
			<div id = "main_contents">
				<form action = "uploadAdmin.php" method = "post" enctype="multipart/form-data">
					WebM檔案上載 <input type = "file" name = "videoFile"  value ="video" /></br>
					<span style = "letter-spacing:6px; ">縮圖影像上載 </span>&nbsp;&nbsp;<input type = "file" name = "imageFile" value ="image"/></br>
					檔案文字說明:&nbsp;&nbsp;<input type = "text" name = "descriptionText" required /> 
			</div>
			<div id = "uploadButton"><input type="submit" value="上載檔案"/></div>
			<!--<input type="submit" value="上載檔案"/>-->
				</form>
			
		</div>
	<?php
	$query_video = "SELECT * FROM  `SecondWorkUpload`";
	$video= mysql_query($query_video) or die(mysql_error());
	?>
	
	<div id = "bottom">
		<form action = "backendDel.php" method = "post">
		<?php		
			while($row = mysql_fetch_array($video)){	
		?>		<div id="bottom_pic">
					<img src="uploadAdminPic/<?php echo $row["imageFile"]?>  "/></br>
					<input type = "checkbox" name = "delete[]" value = "<?php echo $row["imageFile"]?>*<?php echo $row["videoFile"]?>"/>
				</div>
		<?php } ?>	
		
	</div>
		<div id = "deleteButton"><input type = "submit" value = "確認刪除"/></div>
		</form>
	
	</div>
 
</body>
</html>
