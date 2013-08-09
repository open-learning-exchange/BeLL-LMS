<?php session_start(); error_reporting(1);include "talk2db.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Open Learning Exchange - Ghana</title>
<?php
if(isset($_GET['resid']))
{
	$query = mysql_query("SELECT url FROM `resources` where colNum =".$_GET['resid']."") or die(mysql_error());
			 while($data = mysql_fetch_array($query))
			 {
				 $mystring = $data['url'];
			recordAction($_SESSION['name'],"Viewed Resource with id : ".$_GET['resid']);
	   			die('<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$mystring.'">');
			 }
}
?>
</head>

<body>
</body>
</html>