<?php 

//error_reporting(E_ERROR);
include "lib/couch.php";
include "lib/couchClient.php";
include "lib/couchDocument.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>System Configuration</title>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.tableText {
	font-family: Verdana, Geneva, sans-serif;
}
</style>
<?php
if(isset($_POST['systemPassword'])){
global $couchUrl;
$couchUrl = 'http://pi:raspberry@127.0.0.1:5984';
$Facilities = new couchClient($couchUrl,'facilities');
$Facilities->createDatabase();

$facility = (object) array(
  "kind"     => "Facility",
  "type"     => "",
  "GPS"      => array("", ""),
  "phone"    => "",
  "name"     => "",
  "country"  => "gh",
  "region"   => "",
  "district" => "",
  "area"     => "",
  "street"   => "",
  "dateEnrolled" => strtotime('2013-01-01')
);
$facility = $Facilities->storeDoc($facility);
echo "here";
$facilityId = $facility->id;
$whoami = new couchClient($couchUrl,'whoami');
$whoami->createDatabase();
$whoamiFacility = new couchDocument($whoami);
$whoamiFacility->set(array(
  "_id" => "facility",
  "kind" => "system",
  "facilityId" => $facilityId,
));

// Create the whoami/config doc
$whoamiConfig = new couchDocument($whoami);
$whoamiConfig->set(array(
  "_id" => "config",
  "kind" => "system",
  "timezone" => $_POST['timeZone'],
  "language" => $_POST['Language'],
  "version" => $_POST['version'],
  "layout" => $_POST['layout'],
  "subjects" => explode(',', $_POST['subjects']),
  "levels" => array('KG1', 'KG2', 'P1', 'P2', 'P3', 'P4', 'P5', 'P6') 
));

}
?>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
<table width="534" border="0" align="center" cellpadding="4" cellspacing="4">
  <tr>
    <td width="116">&nbsp;</td>
    <td width="390">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-weight: bold">Configuration</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Time Zone</td>
    <td>
      <span id="spryselect1">
        <label for="timeZone"></label>
        <select name="timeZone" id="timeZone">
          <option value="GMT">GMT</option>
        </select>
        <span class="selectRequiredMsg">Please select an item.</span></span>
    </td>
  </tr>
  <tr>
    <td>Language</td>
    <td>
    </select>
      <span id="spryselect2">
      <label for="select1"></label>
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
      <option value='en' selected="selected">English</option>
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
      <span class="selectRequiredMsg">Please select an item.</span></span></td>
  </tr>
  <tr>
    <td>Version</td>
    <td><label for="version"></label>
      <select name="version" id="version">
        <option value="1.0">1.0</option>
        <option value="2.0" selected="selected">2.0</option>
        <option value="2.1">2.1</option>
        <option value="2.2">2.2</option>
        <option value="3.0">3.0</option>
      </select></td>
  </tr>
  <tr>
    <td>Layout</td>
    <td><span id="spryselect3">
      <label for="layout"></label>
      <select name="layout" id="layout">
      <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select>
      <span class="selectRequiredMsg">Please select an item.</span></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="font-size: 12px; font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;">separate text a comma [ , ]</td>
  </tr>
  <tr>
    <td>Subjects</td>
    <td><span id="sprytextarea1">
      <label for="subjects"></label>
      <textarea name="subjects" id="subjects" cols="45" rows="5"></textarea>
      <span class="textareaRequiredMsg"><br />
A value is required.</span></span></td>
  </tr>
  <tr>
    <td>System Password</td>
    <td><pre><span id="sprypassword1"><label for="systemPassword"></label><input type="password" name="systemPassword" id="systemPassword" /><span class="passwordRequiredMsg">A value is required.</span></span></pre></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="submit" name="submit" id="submit" value="Configue System &gt;&gt;" /></td>
  </tr>
</table>
</form>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1");
</script>
</body>
</html>