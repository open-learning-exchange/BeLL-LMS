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
$lessonDoc = $lesson_notes->getDoc($_GET['lesson_noteId']);
$groupDoc = $groups->getDoc($lessonDoc->groupId);
try{
	$memberDoc = $members->getDoc($lessonDoc->memberId);
}catch(Exception $err){
	
}
///print_r($lessonDoc);
?>
</head>

<body>
<table align="center" cellpadding="3" cellspacing="2">
  <tr>
    <td colspan="2" valign="top" class="prntTitle">Name :  <?php echo $memberDoc->firstName." ".$memberDoc->middleNames." ".$memberDoc->lastName;?></td>
    <td width="145" align="left" valign="top"><span class="prntTitle"><b>Class </b>: <?php echo $groupDoc->name;?></span></td>
</tr>
  <tr>
    <td width="143" valign="top" bgcolor="#F4F4F4"><span class="prntTitle"><b class="prntTitle" id="prntTitle">Date</b></span></td>
    <td colspan="2" valign="top" bgcolor="#F4F4F4" class="content"><?php echo date('Y-m-d',$lessonDoc->execDate)?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F4F4F4"><span class="prntTitle"><b>Subject</b></span></td>
    <td colspan="2" valign="top" bgcolor="#F4F4F4" class="content"><?php echo $lessonDoc->subject;?></td>
</tr>
  <tr>
    <td valign="top" bgcolor="#F4F4F4"><span class="prntTitle"><b>References</b></span></td>
    <td colspan="2" valign="top" bgcolor="#F4F4F4" class="content"><?php echo $lessonDoc->references;?></td>
</tr>
  <tr>
    <td valign="top" bgcolor="#F4F4F4"><span class="prntTitle"><b>Time</b></span></td>
    <td colspan="2" valign="top" bgcolor="#F4F4F4" class="content"><?php echo $lessonDoc->execTime;?></td>
</tr>
  <tr>
    <td valign="top" bgcolor="#F4F4F4"><span class="prntTitle"><b>Duration</b></span></td>
    <td colspan="2" valign="top" bgcolor="#F4F4F4" class="content"><?php echo $lessonDoc->duration;?></td>
</tr>
  <tr>
    <td valign="top" bgcolor="#F4F4F4"><span class="prntTitle"><b>Topic</b></span></td>
    <td colspan="2" valign="top" bgcolor="#F4F4F4" class="content"><?php echo $lessonDoc->topic;?></td>
</tr>
  <tr>
    <td valign="top" bgcolor="#F4F4F4"><span class="prntTitle"><b>Sub -Topic</b></span></td>
    <td colspan="2" valign="top" bgcolor="#F4F4F4" class="content"><?php echo $lessonDoc->subTopic;?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F4F4F4"><span class="prntTitle"><b>Aspect</b></span></td>
    <td colspan="2" valign="top" bgcolor="#F4F4F4" class="content"><?php echo $lessonDoc->aspect;?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F4F4F4"><span class="prntTitle"><b>Objective(s)</b></span></td>
    <td colspan="2" valign="top" bgcolor="#F4F4F4" class="content"><?php echo $lessonDoc->objectives;?></td>
</tr>
  <tr>
    <td valign="top" bgcolor="#F4F4F4"><span class="prntTitle"><b>RPK</b></span></td>
    <td colspan="2" valign="top" bgcolor="#F4F4F4" class="content"><?php echo $lessonDoc->rpk;?></td>
</tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2" valign="top" class="content">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" valign="top"><span class="prntTitle"><b>T &amp; L resources selcted from BeLL</b></span></td>
  </tr>
  <?php
  for($cnt=0; $cnt<sizeof($lessonDoc->resources);$cnt++){
		$resourceDoc = $resources->getDoc($lessonDoc->resources[$cnt]);
		echo '<tr>
    <td colspan="3" align="left" valign="top" class="content"  bgcolor="#F4F4F4" ><span class="prntTitle"><b>'.($cnt+1).') &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></span>'.$resourceDoc->title.'</td>
  </tr>';
	}
	
  ?>
  
  <tr>
    <td colspan="3" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" valign="top"><span class="prntTitle"><b>T &amp; L resources selcted from outside the BeLL</b></span></td>
  </tr>
   <?php
  for($cnt=0; $cnt<sizeof($lessonDoc->resOutsideBell);$cnt++){
	  echo '<tr>
    <td colspan="3" align="left" valign="top" class="content"  bgcolor="#F4F4F4" ><span class="prntTitle"><b>'.($cnt+1).') &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></span>'.$lessonDoc->resOutsideBell[$cnt].'</td>
  </tr>';
	}
  ?>
  <tr>
    <td colspan="3" align="center" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" valign="top"><span class="prntTitle"><b>Proposed Technology tools to be used in the lesson</b></span></td>
  </tr>
   <?php
  for($cnt=0; $cnt<sizeof($lessonDoc->techTools);$cnt++){
	  echo '<tr>
    <td colspan="3" align="left" valign="top" class="content"  bgcolor="#F4F4F4" ><span class="prntTitle"><b>'.($cnt+1).') &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></span>'.$lessonDoc->techTools[$cnt].'</td>
  </tr>';
	}
  ?>
  <tr>
    <td colspan="3" align="center" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><span class="prntTitle"><b>Core Points / Literacy Skill to be developed</b></span></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top" bgcolor="#F4F4F4"><span class="content"><?php echo  $lessonDoc->corePoints;?></span></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><span class="prntTitle"><b style="color: #666; font-weight: normal; font-style: italic;">Teaching and Learning Activities (include 1) how RPK will be used <br />
    2) how technology selected will be used <br />
    3) 21st century skills that would be used in the teaching to make it fun, participatory and self- discovery)</b></span></td>
  </tr>
  <tr>
    <td align="left" valign="top"><span class="prntTitle"><b>Introduction</b></span></td>
    <td colspan="2" valign="top" class="content">&nbsp;</td>
</tr>
  <tr>
    <td colspan="3" align="left" valign="top" bgcolor="#F4F4F4"><span class="content"><?php echo $lessonDoc->introduction;?></span></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><span class="prntTitle"><b>Pre –Writing / Reading Stage</b></span></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top" bgcolor="#F4F4F4"><span class="content"><?php echo $lessonDoc->preStage;?></span></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><span class="prntTitle"><b>Writing / Reading Stage</b></span></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top" bgcolor="#F4F4F4"><span class="content"><?php echo $lessonDoc->stage;?></span></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><span class="prntTitle"><b>Post – Writing / Reading Stage</b></span></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top" bgcolor="#F4F4F4"><span class="content"><?php echo $lessonDoc->postStage;?></span></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><span class="prntTitle"><b>Conclusion</b></span></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top" bgcolor="#F4F4F4"><span class="content"><?php echo $lessonDoc->conclusion;?></span></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><span class="prntTitle"><b style="color:#666;">Evaluation Exercises</b></span></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><span class="prntTitle"><b>Low Order Thinking Questions</b></span></td>
  </tr>
   <?php
  for($cnt=0; $cnt<sizeof($lessonDoc->lowThinking);$cnt++){
	  echo '<tr>
    <td colspan="3" align="left" valign="top" class="content"  bgcolor="#F4F4F4" ><span class="prntTitle"><b>'.($cnt+1).') &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></span>'.$lessonDoc->lowThinking[$cnt].'</td>
  </tr>';
	}
  ?>
  <tr>
    <td colspan="3" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><span class="prntTitle"><b>High Order Thinking Questions</b></span></td>
  </tr>
   <?php
  for($cnt=0; $cnt<sizeof($lessonDoc->highThinking);$cnt++){
	  echo '<tr>
    <td colspan="3" align="left" valign="top" class="content"  bgcolor="#F4F4F4" ><span class="prntTitle"><b>'.($cnt+1).') &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></span>'.$lessonDoc->highThinking[$cnt].'</td>
  </tr>';
	}
  ?>
  <tr>
    <td align="right" valign="top">&nbsp;</td>
    <td colspan="2" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><span class="prntTitle"><b>Remarks on the teaching done / observed by the following</b></span></td>
  </tr>
  <tr>
    <td align="left" valign="top"><span class="prntTitle"><b>Teacher</b></span></td>
    <td colspan="2" valign="top" class="content"><br /></td>
</tr>
  <tr>
    <td colspan="3" align="left" valign="top" bgcolor="#F4F4F4"><span class="content"><?php echo $lessonDoc->remarks->teacher;?></span></td>
  </tr>
  <tr>
    <td align="left" valign="top"><span class="prntTitle"><b>Head</b></span></td>
    <td colspan="2" valign="top" class="content"><br /></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top" bgcolor="#F4F4F4"><span class="content"><?php echo $lessonDoc->remarks->headteacher;?></span></td>
  </tr>
  <tr>
    <td align="left" valign="top"><span class="prntTitle"><b>Coach</b></span></td>
    <td colspan="2" valign="top" class="content"><br /></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top" bgcolor="#F4F4F4"><span class="content"><?php echo $lessonDoc->remarks->coach;?></span></td>
  </tr>
  <tr>
    <td></td>
    <td width="143"><input type="hidden" name="systemDateForm" id="systemDateForm" /></td>
    <td><input name="Button" type="button" class="button" value="Print now" onclick="window.print()" style="width:100px;" /></td>
  </tr>
</table>
</body>

</html>