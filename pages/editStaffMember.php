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
<script type="text/javascript" src="../js/jquery.js"></script>

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
	global $couchUrl;
	global $facilityId;
	$members = new couchClient($couchUrl, "members");
	$groups = new couchClient($couchUrl, "groups");
	$checkedLevels = array();
	$doc = $members->getDoc($_POST['memberID']);
	// get data from form and save it to couch
	$doc->kind ="Member";
	$doc->dateOfBirth = strtotime($_POST['dateOfBirth']);
	$doc->dateRegistered = strtotime($_POST['systemDateForm']);
	$doc->facilityId = $facilityId;
	$doc->firstName = $_POST['firstName'];
	$doc->lastName = $_POST['lastName'];
	$doc->middleNames = $_POST['middleNames'];
	$doc->nationality = strtolower($_POST['nationality']);
	$doc->gender = $_POST['gender'];
	$doc->login = $_POST['login'];
	$doc->pass = md5($_POST['password']);
	$doc->phone = $_POST['phoneNumber'];
	foreach($_POST['classAssigned'] as $levels){
		$groupsDoc= $groups->getDoc($levels);
		for($grpCnt=0;$grpCnt<sizeof($groupsDoc->level);$grpCnt++){
			array_push($checkedLevels,$groupsDoc->level[$grpCnt]);
		}
	}
	$doc->levels = $checkedLevels;
	
	// roles is an array.. get selected roles 
	$roles = array();
	foreach($_POST['role'] as $role) {
		array_push($roles,$role);
	}
	$doc->roles = $roles;
	//print_r($doc);
	// save doc to couch and for responce->id
	$response = $members->storeDoc($doc);
	
	
	try {
	// add attached image to document with specified id from response
			$members->storeAttachment($members->getDoc($response->id),$_FILES['uploadedfile']['tmp_name'], mime_content_type($_FILES['uploadedfile']['tmp_name']));
	} catch ( Exception $e ) {
		print ("No photo uploaded");
	}
	
	// Save group assigned to member in group document
	foreach($_POST['classAssigned'] as $groupID){
		$groupDoc = $groups->getDoc($groupID);
		array_push($groupDoc->owners,$response->id);
		$groups->storeDoc($groupDoc);
	}
	//@todo better log information
  ////recordActionDate($_SESSION['lmsUserID'],"Created new account for ".$members->getDoc($response->id),$_POST['systemDateForm']);
  echo "<br/>".$_POST['firstName']." ".$_POST['middleNames']." ".$_POST['lastName']." successfully added to members ".$_POST['Class'].'<br><br>';
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
            <td colspan="2"><select name="nationality" id="nationality" style="font-size:10px; float:left;">
              <option value="af" >Afghanistan</option>
              <option value="ax" >Aland Islands</option>
              <option value="al" >Albania</option>
              <option value="dz" >Algeria</option>
              <option value="as" >American Samoa</option>
              <option value="ad" >Andorra</option>
              <option value="ao" >Angola</option>
              <option value="ai" >Anguilla</option>
              <option value="aq" >Antarctica</option>
              <option value="ag" >Antigua and Barbuda</option>
              <option value="ar" >Argentina</option>
              <option value="am" >Armenia</option>
              <option value="aw" >Aruba</option>
              <option value="au" >Australia</option>
              <option value="at" >Austria</option>
              <option value="az" >Azerbaijan</option>
              <option value="bs" >Bahamas</option>
              <option value="bh" >Bahrain</option>
              <option value="bd" >Bangladesh</option>
              <option value="bb" >Barbados</option>
              <option value="by" >Belarus</option>
              <option value="be" >Belgium</option>
              <option value="bz" >Belize</option>
              <option value="bj" >Benin</option>
              <option value="bm" >Bermuda</option>
              <option value="bt" >Bhutan</option>
              <option value="bo" >Bolivia</option>
              <option value="bq" >Bonaire</option>
              <option value="ba" >Bosnia and Herzegovina</option>
              <option value="bw" >Botswana</option>
              <option value="bv" >Bouvet Island</option>
              <option value="br" >Brazil</option>
              <option value="bn" >Brunei Darussalam</option>
              <option value="bg" >Bulgaria</option>
              <option value="bf" >Burkina Faso</option>
              <option value="bi" >Burundi</option>
              <option value="kh" >Cambodia</option>
              <option value="cm" >Cameroon</option>
              <option value="ca" >Canada</option>
              <option value="cv" >Cape Verde</option>
              <option value="ky" >Cayman Islands</option>
              <option value="cf" >Central African Republic</option>
              <option value="td" >Chad</option>
              <option value="cl" >Chile</option>
              <option value="cn" >China</option>
              <option value="cx" >Christmas Island</option>
              <option value="cc" >Cocos (Keeling) Islands</option>
              <option value="co" >Colombia</option>
              <option value="km" >Comoros</option>
              <option value="cg" >Congo</option>
              <option value="cd" >Congo Republic of the</option>
              <option value="ck" >Cook Islands</option>
              <option value="cr" >Costa Rica</option>
              <option value="ci" >Cote d'Ivoire</option>
              <option value="hr" >Croatia</option>
              <option value="cu" >Cuba</option>
              <option value="cw" >Curacao</option>
              <option value="cy" >Cyprus</option>
              <option value="cz" >Czech Republic</option>
              <option value="dk" >Denmark</option>
              <option value="dj" >Djibouti</option>
              <option value="dm" >Dominica</option>
              <option value="do" >Dominican Republic</option>
              <option value="ec" >Ecuador</option>
              <option value="eg" >Egypt</option>
              <option value="sv" >El Salvador</option>
              <option value="gq" >Equatorial Guinea</option>
              <option value="er" >Eritrea</option>
              <option value="ee" >Estonia</option>
              <option value="et" >Ethiopia</option>
              <option value="fo" >Faroe Islands</option>
              <option value="fj" >Fiji</option>
              <option value="fi" >Finland</option>
              <option value="fr" >France</option>
              <option value="gf" >French Guiana</option>
              <option value="pf" >French Polynesia</option>
              <option value="ga" >Gabon</option>
              <option value="gm" >Gambia</option>
              <option value="ge" >Georgia</option>
              <option value="de" >Germany</option>
              <option value="gh" selected >Ghana</option>
              <option value="gi" >Gibraltar</option>
              <option value="gr" >Greece</option>
              <option value="gl" >Greenland</option>
              <option value="gd" >Grenada</option>
              <option value="gp" >Guadeloupe</option>
              <option value="gu" >Guam</option>
              <option value="gt" >Guatemala</option>
              <option value="gg" >Guernsey</option>
              <option value="gn" >Guinea</option>
              <option value="gw" >Guinea-Bissau</option>
              <option value="gy" >Guyana</option>
              <option value="ht" >Haiti</option>
              <option value="va" >Holy See (Vatican City State)</option>
              <option value="hn" >Honduras</option>
              <option value="hk" >Hong Kong</option>
              <option value="hu" >Hungary</option>
              <option value="is" >Iceland</option>
              <option value="in" >India</option>
              <option value="id" >Indonesia</option>
              <option value="ir" >Iran</option>
              <option value="iq" >Iraq</option>
              <option value="ie" >Ireland</option>
              <option value="im" >Isle of Man</option>
              <option value="il" >Israel</option>
              <option value="it" >Italy</option>
              <option value="jm" >Jamaica</option>
              <option value="jp" >Japan</option>
              <option value="je" >Jersey</option>
              <option value="jo" >Jordan</option>
              <option value="kz" >Kazakhstan</option>
              <option value="ke" >Kenya</option>
              <option value="ki" >Kiribati</option>
              <option value="kp" >Korea</option>
              <option value="kr" >Korea</option>
              <option value="kw" >Kuwait</option>
              <option value="kg" >Kyrgyzstan</option>
              <option value="lv" >Latvia</option>
              <option value="lb" >Lebanon</option>
              <option value="ls" >Lesotho</option>
              <option value="lr" >Liberia</option>
              <option value="ly" >Libyan Arab Jamahiriya</option>
              <option value="li" >Liechtenstein</option>
              <option value="lt" >Lithuania</option>
              <option value="lu" >Luxembourg</option>
              <option value="mo" >Macao</option>
              <option value="mk" >Macedonia</option>
              <option value="mg" >Madagascar</option>
              <option value="mw" >Malawi</option>
              <option value="my" >Malaysia</option>
              <option value="mv" >Maldives</option>
              <option value="ml" >Mali</option>
              <option value="mt" >Malta</option>
              <option value="mh" >Marshall Islands</option>
              <option value="mq" >Martinique</option>
              <option value="mr" >Mauritania</option>
              <option value="mu" >Mauritius</option>
              <option value="yt" >Mayotte</option>
              <option value="mx" >Mexico</option>
              <option value="fm" >Micronesia</option>
              <option value="md" >Moldova</option>
              <option value="mc" >Monaco</option>
              <option value="mn" >Mongolia</option>
              <option value="me" >Montenegro</option>
              <option value="ms" >Montserrat</option>
              <option value="ma" >Morocco</option>
              <option value="mz" >Mozambique</option>
              <option value="mm" >Myanmar</option>
              <option value="na" >Namibia</option>
              <option value="nr" >Nauru</option>
              <option value="np" >Nepal</option>
              <option value="nl" >Netherlands</option>
              <option value="nc" >New Caledonia</option>
              <option value="nz" >New Zealand</option>
              <option value="ni" >Nicaragua</option>
              <option value="ne" >Niger</option>
              <option value="ng" >Nigeria</option>
              <option value="nu" >Niue</option>
              <option value="nf" >Norfolk Island</option>
              <option value="mp" >N. Mariana Islands</option>
              <option value="no" >Norway</option>
              <option value="om" >Oman</option>
              <option value="pk" >Pakistan</option>
              <option value="pw" >Palau</option>
              <option value="ps" >Palestinian</option>
              <option value="pa" >Panama</option>
              <option value="pg" >Papua New Guinea</option>
              <option value="py" >Paraguay</option>
              <option value="pe" >Peru</option>
              <option value="ph" >Philippines</option>
              <option value="pn" >Pitcairn</option>
              <option value="pl" >Poland</option>
              <option value="pt" >Portugal</option>
              <option value="pr" >Puerto Rico</option>
              <option value="qa" >Qatar</option>
              <option value="re" >Reunion</option>
              <option value="ro" >Romania</option>
              <option value="ru" >Russian Federation</option>
              <option value="rw" >Rwanda</option>
              <option value="bl" >Saint Barthelemy</option>
              <option value="sh" >Saint Helena</option>
              <option value="kn" >Saint Kitts and Nevis</option>
              <option value="lc" >Saint Lucia</option>
              <option value="mf" >Saint Martin</option>
              <option value="pm" >Saint Pierre and Miquelon</option>
              <option value="vc" >Saint Vincent </option>
              <option value="ws" >Samoa</option>
              <option value="sm" >San Marino</option>
              <option value="st" >Sao Tome and Principe</option>
              <option value="sa" >Saudi Arabia</option>
              <option value="sn" >Senegal</option>
              <option value="rs" >Serbia</option>
              <option value="sc" >Seychelles</option>
              <option value="sl" >Sierra Leone</option>
              <option value="sg" >Singapore</option>
              <option value="sx" >Sint Maarten (Dutch Part)</option>
              <option value="sk" >Slovakia</option>
              <option value="si" >Slovenia</option>
              <option value="sb" >Solomon Islands</option>
              <option value="so" >Somalia</option>
              <option value="za" >South Africa</option>
              <option value="gs" >South Georgia</option>
              <option value="ss" >South Sudan</option>
              <option value="es" >Spain</option>
              <option value="lk" >Sri Lanka</option>
              <option value="sd" >Sudan</option>
              <option value="sr" >Suriname</option>
              <option value="sj" >Svalbard and Jan Mayen</option>
              <option value="sz" >Swaziland</option>
              <option value="se" >Sweden</option>
              <option value="ch" >Switzerland</option>
              <option value="sy" >Syrian Arab Republic</option>
              <option value="tw" >Taiwan</option>
              <option value="tj" >Tajikistan</option>
              <option value="tz" >Tanzania</option>
              <option value="th" >Thailand</option>
              <option value="tl" >Timor-Leste</option>
              <option value="tg" >Togo</option>
              <option value="tk" >Tokelau</option>
              <option value="to" >Tonga</option>
              <option value="tt" >Trinidad and Tobago</option>
              <option value="tn" >Tunisia</option>
              <option value="tr" >Turkey</option>
              <option value="tm" >Turkmenistan</option>
              <option value="tc" >Turks and Caicos Islands</option>
              <option value="tv" >Tuvalu</option>
              <option value="ug" >Uganda</option>
              <option value="ua" >Ukraine</option>
              <option value="ae" >United Arab Emirates</option>
              <option value="gb" >United Kingdom</option>
              <option value="us" >United States</option>
              <option value="uy" >Uruguay</option>
              <option value="uz" >Uzbekistan</option>
              <option value="vu" >Vanuatu</option>
              <option value="ve" >Venezuela</option>
              <option value="vn" >Viet Nam</option>
              <option value="vg" >Virgin Islands, British</option>
              <option value="vi" >Virgin Islands, U.S.</option>
              <option value="wf" >Wallis and Futuna</option>
              <option value="eh" >Western Sahara</option>
              <option value="ye" >Yemen</option>
              <option value="zm" >Zambia</option>
              <option value="zw" >Zimbabwe</option>
            </select>              &nbsp;</td>
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
              <input type="hidden" name="systemDateForm" id="systemDateForm">
              <input type="hidden" name="memberID" id="memberID" value="<?php echo $docToEdit->_id?>"></td>
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
<script type="text/javascript">
$(function() { 
	//$("#level").val(("<?php echo $doc->levels[0] ?>").toUpperCase());
	$("#nationality").val(("<?php echo $doc->$docToEdit ?>").toUpperCase());
	getGender = '<?php echo $doc->gender ?>';
	if(getGender =="Male"){
		document.getElementById("Male_gender").checked=true;
	} else{
		document.getElementById("Female_gender").checked=true;
	}
});
</script>

</html>