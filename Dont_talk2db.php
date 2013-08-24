<?php


$server ="localhost";
$username ="root";
$password ="raspberry";
///$password ="";
date_default_timezone_set('UTC');
$dbhandle= mysql_connect($server,$username,$password) or die(mysql_error());
$selected = mysql_select_db("schoolBell",$dbhandle) or die (mysql_error());

function recordAction($action_by,$save_data){
	$save = mysql_query("INSERT INTO `action_log` (`colNum`, `person`, `action`, `dateTime`) VALUES (NULL, '".$action_by."', '".$save_data."', CURRENT_TIMESTAMP)");
	
}


function recordActionDate($action_by,$save_data,$systemDateForm){
	$save = mysql_query("INSERT INTO `action_log` (`colNum`, `person`, `action`, `dateTime`) VALUES (NULL, '".$action_by."', '".$save_data."','".$systemDateForm."')");
}

global $couchUrl;
$couchUrl = 'http://pi:raspberry@127.0.0.1:5984';

error_reporting(E_ERROR);


include "quotes.php";
include "lib/couch.php";
include "lib/couchClient.php";
include "lib/couchDocument.php";
/// for docs in pages directory
include "../lib/couch.php";
include "../lib/couchClient.php";
include "../lib/couchDocument.php";

global $facilityId;
global $config;
global $facility_data;
$facility_json = file_get_contents($couchUrl . '/whoami/facility'); 
$facility_data = json_decode($facility_json);
$config_json = file_get_contents($couchUrl . '/whoami/config'); 
$config = json_decode($config_json);
$facilityId = $facility_data->facilityId;

?>