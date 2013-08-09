Hello

<?php
/*/// Creating View
function(doc) {
if (doc.lastName == "Barikisu") {
  for ( var index in doc.lastName) {
	emit(doc.gender[index],null);
   }
  }
}*/
/*function(doc,memberLogin,memberpass) {
if (doc.login == memberLogin && doc.pass == memberpass) {
  for ( var index in doc.lastName) {
	emit(doc.gender[index],null);
   }
  }
}*/
require("lib/couch.php");
require("lib/couchClient.php");
require("lib/couchDocument.php");

global $couchUrl;
$couchUrl = 'http://127.0.0.1:5984';
$ConnMembers = new couchClient($couchUrl, 'members'); 
$view = $ConnMembers->getView("checkUserLogin","loginCheck");
foreach($view->rows as $row){
	echo $row->value->firstName;
}
//if($view->pass=="034")
//{
	//echo json_encode($view);
	//print_r($views);
//}
?>