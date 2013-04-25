<?php session_start(); error_reporting(1);include "talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"schEroll",
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
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
</head>
<?php
if(isset($_POST['schName']))
{
$savequery = mysql_query("UPDATE `schoolDetails` SET `schoolName` = '".$_POST['schName']."', `location` = '".$_POST['schLocation']."', `schoolType` = '".$_POST['schType']."', `dateOfEnrolment` = '".$_POST['schEroll']."'") or die(mysql_error());
 recordActionDate($_SESSION['name'],"Updated school registration destails",$_POST['systemDateForm']);
echo '<script type="text/javascript">alert("School records successfully updated");</script>';

die("School records successfully updated");

}
$shoolName ="";
$schoolEnr ="";
$shoolLocat="";
$schoolType="";

$query = mysql_query("SELECT * FROM  `schoolDetails` ") or die(mysql_error());
	while($data = mysql_fetch_array($query))
	{
		$shoolName =$data['schoolName'];
		$schoolEnr =$data['dateOfEnrolment'];
		$shoolLocat=$data['location'];
		$schoolType=$data['schoolType'];
	}
?>

<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:500px; margin-left:auto; margin-right:auto;"><span style="color: #00C; font-weight: bold;">School Details</span><br><br>
    <form name="form1" method="post" action="">
      <table width="95%">
        <tr>
          <td width="125"><b>Type</b></td>
          <td><span id="spryselect1">
            <select name="schType" id="schType">
            <?php if($schoolType=="Public School")
            {
				echo '<option value="Public School"  selected >Public School</option>
              <option value="Private School">Private School</option>';
            }else{
				echo '<option value="Public School">Public School</option>
              <option value="Private School"  selected >Private School</option>';
			}
			?>
            </select>
          <span class="selectRequiredMsg">*</span></span></td>
        </tr>
        <tr>
          <td><b>School Name</b></td>
          <td><span id="sprytextfield1">
            <input type="text" name="schName" id="schName" class="panjang" value="<?php echo $shoolName;?>">
          <span class="textfieldRequiredMsg">*</span></span></td>
        </tr>
        <tr>
          <td><b>Enrolment  to OLE date</b></td>
          <td><span id="sprytextfield2">
            <input type="text" name="schEroll" id="schEroll" value="<?php echo $schoolEnr;?>">
          <span class="textfieldRequiredMsg">*</span></span> eg. 22 / 08 / 2005</td>
        </tr>
        <tr>
          <td><b>Physical Location</b></td>
          <td><span id="sprytextfield4">
            <input name="schLocation" type="text" id="schLocation" value="<?php echo $shoolLocat;?>">
          <span class="textfieldRequiredMsg">A value is required.</span></span>eg. Town or Area</td>
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
<div class="clear"></div>
</div>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
</script>
</body>
<script type="text/javascript">
	var now = new Date()
	///now = now.toGMTString();
	var fmat= now.getFullYear()+'-'+ (now.getMonth()+1)+'-'+(now.getDay()+10)+' '+(now.getHours())+':'+(now.getMinutes())+':'+(now.getSeconds());
	document.getElementById('systemDateForm').value = fmat;
</script>
</html>