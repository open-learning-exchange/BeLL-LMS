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
          		<td colspan="4" align="left"><b>'.($dispCnt).'. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
				<select name="story[]" id="story'.($dispCnt).'. ">
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
else if(isset($_GET['sLevel'])){
	$language = $_GET['sLanguage'];
	$level = $_GET['sLevel'];
	$subject = $_GET['sSubject'];
	global $couchUrl;
	global $facilityId;
	$resources = new couchClient($couchUrl, "resources");
	$viewResults = $resources->include_docs(TRUE)->getView('api', 'allResources');
	$colorCnt=0;
	echo '<table width="95%">';
	for($rcnt=0;$rcnt<sizeof($viewResults->rows);$rcnt++){
		$doc = $viewResults->rows[$rcnt]->doc;
		//echo "hello";
		if($doc->language==$language && $doc->subject==$subject && in_array($level,$doc->levels)){
			if($doc->legacy->type=='mp3'){
				 $image='<img src="../images/audio.png" width="15" height="15">';
				 $button="Listen";
			 }
			 else if($doc->legacy->type=='mp4'||$doc->legacy->type=='avi'||$doc->legacy->type=='flv'){
				 $image='<img src="../images/video.png" width="18" height="18">';
				 $button="Watch";
			 }
			 else{
				 $image='<img src="../images/pdf.png" width="18" height="18">';
				 $button="Read";
			 }
			 // Display row color for easy location of specific rows
			 if($colorCnt%2==0){
				 echo '
				  <tr>
				<td width="457" height="24"><span style="color: #900;font-weight:bold;">'.($colorCnt+1).'.   '.$doc->title.'</span><br>
					<span style="font-style:italic">'.$doc->discription.'</span>
				</td>
				<td width="98"><input type="submit" class="button" value="'.$button.'" onclick=openRes("'.$doc->_id.'")>'.$image.'</td>
			  </tr>';
			 }else{
				 echo '<tr bgcolor="#F0F0F0">
			<td width="457" height="24"><span style="color: #900;font-weight:bold;">'.($colorCnt+1).'.   '.$doc->title.'</span><br>
				<span style="font-style:italic">'.$doc->discription.'</span>
			</td>
			<td width="98"><input type="submit" class="button" value="'.$button.'" onclick=openRes("'.$doc->_id.'")>'.$image.'</td>
		  </tr>';
			 }
			 $colorCnt++;
		}
	}
	echo ' </table>';
}
?>