<?php session_start();include "../secure/talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<?php
if(isset($_GET['Delete']))
{
	global $couchUrl;
	$members = new couchClient($couchUrl, "members");
	$doc = $members->getDoc($_GET['Delete']);
	$members->deleteDoc($doc);
	
	recordActionObjectDate($_SESSION['lmsUserID'],"deleted student from system",$_GET['Delete'],$_GET['systDate']);
	
	echo '<script type="text/javascript">alert('.$doc->lastName.' '.$doc->middleNames.' '.$doc->firstName. ' deleted succesfully");</script>';
	die($doc->lastName.' '.$doc->middleNames.' '.$doc->firstName. ' deleted succesfully');
} else if (isset($_GET['Inactive']))
{
	global $couchUrl;
	$members = new couchClient($couchUrl, "members");
	$doc = $members->getDoc($_GET['Inactive']);
	$doc->status = "inactive";
	$members->storeDoc($doc);
	
	recordActionObjectDate($_SESSION['lmsUserID'],"made student from status inactive",$_GET['Delete'],$_GET['systDate']);
	
	echo '<script type="text/javascript">alert("'.$doc->lastName.' '.$doc->middleNames.' '.$doc->firstName.' status made inactive")</script>';
	echo ($doc->lastName.' '.$doc->middleNames.' '.$doc->firstName. '\'s status made inactive<br>');
}
else if (isset($_GET['Active']))
{
	global $couchUrl;
	$members = new couchClient($couchUrl, "members");
	$doc = $members->getDoc($_GET['Active']);
	$doc->status = "active";
	$members->storeDoc($doc);
	recordActionObjectDate($_SESSION['lmsUserID'],"made student from status active",$_GET['Delete'],$_GET['systDate']);
	
	echo '<script type="text/javascript">alert("'.$doc->lastName.' '.$doc->middleNames.' '.$doc->firstName.' status made inactive")</script>';
	echo ($doc->lastName.' '.$doc->middleNames.' '.$doc->firstName. '\'s status made active<br>');
}
?>

<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:550px; margin-left:auto; margin-right:auto;">
  <span style="color:#00C; font-weight: bold;">Manage Students</span><br><br>
<form name="form1" method="post" action="">
        <?php
global $couchUrl;
global $facilityId;
global $config;
$members = new couchClient($couchUrl, "members");
// Get members
for($cnt=0;$cnt<sizeof($config->levels);$cnt++){
	$start_key = array($facilityId,$config->levels[$cnt],"A");
	$end_key = array($facilityId,$config->levels[$cnt],"Z");
	if(isset($_GET['inactive']))
	{
		
		$viewResults = $members->include_docs(TRUE)->startkey($start_key)->endkey($end_key)->getView('api', 'facilityLevelInactive_allStudent_sorted');
		$docCounter=1;
		echo '<span style="font-size: 12px;">These are Inactive Students. <span style="color: #900;"><a href="delstudent.php"> Click here to view active students</a></span></span><br>';
		$action = 'Delete';
		$actionMsg = 'Delete';
		$edit = 'Active';
		$editMsg ='Set Active';
		$editLink = 'delstudent.php';
	}else{
		$viewResults = $members->include_docs(TRUE)->startkey($start_key)->endkey($end_key)->getView('api', 'facilityLevelActive_allStudent_sorted');
		echo '<span style="font-size: 12px;">These are Active Students. <span style="color: #900;"><a href="delstudent.php?inactive=true" >Click here to view inactive students</a></span></span><br>';
		$action ='Inactive';
		$actionMsg = 'Set Inactive';
		$edit = 'Edit';
		$editMsg ='Edit';
		$editLink = 'editStudent.php';

	}
		$docCounter=1;
		
		echo '<a name="'.$config->levels[$cnt].'"></a>
			<b>'.$config->levels[$cnt].'</b>
			<table class="data">
				<tr class="data">
						<th class="data" width="29">No</th>
						<th width="201" class="data">Name</th>
						<th width="50" class="data">Code</th>
						<th width="65" class="data">Gender</th>
						<th class="data" width="100">Ation</th>
			  </tr>';
		foreach($viewResults->rows as $row) {
			 if($docCounter%2==0)
			 {
					echo '<tr class="data">
					<td class="data" width="29">'.$docCounter.'</td>
					<td class="data">'.$row->doc->lastName.' '.$row->doc->middleNames.' '.$row->doc->firstName.'</td>
					<td class="data">'.$row->doc->pass.'</td>
					<td class="data">'.$row->doc->gender.'</td>
					<td class="data" width="100"><center><a href="delstudent.php?'.$action.'='.$row->id.'" >'.$actionMsg.'</a>&nbsp;&nbsp; ||&nbsp;&nbsp;<a href="'.$editLink.'?'.$edit.'='.$row->id.'" >'.$editMsg.'</a> </td></center></td>
				</tr>';
			 } else {
					echo '<tr class="data" bgcolor="#EEEEEE">
					<td class="data" width="29">'.$docCounter.'</td>
					<td class="data">'.$row->doc->lastName.' '.$row->doc->middleNames.' '.$row->doc->firstName.'</td>
					<td class="data">'.$row->doc->pass.'</td>
					<td class="data">'.$row->doc->gender.'</td>
					<td class="data" width="100"><center><a href="delstudent.php?'.$action.'='.$row->id.'" >'.$actionMsg.'</a>&nbsp;&nbsp; ||&nbsp;&nbsp;<a href="'.$editLink.'?'.$edit.'='.$row->id.'" >'.$editMsg.'</a> </td></center></td>
				</tr>';
			 }
			 $docCounter++;
		}
		echo '</table>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<a href="#top"><span style="font-size: 12px; color: #900;"> ^ go to the top ^ </a> </span><br><br>';
}
?>
        
      </table>
</form>
  </div>
<div class="clear"></div>
</div>
</body>
</html>