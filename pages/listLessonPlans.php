<?php session_start();include "../secure/talk2db.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>OLE - Digital Lesson Note System</title>
<style type="text/css">
.prntTitle {
	font-size: 12px;
	font-weight: bold;
}
.content {
	font-size: 12px;
}
</style>
<?php 
global $couchUrl;
global $facilityId;
$lesson_notes = new couchClient($couchUrl, "lesson_notes");
$assignments = new couchClient($couchUrl, "assignments");
$resources = new couchClient($couchUrl, "resources");
$members = new couchClient($couchUrl, "members");
$groups = new couchClient($couchUrl, "groups");
$feedbacks = new couchClient($couchUrl, "feedback");
if(isset($_GET['clone'])){
	$lessonDoc = $lesson_notes->getDoc($_GET['clone']);
	unset($lessonDoc->_id,$lessonDoc->_rev);
	$returnedID = $lesson_notes->storeDoc($lessonDoc);
	//print_r($lesson_notes->doc);
	/////
	// Store resources in assignment for syncing
	for($cnt=0; $cnt<sizeof($lessonDoc->resources);$cnt++){
			$doc = new stdClass();
			$resID = $lessonDoc->resources[$cnt];
			$resDoc = $resources->getDoc($resID);
			$doc->kind = "Assignment";
			$doc->resourceId = $lessonDoc->resources[$cnt];
			$doc->startDate = $lessonDoc->execDate;
			$doc->endDate = $lessonDoc->execDate;
			$doc->context = array(
			  "subject" => $resDoc->subject,
			  "use" => "lesson note execution",
			  "groupId" => $lessonDoc->groupId,
			  "facilityId"=>$facilityId,
			  "lesson_noteId"=>$returnedID->id
			);
			$response = $assignments->storeDoc($doc);
	}
//	// store for feedback rating
	for($cnt=0; $cnt<sizeof($lessonDoc->resources);$cnt++){
			$doc = new stdClass();
			$resID = $lessonDoc->resources[$cnt];
			$resDoc = $resources->getDoc($resID);
			$groupDoc = $groups->getDoc($lessonDoc->groupId);
			$doc->kind ="Feedback";
			$doc->rating=0;
			$doc->comment="";
			$doc->facilityId=$facilityId;
			$doc->memberId =$_SESSION['lmsUserID'];
			$doc->resourceId =  $lessonDoc->resources[$cnt];
			$doc->timestamp = $lessonDoc->execDate;
			$doc->context = array(
			  "subject" => $resDoc->subject,
			  "use" => "lesson note execution",
			  "level" => $groupDoc->level[0],
			  "lesson_noteId"=>$returnedID->id
			);
			$response = $feedbacks->storeDoc($doc);
		}
//	
} else if(isset($_GET['delete'])){
	$lessonDoc = $lesson_notes->getDoc($_GET['delete']);
	$lesson_notes->deleteDoc($lessonDoc);
	
	// Remove recources from assignment database
		$the_key = array($facilityId,$_GET['delete']);
		$viewResults =$assignments->include_docs(TRUE)->key($the_key)->getView('api','facilityIdLesson_noteId');
		foreach($viewResults->rows as $row){
			$assignmentDoc = $assignments->getDoc($row->id);
			$assignments->deleteDoc($assignmentDoc);
		}	
		
	// Remove recources from feedback database
		$the_key = array($facilityId,$_GET['delete']);
		$viewResults =$feedbacks->include_docs(TRUE)->key($the_key)->getView('api','facilityIdLesson_noteId');
		///print_r($viewResults);
		foreach($viewResults->rows as $row){
			$feedbackDoc = $feedbacks->getDoc($row->id);
			$feedbacks->deleteDoc($feedbackDoc);
		}	
}


$start_key = array($facilityId,$_GET['memberId']);
$end_key = array($facilityId,$_GET['memberId']);
$viewResults =$lesson_notes->include_docs(TRUE)->startkey($start_key)->endkey($end_key)->getView('api','facilityIdMemberIdExecDate');

try{
	$memberDoc = $members->getDoc($_GET['memberId']);
}catch(Exception $err){
	
}
?>
</head>

<body>
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div class="clear"><span style="color:#00C; font-weight: bold;">Lesson Plans</span><br />
    <br />
  </div>
  <div style="float:none; margin-left:auto; margin-right:auto; width:600px; margin-left:auto; margin-right:auto;">
    <form action="" method="post" name="form1">
      <table align="center" cellpadding="3" cellspacing="2">
        <tr>
          <td colspan="3" valign="top" bgcolor="#FFFFFF" class="prntTitle">Name : <?php echo $memberDoc->firstName." ".$memberDoc->middleNames." ".$memberDoc->lastName;?></td>
          <td align="left" valign="top" bgcolor="#FFFFFF"><span class="prntTitle"><b>Class </b>:&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $memberDoc->levels[0];?></span></td>
        </tr>
        <tr>
          <td width="71" valign="top" bgcolor="#F4F4F4"><span class="prntTitle"><b class="prntTitle" id="prntTitle">Date</b></span></td>
          <td width="160" valign="top" bgcolor="#F4F4F4" class="content"><span class="prntTitle"><b>Topic</b></span></td>
          <td width="158" valign="top" bgcolor="#F4F4F4" class="content" style="font-weight: bold">Aspect</td>
          <td width="112" valign="top" bgcolor="#F4F4F4" class="content" style="font-weight: bold">Action</td>
        </tr>
        <?php
  foreach($viewResults->rows as $row) {
	  echo '<tr>
    <td valign="top" bgcolor="#FFFFFF"><span class="content">'.date('Y-m-d',$row->doc->execDate).'</span></td>
    <td valign="top" bgcolor="#FFFFFF" class="content">'.$row->doc->topic.'</td>
    <td valign="top" bgcolor="#FFFFFF" class="content">'.$row->doc->aspect.'</td>
  <td valign="top" bgcolor="#FFFFFF" class="content"><a href="edit_lessonPlan.php?lesson_noteId='.$row->doc->_id.'">edit</a> || <a href="listLessonPlans.php?clone='.$row->doc->_id.'&memberId='.$_GET['memberId'].'">clone</a> ||  <a href="listLessonPlans.php?delete='.$row->doc->_id.'&memberId='.$_GET['memberId'].'">delete</a></td>
  </tr>
  <tr>
    <td colspan="4"><hr /></td>
  </tr>';
  }
  ?>
      </table>
    </form>
  </div>
</div>
</body>

</html>