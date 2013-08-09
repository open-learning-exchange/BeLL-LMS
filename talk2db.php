<?php

$server ="localhost";
$username ="schoolbell";
$password ="oleole";

$dbhandle= mysql_connect($server,$username,$password) or die(mysql_error());
$selected = mysql_select_db("schoolBell",$dbhandle) or die (mysql_error());

function recordAction($action_by,$save_data){
	$save = mysql_query("INSERT INTO `action_log` (`colNum`, `person`, `action`, `dateTime`) VALUES (NULL, '".$action_by."', '".$save_data."', CURRENT_TIMESTAMP)");
	
}


function recordActionDate($action_by,$save_data,$systemDateForm){
	$save = mysql_query("INSERT INTO `action_log` (`colNum`, `person`, `action`, `dateTime`) VALUES (NULL, '".$action_by."', '".$save_data."','".$systemDateForm."')");
}
?>