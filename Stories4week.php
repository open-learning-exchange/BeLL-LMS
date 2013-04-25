<?php session_start();include "talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<?php 
function saveRes2DB($ResID)
  {
	  if($ResID!="none")
  	  {
			  $query = mysql_query("SELECT * FROM `resources` where resrcID = '".$ResID."'") or die(mysql_error());
			   while($data = mysql_fetch_array($query))
			   {
				   mysql_query("INSERT INTO `usedResources` (`colNum`, `resrcID`, `subject`, `title`, `description`, `type`, `usedby`, `dateUsed`,`class`,`rating`) VALUES (NULL, '".$data['resrcID']."', '".$data['subject']."', ' + ".$data['title']."', '".$data['description']."', '".$data['type']."', '".$_SESSION['name']."', '".$_POST['dateExec']."','".$_POST['class']."',0)") or die(mysql_error());
				   
			   }
		 
  	  }
  }
if(isset($_POST['dateExec']))
{
  saveRes2DB($_POST['story1']);
  saveRes2DB($_POST['story2']);
  saveRes2DB($_POST['story3']);
  saveRes2DB($_POST['story4']);
  recordActionDate($_SESSION['name'],"Prepared stories for the week",$_POST['systemDateForm']);
  echo '<script type="text/javascript">alert("Stories saved successfully");</script>';
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"dateExec",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
</head>


<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:500px; margin-left:auto; margin-right:auto;"><span style="color:#00C; font-weight: bold;">Stories for the week</span><br><br>
    <form name="form1" method="post" action="">
      <table width="95%">
        <tr>
          <td width="123"><b>Week starting on</b></td>
          <td width="188"><span id="sprytextfield1">
          <input type="text" name="dateExec" id="dateExec" style="width:50%">
          <span class="textfieldRequiredMsg">required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
          <td width="139"><b>Class </b>: <span id="spryselect1">
            <select name="class" id="class">
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
          <td colspan="3"><b> Selected stories</b></td>
        </tr>
        <tr>
          <td colspan="3" align="left"><b>1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
            <select name="story1" id="story1">
              <option value="none" selected >none</option>
              <?php
			  $cnt =1;
$query = mysql_query("SELECT * FROM `resources` where TLR=''order by KG, P1, P2, P3, P4, P5, P6") or die(mysql_error());
			 while($data = mysql_fetch_array($query))
			 {
				 $forClass ="";
				 if($data['KG']=="YES"){$forClass=$forClass."KG :";}
				 if($data['P1']=="YES"){$forClass=$forClass."P1 :";}
				 if($data['P2']=="YES"){$forClass=$forClass."P2 :";}
				 if($data['P3']=="YES"){$forClass=$forClass."P3 :";}
				 if($data['P4']=="YES"){$forClass=$forClass."P4 :";}
				 if($data['P5']=="YES"){$forClass=$forClass."P5 :";}
				 if($data['P5']=="YES"){$forClass=$forClass."P6";}
				 echo  '<option value="'.$data['resrcID'].'">'.$cnt.'. ('.$forClass.')  '.$data['title'].'</option>';
				 $cnt++;
			 }
          ?>
              
          </select></td>
        </tr>
        <tr>
          <td colspan="3" align="left"><b>2</b><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>            
            <select name="story2" id="story2">
              <option value="none">none</option>
             <?php
			  $cnt =1;
$query = mysql_query("SELECT * FROM `resources` where TLR=''order by KG, P1, P2, P3, P4, P5, P6") or die(mysql_error());
			 while($data = mysql_fetch_array($query))
			 {
				 $forClass ="";
				 if($data['KG']=="YES"){$forClass=$forClass."KG :";}
				 if($data['P1']=="YES"){$forClass=$forClass."P1 :";}
				 if($data['P2']=="YES"){$forClass=$forClass."P2 :";}
				 if($data['P3']=="YES"){$forClass=$forClass."P3 :";}
				 if($data['P4']=="YES"){$forClass=$forClass."P4 :";}
				 if($data['P5']=="YES"){$forClass=$forClass."P5 :";}
				 if($data['P5']=="YES"){$forClass=$forClass."P6";}
				 echo  '<option value="'.$data['resrcID'].'">'.$cnt.'. ('.$forClass.') '.$data['title'].'</option>';
				 $cnt++;
			 }
          ?>
          </select></td>
        </tr>
        <tr>
          <td colspan="3" align="left"><b>3</b><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>            
            <select name="story3" id="story3">
              <option value="none">none</option>
              <?php
			  $cnt =1;
$query = mysql_query("SELECT * FROM `resources` where TLR=''order by KG, P1, P2, P3, P4, P5, P6") or die(mysql_error());
			 while($data = mysql_fetch_array($query))
			 {
				 $forClass ="";
				 if($data['KG']=="YES"){$forClass=$forClass."KG :";}
				 if($data['P1']=="YES"){$forClass=$forClass."P1 :";}
				 if($data['P2']=="YES"){$forClass=$forClass."P2 :";}
				 if($data['P3']=="YES"){$forClass=$forClass."P3 :";}
				 if($data['P4']=="YES"){$forClass=$forClass."P4 :";}
				 if($data['P5']=="YES"){$forClass=$forClass."P5 :";}
				 if($data['P5']=="YES"){$forClass=$forClass."P6";}
				 echo  '<option value="'.$data['resrcID'].'">'.$cnt.'. ('.$forClass.') '.$data['title'].'</option>';
				 $cnt++;
			 }
          ?>
          </select></td>
        </tr>
        <tr>
          <td colspan="3" align="left"><b>4</b><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
            <select name="story4" id="story4">
              <option value="none">none</option>
             <?php
			  $cnt =1;
$query = mysql_query("SELECT * FROM `resources` where TLR=''order by KG, P1, P2, P3, P4, P5, P6") or die(mysql_error());
			 while($data = mysql_fetch_array($query))
			 {
				 $forClass ="";
				 if($data['KG']=="YES"){$forClass=$forClass."KG :";}
				 if($data['P1']=="YES"){$forClass=$forClass."P1 :";}
				 if($data['P2']=="YES"){$forClass=$forClass."P2 :";}
				 if($data['P3']=="YES"){$forClass=$forClass."P3 :";}
				 if($data['P4']=="YES"){$forClass=$forClass."P4 :";}
				 if($data['P5']=="YES"){$forClass=$forClass."P5 :";}
				 if($data['P5']=="YES"){$forClass=$forClass."P6";}
				 echo  '<option value="'.$data['resrcID'].'">'.$cnt.'. ('.$forClass.') '.$data['title'].'</option>';
				 $cnt++;
			 }
          ?>
          </select></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3"><b style="color:#666;">

Note for discussion:
    <br >
    1. These stories could be used for comprehension passages, or listening and speaking
             or vocabulary building or even composition
    <br>
    2. The question however is what time would they have to read these stories? Would there be enough devices for everyone to read these stories? what are the implications for the time table
    <br>
    3. could this be an after school or a Saturday activity? who will supervise? how do you compensate the one who comes to supervise?</b></td>
        </tr>
        <tr>
          <td></td>
          <td colspan="2"><input type="submit" class="button" value="Submit">
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"yyyy-mm-dd"});
</script>
</body>
<script type="text/javascript">
	var now = new Date()
	///now = now.toGMTString();
	var fmat= now.getFullYear()+'-'+ (now.getMonth()+1)+'-'+(now.getDay()+10)+' '+(now.getHours())+':'+(now.getMinutes())+':'+(now.getSeconds());
	document.getElementById('systemDateForm').value = fmat;
</script>
</html>