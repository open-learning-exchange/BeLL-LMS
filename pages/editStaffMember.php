<?php session_start();include "../secure/talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link href="../SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationRadio.css" rel="stylesheet" type="text/css">
<script src="../SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationRadio.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" media="all" href="../css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../js/jsDatePick.min.1.3.js"></script>

<script type="text/javascript">
	//window.onload = function(){
//		new JsDatePick({
//			useMode:2,
//			target:"dateOfBirth",
//			dateFormat:"%Y-%m-%d"
//		});
//	};
</script>
</head>
<?php
include "../functions/saveImageToCouch.php";
if(isset($_POST['firstName']))
{
	//global $couchUrl;
//	global $facilityId;
//	$members = new couchClient($couchUrl, "members");
//	$doc = new stdClass();
//	
//	// let's add some other properties
//	
//	$doc->kind ="Member";
//	$doc->dateOfBirth = strtotime($_POST['dateOfBirth']);
//	$doc->dateRegistered = strtotime($_POST['systemDateForm']);
//	$doc->facilityId = $facilityId;
//	$doc->firstName = $_POST['firstName'];
//	$doc->lastName = $_POST['lastName'];
//	$doc->middleNames = $_POST['middleNames'];
//	$doc->gender = $_POST['gender'];
//	$doc->login = $_POST['login'];
//	$doc->pass = $_POST['password'];
//	$roles = array();
//	foreach($_POST['role'] as $role) {
//		array_push($roles,$role);
//	}
//	$doc->role = $roles;
//	
//try {
//	$response = $members->storeDoc($doc);
//	$members->storeAttachment($members->getDoc($response->id),$_FILES['uploadedfile']['tmp_name'], mime_content_type($_FILES['uploadedfile']['tmp_name']));
//} catch ( Exception $e ) {
//	die("Unable to store the document : ".$e->getMessage());
//}
//	//@todo better log information
//  recordActionDate($_SESSION['lmsUserID'],"Created new account for ".$members->getDoc($response->id),$_POST['systemDateForm']);
//  
//  die( $_POST['firstName']." ".$_POST['middleNames']." ".$_POST['lastName']." successfully added to members ".$_POST['Class']);
}
else if(isset($_GET['edit']))
{
	global $couchUrl;
	global $facilityId;
	$members = new couchClient($couchUrl, "members");
	$docToEdit = $members->getDoc($_GET['edit']);
	$docToEditAttachment = $docToEdit->_attachments;
	foreach($docToEditAttachment as $key => $value){
			$image = $couchUrl."/members/".$_GET['edit']."/".urlencode($key)."";
	}
}
?>

<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:550px; margin-left:auto; margin-right:auto;">
  <span style="color:#00C; font-weight: bold;">Manage Accessibility and Privilege - Edit Profile</span><br><br>
    <form action="" method="post" enctype="multipart/form-data" name="form1">
      
      <fieldset style="border-color:#CCC;color:#666;">
        <legend style="font-size: 14px; color: #009; font-style: italic;">New Member</legend>
        <table width="95%" align="center">
        
          <tr>
            <td><b>Privilage / Role</b></td>
            <td colspan="2"><p>
                <label>
                  <input name="role[]" type="checkbox" id="role_0" value="teacher" onChange="triggerClassAssigned()" checked="CHECKED">
                Teacher</label> &nbsp;&nbsp;&nbsp;
                <label>
                  <input type="checkbox" name="role[]" value="leadteacher" id="role_1">
                  Leadteacher</label> 
                <label>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="role[]" value="headteacher" id="role_2">
                  Headteacher</label>&nbsp;&nbsp;&nbsp;
                <label>
                  <input type="checkbox" name="role[]" value="coach" id="role_3">
                  Coach</label>
                <br>
                <br>
              </p></td>
          </tr>
          <tr>
            <td><b id="classAssignedLabel">Class Assigned</b></td>
            <td colspan="2"><p id="classAssignedID">
              <label>
                <input type="checkbox" name="classAssigned[]" value="KG1" id="classAssigned_0">
                KG 1&nbsp;</label>
&nbsp;&nbsp;
<label></label>
&nbsp;&nbsp;
<label>&nbsp;&nbsp;</label>
              <label>
                <input type="checkbox" name="classAssigned[]" value="KG2" id="classAssigned_1">
                KG 2&nbsp;&nbsp;</label>
&nbsp;&nbsp;
<label></label>
&nbsp;&nbsp;
<label>&nbsp;</label>
              <label>
                <input type="checkbox" name="classAssigned[]" value="P1" id="classAssigned_2">
                P 1&nbsp;</label>
&nbsp;&nbsp;
<label></label>
&nbsp;&nbsp;
<label>&nbsp;&nbsp;</label>
              <label>
                <input type="checkbox" name="classAssigned[]" value="P2" id="classAssigned_3">
                P 2&nbsp;&nbsp;&nbsp;<br>
                <br>
              </label>
                <label>
                <input type="checkbox" name="classAssigned[]" value="P3" id="classAssigned_4">
                P 3</label>
                &nbsp;&nbsp;&nbsp;
                <label></label>
&nbsp;&nbsp;
<label></label>
&nbsp;&nbsp;
<label></label>
&nbsp;&nbsp;
                <label>
                  <input type="checkbox" name="classAssigned[]" value="P4" id="classAssigned_5">
                P 4</label>
                &nbsp;&nbsp;&nbsp;
                <label></label>
&nbsp;&nbsp;
<label></label>
&nbsp;&nbsp;
<label></label>
&nbsp;&nbsp;&nbsp;&nbsp;
                <label>
                  <input type="checkbox" name="classAssigned[]" value="P5" id="classAssigned_6">
                P 5</label>
                &nbsp;
                <label></label>
&nbsp;&nbsp;
<label></label>
&nbsp;&nbsp;&nbsp;
                <label>
                  <input type="checkbox" name="classAssigned[]" value="P6" id="classAssigned_7">
                P 6</label>
            </p></td>
          </tr>
          <tr>
            <td><b>First Name</b></td>
            <td colspan="2"><span id="sprytextfield1">
              <label for="firstName"></label>
              <input type="text" name="firstName" id="firstName" value="<?php echo $docToEdit->firstName?>">
              <span class="textfieldRequiredMsg">A value is required.</span></span>
            </td>
</tr>
          <tr>
            <td><b> Last Name</b></td>
            <td colspan="2">
              <label for="lastName"></label>
              <span id="sprytextfield2">
              <label for="lastName3"></label>
              <input name="lastName" type="text" id="lastName3" value="<?php echo $docToEdit->lastName?>">
            <span class="textfieldRequiredMsg">A value is required.</span></span></td>
          </tr>
          <tr>
            <td><b> Middle Names</b></td>
            <td colspan="2">
              <label for="middleNames"></label>
              <span id="sprytextfield3">
              <label for="middleNames2"></label>
              <input name="middleNames" type="text" id="middleNames2" value="<?php echo $docToEdit->middleNames?>">
            <span class="textfieldRequiredMsg">A value is required.</span></span></td>
          </tr>
          <tr>
            <td><b>Date Of Birth</b></td>
            <td colspan="2">
              <label for="dateOfBirth"></label>
              <span id="sprytextfield4">
              <label for="dateOfBirth2"></label>
              <input name="dateOfBirth" type="text" id="dateOfBirth" value="<?php echo $docToEdit->dateOfBirth?>">
            <span class="textfieldRequiredMsg">A value is required.</span></span></td>
          </tr>
          <tr>
            <td><b>Gender</b></td>
            <td colspan="2">
              <label>
                <input type="radio" name="gender" value="Male" id="gender_0">
                Male</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <label>
                <input type="radio" name="gender" value="Female" id="gender_1">
                Female</label></td>
          </tr>
          <tr>
            <td><b>Nationality</b></td>
            <td colspan="2"><select name="nationality">
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
            </select>
            &nbsp;</td>
          </tr>
          <tr>
            <td width="143"><b>Phone Number</b></td>
            <td colspan="2"><span id="sprytextfield5">
              <label for="phoneNumber"></label>
              <input name="phoneNumber" type="text" id="phoneNumber" value="<?php echo $docToEdit->phone?>">
            <span class="textfieldRequiredMsg">A value is required.</span></span></td>
</tr>
          <tr>
            <td><b>Login ID</b></td>
            <td colspan="2"><span id="sprytextfield6">
              <label for="login"></label>
              <input name="login" type="text" id="login" value="<?php echo $docToEdit->login?>">
            <span class="textfieldRequiredMsg">A value is required.</span></span></td>
</tr>
          <tr>
            <td><b>Password</b></td>
            <td colspan="2"><span id="sprypassword1">
              <label for="password"></label>
              <input name="password" type="password" id="password" value="<?php echo $docToEdit->pass?>">
            <span class="passwordRequiredMsg">A value is required.</span></span></td>
</tr>
          <tr>
            <td><b>Confirm Password</b></td>
            <td colspan="2"><span id="spryconfirm1">
              <label for="confirmPass"></label>
              <input name="confirmPass" type="password" id="confirmPass" value="<?php echo $docToEdit->pass?>">
            <span class="confirmRequiredMsg">A value is required.</span><span class="confirmInvalidMsg">The values don't match.</span></span></td>
</tr>
          <tr>
            <td colspan="2" rowspan="2"><img name="image" src="<?php echo $image;?>" style="max-width:150px" alt=""></td>
            <td width="355"><strong>Upload new photo</strong></td>
          </tr>
          <tr>
            <td><input name="uploadedfile" type="file" />
            <input type="hidden" name="MAX_FILE_SIZE" value="100000" /></td>
          </tr>
          <tr>
            <td></td>
            <td colspan="2"><input type="submit" class="button" value="Update">
              <input type="reset" class="button" value="Cancel">
              <input type="hidden" name="systemDateForm" id="systemDateForm"></td>
          </tr>
        </table>
        <br>
        <br>
  </fieldset>
    </form>
  </div>
<div class="clear"></div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1");
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "password");
</script>
</body>
<script type="text/javascript">
	var now = new Date()
	///now = now.toGMTString();
	var fmat= now.getFullYear()+'-'+ (now.getMonth()+1)+'-'+(now.getDay()+10)+' '+(now.getHours())+':'+(now.getMinutes())+':'+(now.getSeconds());
	document.getElementById('systemDateForm').value = fmat;
	
	function triggerClassAssigned(){
		if(document.getElementById("role_0").checked){
			document.getElementById("classAssignedID").style.display ="block";
			document.getElementById("classAssignedLabel").style.display ="block";
		}else{
			document.getElementById("classAssignedID").style.display ="none";
			document.getElementById("classAssignedLabel").style.display ="none";
		}
	}
</script>
</html>