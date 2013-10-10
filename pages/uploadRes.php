<?php session_start();include "../secure/talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="../js/jquery.js"></script>

<style type="text/css">
#upReadable {
	border:double;
	border-style:double;
	height: 600px;
	width: 530px;
	display:none;
}
#vbookQuest {
	margin-top:5px;
	border:double;
	border-style:double;
	min-height: 250px;
	width: 530px;
}
#audQuest {
	background-color: #693;
	height: 400px;
	width: 530px;
	display:none;
}
</style>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script><script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../includes/ice/ice.js" type="text/javascript"></script>

<?php

if(isset($_POST['title']))
{
	global $couchUrl;
	global $facilityId;
	$resources = new couchClient($couchUrl, "resources");
	$doc = new stdClass();
	$docType = end(explode(".", $_FILES['uploadedfile']['name']));
	$doc->legacy = array(
	"id"=>"",
	"type"=> strtolower($docType)
	);
	$doc->type=$_POST['resType'];
	$doc->kind='Resource';
	$doc->language=$_POST['Language'];
	$doc->description=$_POST['discription'];
	$doc->title=$_POST['title'];
	$doc->author=$_POST['author'];
	$doc->subject=$_POST['subject'];
	$doc->created=$_POST['systemDateForm'];
	$audData = array();
	foreach($_POST['targetedAudience'] as $audience){
		array_push($audData,$audience);
	}
	$doc->audience = $audData;
	$resLevels = array();
	foreach($_POST['resLevel'] as $levels){
		array_push($resLevels,$levels);
	}
	$doc->levels = $resLevels;
	if($doc->type=="video lesson"){
		$doc->questions= (object)array();
	}
	$responce = $resources->storeDoc($doc);
	print_r($responce);
	try {
		// add attached to document with specified id from response
		$fileName = $responce->id.'.'.end(explode(".", $_FILES['uploadedfile']['name']));
		$resources->storeAttachment($resources->getDoc($responce->id),$_FILES['uploadedfile']['tmp_name'], mime_content_type($_FILES['uploadedfile']['tmp_name']),$fileName);
			
		///$resources->storeAttachment($resources->getDoc($responce->id),$_FILES['uploadedfile']['tmp_name'], mime_content_type($_FILES['uploadedfile']['tmp_name']));
		
	} catch ( Exception $e ) {
		print ("No Resource to uploaded<br>");
	}
	$resDoc = $resources->getDoc($responce->id);
	$resDoc->legacy->id = $responce->id;
	$resources->storeDoc($resDoc);
	
///   recordAction($_SESSION['name'],"Uploaded resources... res title : ".$_POST['RTitle']);
	echo '<script type="text/javascript">alert("Successfully Uploaded '.$_POST['title'].'");</script>';
  die("<br><br><br><br>Successfully saved - ".$_POST['title']."");
  
} else if(isset($_POST['quen1'])){
	// Video Book questions
	global $couchUrl;
	global $facilityId;
	$resources = new couchClient($couchUrl, "resources");
	$resDoc = $resources->getDoc($_POST["vBook"]);
	$masterQuestionArray = array();
	for($cnt=1;$cnt<=$_POST['VBNoOfQuestions'];$cnt++){
		$AnsNo = $_POST["questAns$cnt"];
		$arrayQuestion = array($_POST["quen$cnt"]=>array($_POST["q".$cnt."_pos".$AnsNo.""]=>array($_POST["q".$cnt."_pos1"],$_POST["q".$cnt."_pos2"],$_POST["q".$cnt."_pos3"],$_POST["q".$cnt."_pos4"])));
		array_push($masterQuestionArray,$arrayQuestion);
	}
	$resDoc->questions = (object)$masterQuestionArray;
	$resources->storeDoc($resDoc);
	echo '<script type="text/javascript">alert("Successfully Updated Question for Video Book");</script>';
  die("<br><br><br><br>Successfully saved questions for video book");
}
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#upResID').click(function () {
    	$("#upReadable").slideDown("slow");
		$("#vbookQuest").slideUp("slow");
		$("#audQuest").slideUp("slow");
	});
	$('#AddVBookID').click(function () {
    	$("#upReadable").slideUp("slow");
		$("#vbookQuest").slideDown("slow");
		$("#audQuest").slideUp("slow");
	});
	$('#AddAudID').click(function () {
    	$("#upReadable").slideUp("slow");
		$("#vbookQuest").slideUp("slow");
		$("#audQuest").slideDown("slow");
	});
	requestLoadLanguage();
});
</script>
</head>
<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:550px; margin-left:auto; margin-right:auto;"><span style="font-size: 14px; color: #00C;"><strong>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="#" id="upResID">Upload Resource</a></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ||&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <strong><a href="#" id="AddVBookID">Add V-Book Question&nbsp;&nbsp;&nbsp;</a>&nbsp;&nbsp;&nbsp;</strong> || <strong><!--<a href="#"  id="AddAudID">Add Audio Question</a></strong>--></span><br>
    <br>
  <div id="upReadable">
    <form action="" method="post" enctype="multipart/form-data" name="form1">
      <table width="99%" align="center">
        <tr>
          <td colspan="2" align="center" style="font-size: 16px; color: #903;"><strong>Upload Resource</strong></td>
          </tr>
        <tr>
          <td width="163"><b>Subject</b></td>
          <td>
            <?php
		global $config;
		echo '<select name="subject" id="subject">';
		for($cnt=0;$cnt<sizeof($config->subjects);$cnt++){
			echo '<option value="'.$config->subjects[$cnt].'">'.ucwords($config->subjects[$cnt]).'</option>';
		}
		echo  '</select>';
    ?>            <span class="selectRequiredMsg">Please select an item.</span></td>
          </tr>
        <tr>
          <td width="163"><b>Resource Type</b></td>
          <td><select name="resType" id="resType">
            <option value="audio lesson">Audio Lesson</option>
            <option value="video lesson">Video Lesson</option>
            <option value="readable" selected>Readable</option>
          </select></td>
        </tr>
        <tr>
          <td width="163"><b>Language</b></td>
          <td>
   <select name="Language" id="Language">
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
          &nbsp;</td>
        </tr>
        <tr>
          <td width="163"><b>Targeted Audience</b></td>
          <td><p>
            <label>
              <input type="checkbox" name="targetedAudience[]" value="teacher training" id="targetedAudience_0">
              Teacher Training</label>
            <br>
            <label>
              <input type="checkbox" name="targetedAudience[]" value="health" id="targetedAudience_1">
              Health</label>
            <br>
            <label>
              <input type="checkbox" name="targetedAudience[]" value="community education" id="targetedAudience_2">
              Community Education</label>
            <br>
            <label>
              <input type="checkbox" name="targetedAudience[]" value="formal education" id="targetedAudience_3">
              Formal Education</label>
            <br>
          </p></td>
        </tr>
        <tr>
          <td><b>This Resource can be used for. (targeted group)</b></td>
          <td>
          <?php 
		  	global $config;
			for($cnt=0;$cnt<sizeof($config->levels);$cnt++){
				print '<label>
                <input type="checkbox" name="resLevel[]" value="'.$config->levels[$cnt].'" id="'.$config->levels[$cnt].'">
               '.$config->levels[$cnt].'&nbsp;</label>&nbsp;&nbsp;&nbsp;';
				$wCnt++;
			}
		  ?>
          </td>
        </tr>
        <tr>
          <td><b>Resource Title</b></td>
          <td>
            <label for="RTitle"></label>
            <span id="sprytextfield2">
            <label for="title"></label>
            <input type="text" name="title" id="title">
            <span class="textfieldRequiredMsg">A value is required.</span></span>            <span class="textfieldRequiredMsg">*</span></td>
        </tr>
        <tr>
          <td><b>Author</b></td>
          <td><label for="author"></label>
            <span id="sprytextfield3">
            <label for="author2"></label>
            <input type="text" name="author" id="author">
            <span class="textfieldRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td><b>Remark / Discription</b></td>
          <td ice:editable="*">
            <label for="discription"></label>
            <textarea name="discription" id="discription" cols="45" rows="4" style="height:100px;"></textarea>
          <span class="textareaRequiredMsg">*</span>
          <input type="hidden" name="auploadedby" id="auploadedby" value="<?php echo $_SESSION['lmsUserID'];?>"></td>
        </tr>
        <tr>
          <td><b>Approved By</b></td>
          <td><label for="approvedBy"></label>
            <select name="approvedBy" id="approvedBy">
              <option value="OLE Team">OLE Team</option>
              <option value="Government">Government</option>
              <option value="School">School</option>
            </select></td>
        </tr>
        <tr>
          <td><b>Browse for file</b></td>
          <td><input name="uploadedfile" type="file" /></td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" class="button" value="Submit">
            <input type="reset" class="button" value="Reset">
            <input type="hidden" name="systemDateForm" id="systemDateForm"></td>
        </tr>
      </table>
    </form>
    </div>
    
 
 <div id="audQuest"></div>
 <div id="vbookQuest"><form action="" method="post">
   <table width="522" border="0">
     <tr>
       <td colspan="4" align="center"><span style="font-size: 16px; color: #903; font-weight: bold;">Add Video Book Questions
         
         </span></td>
     </tr>
     <tr>
       <td><b>Group / Level / Class </b>: </td>
       <td><span id="spryselect1">
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
       <td align="right"><b>Language</b></td>
       <td><select name="Language2" id="Language2" onChange="requestLoadLanguage()" >
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
       </select></td>
     </tr>
     <tr>
       <td width="138" align="right" valign="middle">Video Book Title  &nbsp;&nbsp;&nbsp;&nbsp;</td>
       <td colspan="3" valign="top"><p id="res1"></p> </td>
     </tr>
     <tr>
       <td width="138" align="right">Discription  &nbsp;&nbsp;&nbsp;&nbsp;</td>
       <td colspan="3"><p id="descriptionDisp"></p></td>
     </tr>
     <tr>
       <td align="right">Number Of Questions  &nbsp;&nbsp;&nbsp;&nbsp;</td>
       <td width="100"><select name="VBNoOfQuestions" id="VBNoOfQuestions">
         <option value="1" selected>One</option>
         <option value="2">Two</option>
         <option value="3">Three</option>
         <option value="4">Four</option>
         <option value="5">Five</option>
         <option value="6">Six</option>
         <option value="7">Seven</option>
         <option value="8">Eight</option>
         <option value="9">Nine</option>
         <option value="10">Ten</option>
         <option value="11">Eleven</option>
         <option value="12">Twelve </option>
         <option value="13">Thirteen</option>
         <option value="14">Fourteen </option>
         <option value="15">Fifteen</option>
         <option value="16">Sixteen</option>
         <option value="17">Seventeen</option>
         <option value="18">Eighteen </option>
         <option value="19">Nineteen </option>
         <option value="20">Twenty</option>
       </select></td>
       <td width="111"><input type='button' value='Show Fields' id='addButton'></td>
       <td width="155"><input type='button' value='Reset Fields' id='removeButton'></td>
     </tr>
     <tr>
       <td height="24" colspan="4">&nbsp;</td>
       </tr>
   </table>
   <div id='TextBoxesGroup'>
   </div>
   <p style="text-align:center;"><input type="submit" name="SendVBQuestions" class="button" value="Save Questions"></p>
</form>
 </div>
<div class="clear"></div>
  </div>
</div>
<script type="text/javascript">
var now = new Date()
	///now = now.toGMTString();
	var fmat= now.getFullYear()+'-'+ (now.getMonth()+1)+'-'+(now.getDay()+10)+' '+(now.getHours())+':'+(now.getMinutes())+':'+(now.getSeconds());
	document.getElementById('systemDateForm').value = fmat;
</script>
<script type="text/javascript">
$(document).ready(function(){
$("#addButton").click(function () {
	 var counter = 1;
	for(cnt=1;cnt<20;cnt++)
	{
		 $("#TextBoxDiv" + cnt).remove();
	}
	while(counter<=(document.getElementById("VBNoOfQuestions").value))
	{
		//var newTextBoxDiv = $(document.createElement('div')).attr("id", 'TextBoxDiv' + counter);
//		newTextBoxDiv.after().html('<label>Textbox #'+ counter + ' : </label>' +'<input type="text" name="textbox' + counter + 
//		 '" id="textbox' + counter + '" value="" >');
//		newTextBoxDiv.appendTo("#TextBoxesGroup");
		
		var newTextBoxDiv = $(document.createElement('div')).attr("id", 'TextBoxDiv' + counter);
		newTextBoxDiv.after().html('<table width="495" border="0">'+
		'<tr>'+
		'<td width="99">Question No '+counter+'</td>' +
            '<td colspan="3"><textarea name="quen'+counter+'" style="height:50px; width:350px;" cols="2" rows="2"></textarea></td>'+
            '</tr>'+
          '<tr>'+
            '<td>&nbsp;</td>'+
            '<td width="151">a.<input name="q'+counter+'_pos1" type="textbox" id="pos'+counter+'_" style="width:100px" >'+
            '<input type="radio" name="questAns'+counter+'" value="1" checked="CHECKED" id="questAns'+counter+'_0"></td>'+
            '<td width="45">&nbsp;</td>'+
            '<td width="182">c.<input name="q'+counter+'_pos3" type="textbox" id="pos'+counter+'_" style="width:100px" >'+
            '<input type="radio" name="questAns'+counter+'" value="3" id="questAns'+counter+'_2"></td>'+
          '</tr>'+
          '<tr>'+
            '<td>&nbsp;</td>'+
            '<td>b.<input name="q'+counter+'_pos2" type="textbox" id="pos'+counter+'_" style="width:100px" >'+
            '<input type="radio" name="questAns'+counter+'" value="2" id="questAns'+counter+'_1">'+
            '</td>'+
            '<td>&nbsp;</td>'+
            '<td>d.<input name="q'+counter+'_pos4" type="textbox" id="pos'+counter+'_" style="width:100px" >'+
            '<input type="radio" name="questAns'+counter+'" value="4" id="questAns'+counter+'_3"></td>'+
          '</tr>'+
      '</table>');
		newTextBoxDiv.appendTo("#TextBoxesGroup");
		counter++;
	}
});
$("#removeButton").click(function () {
    for(cnt=1;cnt<=(document.getElementById("VBNoOfQuestions").value);cnt++)
	{
		 $("#TextBoxDiv" + cnt).remove();
	}
});

  });
function requestLoadLanguage(){
	var groupId = document.getElementById("level").value;
	var lang = document.getElementById("Language").value;
	var lev;
	$.getJSON("../functions/getVBookByLangLevel.php?grade="+groupId+"",function (data){
		$.each(data.gobackArr, function(i,gback){
			$("#res1").load("../functions/getVBookByLangLevel.php?lang="+lang+"&level="+gback.level+"");
		})
	});
}
function getQuestions(){
	var resID = document.getElementById("vBook").value;
	if(resID!="none"){
		$("#descriptionDisp").load("../functions/getDiscription.php?id="+resID+"");
	}else{
		$("#descriptionDisp").load("blank.php");
	}
}
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
</script>
</body>
</html>