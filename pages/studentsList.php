<?php session_start();include "../secure/talk2db.php"; //error_reporting(1);?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
</head>
<body>
<div id="wrapper"  style="background-color:#FFF; width:600px;"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span style="text-align: right; font-size: 12px; color: #000;"><a href="#">|| click here to print this page ||</a></span>
<div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:550px; margin-left:auto; margin-right:auto;">
  <a name="top"></a><h4>
<?php
global $couchUrl;
global $config;
for($cnt=0;$cnt<sizeof($config->levels);$cnt++){
	echo '&nbsp;&nbsp;&nbsp;<a href="#'.$config->levels[$cnt].'">'.$config->levels[$cnt].' </a>&nbsp;||&nbsp;';
}
?>
</h4>
<?php
global $couchUrl;
global $facilityId;
global $config;
$members = new couchClient($couchUrl, "members");
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
						<th width="50" class="data">Code</th>
						<th width="65" class="data">Gender</th>
						<th class="data" width="89">Class / Level</th>
			  </tr>';
		foreach($viewResults->rows as $row) {
			 if($docCounter%2==0)
			 {
					echo '<tr class="data">
					<td class="data" width="29">'.$docCounter.'</td>
					<td class="data">'.$row->doc->lastName.' '.$row->doc->middleNames.' '.$row->doc->firstName.'</td>
					<td class="data">'.$row->doc->pass.'</td>
					<td class="data">'.$row->doc->gender.'</td>
					<td class="data" width="89"><center>'.$config->levels[$cnt].'</center></td>
				</tr>';
			 } else {
					echo '<tr class="data" bgcolor="#EEEEEE">
					<td class="data" width="29">'.$docCounter.'</td>
					<td class="data">'.$row->doc->lastName.' '.$row->doc->middleNames.' '.$row->doc->firstName.'</td>
					<td class="data">'.$row->doc->pass.'</td>
					<td class="data">'.$row->doc->gender.'</td>
					<td class="data" width="89"><center>'.$config->levels[$cnt].'</center></td>
				</tr>';
			 }
			 $docCounter++;
		}
		echo '</table>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<a href="#top"><span style="font-size: 12px; color: #900;"> ^ go to the top ^ </a> </span><br><br>';
}
?></div>
<div class="clear"></div>
</div>
</body>
<script type="text/javascript">
var TRange=null;

function findString (str) {
 if (parseInt(navigator.appVersion)<4) return;
 var strFound;
 if (window.find) {

  // CODE FOR BROWSERS THAT SUPPORT window.find

  strFound=self.find(str);
  if (!strFound) {
   strFound=self.find(str,0,1);
   while (self.find(str,0,1)) continue;
  }
 }
 else if (navigator.appName.indexOf("Microsoft")!=-1) {

  // EXPLORER-SPECIFIC CODE

  if (TRange!=null) {
   TRange.collapse(false);
   strFound=TRange.findText(str);
   if (strFound) TRange.select();
  }
  if (TRange==null || strFound==0) {
   TRange=self.document.body.createTextRange();
   strFound=TRange.findText(str);
   if (strFound) TRange.select();
  }
 }
 else if (navigator.appName=="Opera") {
  alert ("Opera browsers not supported, sorry...")
  return;
 }
 if (!strFound) alert ("String '"+str+"' not found!")
 return;
}
</script>
</html>