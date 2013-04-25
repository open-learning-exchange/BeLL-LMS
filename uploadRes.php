<?php session_start();include "talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script><script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<?php

if(isset($_POST['Rid']))
{
	
	$location = "resources";

   ///is_uploaded_file($_FILES['upLfile']['tmp_name'])
	  $name = $_FILES["upLfile"]["name"];
	  $ext = end(explode(".", $name));
	  $name = $_POST['Rid'];
	  ////$result =
	  if ( move_uploaded_file($_FILES['upLfile']['tmp_name'], $location."/$name.$ext")) {
	  $url = $location."/".$name.".".$ext;
	  $query = mysql_query("INSERT INTO `resources` (`colNum`, `resrcID`, `subject`, `title`, `description`, `type`, `url`, `dateAdded`, `KG`, `P1`, `P2`, `P3`, `P4`, `P5`, `P6`, `Community`, `TLR`) VALUES (NULL, '".$name."', '".$_POST['Rsubject']."', '".$_POST['RTitle']."', '".$_POST['Rdiscription']."', '".$ext."', '".$url."', CURRENT_TIMESTAMP, '".$_POST['KG']."', '".$_POST['P1']."', '".$_POST['P2']."', '".$_POST['P3']."', '".$_POST['P4']."', '".$_POST['P5']."', '".$_POST['P6']."', '".$_POST['Comu']."', '".$_POST['tlr']."')") or die(mysql_error());
	   recordAction($_SESSION['name'],"Uploaded resources... res title : ".$_POST['RTitle']);
	echo '<script type="text/javascript">alert("Successfully Uploaded '.$_POST['RTitle'].'");</script>';
  die("<br><br><br><br>Successfully saved - ".$_POST['RTitle']."");
   } else {
	   echo "File upload error";
   }
}
?>
</head>
<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:500px; margin-left:auto; margin-right:auto;"><span style="color:#00C; font-weight: bold;">Upload Resources</span><br><br>
    <form action="" method="post" enctype="multipart/form-data" name="form1">
      <table width="99%">
        <tr>
          <td width="163">&nbsp;</td>
          <td width="87">&nbsp;</td>
          <td width="85" align="right">Resource id :</td>
          <td width="130" align="right"><input name="Rid" type="text" id="Rid" style="width:100px;" value="<?php echo rand(0,999999);?>" readonly></td>
        </tr>
        <tr>
          <td width="163"><b>Subject</b></td>
          <td><span id="spryselect1">
          <label for="Rsubject2"></label>
          <select name="Rsubject" id="Rsubject2">
            <option value="English">English</option>
            <option value="Maths">Maths</option>
            <option value="General">General</option>
          </select>
          <span class="selectRequiredMsg">Please select an item.</span></span></td>
          <td width="85">&nbsp;</td>
          <td width="130">&nbsp;</td>
        </tr>
        <tr>
          <td><b>This Resource can be used for. (target group)</b></td>
          <td colspan="3"><input type="checkbox" name="KG" id="KG" value="YES"> 
            KG&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              <input type="checkbox" name="Comu" id="Comu" value="YES">
              Community Education 
            <br>
<input type="checkbox" name="P1" id="P1" value="YES"> 
P1
 &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <input type="checkbox" name="P2" id="P2" value="YES">
P2 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="tlr" id="tlr" value="YES">
Teacher Resources <br>
<input type="checkbox" name="P3" id="P3" value="YES"> 
P3&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="P4" id="P4" value="YES">
P4 <br>
<input type="checkbox" name="P5" id="P5" value="YES"> 
P5&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="P6" id="P6" value="YES">
P6 </td>
        </tr>
        <tr>
          <td><b>Resource Title</b></td>
          <td colspan="3"><span id="sprytextfield1">
            <label for="RTitle"></label>
            <input type="text" name="RTitle" class="panjang" id="RTitle">
          <span class="textfieldRequiredMsg">*</span></span></td>
        </tr>
        <tr>
          <td><b>Remark / Discription</b></td>
          <td colspan="3"><span id="sprytextarea1">
            <label for="Rdiscription"></label>
            <textarea name="Rdiscription" id="Rdiscription" cols="45" rows="5" style="height:100px;"></textarea>
          <span class="textareaRequiredMsg">*</span></span></td>
        </tr>
        <tr>
          <td><b>Browse for file</b></td>
          <td colspan="3"><input type="file" name="upLfile" id="upLfile"></td>
        </tr>
        <tr>
          <td></td>
          <td colspan="3"><input type="submit" class="button" value="Submit">
            <input type="reset" class="button" value="Reset"></td>
        </tr>
      </table>
    </form>
  </div>
<div class="clear"></div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
</script>
</body>
</html>