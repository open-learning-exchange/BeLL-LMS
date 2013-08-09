<?php session_start();include "../secure/talk2db.php";?>
<?php
   $query = mysql_query("SELECT `description` FROM `resources` where `resrcID`=".$_GET['id']."") or die(mysql_error());
   while($data = mysql_fetch_array($query))
   {
	  echo $data['description'];
	   
   }
?>