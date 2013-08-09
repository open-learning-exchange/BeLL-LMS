<?php session_start();include "talk2db.php";?>
<html>
<head>
<script type='text/javascript'>
var now = new Date() 
var fmat= now.getFullYear()+'-'+ (now.getMonth()+1)+'-'+(now.getDay()+10)+' '+(now.getHours())+':'+(now.getMinutes())+':'+(now.getSeconds());
</script>
<?php
/*?>if($_SESSION['name']== null){
	$mystring = "index.php?sesEnded=true&systemDateForm='+fmat";
	die('<script type="text/javascript">window.parent.location.href= "'.$mystring.'";</script>');
}<?php */?>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>
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
<?php
function saveRes2DB($ResID)
  {
	  if($ResID!="none")
  	  {
			  $query = mysql_query("SELECT * FROM `resources` where resrcID = '".$ResID."'") or die(mysql_error());
			   while($data = mysql_fetch_array($query))
			   {
				   mysql_query("INSERT INTO `usedResources` (`colNum`, `resrcID`, `subject`, `title`, `description`, `type`, `usedby`, `dateUsed`,`class`,`rating`) VALUES (NULL, '".$data['resrcID']."', '".$data['subject']."', '".$data['title']."', '".$data['description']."', '".$data['type']."', '".$_POST['preparedBy']."', '".$_POST['dateExec']."','".$_POST['class']."',0)") or die(mysql_error());
				   
			   }
  	  }
  }
if(isset($_POST['subject']))
{
	//////addslashes ( )
  $dataQuery = mysql_query("INSERT INTO `LessonPlan` (`colNum`,`DateOfEx`,`class`,`Subject`, `Ref`, `Time`, `Duration`, `Topic`, `Objective`, `RPK`, `BeLL_Resource_1`, `BeLL_Resource_2`, `BeLL_Resource_3`, `BeLL_Resource_4`, `BeLL_Resource_5`, `Other_Resource_1`, `Other_Resource_2`, `Other_Resource_3`, `Tech_Used_1`, `Tech_Used_2`, `Tech_Used_3`, `Core_Points`, `Introduction`, `Pre_Writing`, `Writing`, `Post_Writing`, `Conclusion`, `Low_Order_Thinking_1`, `Low_Order_Thinking_2`, `Low_Order_Thinking_3`, `Low_Order_Thinking_4`, `Low_Order_Thinking_5`, `High_Order_Thinking_1`, `High_Order_Thinking_2`, `High_Order_Thinking_3`, `High_Order_Thinking_4`, `High_Order_Thinking_5`, `Teacher_Remark`, `Head_Remark`, `Coach_Remark`, `DateUpdated`, `prepared_By` ) VALUES (NULL, '".$_POST['dateExec']."','".$_POST['class']."', '".addslashes($_POST['subject'])."', '".addslashes ($_POST['refrence'])."', '".addslashes($_POST['txtTime'])."', '".addslashes($_POST['duration'])."', '".addslashes($_POST['topic'])."', '".addslashes ($_POST['objectives'])."', '".addslashes($_POST['rpk'])."', '".addslashes($_POST['bellRes1'])."', '".addslashes($_POST['bellRes2'])."', '".addslashes ($_POST['bellRes3'])."', '".addslashes($_POST['bellRes4'])."', '".addslashes($_POST['bellRes5'])."', '".addslashes($_POST['BellSelR1'])."', '".addslashes($_POST['BellSelR2'])."', '".addslashes($_POST['BellSelR3'])."', '".addslashes($_POST['bellTech1'])."', '".addslashes($_POST['bellTech2'])."', '".addslashes($_POST['bellTech3'])."', '".addslashes($_POST['corPoints'])."', '".addslashes($_POST['intro'])."', '".addslashes($_POST['PrewStage'])."', '".addslashes($_POST['wStage'])."', '".addslashes($_POST['PostWStage'])."', '".addslashes($_POST['conclussion'])."', '".addslashes($_POST['LowQ1'])."', '".addslashes($_POST['LowQ2'])."', '".addslashes($_POST['LowQ3'])."', '".addslashes($_POST['LowQ4'])."', '".addslashes($_POST['LowQ5'])."', '".addslashes($_POST['HighQ1'])."', '".addslashes($_POST['HighQ2'])."', '".addslashes($_POST['HighQ3'])."', '".addslashes($_POST['HighQ4'])."', '".addslashes($_POST['HighQ5'])."', '".addslashes($_POST['teacherRem'])."', '".addslashes($_POST['HeadRemk'])."', '".addslashes($_POST['CoachRmk'])."', '".$_POST['systemDateForm']."', '".addslashes($_POST['preparedBy'])."')") or die(mysql_error());
  
  saveRes2DB($_POST['bellRes1']);
  saveRes2DB($_POST['bellRes2']);
  saveRes2DB($_POST['bellRes3']);
  saveRes2DB($_POST['bellRes4']);
  saveRes2DB($_POST['bellRes5']);
  saveRes2DB($_POST['bellRes6']);
  recordActionDate($_POST['preparedBy'],"Created Lesson Plan",$_POST['systemDateForm']);
  
  echo '<script type="text/javascript">alert("Lesson plan successfully saved for '.$_POST['dateExec'].'");</script>';
  $mystring = "printLessonPlan.php?printDate=".$_POST['dateExec']."";
  die('<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$mystring.'">');
 
  ////die("<br><br><br><br>Lesson plan successfully saved for ".$_POST['dateExec']."");
  
  
  
}
?>

<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:600px; margin-left:auto; margin-right:auto;">&nbsp;&nbsp;&nbsp;<span style="color:#00C; font-weight: bold;">Prepare Lesson Plan</span><br><br>
    <form name="form1" method="post" action="">
      <table width="107%">
        <tr>
          <td width="100"><b>Date of Execution</b></td>
          <td width="299"><span id="sprytextfield1">
            <input type="text" name="dateExec" id="dateExec" style="width:50%">
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
          <td width="216"><b>Class </b>:          <span id="spryselect1">
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
          <td><b>Subject</b></td>
          <td colspan="2"><span id="sprytextfield2">
            <input type="text" name="subject" id="subject">
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td><b>References</b></td>
          <td colspan="2"><span id="sprytextarea1">
            <textarea name="refrence" id="refrence" cols="45" rows="3" style="height:60px;width:70%;"></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td><b>Time</b></td>
          <td colspan="2"><span id="sprytextfield3">
            <input type="text" name="txtTime" id="txtTime" style="width:30%">
          <span class="textfieldRequiredMsg">A value is required.</span></span> hh:mm:ss eg 8:00:00</td>
        </tr>
        <tr>
          <td><b>Duration</b></td>
          <td colspan="2"><span id="sprytextfield4">
            <input type="text" name="duration" id="duration">
          <span class="textfieldRequiredMsg">A value is required.</span></span> eg.. 2 hrs / 1hr 30min</td>
        </tr>
        <tr>
          <td><b>Aspect / Topic</b></td>
          <td colspan="2"><span id="sprytextfield5">
            <input type="text" name="topic" id="topic">
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td><b>Objective(s)</b></td>
          <td colspan="2"><span id="sprytextarea2">
            <textarea name="objectives" id="objectives" cols="45" rows="5" style="height:60px;width:70%;"></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td><b>RPK</b></td>
          <td colspan="2"><span id="sprytextarea3">
            <textarea name="rpk" id="rpk" cols="45" rows="5" style="height:60px;width:70%;"></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3"><b>T &amp; L resources selcted from BeLL</b></td>
        </tr>
        <tr>
          <td align="right"><b>1</b></td>
          <td colspan="2"><select name="bellRes1" id="bellRes1">
            <option value="none">none</option>
            <?php
			$query = mysql_query("SELECT * FROM `resources` where TLR='' order by KG,P1,P2,P3,P4,P5,P6") or die(mysql_error());
			 while($data = mysql_fetch_array($query))
			 {
				 $forClass ="";
				 if($data['KG']=="YES"){$forClass=$forClass."KG: ";}
				 if($data['P1']=="YES"){$forClass=$forClass."P1: ";}
				 if($data['P2']=="YES"){$forClass=$forClass."P2: ";}
				 if($data['P3']=="YES"){$forClass=$forClass."P3: ";}
				 if($data['P4']=="YES"){$forClass=$forClass."P4: ";}
				 if($data['P5']=="YES"){$forClass=$forClass."P5: ";}
				 if($data['P5']=="YES"){$forClass=$forClass."P6: ";}
				 echo '<option value="'.$data['resrcID'].'">'.$forClass.'- '.$data['title'].'</option>';
				 
			 }
          ?>
          </select></td>
        </tr>
        <tr>
          <td align="right"><b>2</b></td>
          <td colspan="2">
          <select name="bellRes2" id="bellRes2">
          <option value="none" selected >none</option>
         <?php
$query = mysql_query("SELECT * FROM `resources` where TLR='' order by KG,P1,P2,P3,P4,P5,P6") or die(mysql_error());
			 while($data = mysql_fetch_array($query))
			 {
				 $forClass ="";
				 if($data['KG']=="YES"){$forClass=$forClass."KG: ";}
				 if($data['P1']=="YES"){$forClass=$forClass."P1: ";}
				 if($data['P2']=="YES"){$forClass=$forClass."P2: ";}
				 if($data['P3']=="YES"){$forClass=$forClass."P3: ";}
				 if($data['P4']=="YES"){$forClass=$forClass."P4: ";}
				 if($data['P5']=="YES"){$forClass=$forClass."P5: ";}
				 if($data['P5']=="YES"){$forClass=$forClass."P6: ";}
				 echo '<option value="'.$data['resrcID'].'">'.$forClass.'- '.$data['title'].'</option>';
				 
			 }
          ?>
          </select></td>
        </tr>
        <tr>
          <td align="right"><b>3</b></td>
          <td colspan="2">
          <select name="bellRes3" id="bellRes3">
           <option value="none" selected >none</option>
          <?php
$query = mysql_query("SELECT * FROM `resources` where TLR='' order by KG,P1,P2,P3,P4,P5,P6") or die(mysql_error());
			 while($data = mysql_fetch_array($query))
			 {
				 $forClass ="";
				 if($data['KG']=="YES"){$forClass=$forClass."KG: ";}
				 if($data['P1']=="YES"){$forClass=$forClass."P1: ";}
				 if($data['P2']=="YES"){$forClass=$forClass."P2: ";}
				 if($data['P3']=="YES"){$forClass=$forClass."P3: ";}
				 if($data['P4']=="YES"){$forClass=$forClass."P4: ";}
				 if($data['P5']=="YES"){$forClass=$forClass."P5: ";}
				 if($data['P5']=="YES"){$forClass=$forClass."P6: ";}
				 echo '<option value="'.$data['resrcID'].'">'.$forClass.'- '.$data['title'].'</option>';
				 
			 }
          ?>
          </select></td>
        </tr>
        <tr>
          <td align="right"><b>4</b></td>
          <td colspan="2">
          <select name="bellRes4" id="bellRes4"> 
          <option value="none" selected >none</option>
          <?php
$query = mysql_query("SELECT * FROM `resources` where TLR='' order by KG,P1,P2,P3,P4,P5,P6") or die(mysql_error());
			 while($data = mysql_fetch_array($query))
			 {
				 $forClass ="";
				 if($data['KG']=="YES"){$forClass=$forClass."KG: ";}
				 if($data['P1']=="YES"){$forClass=$forClass."P1: ";}
				 if($data['P2']=="YES"){$forClass=$forClass."P2: ";}
				 if($data['P3']=="YES"){$forClass=$forClass."P3: ";}
				 if($data['P4']=="YES"){$forClass=$forClass."P4: ";}
				 if($data['P5']=="YES"){$forClass=$forClass."P5: ";}
				 if($data['P5']=="YES"){$forClass=$forClass."P6: ";}
				 echo '<option value="'.$data['resrcID'].'">'.$forClass.'- '.$data['title'].'</option>';
				 
			 }
          ?>
          </select></td>
        </tr>
        <tr>
          <td align="right"><b>5</b></td>
          <td colspan="2">
          <select name="bellRes5" id="bellRes5">
           <option value="none" selected >none</option>
         <?php
$query = mysql_query("SELECT * FROM `resources` where TLR='' order by KG,P1,P2,P3,P4,P5,P6") or die(mysql_error());
			 while($data = mysql_fetch_array($query))
			 {
				 $forClass ="";
				 if($data['KG']=="YES"){$forClass=$forClass."KG: ";}
				 if($data['P1']=="YES"){$forClass=$forClass."P1: ";}
				 if($data['P2']=="YES"){$forClass=$forClass."P2: ";}
				 if($data['P3']=="YES"){$forClass=$forClass."P3: ";}
				 if($data['P4']=="YES"){$forClass=$forClass."P4: ";}
				 if($data['P5']=="YES"){$forClass=$forClass."P5: ";}
				 if($data['P5']=="YES"){$forClass=$forClass."P6: ";}
				 echo '<option value="'.$data['resrcID'].'">'.$forClass.'- '.$data['title'].'</option>';
				 
			 }
          ?>
          </select></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3"><b>T &amp; L resources selcted from outside the BeLL</b></td>
        </tr>
        <tr>
          <td align="right"><b>1</b></td>
          <td colspan="2"><input type="text" name="BellSelR1" id="BellSelR1"></td>
        </tr>
        <tr>
          <td align="right"><b>2</b></td>
          <td colspan="2"><input type="text" name="BellSelR2" id="BellSelR2"></td>
        </tr>
        <tr>
          <td align="right"><b>3</b></td>
          <td colspan="2"><input type="text" name="BellSelR3" id="BellSelR3"></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3"><b>Proposed Technology tools to be used in the lesson</b></td>
        </tr>
        <tr>
          <td align="right"><b>1</b></td>
          <td colspan="2">
          <select name="bellTech1" id="bellTech1">
            <option value="none" selected>none</option>
            <option value="Tablets">Tablets</option>
            <option value="Laptop &amp; Speakers">Laptop &amp; Speakers</option>
            <option value="Projector">Projector</option>
            <option value="Camera">Camera</option>
            <option value="Server">Server</option>
            <option value="TV">TV</option>
            <option value="Radio">Radio</option>
          </select></td>
        </tr>
        <tr>
          <td align="right"><b>2</b></td>
          <td colspan="2"><select name="bellTech2" id="bellTech2">
            <option value="none" selected>none</option>
            <option value="Tablets">Tablets</option>
            <option value="Laptop &amp; Speakers">Laptop &amp; Speakers</option>
            <option value="Projector">Projector</option>
            <option value="Camera">Camera</option>
            <option value="Server">Server</option>
            <option value="TV">TV</option>
            <option value="Radio">Radio</option>
          </select></td>
        </tr>
        <tr>
          <td align="right"><b>3</b></td>
          <td colspan="2"><select name="bellTech3" id="bellTech3">
            <option value="none" selected>none</option>
            <option value="Tablets">Tablets</option>
            <option value="Laptop &amp; Speakers">Laptop &amp; Speakers</option>
            <option value="Projector">Projector</option>
            <option value="Camera">Camera</option>
            <option value="Server">Server</option>
            <option value="TV">TV</option>
            <option value="Radio">Radio</option>
          </select></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><b>Core Points / Literacy Skill to be developed</b></td>
          <td colspan="2"><span id="sprytextarea4">
            <textarea name="corPoints" id="corPoints" cols="45" rows="5" style="height:60px;width:70%;"></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td colspan="3" align="left"><b style="color:#666;">Teaching and Learning Activities (include 1) how RPK will be used 2) how technology selected will be used 3) 21st century skills that would be used in the teaching to make it fun, participatory and self- discovery)</b>
</td>
        </tr>
        <tr>
          <td align="left"><b>Introduction</b></td>
          <td colspan="2"><span id="sprytextarea5">
            <textarea name="intro" id="intro" cols="45" rows="5" style="height:60px;width:70%;"></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="left"><b>Pre –Writing / Reading Stage</b></td>
          <td colspan="2"><span id="sprytextarea6">
            <textarea name="PrewStage" id="PrewStage" cols="45" rows="5" style="height:60px;width:70%;"></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="left"><b>Writing / Reading Stage</b></td>
          <td colspan="2"><span id="sprytextarea7">
            <textarea name="wStage" id="wStage" cols="45" rows="5" style="height:60px;width:70%;"></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="left"><b>Post – Writing / Reading Stage</b></td>
          <td colspan="2"><span id="sprytextarea8">
            <textarea name="PostWStage" id="PostWStage" cols="45" rows="5" style="height:60px;width:70%;"></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="left"><b>Conclusion</b></td>
          <td colspan="2"><span id="sprytextarea13">
            <textarea name="conclussion" id="conclussion" cols="45" rows="5" style="height:60px;width:70%;"></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="left"><b style="color:#666;">Evaluation Exercises</b></td>
        </tr>
        <tr>
          <td colspan="3" align="left"><b>Low Order Thinking Questions</b></td>
        </tr>
        <tr>
          <td align="right"><b>1</b></td>
          <td colspan="2"><span id="sprytextarea9">
            <textarea name="LowQ1" id="LowQ1" cols="45" rows="5" style="height:50px;width:70%;" ></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="right"><b>2</b></td>
          <td colspan="2"><span id="sprytextarea10">
            <textarea name="LowQ2" id="LowQ2" cols="45" rows="5"  style="height:50px;width:70%;" ></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="right"><b>3</b></td>
          <td colspan="2"><textarea name="LowQ3" id="LowQ3" cols="45" rows="5"  style="height:50px;width:70%;" ></textarea></td>
        </tr>
        <tr>
          <td align="right"><b>4</b></td>
          <td colspan="2"><textarea name="LowQ4" id="LowQ4" cols="45" rows="5" style="height:50px;width:70%;" ></textarea></td>
        </tr>
        <tr>
          <td align="right"><b>5</b></td>
          <td colspan="2"><textarea name="LowQ5" id="LowQ5" cols="45" rows="5"  style="height:50px;width:70%;"  ></textarea></td>
        </tr>
        <tr>
          <td colspan="3" align="left"><b>High Order Thinking Questions</b></td>
        </tr>
        <tr>
          <td align="right"><b>1</b></td>
          <td colspan="2"><span id="sprytextarea11">
            <textarea name="HighQ1" id="HighQ1" cols="45" rows="5"  style="height:50px;width:70%;" ></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="right"><b>2</b></td>
          <td colspan="2"><span id="sprytextarea12">
            <textarea name="HighQ2" id="HighQ2" cols="45" rows="5"  style="height:50px;width:70%;" ></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="right"><b>3</b></td>
          <td colspan="2"><textarea name="HighQ3" id="HighQ3" cols="45" rows="5"  style="height:50px;width:70%;" ></textarea></td>
        </tr>
        <tr>
          <td align="right"><b>4</b></td>
          <td colspan="2"><textarea name="HighQ4" id="HighQ4" cols="45" rows="5" style="height:50px;width:70%;" ></textarea></td>
        </tr>
        <tr>
          <td align="right"><b>5</b></td>
          <td colspan="2"><textarea name="HighQ5" id="HighQ5" cols="45" rows="5" style="height:50px;width:70%;" ></textarea></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="left"><b>Remarks on the teaching done / observed by the following</b></td>
        </tr>
        <tr>
          <td align="left"><b>Teacher</b></td>
          <td colspan="2"><span id="sprytextarea14">
            <textarea name="teacherRem" id="teacherRem" cols="45" rows="5" style="height:50px;width:70%;"></textarea>
</span></td>
        </tr>
        <tr>
          <td align="left"><b>Head</b></td>
          <td colspan="2"><input name="HeadRemk" type="text" id="HeadRemk" readonly></td>
        </tr>
        <tr>
          <td align="left"><b>Coach</b></td>
          <td colspan="2"><input name="CoachRmk" type="text" id="CoachRmk" readonly></td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
          <td colspan="2"><input type="hidden" name="preparedBy" id="preparedBy" value="<?php echo $_SESSION['name'];?>"></td>
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
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2");
var sprytextarea3 = new Spry.Widget.ValidationTextarea("sprytextarea3");
var sprytextarea4 = new Spry.Widget.ValidationTextarea("sprytextarea4");
var sprytextarea5 = new Spry.Widget.ValidationTextarea("sprytextarea5");
var sprytextarea6 = new Spry.Widget.ValidationTextarea("sprytextarea6");
var sprytextarea7 = new Spry.Widget.ValidationTextarea("sprytextarea7");
var sprytextarea8 = new Spry.Widget.ValidationTextarea("sprytextarea8");
var sprytextarea9 = new Spry.Widget.ValidationTextarea("sprytextarea9");
var sprytextarea10 = new Spry.Widget.ValidationTextarea("sprytextarea10");
var sprytextarea11 = new Spry.Widget.ValidationTextarea("sprytextarea11");
var sprytextarea12 = new Spry.Widget.ValidationTextarea("sprytextarea12");
var sprytextarea13 = new Spry.Widget.ValidationTextarea("sprytextarea13");
var sprytextarea14 = new Spry.Widget.ValidationTextarea("sprytextarea14", {isRequired:false});
</script>
</body>
<script type="text/javascript">
	var now = new Date()
	///now = now.toGMTString();
	var fmat= now.getFullYear()+'-'+ (now.getMonth()+1)+'-'+(now.getDay()+10)+' '+(now.getHours())+':'+(now.getMinutes())+':'+(now.getSeconds());
	document.getElementById('systemDateForm').value = fmat;
</script>
</html>