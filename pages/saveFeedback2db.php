<?php session_start(); include "../secure/talk2db.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Open Learning Exchange - Ghana</title>
</head>
<body>
<?php
$feedStatus ="Feedback already saved. Please ensure syncing of tablets are completed before 'Saving Feedback' ";
$counter=1;
global $facilityId;
global $couchUrl;
$todayDate = date("Y-m-d H:i:s"); 
$actions = new couchClient($couchUrl, "actions");
$exercises = new couchClient($couchUrl, "exercises");

// @ save usage data from tablet into database and delete file from server
if ($handle = opendir('../feedbacks/tabletUsage/')) {
	$files = glob('../feedbacks/tabletUsage/*'); 
	foreach($files as $file){ 
	  if(is_file($file)){
		  $feed = file_get_contents($file);
		  $xml = new SimpleXmlElement($feed);
		  foreach ($xml->usage as $entry){
			  $memberId =$entry->fbstudentID."";
			  $objectUsed = $entry->fbresourceID."";
			  $dateUsed = $entry->fbdate."";
			  $doc = new stdClass();
			  $doc->kind ="Action";
			  $doc->memberId = $memberId;
			  $doc->memberRoles = array("student");
			  $doc->facilityId = $facilityId;
			  $doc->action = "used resource on tablet";
			  $doc->objectId= $objectUsed;
			  $doc->timestamp= strtotime($dateUsed);
			  $doc->context= "tablet";
			  $response = $actions->storeDoc($doc);
		  }
		  echo $counter.".  Saved usage data from tablet with serial ".basename($file,".xml")."<br />";
		  $counter++;
		  unlink($file);
	 }
 	recordActionObject($_SESSION['lmsUserID'],"Saved tablet usage data into database","");
   }
} else {
	 echo " System cant save tablet usage data ";
}

// @ save assignemt result from tablet into database and delete file from server
$counter=1;
if ($handle = opendir('../feedbacks/videoBook/')) {
	$files = glob('../feedbacks/videoBook/*'); 
	foreach($files as $file){ 
	  if(is_file($file)){
		  ///echo basename($file,".xml")."<br />";
		  $feed = file_get_contents($file);
		  $xml_vd = new SimpleXmlElement($feed);
		  foreach ($xml_vd->exercise as $entry){
			  $memberId = $entry->studId."";
			  $resourceId = $entry->resourceId."";
			  $assignmentId = $entry->assignmentId."";
			  $score = $entry->score."";
			  $numberOfQuestions = $entry->numberOfQuest."";
			  $dateTaken = $entry->dateTaken."";
			  
			  $doc = new stdClass();
			  $doc->kind ="Exercise";
			  $doc->memberId = $memberId;
			  $doc->memberRoles = array("student");
			  $doc->facilityId = $facilityId;
			  $doc->type = "video lesson";
			  $doc->assignmentId= $assignmentId;
			  $doc->timestamp= strtotime($dateTaken);
			  $doc->context= array("resourceId"=>$resourceId,
			  "score"=>$score,
			  "numberOfQuestions"=>$numberOfQuestions);
			  $response = $exercises->storeDoc($doc);
		  }
		  echo "Saved ".$counter." exercise result from tablet <br />";
		  $counter++;
		  unlink($file);
	 }
 	recordActionObject($_SESSION['lmsUserID'],"Saved exercises result from tablet into database","");
   }
} else {
	 echo " System cant save tablet usage data ";
}
?>
</body>
</html>