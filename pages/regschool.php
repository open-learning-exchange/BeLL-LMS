<?php session_start();include "../secure/talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="all" href="../css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"enroll",
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
</head>
<?php
if(isset($_POST['name']))
{
	global $couchUrl;
	global $facilityId;
	$facility = new couchClient($couchUrl, "facilities");
	$facilityDetails = $facility->getDoc($facilityId);
	$facilityDetails->type = $_POST['Type'];
	$facilityDetails->GPS[0]=$_POST['lat'];
	$facilityDetails->GPS[1]=$_POST['lon'];
	$facilityDetails->phone=$_POST['phone'];
	$facilityDetails->name=$_POST['name'];
	$facilityDetails->country=$_POST['nation'];
	$facilityDetails->region=$_POST['region'];
	$facilityDetails->district=$_POST['district'];
	$facilityDetails->area=$_POST['area'];
	$facilityDetails->street=$_POST['street'];
	$facilityDetails->enrollDate=$_POST['enroll'];
	$facility->storeDoc($facilityDetails);
	recordActionObject($_SESSION['lmsUserID'],"updated school details (student)",$docId);
	echo '<script type="text/javascript">alert("School records successfully updated");</script>';
	
	
}
global $couchUrl;
global $facilityId;
$facility = new couchClient($couchUrl, "facilities");
$facilityDetails = $facility->getDoc($facilityId);
//print_r($facilityDetails);

?>

<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:500px; margin-left:auto; margin-right:auto;"><span style="color: #00C; font-weight: bold;">School Details</span><br><br>
    <form name="form1" method="post" action="">
      <table width="95%" align="center">
        <tr>
          <td width="125"><b>Type</b></td>
          <td><span id="spryselect1">
            <select name="Type" id="Type">
            <<option value="Public School">Public School</option>
              <option value="Private School">Private School</option>
            </select>
          <span class="selectRequiredMsg">*</span></span>
            <input type="hidden" name="secretField" value="badValueEqualsBadClient"></td>
        </tr>
        <tr>
          <td><b>School Name</b></td>
          <td><span id="sprytextfield1">
            <input type="text" name="name" id="name" class="panjang" value="<?php echo  $facilityDetails->name;?>">
          <span class="textfieldRequiredMsg">*</span></span></td>
        </tr>
        <tr>
          <td><b>Date Enrolled  unto OLE </b></td>
          <td><span id="sprytextfield2">
            <input type="text" name="enroll" id="enroll" value="<?php echo $facilityDetails->enrollDate;?>">
          <span class="textfieldRequiredMsg">*</span></span> eg. 22 / 08 / 2005</td>
        </tr>
        <tr>
          <td><b>Phone Number</b></td>
          <td><span id="sprytextfield7">
            <label for="phone"></label>
            <input type="text" name="phone" id="phone" value="<?php echo  $facilityDetails->phone;?>">
</span></td>
        </tr>
        <tr>
          <td><b>Street</b></td>
          <td><span id="sprytextfield6">
            <label for="street"></label>
            <input type="text" name="street" id="street"  value="<?php echo $facilityDetails->street?>">
</span></td>
        </tr>
        <tr>
          <td><b>Area</b></td>
          <td><span id="sprytextfield4">
            <input name="area" type="text" id="area" value="<?php echo $facilityDetails->area?>">
</span>eg. Town or Area
            </td>
        </tr>
        <tr>
          <td><b>District</b></td>
          <td><span id="sprytextfield3">
            <label for="district"></label>
            <input name="district" type="text" id="district" value="<?php echo $facilityDetails->district;?>">
</span></td>
        </tr>
        <tr>
          <td><b>Region</b></td>
          <td><span id="sprytextfield5">
            <label for="region"></label>
            <input name="region" type="text" id="region" value="<?php echo $facilityDetails->region;?>">
</span></td>
        </tr>
        <tr>
          <td><b>Country</b></td>
          <td><select name="nation" id="nation" style="font-size:10px; float:left;">
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
                    <option value="gh" >Ghana</option>
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
          </select>&nbsp;</td>
        </tr>
        <tr>
          <td><b>GPS Co-ordinate</b></td>
          <td>Lat&nbsp;&nbsp;
<input type="text" name="lat" id="lat" style="width:57px" value="<?php echo $facilityDetails->GPS[0];?>">
         &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lon&nbsp;&nbsp;<input type="text" name="lon" id="lon" style="width:57px" value="<?php echo $facilityDetails->GPS[1];?>"></td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" class="button" value="Update Record">
            <input type="reset" class="button" value="Reset">  
            <input type="hidden" name="systemDateForm" id="systemDateForm"></td>
        </tr>
      </table>
    </form>
  </div>
<div class="clear"></div>
</div>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {isRequired:false});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {isRequired:false});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {isRequired:false});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {isRequired:false});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {isRequired:false});
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
	$("#nation").val("<?php echo $facilityDetails->country; ?>");
	$("#Type").val("<?php echo $facilityDetails->type; ?>");
});
</script>
</html>