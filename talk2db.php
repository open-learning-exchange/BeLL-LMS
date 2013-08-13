<?php



//
// CouchDB stuff, https://github.com/dready92/PHP-on-Couch
//

require_once 'app/vendor/php/PHP-on-Couch/lib/couch.php';
require_once 'app/vendor/php/PHP-on-Couch/lib/couchClient.php';
require_once 'app/vendor/php/PHP-on-Couch/lib/couchDocument.php';

global $db;
$db = new stdClass(); 
$db->couch_path = "http://raspberrypi.local:5984";

// A map for our databases
$db->databases = array(
  "bell_lcms" => "bell-lcms",
//  "bell_school" => "bell-school",
//  "bell_activity" => "bell-activity"
);

// Initialize the database clients
foreach($db->databases as $key => $value) {
  $db->$key = new couchClient($db->couch_path, $value);
}



//
// MySQL stuff
//

$server ="localhost";
$username ="root";
$password ="";

$dbhandle= mysql_connect($server,$username,$password) or die(mysql_error());
$selected = mysql_select_db("schoolBell",$dbhandle) or die (mysql_error());

function recordAction($action_by,$save_data){
	$save = mysql_query("INSERT INTO `action_log` (`colNum`, `person`, `action`, `dateTime`) VALUES (NULL, '".$action_by."', '".$save_data."','')");
}

function recordActionDate($action_by,$save_data,$systemDateForm){
	$save = mysql_query("INSERT INTO `action_log` (`colNum`, `person`, `action`, `dateTime`) VALUES (NULL, '".$action_by."', '".$save_data."','".$systemDateForm."')");
}

?>
