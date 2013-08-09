<?php session_start();include "../secure/talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css">
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
</head>
<?php
if(isset($_POST['name']))
{
	$savData = mysql_query("INSERT INTO `teacherClass` (`colNum`, `Name`, `Contact`, `loginId`, `pswd`, `classAssign`, `Role`) VALUES (NULL, '".$_POST['name']."', '".$_POST['contact']."', '".$_POST['logid']."', MD5('".$_POST['password']."'), '".$_POST['Class']."', '".$_POST['role']."');") or die(mysql_error());
	recordActionDate($_SESSION['name'],"Created new account for ".$_POST['name']."",$_POST['systemDateForm']);
	
	echo '<script type="text/javascript">alert("'.$_POST['name'].' successfully added as '.$_POST['role'].' for '.$_POST['Class'].'");</script>';
	die($_POST['name']." successfully added as ".$_POST['role']." for ".$_POST['Class']);
}
else if(isset($_GET['drop']))
{
	$delItem = mysql_query("DELETE FROM `teacherClass` WHERE `colNum` = ".$_GET['drop']."") or die(mysql_query());
	recordAction($_SESSION['name'],"Deleted account");
	
	echo '<script type="text/javascript">alert("Account deleted succesfully");</script>';
	die("Deleted Succesfully");
}
?>

<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:500px; margin-left:auto; margin-right:auto;">
  <span style="color:#00C; font-weight: bold;">Manage Class</span><br><br>
    <form name="form1" method="post" action="">
      <table width="72%">
        <tr>
          <td width="133"><b> Teacher Name</b></td>
          <td width="207"><span id="sprytextfield1">
            <input type="text" name="name" id="name">
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td width="133"><b> Contact</b></td>
          <td><span id="sprytextfield2">
            <input type="text" name="contact" id="contact">
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td><b>Login ID</b></td>
          <td><span id="sprytextfield3">
            <input type="text" name="logid" id="logid">
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td><b>Password</b></td>
          <td><span id="sprypassword1">
            <input type="password" name="password" id="password">
          <span class="passwordRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td><b>Confirm Password</b></td>
          <td><span id="spryconfirm1">
            <input type="password" name="confPassword" id="confPassword">
          <span class="confirmRequiredMsg">A value is required.</span><span class="confirmInvalidMsg">The values don't match.</span></span></td>
        </tr>
        <tr>
          <td><b>Role</b></td>
          <td><span id="spryselect2">
            <select name="role" id="role">
             <!-- <option value="Admin">Admin</option>-->
              <option value="Teacher">Teacher</option>
              <option value="Coach">Coach</option>
              <option value="Lead">Lead</option>
              <option value="Head">Head</option>
            </select>
          <span class="selectRequiredMsg">Please select an item.</span></span></td>
        </tr>
        <tr>
          <td><b>Class</b></td>
          <td><span id="spryselect1">
          <select name="Class" id="Class">
            <option value="General">General</option>
            <option value="KG">KG</option>
            <option value="P1">P1</option>
            <option value="P2">P2</option>
            <option value="P3">P3</option>
            <option value="P4">P4</option>
            <option value="P5">P5</option>
            <option value="P6">P6</option>
          </select>
          <span class="selectRequiredMsg">Please select an item.</span></span></td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" class="button" value="Submit">
            <input type="reset" class="button" value="Reset">
            <input type="hidden" name="systemDateForm" id="systemDateForm"></td>
        </tr>
      </table>
    </form>
    <form name="form1" method="post" action="">
      <table width="72%" align="center">
      <tr>        </tr>
      <tr>        </tr>
      </table>
      <table width="478" height="60" border="1">
        <tr>
          <td width="32" height="26">No.</td>
          <td width="83"><b>Class / Level</b></td>
          <td width="178"><b>Teacher's Name</b></td>
          <td width="93"><b>Teacher's ID</b></td>
          <td width="58"><b>Action</b></td>
        </tr>
         <?php
			 $query = mysql_query("SELECT * FROM `teacherClass` ") or die(mysql_error());
			 $cnt=1;
			 while($data = mysql_fetch_array($query))
			 {
				 	echo '<tr>
          <td width="32" height="26">No.</td>
          <td width="83">'.$data['classAssign'].'</td>
          <td width="178">'.$data['Name'].'</td>
          <td width="93">'.$data['loginId'].'</td>
          <td width="58"><a href="ManClasses.php?drop='.$data['colNum'].'" >Drop</a></td>
        </tr>';
				 $cnt++;
			 }
          ?>
        
      </table>
      <table width="72%" align="center">
        <tr> </tr>
        <tr> </tr>
      </table>
    </form>
  </div>
<div class="clear"></div>
</div>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1");
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "password");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
</script>
</body>
<script type="text/javascript">
	var now = new Date()
	///now = now.toGMTString();
	var fmat= now.getFullYear()+'-'+ (now.getMonth()+1)+'-'+(now.getDay()+10)+' '+(now.getHours())+':'+(now.getMinutes())+':'+(now.getSeconds());
	document.getElementById('systemDateForm').value = fmat;
</script>
</html>