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
  <div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:550px; margin-left:auto; margin-right:auto;"><span style="color:#00C; font-weight: bold;">Teacher Resources</span> -<b> <a href="../Teacher_Resources/_" style="color: #CC0000">Click to Browse Main</a></b><br><br>
      <?php
	global $couchUrl;
	global $facilityId;
	$resources = new couchClient($couchUrl, "resources");
	$viewResults = $resources->include_docs(TRUE)->getView('api', 'allTeacherTraining');
	$colorCnt=0;
	echo '<table width="80%">';
	for($rcnt=0;$rcnt<sizeof($viewResults->rows);$rcnt++){
		$doc = $viewResults->rows[$rcnt]->doc;
		//echo "hello";
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
		 if($colorCnt%2==0){
echo '<tr>
	<td width="457" height="24"><span style="color: #900;font-weight:bold;">'.($colorCnt+1).'.   '.$doc->title.'</span>	<br>
		<span style="font-style:italic">'.$doc->description.'</span>
	</td>
	<td width="98"><input type="submit" class="button" value="'.$button.'" onclick=openRes("'.$doc->_id.'")>'.$image.'</td>
  </tr>';
		 }
		 else
		 {
			 echo '<tr bgcolor="#F0F0F0">
			<td width="457" height="24"><span style="color: #900;font-weight:bold;">'.($colorCnt+1).'.  '.$doc->title.'</span><br>
				<span style="font-style:italic">'.$doc->discription.'</span>
			</td>
			<td width="98"><input type="submit" class="button" value="'.$button.'" onclick=openRes("'.$doc->_id.'")>'.$image.'</td>
		  </tr>';
		 }
	}
	echo ' </table>';
      ?>
	</div>
<div class="clear"></div>
</div>
</body>
<script type="text/javascript">
function openRes(pNumber)
{
	var now = new Date()
	///now = now.toGMTString();
	var fmat= now.getFullYear()+'-'+ (now.getMonth()+1)+'-'+(now.getDay()+10)+' '+(now.getHours())+':'+(now.getMinutes())+':'+(now.getSeconds());
	window.open('viewResource.php?resid='+pNumber+'&systDate='+fmat); 
}
</script>
</html>