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
					圖片檔案上載 <input name="imageFile[]" type="file" multiple="multiple" /></br>
					檔案文字說明:&nbsp;&nbsp;<input type = "text" name = "descriptionText" required /> 
			</div>
			<div id = "uploadButton"><input type="submit" value="上載檔案"/></div>
			<!--<input type="submit" value="上載檔案"/>-->
				</form>
			
		</div>
	<?php
	
	$query_count = "SELECT count FROM `SecondWorkAdminMember_v2`";
	$resultCount = mysql_query($query_count) or die(mysql_error());
	?>
	<div id = "bottom">
		<form action = "backendDel.php" method = "post">
		<?php	
			$rowCount = mysql_fetch_array($resultCount);//抓出管理者資料庫資料
			$count = $rowCount["count"];//只需要count的資訊
			for($i=1;$i<=$count;$i++){	//for迴圈跑
					
			$query_image = "SELECT * FROM `SecondWorkUpload_v2` WHERE count = '".$i."'";
			$image= mysql_query($query_image) or die(mysql_error());			
			$row = mysql_fetch_array($image);//抓出上傳資料庫資料			
			if(is_dir("uploadAdminPic/".$i)){
		?>		<div id="bottom_pic">
					<img src="uploadAdminPic/<?php echo $i."/resize".$i.".jpg";?>  "/></br>
					<?php 
						$cutno = 5;
						$descriptionDisplay=cutword($row["descriptionText"],$cutno); 
						echo $descriptionDisplay;
					?>
					</br>
					<input type = "checkbox" name = "delete[]" value = "<?php echo $i;?>"/>
					
				</div>
		<?php }//如果目錄存在
			else{//目錄不存在
				continue;
			}
		}//for 迴圈結束 ?>	
		
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