<?php session_start();include "../secure/talk2db.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jsDatePick.min.1.3.js"></script>
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
</head>

<body>
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div class="clear"><span style="color:#00C; font-weight: bold;">Excercises Assigned to students</span><br />
    <br />
  </div>
  <div style="float:none; margin-left:auto; margin-right:auto; width:600px; margin-left:auto; margin-right:auto;">
<form action="" method="post" name="form1">
  <table width="569" border="0" align="center" class="prntTitle">
    <tr>
    <td width="116">&nbsp;</td>
    <td width="437">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center">Task Title and Date
      <select name="assignmetId" id="assignmetId" onchange="getResults()">
      <option value="none">none</option>
        <?php
	global $couchUrl;
	global $facilityId;
	$feedbacks = new couchClient($couchUrl, "feedback");
	$resources = new couchClient($couchUrl, "resources");
	$assignments = new couchClient($couchUrl, "assignments");
	$key=array($facilityId,$_GET['memberId']);
	$asssignemt_viewResults = $assignments->include_docs(TRUE)->key($key)->getView('api', 'facilityIdMemberId');
	foreach($asssignemt_viewResults->rows as $row) {
		if($row->doc->context->use=="video book task"){
			$doc = $resources->getDoc($row->doc->resourceId);
			$titleDate = $doc->title."   ( ".date("Y-m-d",$row->doc->startDate)." )";
			echo '<option value="'.$row->doc->_id.'">'.$titleDate.'</option>';
		}
	}
	?>
      </select></td>
    </tr>
  <tr>
    <td colspan="2">
    <p id="results"></p></td>
  </tr>
  </table>
</form>
  </div>
</div>
</body>
<script type="text/javascript">
function getResults(){
	var assignmentId = document.getElementById("assignmetId").value;
	if(assignmentId!="none"){
		$("#results").load("../functions/getVBookTaskresult.php?id="+assignmentId+"");
	}
}
</script>
</html>