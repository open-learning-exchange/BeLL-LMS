<?php
global $target_path;
function UploadImage($CouchDocID)
{
	$txtCode="";
	$target_path = "../images/";
	$filename = stripslashes($_FILES['uploadedfile']['name']);
	function getExtension($str) {
			 $i = strrpos($str,".");
			 if (!$i) { return ""; }
			 $l = strlen($str) - $i;
			 $ext = substr($str,$i+1,$l);
			 return $ext;
	 }
	$errors=0;
	$extension = getExtension($filename);
	$extension = strtolower($extension);
	global $target_path;
	$target_path = $target_path . $CouchDocID .".". $extension; 
	$txtCode=$imgID.".". $extension;
	$maxResizeWidth = 200;
	$maxResizeHeight = 100;
	move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);
	if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path."ii")) 	{
		return true;
	} else{
		return false;
	}
}
?>