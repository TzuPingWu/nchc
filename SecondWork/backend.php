<?php 
include("connect.php");
	
session_start();
header("Content-Type: text/html; charset=utf-8");
//按下登出所做的動作開始
if(isset($_GET["logout"])&&$_GET["logout"]=="true"){
	unset($_SESSION["id"]);
	header("Location: index.php");
	}
//按下登出所做的動作結束

 if(isset($_SESSION['id'])){ ?>
<!DOCTYPE html>


<html>
<head>
	<meta charset="UTF-8">
	<title>後台影片上傳介面</title>
	<link rel=stylesheet type="text/css" href="backend_css.css">
	<?php
	function cutword($cutstring,$cutno){
		if(strlen($cutstring) > $cutno) { 
			for($i=0;$i<$cutno;$i++) { 
				$ch=mb_substr($cutstring,0,$i,'UTF-8'); 
				if(ord($ch)>127) $i++; 
			} 
		$cutstring= mb_substr($cutstring,0,$i,'UTF-8')."..."; 
		} 
		return $cutstring; 
	}
	?>
	
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
			<div style = "font-weight:normal;font-size:20px;float:right;width:310px;height:60px;padding-top:20px;text-align:center;">
					<form method="GET" action="backend.php" name="logoutForm">
						<input type="hidden" name="logout" value="true" />
						<input type="submit" value="登出" />
					</form>
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
					<?php 
						$cutno = 5;
						$descriptionDisplay=cutword($row["descriptionText"],$cutno);

						echo $descriptionDisplay;
					?>
					</br>
					<input type = "checkbox" name = "delete[]" value = "<?php echo $row["imageFile"]?>*<?php echo $row["videoFile"]?>"/>
					
				</div>
		<?php } ?>	
		
	</div>
		<div id = "deleteButton"><input type = "submit" value = "確認刪除"/></div>
			
		</form>
			
	
	</div>
 
</body>
</html>
<?php 
}
else {
	header("Location:index.php");
}

?>