<?php
global $studentIDs;
global $MasterstudentIDs;
global $resourceArray;
global $videoBookResArray;
global $couchUrl;
$resourceArray = array();
$MasterstudentIDs =array();
$videoBookResArray= array();


if(isset($_POST['dateFrom']))
{
echo "<br /> *************************************************************** <br />
Preparing System for Sync Process<br />";
// Delet all files from the resorces folder
$files = glob('../resources/*'); // get all file names
foreach($files as $file){ 
  if(is_file($file))
    unlink($file); // delete file
}
$files = glob('../transferData/studentsRecords/*'); // get all file names
foreach($files as $file){ 
  if(is_file($file))
    unlink($file); // delete file
}
$files = glob('../transferData/readWide/*'); // get all file names
foreach($files as $file){ 
  if(is_file($file))
    unlink($file); // delete file
}
$files = glob('../transferData/videoBook/*'); // get all file names
foreach($files as $file){ 
  if(is_file($file))
    unlink($file); // delete file
}


///// begin function for compiling students ////start_key=["test","z"]&end_key=["test","a"]
function compileClass($theClass)
{	
echo "Processing student details for ".$theClass." <br />";
global $couchUrl;
global $facilityId;
global $config;
$studentIDs= array();
$members = new couchClient($couchUrl, "members");
$start_key = array($facilityId,$theClass,"A");
$end_key = array($facilityId,$theClass,"Z");
$viewResults = $members->include_docs(TRUE)->startkey($start_key)->endkey($end_key)->getView('api', 'facilityLevelActive_allStudent_sorted');
$docCounter=1;
$dataBody ='<?xml version="1.0" encoding="UTF-8"?>
<!--
    Document   : '.$theClass.'.xml
    Author     : Open Learning Exchange
-->
<allstudent>';
$studentCode ="";
foreach($viewResults->rows as $row) {
	if(trim($row->doc->pass)==""){
		$studentCode = "000";
	} else {
		$studentCode = $row->doc->pass;
	}
$dataBody = $dataBody.'
<student>
<name>'.$row->doc->lastName.' '.$row->doc->middleNames.' '.$row->doc->firstName.'</name>
<bcode>'.$studentCode.'</bcode>
<stuId>'.$row->doc->_id.'</stuId>
</student>';
array_push($studentIDs,$row->doc->_id);

}

if($theClass=="KG1"){
$studentCode ="";
$start_key = array($facilityId,'KG2',"A");
$end_key = array($facilityId,'KG2',"Z");
$viewResults = $members->include_docs(TRUE)->startkey($start_key)->endkey($end_key)->getView('api', 'facilityLevelActive_allStudent_sorted');
foreach($viewResults->rows as $row) {
  if(trim($row->doc->pass)==""){
	  $studentCode = "000";
  } else {
	  $studentCode = $row->doc->pass;
  }
$dataBody = $dataBody.'
<student>
<name>'.$row->doc->lastName.' '.$row->doc->middleNames.' '.$row->doc->firstName.'</name>
<bcode>'.$studentCode.'</bcode>
<stuId>'.$row->doc->_id.'</stuId>
</student>';
array_push($studentIDs,$row->doc->_id);
}
$theClass="KG";
}
 $dataBody=$dataBody.'
</allstudent>';
 $myFile = "../transferData/studentsRecords/".$theClass.".xml";
$fh = fopen($myFile, 'w') or die("can't open file");
fwrite($fh,$dataBody);
fclose($fh);
chmod($fh,777);
echo "Successfully processed data for  ".$theClass." <br />";
return $studentIDs;

}
//// end function /////


///// begin function for readable resources////
function compileResources($memberID)
{	
global $couchUrl;
global $facilityId;
global $config;
$groups = new couchClient($couchUrl, "groups");
$assignments = new couchClient($couchUrl, "assignments");
$resources = new couchClient($couchUrl, "resources");
$start_key = array($facilityId,$memberID);
$viewResults = $groups->key($start_key)->getView('api', 'facilityWithMemberID');
$dataBody ='<?xml version="1.0" encoding="UTF-8"?>
<!--
    Document   : '.$memberID.'.xml
    Author     : Open Learning Exchange
-->
<allresources>';
foreach($viewResults->rows as $row){
//	echo "Here<br />";
	if(count($row) > 0){
		$sign="";
		$start_key = array($facilityId,$row->id);
		
		$assaign_viewResults = $assignments->include_docs(TRUE)->key($start_key)->getView('api', 'facilityGroupID');
		foreach($assaign_viewResults->rows as $assignRow){
			if($assignRow->doc->context->use=="stories for the week"){
				$sign="+ ";
			}else{
				$sign="";
			}
		//----//
		///print($assignRow->doc->endDate."<br />");
	
		if(strtotime($_POST['dateFrom']) <= ($assignRow->doc->endDate) && ($assignRow->doc->endDate)<=strtotime($_POST['dateTo'])){
		$resDoc = $resources->getDoc($assignRow->value);
			if($resDoc->type!="video lesson"){
$dataBody = $dataBody.'
<resources>
<id>'.$resDoc->_id.'</id>
<title>'.$sign.$resDoc->title.'</title>
<type>'.$resDoc->legacy->type.'</type>
</resources>';
//Save Resources to Array for downloading
				global $resourceArray;
				$foundDuplicateInArray = false;
				for($cnt=0;$cnt<sizeof($resourceArray);$cnt++){
					if($resourceArray[$cnt]==$resDoc->_id){
						$foundDuplicateInArray =true;
					}
				}
				if(!$foundDuplicateInArray){
					array_push($resourceArray,$resDoc->_id);
				}
			}
		}
		//----//
		}
	}
}
 $dataBody=$dataBody.'
</allresources>';
$Student_File = "../transferData/readWide/rd_".$memberID.".xml";
$fh = fopen($Student_File, 'w') or die("can't open file");
fwrite($fh,$dataBody);
fclose($fh);
chmod($fh,777);
}
//////////// end function ////////////

///// begin function for readable resources////
function compileVideoBook($memberID)
{	
global $couchUrl;
global $facilityId;
global $config;
$groups = new couchClient($couchUrl, "groups");
$assignments = new couchClient($couchUrl, "assignments");
$resources = new couchClient($couchUrl, "resources");
$start_key = array($facilityId,$memberID);
$viewResults = $groups->key($start_key)->getView('api', 'facilityWithMemberID');
$dataBody ='<?xml version="1.0" encoding="UTF-8"?>
<!--
    Document   : '.$memberID.'.xml
    Author     : Open Learning Exchange
-->
<allresources>';
foreach($viewResults->rows as $row){
//	echo "Here<br />";
	if(count($row) > 0){
		$sign="";
		$start_key = array($facilityId,$row->id);
		
		$assaign_viewResults = $assignments->include_docs(TRUE)->key($start_key)->getView('api', 'facilityGroupIdVideoBook');
		foreach($assaign_viewResults->rows as $assignRow){
		//----//
		///print($assignRow->doc->endDate."<br />");
	
		if(strtotime($_POST['dateFrom']) <= ($assignRow->doc->endDate) && ($assignRow->doc->endDate)<=strtotime($_POST['dateTo'])){
		$resDoc = $resources->getDoc($assignRow->value);
			if($resDoc->type=="video lesson"){
				/// count the number of questions
				$counter=sizeof($assignRow->doc->context->questions);
				/// finish counting
				///echo "<br />".$counter."<br />";
$allquestions = array();
$questionHolder ="";
$dataBody = $dataBody.'
	<resources>
		<id>'.$resDoc->_id.'</id>
		<assignmentId>'.$assignRow->doc->_id.'</assignmentId>
		<title>'.$resDoc->title.'</title>
		<type>'.$resDoc->legacy->type.'</type>
		<noOfQuestions>'.$counter.'</noOfQuestions>
		<listquest>';
$question="";
$questionAnswer ="";
$Quencnt=0;
$questionHolder="";
foreach($resDoc->questions as $questn){
	$avalable =0;
$questionHolder = $questionHolder.'
			<question>
				<text>'.key($questn).'</text>';
	foreach($questn as $answer){
$questionHolder = $questionHolder.'
				<ans>'.key($answer).'</ans>';
			foreach($answer as $possibles){
				for($counter = 0; $counter<4;$counter++){
				//	echo $possibles[$counter]." <br />";
$questionHolder = $questionHolder.'
				<pos'.($counter+1).'>'.$possibles[$counter].'</pos'.($counter+1).'>';
			}
		}
$questionHolder = $questionHolder.'
			</question>';
	array_push($allquestions,$questionHolder);
	$questionHolder="";
	}
}
foreach($assignRow->doc->context->questions as $chosenValue){
	//echo $chosenValue."<br />";
	$dataBody = $dataBody.$allquestions[$chosenValue];
}
$dataBody = $dataBody.'
		</listquest>
	</resources>';
//Save Resources to Array for downloading
				global $videoBookResArray;
				$foundDuplicateVideoBookInArray = false;
				for($cnt=0;$cnt<sizeof($videoBookResArray);$cnt++){
					if($videoBookResArray[$cnt]==$resDoc->_id){
						$foundDuplicateVideoBookInArray =true;
					}
				}
				if(!$foundDuplicateVideoBookInArray){
					array_push($videoBookResArray,$resDoc->_id);
				}
			}
		}
		//----//
		}
	}
}
 $dataBody=$dataBody.'
</allresources>';
$Student_File = "../transferData/videoBook/vb_".$memberID.".xml";
$fh = fopen($Student_File, 'w') or die("can't open file");
fwrite($fh,$dataBody);
fclose($fh);
chmod($fh,777);
}
//////////// end function ////////////
/////////////////////////////

///// begin function for Video Books////
/*function compileVBResources($theClass)
{	
$dataBody ='<?xml version="1.0" encoding="UTF-8"?>
<!--
    Document   : VBR_'.$theClass.'.xml
    Author     : Open Learning Exchange
-->
<allresources>';
 $query = mysql_query("SELECT VBTask.usedby,VBTask.resrcID,VBTask.class,VBTask.questColNum,resources.title,resources.type from VBTask inner join resources on  VBTask.resrcID = resources.resrcID where VBTask.class = '".$theClass."' and VBTask.dateUsed between '".$_POST['dateFrom']."' and '".$_POST['dateTo']."' order by VBTask.dateUsed") or die(mysql_error());
   while($data = mysql_fetch_array($query))
   {
	   $NoOfQuest = explode(":",$data['questColNum']);
$dataBody = $dataBody.'
<resources>
<id>'.$data['resrcID'].'</id>
<title>'.$data['title'].'</title>
<type>'.$data['type'].'</type>
<questions>'.sizeof($NoOfQuest).'</questions>
</resources>';
	   
   }
 $dataBody=$dataBody.'
</allresources>';
 $myFile = "../transferData/vbTask/VBR_".$theClass.".xml";
$fh = fopen($myFile, 'w') or die("can't open file");
fwrite($fh,$dataBody);
fclose($fh);
chmod($fh,777);
}*/
//// end function for Vedio Books////

/*
///// begin function for Video Book Questions ////
function compileVBQuestions($theClass)
{
$dataBody ='<?xml version="1.0" encoding="UTF-8"?>

    Document   : VBR_'.$theClass.'.xml
    Author     : Open Learning Exchange

<allquestions>';
$queryAllQuest = mysql_query("SELECT * FROM `VBTask` where class = '".$theClass."' and dateUsed between '".$_POST['dateFrom']."' and '".$_POST['dateTo']."'") or die("ITA HERE");
while($AllQuest = mysql_fetch_array($queryAllQuest)){   /////start While
			$listOfQColNum = explode(":",$AllQuest['questColNum']);
			$dataBody = $dataBody.'
<questiongroup>
<resid>'.$AllQuest['resrcID'].'</resid>';
foreach($listOfQColNum as $question){ 
		$dataBody = $dataBody.'
<listquest>';
   $query = mysql_query("SELECT * FROM  `VBQuestion` where ColNum ='".$question."'") or die(mysql_error());
   while($data = mysql_fetch_array($query))
   {
$dataBody = $dataBody.'
<quest>'.$data['question'].'</quest>
<ans>'.$data['answer'].'</ans>
<pos1>'.$data['posAnsw1'].'</pos1>
<pos2>'.$data['posAnsw2'].'</pos2>
<pos3>'.$data['posAnsw3'].'</pos3>
<pos4>'.$data['posAnsw4'].'</pos4>';
   }
$dataBody = $dataBody.'
</listquest>';    
} 
$dataBody = $dataBody.'
</questiongroup>';
	   } /////End Wile


 $dataBody=$dataBody.'
</allquestions>';
 $myFile = "../transferData/vbTask/VBQ_".$theClass.".xml";
$fh = fopen($myFile, 'w') or die("can't open file");
fwrite($fh,$dataBody);
fclose($fh);
chmod($fh,777);
}
/// end function for Vedio Books////



///// begin function for Video Book Questions ////
function compileVBQuestions($theClass)
{
$dataBody ='<?xml version="1.0" encoding="UTF-8"?>
<!--
    Document   : VBR_'.$theClass.'.xml
    Author     : Open Learning Exchange
-->
<allquestions>';
$queryAllQuest = mysql_query("SELECT * FROM `VBTask` where class = '".$theClass."' and dateUsed between '".$_POST['dateFrom']."' and '".$_POST['dateTo']."'") or die("ITA HERE");
while($AllQuest = mysql_fetch_array($queryAllQuest)){   /////start While
	$listOfQColNum = explode(":",$AllQuest['questColNum']);
foreach($listOfQColNum as $question){ 
   $query = mysql_query("SELECT * FROM  `VBQuestion` where ColNum ='".$question."'") or die(mysql_error());
   while($data = mysql_fetch_array($query))
   {
$dataBody = $dataBody.'
<questiongroup name="'.$AllQuest['resrcID'].'">';
$dataBody = $dataBody.'
<quest question="'.$data['question'].'"></quest>
<quest answer="'.$data['answer'].'"></quest>
<quest pos1="'.$data['posAnsw1'].'"></quest>
<quest pos2="'.$data['posAnsw2'].'"></quest>
<quest pos3="'.$data['posAnsw3'].'"></quest>
<quest pos4="'.$data['posAnsw4'].'"></quest>';
$dataBody = $dataBody.'
</questiongroup>';
   }  
} 

	   } /////End Wile


 $dataBody=$dataBody.'
</allquestions>';
 $myFile = "../transferData/vbTask/VBQ_".$theClass.".xml";
$fh = fopen($myFile, 'w') or die("can't open file");
fwrite($fh,$dataBody);
fclose($fh);
chmod($fh,777);
}*/
//// end function for Vedio Books////
function pullResourceFromCouch($getResourceArray){
	
	global $couchUrl;
	global $facilityId;
	global $config;
	echo "Pulling resources together for distrubution unto tablet <br /><br />";
	$counter = 100/sizeof($getResourceArray);
	$percentage=0;
	foreach($getResourceArray as $link){
		$percentage = $percentage + $counter;
		$resources = new couchClient($couchUrl, "resources");
		$docToDownload = $resources->getDoc($link);
		$get_FileToDownload = $docToDownload->_attachments;
		echo $percentage."% complete <br />";
		foreach($get_FileToDownload as $key => $value){
		  $url = $couchUrl."/resources/".$link."/".urlencode($key)."";
		  $content = file_get_contents($url);
		  file_put_contents('../resources/'.$link.'.'.end(explode(".",strtolower($key))), $content);
			  ///array_push($arrayImage,$key);
		}
	}
}

/// Class Names and Code //////
//////////////////////////////
$MasterstudentIDs = array_merge($MasterstudentIDs,compileClass("KG1"));
$MasterstudentIDs = array_merge($MasterstudentIDs,compileClass("P1"));
$MasterstudentIDs = array_merge($MasterstudentIDs,compileClass("P2"));
$MasterstudentIDs = array_merge($MasterstudentIDs,compileClass("P3"));
$MasterstudentIDs = array_merge($MasterstudentIDs,compileClass("P4"));
$MasterstudentIDs = array_merge($MasterstudentIDs,compileClass("P5"));
$MasterstudentIDs = array_merge($MasterstudentIDs,compileClass("P6"));
//print_r($MasterstudentIDs);

///////// Used Readable Resources /////
echo "Gathering resource data assigned to students <br />";
foreach($MasterstudentIDs as $stuID){
	compileResources($stuID);
}
echo "Successfully processed resource data for all students <br />";
pullResourceFromCouch($resourceArray);
///////////////////////////////////////


echo "Gathering video book task <br />";
//// Video Book Task in asignment /////
foreach($MasterstudentIDs as $stuID){
	compileVideoBook($stuID);
}
echo "Successfully processed video book data for all students <br />";
pullResourceFromCouch($videoBookResArray);
///////////////////////////////////////





recordActionObject($_SESSION['lmsUserID'],"prepared system for syncing","");
	

/////////////////////////////////////////
//compileVBResources("KG");
//compileVBResources("P1");
//compileVBResources("P2");
//compileVBResources("P3");
//compileVBResources("P4");
//compileVBResources("P5");
//compileVBResources("P6");
///////////////////////////////////////
//
//compileVBQuestions("KG");
//compileVBQuestions("P1");
//compileVBQuestions("P2");
//compileVBQuestions("P3");
//compileVBQuestions("P4");
//compileVBQuestions("P5");
//compileVBQuestions("P6");

echo '<script type="text/javascript">alert("System ready for syncing \n Date: '.$_POST['dateFrom'].' to '.$_POST['dateTo'].'");</script>';
die ('System ready for syncing Date: '.$_POST['dateFrom'].' to '.$_POST['dateTo'].'<br><br><br /> *************************************************************** <br />');
}
?>