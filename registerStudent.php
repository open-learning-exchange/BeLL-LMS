<?php session_start(); error_reporting(1);include "talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationRadio.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"stuDob",
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
<script src="SpryAssets/SpryValidationRadio.js" type="text/javascript"></script>
</head>
<?php
if(isset($_POST['logCode']))
{
	
$savequery = mysql_query("INSERT INTO `students` (`colNum`, `stuCode`, `stuName`, `stuClass`, `stuDOB`, `stuGender`, `DateRegistered`) VALUES (NULL, '".$_POST['logCode']."', '".$_POST['stuName']."', '".$_POST['stuClass']."', '".$_POST['stuDob']."', '".$_POST['stuGender']."','".$_POST['systemDateForm']."')") or die(mysql_error());

 recordActionDate($_SESSION['name']," Added a new student by name ".$_POST['stuName']." in ".$_POST['stuClass'],$_POST['systemDateForm']);
 
echo '<script type="text/javascript">alert("Successfully Added \n Student Name:'.$_POST['stuName'].'\n Please save student code : '.$_POST['logCode'].'");</script>';
die("Successfully Added <br>Student Name:".$_POST['stuName']."<br> Please save student code : ".$_POST['logCode']);

}
?>

<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div id="rightContent" style="float: none; margin-left: auto; margin-right: auto; width: 500px; margin-left: auto; margin-right: auto;">
    <span style="color: #00C; font-weight: bold;">Register Students</span><br><br>
    <form name="form1" method="post" action="">
      <table width="95%">
        <tr>
          <td width="125"><b>Level / Class </b></td>
          <td>
            <select name="stuClass" id="stuClass">
              <option value="KG">KG</option>
              <option value="P1">P1</option>
              <option value="P2">P2</option>
              <option value="P3">P3</option>
              <option value="P4">P4</option>
              <option value="P5">P5</option>
              <option value="P6">P6</option>
            </select>
          <span class="selectRequiredMsg">*</span></td>
        </tr>
        <tr>
          <td><b>Student Name</b></td>
          <td>
          <span id="sprytextfield1">
            <input type="text" name="stuName" id="stuName" class="panjang">
          <span class="textfieldRequiredMsg">*</span></span></td>
        </tr>
        <tr>
          <td><b>Date Of Birth</b></td>
          <td><span id="sprytextfield2">
            <input type="text" name="stuDob" id="stuDob">
          <span class="textfieldRequiredMsg">*</span></span> eg. 2005-08-15</td>
        </tr>
        <tr>
          <td><b>Gender</b></td>
          <td>
            <label>
              <input name="stuGender" type="radio" id="stuGender_0" value="Male" checked="CHECKED">
              Male</label>
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="radio" name="stuGender" value="Female" id="stuGender_1">
              Female</label>
          <span class="radioRequiredMsg">*</span></td>
        </tr>
        <tr>
          <td><b>Login Code</b></td>
          <td><span id="sprytextfield3">
            <input name="logCode" type="text" id="logCode" readonly>
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
	var existText = document.getElementById("logCode").value;
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
	document.getElementById("logCode").value = existText;
}
</script>
</body>
<script type="text/javascript">
	var now = new Date()
	///now = now.toGMTString();
	var fmat= now.getFullYear()+'-'+ (now.getMonth()+1)+'-'+(now.getDay()+10)+' '+(now.getHours())+':'+(now.getMinutes())+':'+(now.getSeconds());
	document.getElementById('systemDateForm').value = fmat;
</script>
</html>