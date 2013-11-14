<?php
include "../secure/talk2db.php";
global $couchUrl;
global $facilityId;
global $config;
$feedbacks = new couchClient($couchUrl, "feedback");
$resources = new couchClient($couchUrl, "resources");
$exercises = new couchClient($couchUrl, "exercises");
$members = new couchClient($couchUrl, "members");
if(isset($_GET['id'])){
	$key = array($facilityId,$_GET['id']);
	$viewResults = $exercises->include_docs(TRUE)->key($key)->getView('api', 'facilityIdAssgnmentID');
	echo '<table width="550" border="1">
      <tr>
        <td width="373"  style="font-size: 14px; color: #009;">Student Full Name</td>
        <td width="80"  style="font-size: 14px; color: #009;"  align="center">Score </td>
        <td width="83"  style="font-size: 14px; color: #009;"  align="center">Date Taken</td>
      </tr>';
	 $displayCounter= 0;
	foreach($viewResults->rows as $row){
		$memberDoc = $members->getDoc($row->doc->memberId);
		if($displayCounter%2!=0){
		echo '<tr>
			<td  bgcolor="#FFFFCC">'.$memberDoc->lastName.' '.$memberDoc->middleNames.' '.$memberDoc->firstName.'</td>
			<td align="center" bgcolor="#FFFFCC">'.$row->doc->context->score.' / '.$row->doc->context->numberOfQuestions.'</td>
			<td  align="center"  bgcolor="#FFFFCC">'.date("Y-m-d",$row->doc->timestamp).'</td>
		  </tr>';
		}else{
			echo '<tr>
			<td >'.$memberDoc->lastName.' '.$memberDoc->middleNames.' '.$memberDoc->firstName.'</td>
			<td align="center">'.$row->doc->context->score.' / '.$row->doc->context->numberOfQuestions.'</td>
			<td  align="center">'.date("Y-m-d",$row->doc->timestamp).'</td>
		  </tr>';
		}
		$displayCounter++;
	}
	echo '</table>';
}
?>