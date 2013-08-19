<?php
global $studentIDs;
global $MasterstudentIDs;
$MasterstudentIDs =array();
if(isset($_POST['dateFrom']))
{

///// begin function for compiling students ////start_key=["test","z"]&end_key=["test","a"]
function compileClass($theClass)
{	
global $couchUrl;
global $facilityId;
global $config;
$studentIDs= array();
$members = new couchClient($couchUrl, "members");
$start_key = array($facilityId,$theClass,"A");
$end_key = array($facilityId,$theClass,"Z");
$viewResults = $members->include_docs(TRUE)->startkey($start_key)->endkey($end_key)->getView('api', 'facilityLevelActive_allStudent_sorted');
//$viewResults = $members->include_docs(TRUE)->key($key)->descending(TRUE)->getView('api', 'facilityLevelActive_allStudent');
///print_r($viewResults);
$docCounter=1;
$dataBody ='<?xml version="1.0" encoding="UTF-8"?>
<!--
    Document   : '.$theClass.'.xml
    Author     : Open Learning Exchange
-->
<allstudent>';
foreach($viewResults->rows as $row) {
$dataBody = $dataBody.'
<student>
<name>'.$row->doc->lastName.' '.$row->doc->middleNames.' '.$row->doc->firstName.'</name>
<bcode>'.$row->doc->pass.'</bcode>
<stuId>'.$row->doc->_id.'</stuId>
</student>';
array_push($studentIDs,$row->doc->_id);
}

if($theClass=="KG1"){
$key = $facilityId.'KG2';
$viewResults = $members->include_docs(TRUE)->key($key)->descending(TRUE)->getView('api', 'facilityLevelActive_allStudent');
foreach($viewResults->rows as $row) {
$dataBody = $dataBody.'
<student>
<name>'.$row->doc->lastName.' '.$row->doc->middleNames.' '.$row->doc->firstName.'</name>
<bcode>'.$row->doc->pass.'</bcode>
<stuId>'.$row->doc->_id.'</stuId>
</student>';
$theClass="KG";
array_push($studentIDs,$row->doc->_id);
}
}
 $dataBody=$dataBody.'
</allstudent>';
 $myFile = "../transferData/studentsRecords/".$theClass.".xml";
$fh = fopen($myFile, 'w') or die("can't open file");
fwrite($fh,$dataBody);
fclose($fh);
chmod($fh,777);
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
$start_key = array($facilityId,$memberID);
$viewResults = $groups->key($start_key)->getView('api', 'facilityWithMemberID');
print_r($viewResults);
foreach($viewResults->rows as $row){
//	echo "Here<br />";
print ($row->id);
//foreach($rows as $row)
//	//;
//}
}
/*$dataBody ='<?xml version="1.0" encoding="UTF-8"?>
<!--
    Document   : R_'.$theClass.'.xml
    Author     : Open Learning Exchange
-->
<allresources>';

   $query = mysql_query("SELECT * FROM  `usedResources` where class = '".$theClass."' and type != 'mp4' and type != 'mp3' and dateUsed between '".$_POST['dateFrom']."' and '".$_POST['dateTo']."' group by resrcID order by `subject` ") or die(mysql_error());
   while($data = mysql_fetch_array($query))
   {
$dataBody = $dataBody.'
<resources>
<id>'.$data['resrcID'].'</id>
<title>'.$data['title'].'</title>
<type>'.$data['type'].'</type>
</resources>';
	   
   }
 $dataBody=$dataBody.'
</allresources>';
 $myFile = "../transferData/readWide/R_".$theClass.".xml";
$fh = fopen($myFile, 'w') or die("can't open file");
fwrite($fh,$dataBody);
fclose($fh);
chmod($fh,777);*/
}
//////////// end function ////////////


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
///////////////////////////////////////


foreach($MasterstudentIDs as $stuID){
	compileResources($stuID);
}
//compileResources("KG");
//compileResources("P1");
//compileResources("P2");
//compileResources("P3");
//compileResources("P4");
//compileResources("P5");
//compileResources("P6");
///////////////////////////////////////
//////////////////////////////////////
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

recordActionDate($_SESSION['name'],"Prepared system for syncing -: ".$_POST['dateFrom']." to ".$_POST['dateTo']."",$_POST['systemDateForm']);

echo '<script type="text/javascript">alert("System ready for syncing \n Date: '.$_POST['dateFrom'].' to '.$_POST['dateTo'].'");</script>';
echo 'System ready for syncing Date: '.$_POST['dateFrom'].' to '.$_POST['dateTo'].'<br><br>';
}
?>