<?php session_start();include "../secure/talk2db.php";?>
<table width="427" border="0" cellpadding="2" cellspacing="2"  style="color:#FFF;">
  <tr>
    <td width="31" bgcolor="#3366FF">Add</td>
    <td width="294" bgcolor="#3366FF">Question</td>
    <td width="82" bgcolor="#3366FF">Answer</td>
  </tr>
  <?php
  global $couchUrl;
	global $facilityId;
	$numberOfUsedRes=0;
	$resources = new couchClient($couchUrl, "resources");
	$resDoc = $resources->getDoc($_GET['id']);
	//$numberOfQuestions = count($resDoc->questions);
	$question="";
	$Quencnt=0;
	foreach($resDoc->questions as $questn){
		$question = key($questn);
		foreach($questn as $answer){
			//echo key($answer)." => answer <br />";
				//foreach($answer as $possibles){
					///for($counter = 0; $counter<4;$counter++){
					//	echo $possibles[$counter]." <br />";
						echo '<tr>
							<td bgcolor="#3366FF"><span class="clear" style="font-size: 14px; color: #00C; text-align:center;">
							  <input name="vbQ[]" type="checkbox" id="vbQ'.$Quencnt.'" value="'.$Quencnt.'">
							</span></td>
							<td bgcolor="#3366FF">'.$question.'</td>
							<td bgcolor="#3366FF">'.key($answer).'</td>
						  </tr>';
				//	}
			//}
			$Quencnt++;
			
		}
	}
?>
</table>
