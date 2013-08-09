<?php


$server ="localhost";
$username ="root";
///$password ="raspberry";
$password ="";

$dbhandle= mysql_connect($server,$username,$password) or die(mysql_error());
$selected = mysql_select_db("schoolBell",$dbhandle) or die (mysql_error());

function recordAction($action_by,$save_data){
	$save = mysql_query("INSERT INTO `action_log` (`colNum`, `person`, `action`, `dateTime`) VALUES (NULL, '".$action_by."', '".$save_data."', CURRENT_TIMESTAMP)");
	
}


function recordActionDate($action_by,$save_data,$systemDateForm){
	$save = mysql_query("INSERT INTO `action_log` (`colNum`, `person`, `action`, `dateTime`) VALUES (NULL, '".$action_by."', '".$save_data."','".$systemDateForm."')");
}

///
// V 2
///
//global $mysqli;
///$mysqli = new mysqli("localhost", "root", "raspberry", "schoolBell");
///$mysqli = new mysqli("localhost", "root", "", "schoolBell");


// CouchDB

///$doc = new couchDocument($couchUrl);
//echo "Me here";

///$doc = new couchDocument($client);
//$doc = couchDocument($couchUrl,"_design/checkUserLogin");
//$views = $doc->views;
//global $couchClient;
////$couchClient = new couchClient($couchUrl);
?>