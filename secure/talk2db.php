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

global $couchUrl;
$couchUrl = 'http://127.0.0.1:5984';



try{
	include "lib/couch.php";
	include "lib/couchClient.php";
	include "lib/couchDocument.php";
} catch(Exception $err){
	include "../lib/couch.php";
	include "../lib/couchClient.php";
	include "../lib/couchDocument.php";
}

$json = file_get_contents($couchUrl . '/whoami/facility'); 
$data = json_decode($json);
global $facilityId;
$facilityId = $data->facilityId;

error_reporting(E_ALL ^ E_NOTICE);
?>