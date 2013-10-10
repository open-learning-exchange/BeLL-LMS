<?php session_start(); include "../secure/talk2db.php";error_reporting(1);?>
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
<script type="text/javascript" src="../js/jquery.js"></script>
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
	//echo $_POST['level'];
	global $couchUrl;
	global $facilityId;
	$members = new couchClient($couchUrl, "members");
	$doc = $members->getDoc($_POST['studentID']);
	
	// get data from form and save it to couch
	$doc->kind ="Member";
	$doc->dateOfBirth = strtotime($_POST['dateOfBirth']);
	$doc->dateRegistered = strtotime($_POST['systemDateForm']);
	$doc->facilityId = $facilityId;
	$doc->firstName = $_POST['firstName'];
	$doc->lastName = $_POST['lastName'];
	$doc->middleNames = $_POST['middleNames'];
	$doc->nationality = strtolower($_POST['nationality']);
	$doc->status = "active";
	$doc->gender = $_POST['gender'];
	$doc->levels =array($_POST['level']);
	//@todo.. create a login for student
	$doc->login = "";
	$doc->pass = $_POST['pass'];
	$doc->phone = $_POST['phoneNumber'];
	// roles is an array.. get selected roles 
	$doc->role = array("student");
	// save doc to couch and for responce->id
	$response = $members->storeDoc($doc);
	try {
			$fileUniqueID = $members->getUuids(1);
			// add attached image to document with specified id from response
			$fileName = $fileUniqueID[0].'.'.end(explode(".", $_FILES['uploadedfile']['name']));
			$members->storeAttachment($members->getDoc($response->id),$_FILES['uploadedfile']['tmp_name'], mime_content_type($_FILES['uploadedfile']['tmp_name']),$fileName);
	} catch ( Exception $e ) {
		print ("No photo uploaded");
	}
	// Remove previouse and Save group assigned to member in group document
	$groups = new couchClient($couchUrl, "groups");
	//get all groups from view into viewResults
	$viewResults = $groups->include_docs(TRUE)->key($facilityId.$_POST['prevLevel'])->getView('api', 'facilityLevel');
	// search student list to group members array and remove id from previouse group
	$arrayMembers = array();
	///$key = array_search($_POST['studentID'],$viewResults->rows[0]->doc->members);
	foreach($viewResults->rows as $groupView){
		for($arc=0;$arc<sizeof($groupView->doc->members);$arc++){	
			if($groupView->doc->members[$arc]!=$_POST['studentID']){
				array_push($arrayMembers,$groupView->doc->members[$arc]);
			}
		}
		$groupView->doc->members = $arrayMembers;
		$groups->storeDoc($groupView->doc);
	}
	// add to new group members array
	$newGroup_viewResults = $groups->include_docs(TRUE)->key($facilityId.$_POST['level'])->getView('api', 'facilityLevel');
	foreach($newGroup_viewResults->rows as $newGroup){
		array_push($newGroup->doc->members,$_POST['studentID']);
		$groups->storeDoc($newGroup->doc);
	}
	
recordActionObject($_SESSION['lmsUserID'],"modified (student) member details",$_POST['studentID']);
echo '<script type="text/javascript">alert("Successfully Updated ||||  Student Name:'.$_POST['firstName'].' |||  Please save student code : '.$_POST['pass'].'");</script><br>';
die ("Successfully Updated  <|>  Student Name:".$_POST['firstName']."  <|> Please save student code : ".$_POST['pass']."<br>");

}
if(isset($_GET['Edit']))
{
	global $couchUrl;
	global $facilityId;
	$members = new couchClient($couchUrl, "members");
	$doc = $members->getDoc($_GET['Edit']);
	$docToEditAttachment = $doc->_attachments;
	$image="";
	$arrayImage = array();
	foreach($docToEditAttachment as $key => $value){
			array_push($arrayImage,$key);
			
	}
	//echo $arrayImage[0];
	$image = "http://".$_SERVER['SERVER_NAME'].":5984/members/".$_GET['Edit']."/".urlencode($arrayImage[0])."";
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
          <?php 
		  	global $config;
			echo '<select name="level" id="level">';
			for($cnt=0;$cnt<=sizeof($config->levels);$cnt++){
				echo '<option value="'.$config->levels[$cnt].'">'.$config->levels[$cnt].'</option>';
			}
			echo  '</select>';
		  ?>
           
          <span class="selectRequiredMsg">*</span>
          <input type="hidden" name="facility" id="facility">
          <input type="hidden" name="loginID" id="loginID">
          <input type="hidden" name="faci_CountryCode" id="faci_CountryCode">
          <input type="hidden" name="prevLevel" id="prevLevel" value="<?php echo $doc->levels[0];?>"></td>
        </tr>
        <tr>
          <td><b>Student First Name</b></td>
          <td>
          <span id="sprytextfield1">
            <input type="text" name="firstName" id="firstName" value="<?php echo $doc->firstName?>">
          <span class="textfieldRequiredMsg">*</span></span></td>
        </tr>
        <tr>
          <td><b>Student Last Name</b></td>
          <td><span id="sprytextfield4">
            <label for="lastName"></label>
            <input type="text" name="lastName" id="lastName" value="<?php echo $doc->lastName?>">
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td><b>Student Middle Names</b></td>
          <td><span id="sprytextfield5">
            <label for="middleNames"></label>
            <input type="text" name="middleNames" id="middleNames" value="<?php echo $doc->middleNames?>">
</span></td>
        </tr>
        <tr>
          <td><b>Date Of Birth</b></td>
          <td><span id="sprytextfield2">
            <input type="text" name="dateOfBirth" id="dateOfBirth" value="<?php echo date('Y-m-d',$doc->dateOfBirth)?>">
          <span class="textfieldRequiredMsg">*</span></span> eg. 2005-08-15</td>
        </tr>
        <tr>
          <td><b>Gender</b></td>
          <td>
            <label>
              <input name="gender" type="radio" id="Male_gender" value="Male">
              Male</label>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="radio" name="gender" value="Female" id="Female_gender">
              Female</label>
          <span class="radioRequiredMsg">*</span></td>
        </tr>
        <tr>
          <td><b>Nationality</b></td>
          <td><select name="nationality" id="nationality">
 	<option value="AF">Afghanistan</option>
	<option value="AX">Åland Islands</option>
	<option value="AL">Albania</option>
	<option value="DZ">Algeria</option>
	<option value="AS">American Samoa</option>
	<option value="AD">Andorra</option>
	<option value="AO">Angola</option>
	<option value="AI">Anguilla</option>
	<option value="AQ">Antarctica</option>
	<option value="AG">Antigua and Barbuda</option>
	<option value="AR">Argentina</option>
	<option value="AM">Armenia</option>
	<option value="AW">Aruba</option>
	<option value="AU">Australia</option>
	<option value="AT">Austria</option>
	<option value="AZ">Azerbaijan</option>
	<option value="BS">Bahamas</option>
	<option value="BH">Bahrain</option>
	<option value="BD">Bangladesh</option>
	<option value="BB">Barbados</option>
	<option value="BY">Belarus</option>
	<option value="BE">Belgium</option>
	<option value="BZ">Belize</option>
	<option value="BJ">Benin</option>
	<option value="BM">Bermuda</option>
	<option value="BT">Bhutan</option>
	<option value="BO">Bolivia, Plurinational State of</option>
	<option value="BQ">Bonaire, Sint Eustatius and Saba</option>
	<option value="BA">Bosnia and Herzegovina</option>
	<option value="BW">Botswana</option>
	<option value="BV">Bouvet Island</option>
	<option value="BR">Brazil</option>
	<option value="IO">British Indian Ocean Territory</option>
	<option value="BN">Brunei Darussalam</option>
	<option value="BG">Bulgaria</option>
	<option value="BF">Burkina Faso</option>
	<option value="BI">Burundi</option>
	<option value="KH">Cambodia</option>
	<option value="CM">Cameroon</option>
	<option value="CA">Canada</option>
	<option value="CV">Cape Verde</option>
	<option value="KY">Cayman Islands</option>
	<option value="CF">Central African Republic</option>
	<option value="TD">Chad</option>
	<option value="CL">Chile</option>
	<option value="CN">China</option>
	<option value="CX">Christmas Island</option>
	<option value="CC">Cocos (Keeling) Islands</option>
	<option value="CO">Colombia</option>
	<option value="KM">Comoros</option>
	<option value="CG">Congo</option>
	<option value="CD">Congo, the Democratic Republic of the</option>
	<option value="CK">Cook Islands</option>
	<option value="CR">Costa Rica</option>
	<option value="CI">Côte d'Ivoire</option>
	<option value="HR">Croatia</option>
	<option value="CU">Cuba</option>
	<option value="CW">Curaçao</option>
	<option value="CY">Cyprus</option>
	<option value="CZ">Czech Republic</option>
	<option value="DK">Denmark</option>
	<option value="DJ">Djibouti</option>
	<option value="DM">Dominica</option>
	<option value="DO">Dominican Republic</option>
	<option value="EC">Ecuador</option>
	<option value="EG">Egypt</option>
	<option value="SV">El Salvador</option>
	<option value="GQ">Equatorial Guinea</option>
	<option value="ER">Eritrea</option>
	<option value="EE">Estonia</option>
	<option value="ET">Ethiopia</option>
	<option value="FK">Falkland Islands (Malvinas)</option>
	<option value="FO">Faroe Islands</option>
	<option value="FJ">Fiji</option>
	<option value="FI">Finland</option>
	<option value="FR">France</option>
	<option value="GF">French Guiana</option>
	<option value="PF">French Polynesia</option>
	<option value="TF">French Southern Territories</option>
	<option value="GA">Gabon</option>
	<option value="GM">Gambia</option>
	<option value="GE">Georgia</option>
	<option value="DE">Germany</option>
	<option value="GH">Ghana</option>
	<option value="GI">Gibraltar</option>
	<option value="GR">Greece</option>
	<option value="GL">Greenland</option>
	<option value="GD">Grenada</option>
	<option value="GP">Guadeloupe</option>
	<option value="GU">Guam</option>
	<option value="GT">Guatemala</option>
	<option value="GG">Guernsey</option>
	<option value="GN">Guinea</option>
	<option value="GW">Guinea-Bissau</option>
	<option value="GY">Guyana</option>
	<option value="HT">Haiti</option>
	<option value="HM">Heard Island and McDonald Islands</option>
	<option value="VA">Holy See (Vatican City State)</option>
	<option value="HN">Honduras</option>
	<option value="HK">Hong Kong</option>
	<option value="HU">Hungary</option>
	<option value="IS">Iceland</option>
	<option value="IN">India</option>
	<option value="ID">Indonesia</option>
	<option value="IR">Iran, Islamic Republic of</option>
	<option value="IQ">Iraq</option>
	<option value="IE">Ireland</option>
	<option value="IM">Isle of Man</option>
	<option value="IL">Israel</option>
	<option value="IT">Italy</option>
	<option value="JM">Jamaica</option>
	<option value="JP">Japan</option>
	<option value="JE">Jersey</option>
	<option value="JO">Jordan</option>
	<option value="KZ">Kazakhstan</option>
	<option value="KE">Kenya</option>
	<option value="KI">Kiribati</option>
	<option value="KP">Korea, Democratic People's Republic of</option>
	<option value="KR">Korea, Republic of</option>
	<option value="KW">Kuwait</option>
	<option value="KG">Kyrgyzstan</option>
	<option value="LA">Lao People's Democratic Republic</option>
	<option value="LV">Latvia</option>
	<option value="LB">Lebanon</option>
	<option value="LS">Lesotho</option>
	<option value="LR">Liberia</option>
	<option value="LY">Libya</option>
	<option value="LI">Liechtenstein</option>
	<option value="LT">Lithuania</option>
	<option value="LU">Luxembourg</option>
	<option value="MO">Macao</option>
	<option value="MK">Macedonia, the former Yugoslav Republic of</option>
	<option value="MG">Madagascar</option>
	<option value="MW">Malawi</option>
	<option value="MY">Malaysia</option>
	<option value="MV">Maldives</option>
	<option value="ML">Mali</option>
	<option value="MT">Malta</option>
	<option value="MH">Marshall Islands</option>
	<option value="MQ">Martinique</option>
	<option value="MR">Mauritania</option>
	<option value="MU">Mauritius</option>
	<option value="YT">Mayotte</option>
	<option value="MX">Mexico</option>
	<option value="FM">Micronesia, Federated States of</option>
	<option value="MD">Moldova, Republic of</option>
	<option value="MC">Monaco</option>
	<option value="MN">Mongolia</option>
	<option value="ME">Montenegro</option>
	<option value="MS">Montserrat</option>
	<option value="MA">Morocco</option>
	<option value="MZ">Mozambique</option>
	<option value="MM">Myanmar</option>
	<option value="NA">Namibia</option>
	<option value="NR">Nauru</option>
	<option value="NP">Nepal</option>
	<option value="NL">Netherlands</option>
	<option value="NC">New Caledonia</option>
	<option value="NZ">New Zealand</option>
	<option value="NI">Nicaragua</option>
	<option value="NE">Niger</option>
	<option value="NG">Nigeria</option>
	<option value="NU">Niue</option>
	<option value="NF">Norfolk Island</option>
	<option value="MP">Northern Mariana Islands</option>
	<option value="NO">Norway</option>
	<option value="OM">Oman</option>
	<option value="PK">Pakistan</option>
	<option value="PW">Palau</option>
	<option value="PS">Palestinian Territory, Occupied</option>
	<option value="PA">Panama</option>
	<option value="PG">Papua New Guinea</option>
	<option value="PY">Paraguay</option>
	<option value="PE">Peru</option>
	<option value="PH">Philippines</option>
	<option value="PN">Pitcairn</option>
	<option value="PL">Poland</option>
	<option value="PT">Portugal</option>
	<option value="PR">Puerto Rico</option>
	<option value="QA">Qatar</option>
	<option value="RE">Réunion</option>
	<option value="RO">Romania</option>
	<option value="RU">Russian Federation</option>
	<option value="RW">Rwanda</option>
	<option value="BL">Saint Barthélemy</option>
	<option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
	<option value="KN">Saint Kitts and Nevis</option>
	<option value="LC">Saint Lucia</option>
	<option value="MF">Saint Martin (French part)</option>
	<option value="PM">Saint Pierre and Miquelon</option>
	<option value="VC">Saint Vincent and the Grenadines</option>
	<option value="WS">Samoa</option>
	<option value="SM">San Marino</option>
	<option value="ST">Sao Tome and Principe</option>
	<option value="SA">Saudi Arabia</option>
	<option value="SN">Senegal</option>
	<option value="RS">Serbia</option>
	<option value="SC">Seychelles</option>
	<option value="SL">Sierra Leone</option>
	<option value="SG">Singapore</option>
	<option value="SX">Sint Maarten (Dutch part)</option>
	<option value="SK">Slovakia</option>
	<option value="SI">Slovenia</option>
	<option value="SB">Solomon Islands</option>
	<option value="SO">Somalia</option>
	<option value="ZA">South Africa</option>
	<option value="GS">South Georgia and the South Sandwich Islands</option>
	<option value="SS">South Sudan</option>
	<option value="ES">Spain</option>
	<option value="LK">Sri Lanka</option>
	<option value="SD">Sudan</option>
	<option value="SR">Suriname</option>
	<option value="SJ">Svalbard and Jan Mayen</option>
	<option value="SZ">Swaziland</option>
	<option value="SE">Sweden</option>
	<option value="CH">Switzerland</option>
	<option value="SY">Syrian Arab Republic</option>
	<option value="TW">Taiwan, Province of China</option>
	<option value="TJ">Tajikistan</option>
	<option value="TZ">Tanzania, United Republic of</option>
	<option value="TH">Thailand</option>
	<option value="TL">Timor-Leste</option>
	<option value="TG">Togo</option>
	<option value="TK">Tokelau</option>
	<option value="TO">Tonga</option>
	<option value="TT">Trinidad and Tobago</option>
	<option value="TN">Tunisia</option>
	<option value="TR">Turkey</option>
	<option value="TM">Turkmenistan</option>
	<option value="TC">Turks and Caicos Islands</option>
	<option value="TV">Tuvalu</option>
	<option value="UG">Uganda</option>
	<option value="UA">Ukraine</option>
	<option value="AE">United Arab Emirates</option>
	<option value="GB">United Kingdom</option>
	<option value="US">United States</option>
	<option value="UM">United States Minor Outlying Islands</option>
	<option value="UY">Uruguay</option>
	<option value="UZ">Uzbekistan</option>
	<option value="VU">Vanuatu</option>
	<option value="VE">Venezuela, Bolivarian Republic of</option>
	<option value="VN">Viet Nam</option>
	<option value="VG">Virgin Islands, British</option>
	<option value="VI">Virgin Islands, U.S.</option>
	<option value="WF">Wallis and Futuna</option>
	<option value="EH">Western Sahara</option>
	<option value="YE">Yemen</option>
	<option value="ZM">Zambia</option>
	<option value="ZW">Zimbabwe</option>
</select>&nbsp;</td>
        </tr>
        <tr>
          <td><b>Phone No. of Guardian</b></td>
          <td><span id="sprytextfield6">
            <label for="phoneNumber"></label>
            <input type="text" name="phoneNumber" id="phoneNumber" value="<?php echo $doc->phone?>">
            <span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
        </tr>
        <tr>
          <td><b>Login Code</b></td>
          <td><span id="sprytextfield3">
            <input name="pass" type="text" id="pass" readonly value="<?php echo $doc->pass?>">
          <span class="textfieldRequiredMsg"> required.</span></span></td>
        </tr>
        <tr>
          <td><img name="image" src="<?php echo $image;?>" style="max-width:150px" alt="">&nbsp;</td>
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
          <td><b>Upload New Photo</b></td>
          <td><input name="uploadedfile" type="file" />
          <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
          <input type="hidden" name="studentID" id="studentID" value="<?php echo $doc->_id ?>"></td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" class="button" value="Submit">
            <input name="Button" type="button" class="button" value="Reload Default" onClick="location.reload()">
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
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {isRequired:false});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "real", {isRequired:false});
</script>
</body>
<script type="text/javascript">
	var now = new Date()
	///now = now.toGMTString();
	var fmat= now.getFullYear()+'-'+ (now.getMonth()+1)+'-'+(now.getDay()+10)+' '+(now.getHours())+':'+(now.getMinutes())+':'+(now.getSeconds());
	document.getElementById('systemDateForm').value = fmat;
</script>
<script type="text/javascript">
$(function() { 
	$("#level").val(("<?php echo $doc->levels[0] ?>").toUpperCase());
	$("#nationality").val(("<?php echo $doc->nationality ?>").toUpperCase());
	getGender = '<?php echo $doc->gender ?>';
	if(getGender =="Male"){
		document.getElementById("Male_gender").checked=true;
	} else{
		document.getElementById("Female_gender").checked=true;
	}
});
</script>
</html>