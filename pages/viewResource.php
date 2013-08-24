<?php session_start(); include "../secure/talk2db.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Open Learning Exchange - Ghana</title>
<?php
if(isset($_GET['resid']))
{
	global $couchUrl;
	global $facilityId;
	$resources = new couchClient($couchUrl, "resources");
	$doc = $resources->getDoc($_GET['resid']);
	$docAttachment = $doc->_attachments;
	$arrayFiles = array();
	foreach($docAttachment as $key => $value){
			array_push($arrayFiles,$key);
	}
	//echo $arrayImage[0];
	//echo $_SERVER['SERVER_NAME'];
	$mystring = "http://".$_SERVER['SERVER_NAME'].":5984/resources/".$_GET['resid']."/".urlencode($arrayFiles[0])."";
	recordActionObjectDate($_SESSION['lmsUserID'],"Viewed Resource",$_GET['resid'],$_GET['systDate']);
	die('<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$mystring.'">');
			
}
?>
</head>

<body>
</body>
</html>