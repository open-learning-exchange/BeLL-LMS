<?php session_start(); error_reporting(1);include "../secure/talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>


<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:550px; margin-left:auto; margin-right:auto;"><span style="color:#00C; font-weight: bold;">Student usage feedback</span> - &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="javascript:window.print()" style="color: #CC0000">|| Print Page ||</A><br><br>
<br>
<br>
<?php
global $couchUrl;
global $config;
for($cnt=0;$cnt<sizeof($config->levels);$cnt++){
	echo '&nbsp;&nbsp;&nbsp;<a href="#'.$config->levels[$cnt].'">'.$config->levels[$cnt].' </a>&nbsp;||&nbsp;';
}
echo "<br>
<br>";
?>
</h4>
<?php
global $couchUrl;
global $facilityId;
global $config;
$members = new couchClient($couchUrl, "members");
$actions = new couchClient($couchUrl, "actions");
// Get members
for($cnt=0;$cnt<sizeof($config->levels);$cnt++){
		$start_key = array($facilityId,$config->levels[$cnt],"A");
		$end_key = array($facilityId,$config->levels[$cnt],"Z");
		$viewResults = $members->include_docs(TRUE)->startkey($start_key)->endkey($end_key)->getView('api', 'facilityLevelActive_allStudent_sorted');
		$docCounter=1;
		echo '<a name="'.$config->levels[$cnt].'"></a>
			<b>'.$config->levels[$cnt].'</b>
			<table class="data">
				<tr class="data">
						<th class="data" width="29">No</th>
						<th width="201" class="data">Name</th>
						<th width="50" class="data">Gender</th>
						<th width="65" class="data">Total Usage</th>
						<th class="data" width="89">Last Time Used</th>
			  </tr>';
		foreach($viewResults->rows as $row) {
			$action_key = array($row->doc->_id,$facilityId,"used resource on tablet");
			$actionViewResults = $actions->include_docs(TRUE)->key($action_key)->getView('api', 'memIdFacilityIdActionTime');
			$totalNoUsed = 0;
			$lastTimeUsed= 0;
			foreach($actionViewResults->rows as $action_row) {
				if($lastTimeUsed < $action_row->doc->timestamp){
					$lastTimeUsed = $action_row->doc->timestamp;
				}
				$totalNoUsed++;
			}
			if(date('Y-m-d',$lastTimeUsed) < date('2000-09-10')){
				$lastTimeUsed = " - ";
			} else {$lastTimeUsed = date('Y-m-d',$lastTimeUsed); }
			 if($docCounter%2==0)
			 {
					echo '<tr class="data">
					<td class="data" width="29">'.$docCounter.'</td>
					<td class="data">'.$row->doc->lastName.' '.$row->doc->middleNames.' '.$row->doc->firstName.'</td>
					<td class="data">'.$row->doc->gender.'</td>
					<td class="data">'.$totalNoUsed.'</td>
					<td class="data" width="89"><center>'.$lastTimeUsed.'</center></td>
				</tr>';
			 } else {
					echo '<tr class="data" bgcolor="#EEEEEE">
					<td class="data" width="29">'.$docCounter.'</td>
					<td class="data">'.$row->doc->lastName.' '.$row->doc->middleNames.' '.$row->doc->firstName.'</td>
					<td class="data">'.$row->doc->gender.'</td>
					<td class="data">'.$totalNoUsed.'</td>
					<td class="data" width="89"><center>'.$lastTimeUsed.'</center></td>
				</tr>';
			 }
			 $docCounter++;
		}
		echo '</table>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<a href="#top"><span style="font-size: 12px; color: #900;"> ^ go to the top ^ </a> </span><br><br>';
}
?>
  </div>
<div class="clear"></div>
</div>
</body>
<script type="text/javascript">
function openRes(pNumber)
{
	window.open('viewResource.php?resid='+pNumber);
	///alert('Yes'); 
}
</script>
</html>