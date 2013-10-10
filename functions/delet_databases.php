<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
$dbs= array( 
  "facilities",
  "whoami",
  "resources",
  "members",
  "assignments",
  "actions",
  "questions",
  "feedback",
  "groups"
  );
$i = 1;

foreach($dbs as $db) {
	while ($i < 50){
		exec("curl -XDELETE http://pi:raspberry@raspberrypi.local:5984/" . $db);
		$i++;
  }
  $i=1;
}
?>
</body>
</html>