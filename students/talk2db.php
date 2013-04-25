<?php

$server ="localhost";
$username ="schoolbell";
$password ="oleole";

$dbhandle= mysql_connect($server,$username,$password) or die(mysql_error());
$selected = mysql_select_db("schoolBell",$dbhandle) or die (mysql_error());

?>