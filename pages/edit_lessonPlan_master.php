<?php session_start();include "../secure/talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" media="all" href="../css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../js/jsDatePick.min.1.3.js"></script>
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
if(isset($_POST['subject']))
{
  $dataQuery = mysql_query("UPDATE `LessonPlan` SET `DateOfEx` = '".$_POST['dateExec']."',`class` = '".$_POST['class']."', `Subject` = '".$_POST['subject']."', `Ref`='".$_POST['refrence']."', `Time`='".$_POST['txtTime']."', `Duration`='".$_POST['duration']."', `Topic`='".$_POST['topic']."', `Objective`='".$_POST['objectives']."', `RPK` = '".$_POST['rpk']."', `BeLL_Resource_1` = '".$_POST['bellRes1']."', `BeLL_Resource_2`= '".$_POST['bellRes2']."', `BeLL_Resource_3`='".$_POST['bellRes3']."', `BeLL_Resource_4`='".$_POST['bellRes4']."', `BeLL_Resource_5`='".$_POST['bellRes5']."', `Other_Resource_1`='".$_POST['BellSelR1']."', `Other_Resource_2`='".$_POST['BellSelR2']."', `Other_Resource_3`='".$_POST['BellSelR3']."', `Tech_Used_1`='".$_POST['bellTech1']."', `Tech_Used_2`='".$_POST['bellTech2']."', `Tech_Used_3`='".$_POST['bellTech3']."', `Core_Points` = '".$_POST['corPoints']."', `Introduction`='".$_POST['intro']."', `Pre_Writing`='".$_POST['PrewStage']."', `Writing`='".$_POST['wStage']."', `Post_Writing`='".$_POST['PostWStage']."', `Conclusion`='".$_POST['conclussion']."', `Low_Order_Thinking_1`='".$_POST['LowQ1']."', `Low_Order_Thinking_2`='".$_POST['LowQ2']."', `Low_Order_Thinking_3`='".$_POST['LowQ3']."', `Low_Order_Thinking_4`='".$_POST['LowQ4']."', `Low_Order_Thinking_5`='".$_POST['LowQ5']."', `High_Order_Thinking_1`='".$_POST['HighQ1']."', `High_Order_Thinking_2`='".$_POST['HighQ2']."', `High_Order_Thinking_3`='".$_POST['HighQ3']."', `High_Order_Thinking_4`='".$_POST['HighQ4']."', `High_Order_Thinking_5`='".$_POST['HighQ5']."', `Teacher_Remark`='".$_POST['teacherRem']."', `Head_Remark`='".$_POST['HeadRemk']."', `Coach_Remark` = '".$_POST['CoachRmk']."', DateUpdated = CURRENT_TIMESTAMP  colNum`= ".$_POST['colNumber']."") or die(mysql_error());
 recordActionObject($_SESSION['lmsUserID'],"Modified Leson Plan",$_GET['lID']);
  die("<br><br><br><br>Lesson plane updated.");
} 
else if(isset($_GET['editdate']))
{
	$ColNum = "";
	$Class ="";
	   $DataOfEx = "";
	   $Subject = "";
	   $Refrence = "";
	   $Time = "";
	   $Duation = "";
	   $Topic = "";
	   $Objective = "";
	   $RPK = "";
	   $Bell_Res1 = "";
	   $Bell_Res2 = "";
	   $Bell_Res3 = "";
	   $Bell_Res4 = "";
	   $Bell_Res5 = "";
	   $Outside_Res1 = "";
	   $Outside_Res2 = "";
	   $Outside_Res3 = "";
	   $Tech1 = "";
	   $Tech2 = "";
	   $Tech3 = "";
	   $CorePoint = "";
	   $Intro = "";
	   $PreWrite = "";
	   $Writing = "";
	   $Post_Writing = "";
	   $Conclu = "";
	   $LowThink1 = "";
	   $LowThink2 = "";
	   $LowThink3 = "";
	   $LowThink4 = "";
	   $LowThink5 = "";
	   $HighThink1 = "";
	   $HighThink2 = "";
	   $HighThink3 = "";
	   $HighThink4 = "";
	   $HighThink5 = "";
	   $TeacherRem = "";
	   $HeadRem = "";
	   $CoachRem = "";
	   $UpdateDtate = "";
	$query = mysql_query("SELECT * FROM  `LessonPlan` where `colNum` = '".$_GET['editdate']."'") or die(mysql_error());
   while($data = mysql_fetch_array($query))
   {
	   $ColNum = $data['colNum'];
	   $Class = $data['class'];
	   $DataOfEx = $data['DateOfEx'];
	   $Subject = $data['Subject'];
	   $Refrence = $data['Ref'];
	   $Time = $data['Time'];
	   $Duation =$data['Duration'];
	   $Topic = $data['Topic'];
	   $Objective = $data['Objective'];
	   $RPK = $data['RPK'];
	   $Bell_Res1 = $data['BeLL_Resource_1'];
	   $Bell_Res2 = $data['BeLL_Resource_2'];
	   $Bell_Res3 = $data['BeLL_Resource_3'];
	   $Bell_Res4 = $data['BeLL_Resource_4'];
	   $Bell_Res5 = $data['BeLL_Resource_5'];
	   $Outside_Res1 = $data['Other_Resource_1'];
	   $Outside_Res2 = $data['Other_Resource_2'];
	   $Outside_Res3 = $data['Other_Resource_3'];
	   $Tech1 = $data['Tech_Used_1'];
	   $Tech2 = $data['Tech_Used_2'];
	   $Tech3 = $data['Tech_Used_3'];
	   $CorePoint = $data['Core_Points'];
	   $Intro= $data['Introduction'];
	   $PreWrite  = $data['Pre_Writing'];
	   $Writing = $data['Writing'];
	   $Post_Writing  = $data['Post_Writing'];
	   $Conclu = $data['Conclusion'];
	   $LowThink1  = $data['Low_Order_Thinking_1'];
	   $LowThink2  = $data['Low_Order_Thinking_2'];
	   $LowThink3  = $data['Low_Order_Thinking_3'];
	   $LowThink4  = $data['Low_Order_Thinking_4'];
	   $LowThink5  = $data['Low_Order_Thinking_5'];
	   $HighThink1  = $data['High_Order_Thinking_1'];
	   $HighThink2  = $data['High_Order_Thinking_2'];
	   $HighThink3  = $data['High_Order_Thinking_3'];
	   $HighThink4  = $data['High_Order_Thinking_4'];
	   $HighThink5  = $data['High_Order_Thinking_5'];
	   $TeacherRem  = $data['Teacher_Remark'];
	   $HeadRem  = $data['Head_Remark'];
	   $CoachRem  = $data['Coach_Remark'];
	   $UpdateDtate  = $data['DateUpdated'];
	   
   }
}
?>

<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:600px; margin-left:auto; margin-right:auto;">
  <table width="272" border="1" align="center">
    <tr>
      <td width="132" valign="top">Select Lesson Plan Date :</td>
      <td width="124" valign="top"><form name="form2" method="post" action="">
        <select name="editdate" id="editdate" onChange="loadUrl()">
        <option value="select">select</option>
          <?php
		$query = mysql_query("SELECT * FROM  `LessonPlan` ORDER BY `DateOfEx` ") or die(mysql_error());
			 while($data = mysql_fetch_array($query))
			 {
				 echo '<option value="'.$data['colNum'].'">'.$data['DateOfEx'].' - '.$data['class'].'</option>';
				 
			 }
          ?>
        </select>
      </form></td>
    </tr>
  </table>
<form name="form1" method="post" action="">
      <table width="107%">
        <tr>
          <td width="100"><b>Date of Execution</b></td>
          <td width="299"><span id="sprytextfield1">
            <input name="dateExec" type="text" id="dateExec" style="width:50%" value="<?php echo $DataOfEx;?>" readonly>
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
          <span class="selectRequiredMsg">Please select an item.</span></span>
            <input type="hidden" name="colNumber" id="colNumber" value="<?php echo $ColNum;?>"></td>
        </tr>
        <tr>
          <td><b>Subject</b></td>
          <td colspan="2"><span id="sprytextfield2">
            <input type="text" name="subject" id="subject" value="<?php echo $Subject;?>">
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td><b>References</b></td>
          <td colspan="2"><span id="sprytextarea1">
            <textarea name="refrence" id="refrence" cols="45" rows="3" style="height:60px;width:70%;"><?php echo $Refrence; ?>
            </textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td><b>Time</b></td>
          <td colspan="2"><span id="sprytextfield3">
            <input type="text" name="txtTime" id="txtTime" style="width:30%" value="<?php echo $Time;?>">
          <span class="textfieldRequiredMsg">A value is required.</span></span> hh:mm:ss eg 8:00:00</td>
        </tr>
        <tr>
          <td><b>Duration</b></td>
          <td colspan="2"><span id="sprytextfield4">
            <input type="text" name="duration" id="duration" value="<?php echo $Duation;?>">
          <span class="textfieldRequiredMsg">A value is required.</span></span> eg.. 2 hrs / 1hr 30min</td>
        </tr>
        <tr>
          <td><b>Aspect / Topic</b></td>
          <td colspan="2"><span id="sprytextfield5">
            <input type="text" name="topic" id="topic" value="<?php echo $Topic;?>">
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td><b>Objective(s)</b></td>
          <td colspan="2"><span id="sprytextarea2">
 <textarea name="objectives" id="objectives" cols="45" rows="5" style="height:60px;width:70%;"><?php echo $Objective;?></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td><b>RPK</b></td>
          <td colspan="2"><span id="sprytextarea3">
            <textarea name="rpk" id="rpk" cols="45" rows="5" style="height:60px;width:70%;"><?php echo $RPK;?></textarea>
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
			 $query = mysql_query("SELECT * FROM `resources`") or die(mysql_error());
			 while($data = mysql_fetch_array($query))
			 {
				 if($data['resrcID']==$Bell_Res1)
				 {
				 	echo '<option value="'.$data['resrcID'].'"  selected >'.$data['title'].'</option>';
				 } else { echo '<option value="'.$data['resrcID'].'">'.$data['title'].'</option>';}
				 
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
			 $query = mysql_query("SELECT * FROM `resources`") or die(mysql_error());
			 while($data = mysql_fetch_array($query))
			 {
				 if($data['resrcID']==$Bell_Res2)
				 {
				 	echo '<option value="'.$data['resrcID'].'"  selected >'.$data['title'].'</option>';
				 } else { echo '<option value="'.$data['resrcID'].'">'.$data['title'].'</option>';}
				 
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
			 $query = mysql_query("SELECT * FROM `resources`") or die(mysql_error());
			 while($data = mysql_fetch_array($query))
			 {
				 if($data['resrcID']==$Bell_Res3)
				 {
				 	echo '<option value="'.$data['resrcID'].'"  selected >'.$data['title'].'</option>';
				 } else { echo '<option value="'.$data['resrcID'].'">'.$data['title'].'</option>';}
				 
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
			 $query = mysql_query("SELECT * FROM `resources`") or die(mysql_error());
			 while($data = mysql_fetch_array($query))
			 {
				 if($data['resrcID']==$Bell_Res4)
				 {
				 	echo '<option value="'.$data['resrcID'].'"  selected >'.$data['title'].'</option>';
				 } else { echo '<option value="'.$data['resrcID'].'">'.$data['title'].'</option>';}
				 
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
			 $query = mysql_query("SELECT * FROM `resources`") or die(mysql_error());
			 while($data = mysql_fetch_array($query))
			 {
				 if($data['resrcID']==$Bell_Res5)
				 {
				 	echo '<option value="'.$data['resrcID'].'"  selected >'.$data['title'].'</option>';
				 } else { echo '<option value="'.$data['resrcID'].'">'.$data['title'].'</option>';}
				 
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
          <td colspan="2"><input type="text" name="BellSelR1" id="BellSelR1" value="<?php echo $Outside_Res1;?>"></td>
        </tr>
        <tr>
          <td align="right"><b>2</b></td>
          <td colspan="2"><input type="text" name="BellSelR2" id="BellSelR2" value="<?php echo $Outside_Res2;?>"></td>
        </tr>
        <tr>
          <td align="right"><b>3</b></td>
          <td colspan="2"><input type="text" name="BellSelR3" id="BellSelR3" value="<?php echo $Outside_Res3;?>"></td>
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
            <option value="Laptop & Speakers">Laptop & Speakers</option>
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
            <textarea name="corPoints" id="corPoints" cols="45" rows="5" style="height:60px;width:70%;"><?php echo $CorePoint;?></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td colspan="3" align="left"><b style="color:#666;">Teaching and Learning Activities (include 1) how RPK will be used 2) how technology selected will be used 3) 21st century skills that would be used in the teaching to make it fun, participatory and self- discovery)</b>
</td>
        </tr>
        <tr>
          <td align="left"><b>Introduction</b></td>
          <td colspan="2"><span id="sprytextarea5">
            <textarea name="intro" id="intro" cols="45" rows="5" style="height:60px;width:70%;"><?php echo $Intro;?></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="left"><b>Pre –Writing stage</b></td>
          <td colspan="2"><span id="sprytextarea6">
            <textarea name="PrewStage" id="PrewStage" cols="45" rows="5" style="height:60px;width:70%;"><?php echo $PreWrite;?></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="left"><b>Writing Stage</b></td>
          <td colspan="2"><span id="sprytextarea7">
            <textarea name="wStage" id="wStage" cols="45" rows="5" style="height:60px;width:70%;"><?php echo $Writing;?></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="left"><b>Post – Writing Stage</b></td>
          <td colspan="2"><span id="sprytextarea8">
            <textarea name="PostWStage" id="PostWStage" cols="45" rows="5" style="height:60px;width:70%;"></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="left"><b>Conclusion</b></td>
          <td colspan="2"><span id="sprytextarea13">
            <textarea name="conclussion" id="conclussion" cols="45" rows="5" style="height:60px;width:70%;"><?php echo $Conclu;?></textarea>
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
            <textarea name="LowQ1" id="LowQ1" cols="45" rows="5" style="height:50px;width:70%;" ><?php echo $LowThink1;?></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="right"><b>2</b></td>
          <td colspan="2"><span id="sprytextarea10">
            <textarea name="LowQ2" id="LowQ2" cols="45" rows="5"  style="height:50px;width:70%;" ><?php echo $LowThink2?></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="right"><b>3</b></td>
          <td colspan="2"><textarea name="LowQ3" id="LowQ3" cols="45" rows="5"  style="height:50px;width:70%;" ><?php echo $LowThink3;?></textarea></td>
        </tr>
        <tr>
          <td align="right"><b>4</b></td>
          <td colspan="2"><textarea name="LowQ4" id="LowQ4" cols="45" rows="5" style="height:50px;width:70%;" ><?php echo $LowThink4;?></textarea></td>
        </tr>
        <tr>
          <td align="right"><b>5</b></td>
          <td colspan="2"><textarea name="LowQ5" id="LowQ5" cols="45" rows="5"  style="height:50px;width:70%;"><?php echo $LowThink5;?></textarea></td>
        </tr>
        <tr>
          <td colspan="3" align="left"><b>High Order Thinking Questions</b></td>
        </tr>
        <tr>
          <td align="right"><b>1</b></td>
          <td colspan="2"><span id="sprytextarea11">
            <textarea name="HighQ1" id="HighQ1" cols="45" rows="5"  style="height:50px;width:70%;" ><?php echo $HighThink1;?></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="right"><b>2</b></td>
          <td colspan="2"><span id="sprytextarea12">
            <textarea name="HighQ2" id="HighQ2" cols="45" rows="5"  style="height:50px;width:70%;" ><?php echo $HighThink2;?></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="right"><b>3</b></td>
          <td colspan="2"><textarea name="HighQ3" id="HighQ3" cols="45" rows="5"  style="height:50px;width:70%;" ><?php echo $HighThink3;?></textarea></td>
        </tr>
        <tr>
          <td align="right"><b>4</b></td>
          <td colspan="2"><textarea name="HighQ4" id="HighQ4" cols="45" rows="5" style="height:50px;width:70%;" ><?php echo $HighThink4;?></textarea></td>
        </tr>
        <tr>
          <td align="right"><b>5</b></td>
          <td colspan="2"><textarea name="HighQ5" id="HighQ5" cols="45" rows="5" style="height:50px;width:70%;" ><?php echo $HighThink5;?></textarea></td>
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
            <textarea name="teacherRem" id="teacherRem" cols="45" rows="5" style="height:50px;width:70%;"><?php echo $TeacherRem;?></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr>
          <td align="left"><b>Head</b></td>
          <td colspan="2"><input name="HeadRemk" type="text" id="HeadRemk" readonly value="<?php echo $HeadRem;?>"></td>
        </tr>
        <tr>
          <td align="left"><b>Coach</b></td>
          <td colspan="2"><input name="CoachRmk" type="text" id="CoachRmk" readonly value="<?php echo $CoachRem;?>"></td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td></td>
          <td colspan="2"><input type="submit" class="button" value="Update">
          <input type="reset" class="button" value="Reset"></td>
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
var sprytextarea14 = new Spry.Widget.ValidationTextarea("sprytextarea14");
</script>
 <script type="text/javascript"> 
function loadUrl()
{
		var Plan_date = document.getElementById("editdate").value;
		window.open("edit_lessonPlan.php?editdate="+Plan_date+"","_self");
}
</script>
<?php
function Tech($val,$menuList)
{
	if($val=="Tablets"){
	 echo '<script type="text/javascript"> document.getElementById("'.$menuList.'").selectedIndex =1;</script>';
	} else if($val=="Laptop & Speakers"){
	 echo '<script type="text/javascript"> document.getElementById("'.$menuList.'").selectedIndex =2;</script>';
	} else if($val=="Projector"){
	 echo '<script type="text/javascript"> document.getElementById("'.$menuList.'").selectedIndex =3;</script>';
	} else if($val=="Camera"){
	 echo '<script type="text/javascript"> document.getElementById("'.$menuList.'").selectedIndex =4;</script>';
	} else if($val=="Server"){
	 echo '<script type="text/javascript"> document.getElementById("'.$menuList.'").selectedIndex =5;</script>';
	} else if($val=="TV"){
	 echo '<script type="text/javascript"> document.getElementById("'.$menuList.'").selectedIndex =6;</script>';
	} else if($val=="Radio"){
	 echo '<script type="text/javascript"> document.getElementById("'.$menuList.'").selectedIndex =7;</script>';
	}	
}
Tech($Tech1,"bellTech1");
Tech($Tech2,"bellTech2");
Tech($Tech3,"bellTech3");

///////////Select Class ////
if($Class=="KG")
{
	echo '<script type="text/javascript"> document.getElementById("class").selectedIndex =0;</script>';	
} else if($Class=="P1")
{
	echo '<script type="text/javascript"> document.getElementById("class").selectedIndex =1;</script>';	
}else if($Class=="P2")
{
	echo '<script type="text/javascript"> document.getElementById("class").selectedIndex =2;</script>';	
}else if($Class=="P3")
{
	echo '<script type="text/javascript"> document.getElementById("class").selectedIndex =3;</script>';	
}else if($Class=="P4")
{
	echo '<script type="text/javascript"> document.getElementById("class").selectedIndex =4;</script>';	
}else if($Class=="P5")
{
	echo '<script type="text/javascript"> document.getElementById("class").selectedIndex =5;</script>';	
}else if($Class=="P6")
{
	echo '<script type="text/javascript"> document.getElementById("class").selectedIndex =6;</script>';	
}
?>
</body>
</html>