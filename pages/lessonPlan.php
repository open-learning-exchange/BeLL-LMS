<?php session_start();include "../secure/talk2db.php";?>
<html>
<head>
<script type='text/javascript'>
var now = new Date() 
var fmat= now.getFullYear()+'-'+ (now.getMonth()+1)+'-'+(now.getDay()+10)+' '+(now.getHours())+':'+(now.getMinutes())+':'+(now.getSeconds());
</script>
<?php
/*?>if($_SESSION['name']== null){
	$mystring = "index.php?sesEnded=true&systemDateForm='+fmat";
	die('<script type="text/javascript">window.parent.location.href= "'.$mystring.'";</script>');
}<?php */?>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" media="all" href="../css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"dateExec",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>

</head>
<?php
if(isset($_POST['dateExec'])){
	global $couchUrl;
	global $facilityId;
	$lesson_notes = new couchClient($couchUrl, "lesson_notes");
	$assignments = new couchClient($couchUrl, "assignments");
	$resources = new couchClient($couchUrl, "resources");
	$groups = new couchClient($couchUrl, "groups");
	$feedbacks = new couchClient($couchUrl, "feedback");

	$todayDateTime = date("Y-m-d H:i:s"); 
	
	$facility = new couchClient($couchUrl, "facilities");
	$facDoc = $facility->getDoc($facilityId);
	$doc = new stdClass();
	$doc->kind = "lesson_note";
	$doc->memberId = $_SESSION['lmsUserID'];
	$doc->facilityId =$facilityId;
	$doc->execDate = strtotime($_POST['dateExec']);
	$doc->execTime = $_POST['txtTime'];
	$doc->duration = $_POST['duration'];
	$doc->subject = $_POST['subject'];
	$doc->groupId = $_POST['level'];
	$doc->references = $_POST['references'];
	$doc->topic=$_POST['topic'];
	$doc->subTopic=$_POST['subtopic'];
	$doc->aspect = $_POST['aspect'];
	$doc->objectives=$_POST['objectives'];
	$doc->rpk=$_POST['rpk'];
	$doc->corePoints = $_POST['corPoints'];
	$doc->introduction = $_POST['intro'];
	$doc->preStage= $_POST['preStage'];
	$doc->stage= $_POST['stage'];
	$doc->postStage= $_POST['postStage'];
	$doc->conclusion= $_POST['conclusion'];
	$doc->remarks = array(
					"teacher" => $_POST['teacherRmk'],
					"headteacher" => $_POST['HeadRmk'],
					"coach" => $_POST['CoachRmk']);
	$doc->timestamp = strtotime($todayDateTime);
	$doc->lastUpdated = array(
					"updatedBy" => 	$_SESSION['lmsUserID'],
					"timestamp" => strtotime($todayDateTime));
					
	// resources
	$selectedResources = array();
	for($cnt=0; $cnt<sizeof($_POST['story']);$cnt++){
		if($_POST['story'][$cnt]!="none")
		{
			array_push($selectedResources,$_POST['story'][$cnt]);
		}
	}
	$doc->resources = $selectedResources;
	
	// resources outside BeLL
	$resourcesOutsideBeLL = array();
	for($cnt=0; $cnt<sizeof($_POST['res_OutsideBell']);$cnt++){
		if($_POST['res_OutsideBell'][$cnt]!="")
		{
			array_push($resourcesOutsideBeLL,$_POST['res_OutsideBell'][$cnt]);
		}
	}
	$doc->resOutsideBell = $resourcesOutsideBeLL;
	
	// technology used
	$selectedTech = array();
	for($cnt=0; $cnt<sizeof($_POST['bellTech']);$cnt++){
		if($_POST['bellTech'][$cnt]!="none")
		{
			array_push($selectedTech,$_POST['bellTech'][$cnt]);
		}
	}
	$doc->techTools = $selectedTech;
	
	// low thinking questions
	$lowThinkingQuest = array();
	for($cnt=0; $cnt<sizeof($_POST['LowQuest']);$cnt++){
		if($_POST['LowQuest'][$cnt]!="")
		{
			array_push($lowThinkingQuest,$_POST['LowQuest'][$cnt]);
		}
	}
	$doc->lowThinking = $lowThinkingQuest;
	
	// high thinking question
	$highThinkingQuest = array();
	for($cnt=0; $cnt<sizeof($_POST['HighQuest']);$cnt++){
		if($_POST['HighQuest'][$cnt]!="")
		{
			array_push($highThinkingQuest,$_POST['HighQuest'][$cnt]);
		}
	}
	$doc->highThinking = $highThinkingQuest;
	$storeResult = $lesson_notes->storeDoc($doc);
	
	// Store resources in assignment for syncing
	for($cnt=0; $cnt<sizeof($_POST['story']);$cnt++){
		if($_POST['story'][$cnt]!="none")
		{
			$doc = new stdClass();
			$resID = $_POST['story'][$cnt];
			$resDoc = $resources->getDoc($resID);
			$doc->kind = "Assignment";
			$doc->resourceId = $_POST['story'][$cnt];
			$doc->startDate = strtotime($_POST['dateExec']);
			$doc->endDate = strtotime($_POST['dateExec']);
			$doc->memberId = $_SESSION['lmsUserID'];
			$doc->context = array(
			  "subject" => $resDoc->subject,
			  "use" => "lesson note execution",
			  "groupId" => $_POST['level'],
			  "facilityId"=>$facilityId,
			  "lesson_noteId"=>$storeResult->id
			  
			);
			$response = $assignments->storeDoc($doc);
		}
	}
	// store for feedback rating
	for($cnt=0; $cnt<sizeof($_POST['story']);$cnt++){
		if($_POST['story'][$cnt]!="none")
		{
			$doc = new stdClass();
			$resID = $_POST['story'][$cnt];
			$resDoc = $resources->getDoc($resID);
			$groupDoc = $groups->getDoc($_POST['level']);
			$doc->kind ="Feedback";
			$doc->rating=0;
			$doc->comment="";
			$doc->facilityId=$facilityId;
			$doc->memberId =$_SESSION['lmsUserID'];
			$doc->resourceId = $_POST['story'][$cnt];
			$doc->timestamp = strtotime($_POST['dateExec']);
			$doc->context = array(
			  "subject" => $resDoc->subject,
			  "use" => "lesson note execution",
			  "level" => $groupDoc->level[0],
			  "lesson_noteId"=> $storeResult->id
			);
			$response = $feedbacks->storeDoc($doc);
		}
	}
	
	///recordActionObject($_SESSION['lmsUserID'],"created a new lesson note",$_POST['lessonNoteID']);
  echo '<script type="text/javascript">alert("Lesson plan successfully saved for '.$storeResult->id.'");</script>';
  $mystring = "printLessonPlan.php?lesson_noteId=".$storeResult->id;
	die('<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$mystring.'">');
// 
//  ////die("<br><br><br><br>Lesson plan successfully saved for ".$_POST['dateExec']."");
	
}
?>

<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:580px; margin-left:auto; margin-right:auto;">&nbsp;&nbsp;&nbsp;<span style="color:#00C; font-weight: bold;">Prepare Lesson Plan</span><br><br>
    <form name="form1" method="post" action="">
      <table width="94%">
        <tr>
          <td width="150"><b>Date of Execution</b></td>
          <td width="255"><span id="sprytextfield1">
            <input type="text" name="dateExec" id="dateExec" style="width:50%">
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
          <td width="131"><b>Class </b>:        <span id="spryselect1">
          <select name="level" id="level"  onChange="requestLoadLanguage()">
          <?php
		  	global $couchUrl;
			global $facilityId;
			$groups = new couchClient($couchUrl, "groups");
			//get all groups from view into viewResults
			$viewResults = $groups->include_docs(TRUE)->key($facilityId)->getView('api', 'allGroupsInFacility');
			$wCnt=0;
			while($wCnt<sizeof($viewResults->rows)){
				print '<option value="'.$viewResults->rows[$wCnt]->doc->_id.'">'.$viewResults->rows[$wCnt]->doc->name.'</option>';
				$wCnt++;
			}
			
			
          ?>
          </select>
          <span class="selectRequiredMsg">Please select an item.</span></span></td>
        </tr>
        <tr>
          <td><b>Subject</b></td>
          <td colspan="2"><span id="sprytextfield2">
            <input type="text" name="subject" id="subject">
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td><b>References</b></td>
          <td colspan="2"><span id="sprytextarea1">
            <textarea name="references" id="references" cols="45" rows="3" style="height:60px;width:70%;"></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td><b>Time</b></td>
          <td colspan="2"><span id="sprytextfield3">
            <input type="text" name="txtTime" id="txtTime" style="width:30%">
          <span class="textfieldRequiredMsg">A value is required.</span></span> hh:mm:ss eg 8:00:00</td>
        </tr>
        <tr>
          <td><b>Duration</b></td>
          <td colspan="2"><span id="sprytextfield4">
            <input type="text" name="duration" id="duration">
          <span class="textfieldRequiredMsg">A value is required.</span></span> eg.. 2 hrs / 1hr 30min</td>
        </tr>
        <tr>
          <td><b>Topic</b></td>
          <td colspan="2"><span id="sprytextfield6">
          <label for="topic"></label>
          <input type="text" name="topic" id="topic">
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td><b>Sub - Topic</b></td>
          <td colspan="2"><span id="sprytextfield7">
            <label for="subtopic"></label>
            <input type="text" name="subtopic" id="subtopic">
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td><b>Aspect</b></td>
          <td colspan="2"><span id="sprytextfield5">
          <input name="aspect" type="text" id="aspect">
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td><b>Objective(s)</b></td>
          <td colspan="2"><span id="sprytextarea2">
            <textarea name="objectives" id="objectives" cols="45" rows="5" style="height:60px;width:70%;"></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td><b>RPK</b></td>
          <td colspan="2"><span id="sprytextarea3">
            <textarea name="rpk" id="rpk" cols="45" rows="5" style="height:60px;width:70%;"></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3"><b>T &amp; L resources selcted from BeLL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( View
              <select name="Language" id="Language" onChange="requestLoadLanguage()" >
            <option value='aa'>Afar</option>
            <option value='ab'>Abkhazian</option>
            <option value='af'>Afrikaans</option>
            <option value='ak'>Akan</option>
            <option value='sq'>Albanian</option>
            <option value='am'>Amharic</option>
            <option value='ar'>Arabic</option>
            <option value='an'>Aragonese</option>
            <option value='hy'>Armenian</option>
            <option value='as'>Assamese</option>
            <option value='av'>Avaric</option>
            <option value='ae'>Avestan</option>
            <option value='ay'>Aymara</option>
            <option value='az'>Azerbaijani</option>
            <option value='ba'>Bashkir</option>
            <option value='bm'>Bambara</option>
            <option value='eu'>Basque</option>
            <option value='be'>Belarusian</option>
            <option value='bn'>Bengali</option>
            <option value='bh'>Bihari</option>
            <option value='bi'>Bislama</option>
            <option value='bo'>Tibetan</option>
            <option value='bs'>Bosnian</option>
            <option value='br'>Breton</option>
            <option value='bg'>Bulgarian</option>
            <option value='my'>Burmese</option>
            <option value='ca'>Catalan</option>
            <option value='ca'>Valencian</option>
            <option value='cs'>Czech</option>
            <option value='ch'>Chamorro</option>
            <option value='ce'>Chechen</option>
            <option value='zh'>Chinese</option>
            <option value='cu'>Church Slavic</option>
            <option value='cu'>Old Slavonic</option>
            <option value='cu'>Church Slavonic</option>
            <option value='cu'>Old Bulgarian;</option>
            <option value='cu'>Old Church Slavonic</option>
            <option value='cv'>Chuvash</option>
            <option value='kw'>Cornish</option>
            <option value='co'>Corsican</option>
            <option value='cr'>Cree</option>
            <option value='cy'>Welsh</option>
            <option value='da'>Danish</option>
            <option value='de'>German</option>
            <option value='dv'>Divehi</option>
            <option value='dv'>Dhivehi</option>
            <option value='dv'>Maldivian</option>
            <option value='nl'>Dutch; Flemish</option>
            <option value='dz'>Dzongkha</option>
            <option value='en' selected>English</option>
            <option value='eo'>Esperanto</option>
            <option value='et'>Estonian</option>
            <option value='ee'>Ewe</option>
            <option value='fo'>Faroese</option>
            <option value='fa'>Persian</option>
            <option value='fj'>Fijian</option>
            <option value='fi'>Finnish</option>
            <option value='fr'>French</option>
            <option value='fy'>Western Frisian</option>
            <option value='ff'>Fulah</option>
            <option value='ka'>Georgian</option>
            <option value='gd'>Gaelic</option>
            <option value='gd'>Scottish Gaelic</option>
            <option value='ga'>Irish</option>
            <option value='gl'>Galician</option>
            <option value='gv'>Manx</option>
            <option value='el'>Greek</option>
            <option value='gn'>Guarani</option>
            <option value='gu'>Gujarati</option>
            <option value='ht'>Haitian</option>
            <option value='ht'>Haitian Creole</option>
            <option value='ha'>Hausa</option>
            <option value='he'>Hebrew</option>
            <option value='hz'>Herero</option>
            <option value='hi'>Hindi</option>
            <option value='ho'>Hiri Motu</option>
            <option value='hr'>Croatian</option>
            <option value='hu'>Hungarian</option>
            <option value='ig'>Igbo</option>
            <option value='is'>Icelandic</option>
            <option value='io'>Ido</option>
            <option value='ii'>Sichuan Yi</option>
            <option value='iu'>Inuktitut</option>
            <option value='ie'>Interlingue</option>
            <option value='ia'>Interlingua</option>
            <option value='id'>Indonesian</option>
            <option value='ik'>Inupiaq</option>
            <option value='it'>Italian</option>
            <option value='jv'>Javanese</option>
            <option value='ja'>Japanese</option>
            <option value='kl'>Kalaallisut</option>
            <option value='kl'>Greenlandic</option>
            <option value='kn'>Kannada</option>
            <option value='ks'>Kashmiri</option>
            <option value='kr'>Kanuri</option>
            <option value='kk'>Kazakh</option>
            <option value='km'>Central Khmer</option>
            <option value='ki'>Kikuyu</option>
            <option value='ki'>Gikuyu</option>
            <option value='rw'>Kinyarwanda</option>
            <option value='ky'>Kirghiz</option>
            <option value='ky'>Kyrgyz</option>
            <option value='kv'>Komi</option>
            <option value='kg'>Kongo</option>
            <option value='ko'>Korean</option>
            <option value='kj'>Kuanyama</option>
            <option value='kj'>Kwanyama</option>
            <option value='ku'>Kurdish</option>
            <option value='lo'>Lao</option>
            <option value='la'>Latin</option>
            <option value='lv'>Latvian</option>
            <option value='li'>Limburgan</option>
            <option value='li'>Limburger</option>
            <option value='li'>Limburgish</option>
            <option value='ln'>Lingala</option>
            <option value='lt'>Lithuanian</option>
            <option value='lb'>Luxembourgish</option>
            <option value='lb'>Letzeburgesch</option>
            <option value='lu'>Luba-Katanga</option>
            <option value='lg'>Ganda</option>
            <option value='mk'>Macedonian</option>
            <option value='mh'>Marshallese</option>
            <option value='ml'>Malayalam</option>
            <option value='mi'>Maori</option>
            <option value='mr'>Marathi</option>
            <option value='ms'>Malay</option>
            <option value='mg'>Malagasy</option>
            <option value='mt'>Maltese</option>
            <option value='mo'>Moldavian</option>
            <option value='mn'>Mongolian</option>
            <option value='na'>Nauru</option>
            <option value='nv'>Navajo</option>
            <option value='nv'>Navaho</option>
            <option value='nr'>Ndebele South</option>
            <option value='nr'>South Ndebele</option>
            <option value='nr'>Ndebele North</option>
            <option value='nd'>North Ndebele</option>
            <option value='ng'>Ndonga</option>
            <option value='ne'>Nepali</option>
            <option value='nl'>Dutch</option>
            <option value='nn'>Norwegian Nynorsk</option>
            <option value='nn'>Nynorsk Norwegian</option>
            <option value='nb'>Bokmål Norwegian</option>
            <option value='nb'>Norwegian Bokmål</option>
            <option value='no'>Norwegian</option>
            <option value='ny'>Chichewa</option>
            <option value='ny'>Nyanja</option>
            <option value='oc'>Occitan </option>
            <option value='oc'>Provençal</option>
            <option value='oj'>Ojibwa</option>
            <option value='or'>Oriya</option>
            <option value='om'>Oromo</option>
            <option value='os'>Ossetian</option>
            <option value='os'>Ossetic</option>
            <option value='pa'>Panjabi</option>
            <option value='pa'>Punjabi</option>
            <option value='pi'>Pali</option>
            <option value='pl'>Polish</option>
            <option value='pt'>Portuguese</option>
            <option value='ps'>Pushto</option>
            <option value='qu'>Quechua</option>
            <option value='rm'>Romansh</option>
            <option value='ro'>Romanian</option>
            <option value='rn'>Rundi</option>
            <option value='ru'>Russian</option>
            <option value='sg'>Sango</option>
            <option value='sa'>Sanskrit</option>
            <option value='sr'>Serbian</option>
            <option value='si'>Sinhala</option>
            <option value='si'>Sinhalese</option>
            <option value='sk'>Slovak</option>
            <option value='sl'>Slovenian</option>
            <option value='se'>Northern Sami</option>
            <option value='sm'>Samoan</option>
            <option value='sn'>Shona</option>
            <option value='sd'>Sindhi</option>
            <option value='so'>Somali</option>
            <option value='st'>Sotho Southern</option>
            <option value='es'>Spanish</option>
            <option value='es'>Castilian</option>
            <option value='sc'>Sardinian</option>
            <option value='ss'>Swati</option>
            <option value='su'>Sundanese</option>
            <option value='sw'>Swahili</option>
            <option value='sv'>Swedish</option>
            <option value='ty'>Tahitian</option>
            <option value='ta'>Tamil</option>
            <option value='tt'>Tatar</option>
            <option value='te'>Telugu</option>
            <option value='tg'>Tajik</option>
            <option value='tl'>Tagalog</option>
            <option value='th'>Thai</option>
            <option value='ti'>Tigrinya</option>
            <option value='to'>Tonga </option>
            <option value='to'>Tonga Islands</option>
            <option value='tn'>Tswana</option>
            <option value='ts'>Tsonga</option>
            <option value='tk'>Turkmen</option>
            <option value='tr'>Turkish</option>
            <option value='tw'>Twi</option>
            <option value='ug'>Uighur</option>
            <option value='ug'>Uyghur</option>
            <option value='uk'>Ukrainian</option>
            <option value='ur'>Urdu</option>
            <option value='uz'>Uzbek</option>
            <option value='ve'>Venda</option>
            <option value='vi'>Vietnamese</option>
            <option value='vo'>Volapük</option>
            <option value='wa'>Walloon</option>
            <option value='wo'>Wolof</option>
            <option value='xh'>Xhosa</option>
            <option value='yi'>Yiddish</option>
            <option value='yo'>Yoruba</option>
            <option value='za'>Zhuang Chuang</option>
            <option value='zu'>Zulu</option>
          </select> 
          resources )</b></td>
        </tr>
        <tr>
          <td colspan="3" align="right"><p id="res1"></p></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3"><b>T &amp; L resources selcted from outside the BeLL</b></td>
        </tr>
        <tr>
          <td align="right"><b>1</b></td>
          <td colspan="2"><input type="text" name="res_OutsideBell[]" id="res_OutsideBell"></td>
        </tr>
        <tr>
          <td align="right"><b>2</b></td>
          <td colspan="2"><input type="text" name="res_OutsideBell[]" id="res_OutsideBell"></td>
        </tr>
        <tr>
          <td align="right"><b>3</b></td>
          <td colspan="2"><input type="text" name="res_OutsideBell[]" id="res_OutsideBell"></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3"><b>Proposed Technology tools to be used in the lesson</b></td>
        </tr>
        <tr>
          <td align="right"><b>1</b></td>
          <td colspan="2">
          <select name="bellTech[]" id="bellTech1">
            <option value="none" selected>none</option>
            <option value="Tablets">Tablets</option>
            <option value="Laptop &amp; Speakers">Laptop &amp; Speakers</option>
            <option value="Projector">Projector</option>
            <option value="Camera">Camera</option>
            <option value="Server">Server</option>
            <option value="TV">TV</option>
            <option value="Radio">Radio</option>
          </select></td>
        </tr>
        <tr>
          <td align="right"><b>2</b></td>
          <td colspan="2"><select name="bellTech[]" id="bellTech2">
            <option value="none" selected>none</option>
            <option value="Tablets">Tablets</option>
            <option value="Laptop &amp; Speakers">Laptop &amp; Speakers</option>
            <option value="Projector">Projector</option>
            <option value="Camera">Camera</option>
            <option value="Server">Server</option>
            <option value="TV">TV</option>
            <option value="Radio">Radio</option>
          </select></td>
        </tr>
        <tr>
          <td align="right"><b>3</b></td>
          <td colspan="2"><select name="bellTech[]" id="bellTech3">
            <option value="none" selected>none</option>
            <option value="Tablets">Tablets</option>
            <option value="Laptop &amp; Speakers">Laptop &amp; Speakers</option>
            <option value="Projector">Projector</option>
            <option value="Camera">Camera</option>
            <option value="Server">Server</option>
            <option value="TV">TV</option>
            <option value="Radio">Radio</option>
          </select></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><b>Core Points / Literacy Skill to be developed</b></td>
          <td colspan="2"><span id="sprytextarea4">
            <textarea name="corPoints" id="corPoints" cols="45" rows="5" style="height:60px;width:70%;"></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td colspan="3" align="left"><b style="color:#666;">Teaching and Learning Activities (include 1) how RPK will be used 2) how technology<br>
selected will be used 3) 21st century skills that would be used in the teaching to make<br>
it fun, participatory and self- discovery)</b>
</td>
        </tr>
        <tr>
          <td align="left"><b>Introduction</b></td>
          <td colspan="2"><span id="sprytextarea5">
            <textarea name="intro" id="intro" cols="45" rows="5" style="height:60px;width:70%;"></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="left"><b>Pre –Writing / Reading Stage</b></td>
          <td colspan="2"><span id="sprytextarea6">
            <textarea name="preStage" id="preStage" cols="45" rows="5" style="height:60px;width:70%;"></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="left"><b>Writing / Reading Stage</b></td>
          <td colspan="2"><span id="sprytextarea7">
            <textarea name="stage" id="stage" cols="45" rows="5" style="height:60px;width:70%;"></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="left"><b>Post – Writing / Reading Stage</b></td>
          <td colspan="2"><span id="sprytextarea8">
            <textarea name="postStage" id="postStage" cols="45" rows="5" style="height:60px;width:70%;"></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="left"><b>Conclusion</b></td>
          <td colspan="2"><span id="sprytextarea13">
            <textarea name="conclusion" id="conclusion" cols="45" rows="5" style="height:60px;width:70%;"></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="left"><b style="color:#666;">Evaluation Exercises</b></td>
        </tr>
        <tr>
          <td colspan="3" align="left"><b>Low Order Thinking Questions</b></td>
        </tr>
        <tr>
          <td align="right"><b>1</b></td>
          <td colspan="2"><span id="sprytextarea9">
            <textarea name="LowQuest[]" id="LowQuest1" cols="45" rows="5" style="height:50px;width:70%;" ></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="right"><b>2</b></td>
          <td colspan="2"><span id="sprytextarea10">
            <textarea name="LowQuest[]" id="LowQuest2" cols="45" rows="5"  style="height:50px;width:70%;" ></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="right"><b>3</b></td>
          <td colspan="2"><textarea name="LowQuest[]" id="LowQuest3" cols="45" rows="5"  style="height:50px;width:70%;" ></textarea></td>
        </tr>
        <tr>
          <td align="right"><b>4</b></td>
          <td colspan="2"><textarea name="LowQuest[]" id="LowQuest4" cols="45" rows="5" style="height:50px;width:70%;" ></textarea></td>
        </tr>
        <tr>
          <td align="right"><b>5</b></td>
          <td colspan="2"><textarea name="LowQuest[]" id="LowQuest5" cols="45" rows="5"  style="height:50px;width:70%;"  ></textarea></td>
        </tr>
        <tr>
          <td colspan="3" align="left"><b>High Order Thinking Questions</b></td>
        </tr>
        <tr>
          <td align="right"><b>1</b></td>
          <td colspan="2"><span id="sprytextarea11">
            <textarea name="HighQuest[]" id="HighQuest1" cols="45" rows="5"  style="height:50px;width:70%;" ></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="right"><b>2</b></td>
          <td colspan="2"><span id="sprytextarea12">
            <textarea name="HighQuest[]" id="HighQuest2" cols="45" rows="5"  style="height:50px;width:70%;" ></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="right"><b>3</b></td>
          <td colspan="2"><textarea name="HighQuest[]" id="HighQuest3" cols="45" rows="5"  style="height:50px;width:70%;" ></textarea></td>
        </tr>
        <tr>
          <td align="right"><b>4</b></td>
          <td colspan="2"><textarea name="HighQuest[]" id="HighQuest4" cols="45" rows="5" style="height:50px;width:70%;" ></textarea></td>
        </tr>
        <tr>
          <td align="right"><b>5</b></td>
          <td colspan="2"><textarea name="HighQuest[]" id="HighQuest5" cols="45" rows="5" style="height:50px;width:70%;" ></textarea></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="left"><b>Remarks on the teaching done / observed by the following</b></td>
        </tr>
        <tr>
          <td align="left"><b>Teacher</b></td>
          <td colspan="2"><span id="sprytextarea14">
            <textarea name="teacherRmk" id="teacherRmk" cols="45" rows="5" style="height:50px;width:70%;"></textarea>
</span></td>
        </tr>
        <tr>
          <td align="left"><b>Head</b></td>
          <td colspan="2"><input name="HeadRmk" type="text" id="HeadRmk" readonly></td>
        </tr>
        <tr>
          <td align="left"><b>Coach</b></td>
          <td colspan="2"><input name="CoachRmk" type="text" id="CoachRmk" readonly></td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
          <td colspan="2"><input type="hidden" name="preparedBy" id="preparedBy" value="<?php echo $_SESSION['name'];?>"></td>
        </tr>
        <tr>
          <td></td>
          <td colspan="2"><input type="submit" class="button" value="Submit">
            <input type="reset" class="button" value="Reset">
            <input type="hidden" name="systemDateForm" id="systemDateForm"></td>
        </tr>
      </table>
    </form>
  </div>
<div class="clear"></div>
</div>
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2");
var sprytextarea3 = new Spry.Widget.ValidationTextarea("sprytextarea3");
var sprytextarea4 = new Spry.Widget.ValidationTextarea("sprytextarea4");
var sprytextarea5 = new Spry.Widget.ValidationTextarea("sprytextarea5");
var sprytextarea6 = new Spry.Widget.ValidationTextarea("sprytextarea6");
var sprytextarea7 = new Spry.Widget.ValidationTextarea("sprytextarea7");
var sprytextarea8 = new Spry.Widget.ValidationTextarea("sprytextarea8");
var sprytextarea9 = new Spry.Widget.ValidationTextarea("sprytextarea9");
var sprytextarea10 = new Spry.Widget.ValidationTextarea("sprytextarea10");
var sprytextarea11 = new Spry.Widget.ValidationTextarea("sprytextarea11");
var sprytextarea12 = new Spry.Widget.ValidationTextarea("sprytextarea12");
var sprytextarea13 = new Spry.Widget.ValidationTextarea("sprytextarea13");
var sprytextarea14 = new Spry.Widget.ValidationTextarea("sprytextarea14", {isRequired:false});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");
</script>
</body>
<script type="text/javascript">

function requestLoadLanguage(){
	var groupId = document.getElementById("level").value;
	var lang = document.getElementById("Language").value;
	var lev;
	$.getJSON("../functions/getResByLangLevel.php?grade="+groupId+"",function (data){
		$.each(data.gobackArr, function(i,gback){
			$("#res1").load("../functions/getResByLangLevel.php?lang="+lang+"&level="+gback.level+"");
		})
	});
	
}
</script>
<script type="text/javascript">
	requestLoadLanguage();
	var now = new Date()
	///now = now.toGMTString();
	var fmat= now.getFullYear()+'-'+ (now.getMonth()+1)+'-'+(now.getDay()+10)+' '+(now.getHours())+':'+(now.getMinutes())+':'+(now.getSeconds());
	document.getElementById('systemDateForm').value = fmat;
</script>
</html>