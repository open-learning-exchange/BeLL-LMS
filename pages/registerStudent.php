<?php session_start(); error_reporting(1);include "../secure/talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationRadio.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="all" href="../css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"dateOfBirth",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
<style type="text/css">
#numbersInput {
	font-size: 16px;
	font-weight: bold;
	width:35px;
	height:20px;
}
</style>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationRadio.js" type="text/javascript"></script>
</head>
<?php
if(isset($_POST['pass']))
{
	global $couchUrl;
	global $facilityId;
	$members = new couchClient($couchUrl, "members");
	$doc = new stdClass();
	
	// get data from form and save it to couch
	$doc->kind ="Member";
	$doc->dateOfBirth = strtotime($_POST['dateOfBirth']);
	$doc->dateRegistered = strtotime($_POST['systemDateForm']);
	$doc->facilityId = $facilityId;
	$doc->firstName = $_POST['firstName'];
	$doc->lastName = $_POST['lastName'];
	$doc->middleNames = $_POST['middleNames'];
	$doc->nationality = $_POST['nationality'];
	$doc->gender = $_POST['gender'];
	$doc->level =array($_POST['level']);
	//@todo.. create a login for student
	$doc->login = "";
	$doc->pass = $_POST['pass'];
	$doc->phone = $_POST['phoneNumber'];
	// roles is an array.. get selected roles 
	$doc->role = array("student");
	// save doc to couch and for responce->id
	$response = $members->storeDoc($doc);
	try {
	// add attached image to document with specified id from response
			$members->storeAttachment($members->getDoc($response->id),$_FILES['uploadedfile']['tmp_name'], mime_content_type($_FILES['uploadedfile']['tmp_name']));
	} catch ( Exception $e ) {
		print ("No photo uploaded : ".$e->getMessage());
	}
	// Start saving group assigned to member in group document
	$groups = new couchClient($couchUrl, "groups");
	//get all groups from view into viewResults
	$viewResults = $groups->include_docs(TRUE)->key($facilityId.$_POST['level'])->getView('api', 'facilityLevel');
	// add student list to group members array
	array_push($viewResults->rows[0]->doc->members,$response->id);
	$groups->storeDoc($viewResults->rows[0]->doc);
	/*
 recordActionDate($_SESSION['name']," Added a new student by name ".$_POST['stuName']." in ".$_POST['stuClass'],$_POST['systemDateForm']);*/
 
echo '<script type="text/javascript">alert("Successfully Added ||||  Student Name:'.$_POST['firstName'].' |||  Please save student code : '.$_POST['pass'].'");</script>';
echo ("Successfully Added  <|>  Student Name:".$_POST['firstName']."  <|>  Please save student code : ".$_POST['pass']."<br>
");

}

?>

<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div id="rightContent" style="float: none; margin-left: auto; margin-right: auto; width: 500px; margin-left: auto; margin-right: auto;">
    <span style="color: #00C; font-weight: bold;">Register Students</span><br><br>
    <form action="" method="post" enctype="multipart/form-data" name="form1">
      <table width="95%">
        <tr>
          <td width="125"><b>Level / Class </b></td>
          <td>
            <select name="level" id="level">
              <option value="KG1">KG 1</option>
              <option value="KG2">KG 2</option>
              <option value="P1">P1</option>
              <option value="P2">P2</option>
              <option value="P3">P3</option>
              <option value="P4">P4</option>
              <option value="P5">P5</option>
              <option value="P6">P6</option>
            </select>
          <span class="selectRequiredMsg">*</span>
          <input type="hidden" name="facility" id="facility">
          <input type="hidden" name="loginID" id="loginID">
          <input type="hidden" name="faci_CountryCode" id="faci_CountryCode"></td>
        </tr>
        <tr>
          <td><b>Student First Name</b></td>
          <td>
          <span id="sprytextfield1">
            <input type="text" name="firstName" id="firstName">
          <span class="textfieldRequiredMsg">*</span></span></td>
        </tr>
        <tr>
          <td><b>Student Last Name</b></td>
          <td><span id="sprytextfield4">
            <label for="lastName"></label>
            <input type="text" name="lastName" id="lastName">
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td><b>Student Middle Names</b></td>
          <td><span id="sprytextfield5">
            <label for="middleNames"></label>
            <input type="text" name="middleNames" id="middleNames">
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td><b>Date Of Birth</b></td>
          <td><span id="sprytextfield2">
            <input type="text" name="dateOfBirth" id="dateOfBirth">
          <span class="textfieldRequiredMsg">*</span></span> eg. 2005-08-15</td>
        </tr>
        <tr>
          <td><b>Gender</b></td>
          <td>
            <label>
              <input name="gender" type="radio" id="stuGender_0" value="Male" checked="CHECKED">
              Male</label>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="radio" name="gender" value="Female" id="stuGender_1">
              Female</label>
          <span class="radioRequiredMsg">*</span></td>
        </tr>
        <tr>
          <td><b>Nationality</b></td>
          <td><select name="nationality">
  <option value="">-- select one --</option>
  <option value="afghan">Afghan</option>
  <option value="albanian">Albanian</option>
  <option value="algerian">Algerian</option>
  <option value="american">American</option>
  <option value="andorran">Andorran</option>
  <option value="angolan">Angolan</option>
  <option value="antiguans">Antiguans</option>
  <option value="argentinean">Argentinean</option>
  <option value="armenian">Armenian</option>
  <option value="australian">Australian</option>
  <option value="austrian">Austrian</option>
  <option value="azerbaijani">Azerbaijani</option>
  <option value="bahamian">Bahamian</option>
  <option value="bahraini">Bahraini</option>
  <option value="bangladeshi">Bangladeshi</option>
  <option value="barbadian">Barbadian</option>
  <option value="barbudans">Barbudans</option>
  <option value="batswana">Batswana</option>
  <option value="belarusian">Belarusian</option>
  <option value="belgian">Belgian</option>
  <option value="belizean">Belizean</option>
  <option value="beninese">Beninese</option>
  <option value="bhutanese">Bhutanese</option>
  <option value="bolivian">Bolivian</option>
  <option value="bosnian">Bosnian</option>
  <option value="brazilian">Brazilian</option>
  <option value="british">British</option>
  <option value="bruneian">Bruneian</option>
  <option value="bulgarian">Bulgarian</option>
  <option value="burkinabe">Burkinabe</option>
  <option value="burmese">Burmese</option>
  <option value="burundian">Burundian</option>
  <option value="cambodian">Cambodian</option>
  <option value="cameroonian">Cameroonian</option>
  <option value="canadian">Canadian</option>
  <option value="cape verdean">Cape Verdean</option>
  <option value="central african">Central African</option>
  <option value="chadian">Chadian</option>
  <option value="chilean">Chilean</option>
  <option value="chinese">Chinese</option>
  <option value="colombian">Colombian</option>
  <option value="comoran">Comoran</option>
  <option value="congolese">Congolese</option>
  <option value="costa rican">Costa Rican</option>
  <option value="croatian">Croatian</option>
  <option value="cuban">Cuban</option>
  <option value="cypriot">Cypriot</option>
  <option value="czech">Czech</option>
  <option value="danish">Danish</option>
  <option value="djibouti">Djibouti</option>
  <option value="dominican">Dominican</option>
  <option value="dutch">Dutch</option>
  <option value="east timorese">East Timorese</option>
  <option value="ecuadorean">Ecuadorean</option>
  <option value="egyptian">Egyptian</option>
  <option value="emirian">Emirian</option>
  <option value="equatorial guinean">Equatorial Guinean</option>
  <option value="eritrean">Eritrean</option>
  <option value="estonian">Estonian</option>
  <option value="ethiopian">Ethiopian</option>
  <option value="fijian">Fijian</option>
  <option value="filipino">Filipino</option>
  <option value="finnish">Finnish</option>
  <option value="french">French</option>
  <option value="gabonese">Gabonese</option>
  <option value="gambian">Gambian</option>
  <option value="georgian">Georgian</option>
  <option value="german">German</option>
  <option value="ghanaian" selected >Ghanaian</option>
  <option value="greek">Greek</option>
  <option value="grenadian">Grenadian</option>
  <option value="guatemalan">Guatemalan</option>
  <option value="guinea-bissauan">Guinea-Bissauan</option>
  <option value="guinean">Guinean</option>
  <option value="guyanese">Guyanese</option>
  <option value="haitian">Haitian</option>
  <option value="herzegovinian">Herzegovinian</option>
  <option value="honduran">Honduran</option>
  <option value="hungarian">Hungarian</option>
  <option value="icelander">Icelander</option>
  <option value="indian">Indian</option>
  <option value="indonesian">Indonesian</option>
  <option value="iranian">Iranian</option>
  <option value="iraqi">Iraqi</option>
  <option value="irish">Irish</option>
  <option value="israeli">Israeli</option>
  <option value="italian">Italian</option>
  <option value="ivorian">Ivorian</option>
  <option value="jamaican">Jamaican</option>
  <option value="japanese">Japanese</option>
  <option value="jordanian">Jordanian</option>
  <option value="kazakhstani">Kazakhstani</option>
  <option value="kenyan">Kenyan</option>
  <option value="kittian and nevisian">Kittian and Nevisian</option>
  <option value="kuwaiti">Kuwaiti</option>
  <option value="kyrgyz">Kyrgyz</option>
  <option value="laotian">Laotian</option>
  <option value="latvian">Latvian</option>
  <option value="lebanese">Lebanese</option>
  <option value="liberian">Liberian</option>
  <option value="libyan">Libyan</option>
  <option value="liechtensteiner">Liechtensteiner</option>
  <option value="lithuanian">Lithuanian</option>
  <option value="luxembourger">Luxembourger</option>
  <option value="macedonian">Macedonian</option>
  <option value="malagasy">Malagasy</option>
  <option value="malawian">Malawian</option>
  <option value="malaysian">Malaysian</option>
  <option value="maldivan">Maldivan</option>
  <option value="malian">Malian</option>
  <option value="maltese">Maltese</option>
  <option value="marshallese">Marshallese</option>
  <option value="mauritanian">Mauritanian</option>
  <option value="mauritian">Mauritian</option>
  <option value="mexican">Mexican</option>
  <option value="micronesian">Micronesian</option>
  <option value="moldovan">Moldovan</option>
  <option value="monacan">Monacan</option>
  <option value="mongolian">Mongolian</option>
  <option value="moroccan">Moroccan</option>
  <option value="mosotho">Mosotho</option>
  <option value="motswana">Motswana</option>
  <option value="mozambican">Mozambican</option>
  <option value="namibian">Namibian</option>
  <option value="nauruan">Nauruan</option>
  <option value="nepalese">Nepalese</option>
  <option value="new zealander">New Zealander</option>
  <option value="ni-vanuatu">Ni-Vanuatu</option>
  <option value="nicaraguan">Nicaraguan</option>
  <option value="nigerien">Nigerien</option>
  <option value="north korean">North Korean</option>
  <option value="northern irish">Northern Irish</option>
  <option value="norwegian">Norwegian</option>
  <option value="omani">Omani</option>
  <option value="pakistani">Pakistani</option>
  <option value="palauan">Palauan</option>
  <option value="panamanian">Panamanian</option>
  <option value="papua new guinean">Papua New Guinean</option>
  <option value="paraguayan">Paraguayan</option>
  <option value="peruvian">Peruvian</option>
  <option value="polish">Polish</option>
  <option value="portuguese">Portuguese</option>
  <option value="qatari">Qatari</option>
  <option value="romanian">Romanian</option>
  <option value="russian">Russian</option>
  <option value="rwandan">Rwandan</option>
  <option value="saint lucian">Saint Lucian</option>
  <option value="salvadoran">Salvadoran</option>
  <option value="samoan">Samoan</option>
  <option value="san marinese">San Marinese</option>
  <option value="sao tomean">Sao Tomean</option>
  <option value="saudi">Saudi</option>
  <option value="scottish">Scottish</option>
  <option value="senegalese">Senegalese</option>
  <option value="serbian">Serbian</option>
  <option value="seychellois">Seychellois</option>
  <option value="sierra leonean">Sierra Leonean</option>
  <option value="singaporean">Singaporean</option>
  <option value="slovakian">Slovakian</option>
  <option value="slovenian">Slovenian</option>
  <option value="solomon islander">Solomon Islander</option>
  <option value="somali">Somali</option>
  <option value="south african">South African</option>
  <option value="south korean">South Korean</option>
  <option value="spanish">Spanish</option>
  <option value="sri lankan">Sri Lankan</option>
  <option value="sudanese">Sudanese</option>
  <option value="surinamer">Surinamer</option>
  <option value="swazi">Swazi</option>
  <option value="swedish">Swedish</option>
  <option value="swiss">Swiss</option>
  <option value="syrian">Syrian</option>
  <option value="taiwanese">Taiwanese</option>
  <option value="tajik">Tajik</option>
  <option value="tanzanian">Tanzanian</option>
  <option value="thai">Thai</option>
  <option value="togolese">Togolese</option>
  <option value="tongan">Tongan</option>
  <option value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
  <option value="tunisian">Tunisian</option>
  <option value="turkish">Turkish</option>
  <option value="tuvaluan">Tuvaluan</option>
  <option value="ugandan">Ugandan</option>
  <option value="ukrainian">Ukrainian</option>
  <option value="uruguayan">Uruguayan</option>
  <option value="uzbekistani">Uzbekistani</option>
  <option value="venezuelan">Venezuelan</option>
  <option value="vietnamese">Vietnamese</option>
  <option value="welsh">Welsh</option>
  <option value="yemenite">Yemenite</option>
  <option value="zambian">Zambian</option>
  <option value="zimbabwean">Zimbabwean</option>
</select>&nbsp;</td>
        </tr>
        <tr>
          <td><b>Phone No. of Guardian</b></td>
          <td><span id="sprytextfield6">
            <label for="phoneNumber"></label>
            <input type="text" name="phoneNumber" id="phoneNumber">
            <span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
        </tr>
        <tr>
          <td><b>Login Code</b></td>
          <td><span id="sprytextfield3">
            <input name="pass" type="text" id="pass" readonly>
          <span class="textfieldRequiredMsg"> required.</span></span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><table width="163" border="1">
            <tr>
             <td width="44" align="center" bgcolor="#E3E3E3"><a href="#" onClick="NoClicked(1)"><div id="numbersInput">1</div></a></td>
             <td width="44" align="center" bgcolor="#E3E3E3"><a href="#" onClick="NoClicked(2)"><div id="numbersInput">2</div></a></td>
             <td width="53" align="center" bgcolor="#E3E3E3"><a href="#" onClick="NoClicked(3)"><div id="numbersInput">3</div></a></td>
            </tr>
            <tr>
              <td align="center" bgcolor="#E3E3E3"><a href="#" onClick="NoClicked(4)"><div id="numbersInput">4</div></a></td>
              <td align="center" bgcolor="#E3E3E3"><a href="#" onClick="NoClicked(5)"><div id="numbersInput">5</div></a></td>
              <td align="center" bgcolor="#E3E3E3"><a href="#" onClick="NoClicked(6)"><div id="numbersInput">6</div></a></td>
            </tr>
            <tr>
              <td align="center" bgcolor="#E3E3E3"><a href="#" onClick="NoClicked(7)"><div id="numbersInput">7</div></a></td>
              <td align="center" bgcolor="#E3E3E3"><a href="#" onClick="NoClicked(8)"><div id="numbersInput">8</div></a></td>
              <td align="center" bgcolor="#E3E3E3"><a href="#" onClick="NoClicked(9)"><div id="numbersInput">9</div></a></td>
            </tr>
            <tr>
              <td align="center" bgcolor="#E3E3E3">&nbsp;</td>
              <td align="center" bgcolor="#E3E3E3"><a href="#" onClick="NoClicked(0)"><div id="numbersInput">0</div></a></td>
              <td align="center" bgcolor="#E3E3E3"><a href="#" onClick="NoClicked(10)">
                <div id="numbersInput">clear</div></a></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><b>Upload Image</b></td>
          <td><input name="uploadedfile" type="file" />
          <input type="hidden" name="MAX_FILE_SIZE" value="100000" /></td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" class="button" value="Submit">
            <input type="reset" class="button" value="Reset">
    <input type="hidden" name="systemDateForm" id="systemDateForm">
            </td>
        </tr>
      </table>
    </form>
  </div>
<div class="clear"></div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
</script>
<script type="text/javascript">
function NoClicked(nm)
{
	var existText = document.getElementById("pass").value;
	switch(nm)
	{
		case 0:
		existText = existText+"0";
		break;
		case 1:
		existText = existText+"1";
		break;
		case 2:
		existText = existText+"2";
		break;
		case 3:
		existText = existText+"3";
		break;
		case 4:
		existText = existText+"4";
		break;
		case 5:
		existText = existText+"5";
		break;
		case 6:
		existText = existText+"6";
		break;
		case 7:
		existText = existText+"7";
		break;
		case 8:
		existText = existText+"8";
		break;
		case 9:
		existText = existText+"9";
		break;
		case 10:
		existText ="";
		break;
	}
	document.getElementById("pass").value = existText;
}
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "real", {isRequired:false});
</script>
</body>
<script type="text/javascript">
	var now = new Date()
	///now = now.toGMTString();
	var fmat= now.getFullYear()+'-'+ (now.getMonth()+1)+'-'+(now.getDay()+10)+' '+(now.getHours())+':'+(now.getMinutes())+':'+(now.getSeconds());
	document.getElementById('systemDateForm').value = fmat;
</script>
</html>