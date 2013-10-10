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
	$lesson_notes->storeDoc($lessonDoc);
	
} else if(isset($_GET['delete'])){
	$lessonDoc = $lesson_notes->getDoc($_GET['delete']);
	$lesson_notes->deleteDoc($lessonDoc);
	
}

//global $config;
//$memberIdArray = array();
//for($cnt=0;$cnt<sizeof($config->levels);$cnt++){
//		$start_key = array($facilityId,$config->levels[$cnt]);
//		$end_key = array($facilityId,$config->levels[$cnt]);
//		$viewResults = $groups->include_docs(TRUE)->startkey($start_key)->endkey($end_key)->getView('api', 'facilityLevelActive_allStudent_sorted');
//		array_push($memberIdArray,"");
//}
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
          <td colspan="3" valign="top" class="prntTitle">&nbsp;</td>
          <td align="left" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td width="71" valign="top" bgcolor="#F4F4F4"><span class="prntTitle"><b class="prntTitle" id="prntTitle">Date</b></span></td>
          <td width="160" valign="top" bgcolor="#F4F4F4" class="content"><span class="prntTitle"><b>Teacher's Name</b></span></td>
          <td width="158" valign="top" bgcolor="#F4F4F4" class="content" style="font-weight: bold">Aspect</td>
          <td width="112" valign="top" bgcolor="#F4F4F4" class="content" style="font-weight: bold">Action</td>
        </tr>
 <?php
	global $config;
	$groups_viewResults = $groups->include_docs(TRUE)->key($facilityId)->getView('api','allGroupsInFacility');
	foreach($groups_viewResults->rows as $row) {
		$start_key = array($facilityId,$row->doc->_id);
		$end_key = array($facilityId,$row->doc->_id);
		$viewResults =$lesson_notes->include_docs(TRUE)->startkey($start_key)->endkey($end_key)->getView('api','facilityIdGroupId');
			///$memberDoc = $members->getDoc($_GET['memberId']);
		foreach($viewResults->rows as $row) {
	  echo '<tr>
    <td valign="top" bgcolor="#FFFFFF"><span class="content">'.date('Y-m-d',$row->doc->execDate).'</span></td>
    <td valign="top" bgcolor="#FFFFFF" class="content">'.$row->doc->topic.'</td>
    <td valign="top" bgcolor="#FFFFFF" class="content">'.$row->doc->aspect.'</td>
  <td valign="top" bgcolor="#FFFFFF" class="content"> <a href="edit_lessonPlan.php?lesson_noteId='.$row->doc->_id.'">Add Remark</a>&nbsp;&nbsp;  ||&nbsp;&nbsp;&nbsp; <a href="printLessonPlan.php?lesson_noteId='.$row->doc->_id.'">View </a></td>
  </tr>
  <tr>
    <td colspan="4"><hr /></td>
  </tr>';
  			}
			
	}
		

  
  ?>
      </table>
    </form>
  </div>
</div>
</body>

</html>