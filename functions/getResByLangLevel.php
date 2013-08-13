<?php
include "../secure/talk2db.php";
if(isset($_GET['lang'])){
	$language = $_GET['lang'];
	$level = $_GET['level'];
	global $couchUrl;
	global $facilityId;
	$resources = new couchClient($couchUrl, "resources");
	$viewResults = $resources->include_docs(TRUE)->getView('api', 'allResources');
	echo '<table width="95%">';
	for($dispCnt =1;$dispCnt<=4;$dispCnt++){
		echo ' <tr>
          		<td colspan="4" align="left"><b>'.($dispCnt+1).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
				<select name="story[]" id="story'.($dispCnt+1).'">
				<option value="none" selected >none</option>';
				for($rcnt=0;$rcnt<sizeof($viewResults->rows);$rcnt++){
					$doc = $viewResults->rows[$rcnt]->doc;
					if($doc->language==$language && in_array($level,$doc->levels)){
						echo '<option value="'.$doc->_id.'">'.$doc->title.'</option>';
					}
				}
		echo '</select>
		</td>
        </tr>';
	}
	echo ' </table>';
}
else if(isset($_GET['grade'])){
	global $couchUrl;
	global $facilityId;
	$groups = new couchClient($couchUrl, "groups");
	$doc = $groups->getDoc($_GET['grade']);
	///print_r($doc->level);
	$gobackArr = array();
	$gobackArr[] = array(
	'level'=>$doc->level
	);
	$obj['gobackArr'] = $gobackArr;
    echo json_encode($obj);
}
?>