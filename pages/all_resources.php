<?php session_start(); error_reporting(1);include "../secure/talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<script type="text/javascript" src="../js/jquery.js"></script>
</head>


<body  style="background-color:#FFF">
<div id="wrapper" style="background-color: #FFF; width: 600px;">
  <div id="rightContent" style="float: none; margin-left: auto; margin-right: auto; width: 550px; margin-left: auto; margin-right: auto; font-size: 14px;"><span style="color:#00C; font-weight: bold;">Available Student Resources</span><br>
    <br>
    <form action="" method="post">
    <fieldset>
    <legend>Search By</legend>
    <?php
	global $config;
			echo '<p>';
			for($cnt=0;$cnt<sizeof($config->levels);$cnt++){
				echo '<label>
          <input type="radio" name="rdLevel" value="'.$config->levels[$cnt].'" id="rdLevel" onChange="requestLoadLanguage()">
         '.$config->levels[$cnt].'</label>
        &nbsp;&nbsp;';
			}
	echo  '</p>
	<hr>';
    ?>
    <table width="493" border="0" align="center" cellspacing="0">
  <tr>
    <td width="75"><b>Language</b></td>
    <td width="172"><select name="Language" id="Language" onChange="requestLoadLanguage()" >
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
    <td width="74" align="right"><b>Subject</b></td>
    <td width="164">
    <?php
		global $config;
		echo '<select name="subject" id="subject"  onChange="requestLoadLanguage()">';
		for($cnt=0;$cnt<sizeof($config->subjects);$cnt++){
			echo '<option value="'.$config->subjects[$cnt].'">'.ucwords($config->subjects[$cnt]).'</option>';
		}
		echo  '</select>';
    ?>
      </select></td>
  </tr>
</table>

    </fieldset>
    </form>
      <p id="results"></p>
	</div><span style="color: #900; font-weight:bold; font-style:italic"></span>  
<div class="clear"></div>
</div>
</body>
<script type="text/javascript">
function openRes(pNumber)
{
	window.open('viewResource.php?resid='+pNumber);
	///alert('Yes'); 
}
</script>

<script type="text/javascript">

function requestLoadLanguage(){
	var lang = document.getElementById("Language").value;
	var subject =  document.getElementById("subject").value;
	var level = $('input:radio[name=rdLevel]:checked').val();
	$("#results").load("../functions/getResByLangLevel.php?sLanguage="+lang+"&sLevel="+level+"&sSubject="+subject);
}
</script>
</html>