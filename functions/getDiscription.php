<?php session_start();include "../secure/talk2db.php";?>
<?php
global $couchUrl;
	global $facilityId;
	$numberOfUsedRes=0;
	$resources = new couchClient($couchUrl, "resources");
	$resDoc = $resources->getDoc($_GET['id']);
	echo $resDoc->description;
	   
?>