<?php
function fn_resize($image_resource_id,$width,$height) {
	$imageSize_width = 100;
	$imageSize_height = 80;

	$target_width = $imageSize_width;
	$target_height = $imageSize_height;
	$target_layer=imagecreatetruecolor($target_width,$target_height);
	imagecopyresampled($target_layer,$image_resource_id,0,0,0,0,$target_width,$target_height, $width,$height);
	return $target_layer;
			}
?>