<?php session_start();include "talk2db.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>OLE - Digital Lesson Note System</title>
<style type="text/css">
.prntTitle {
	font-size: 12px;
	font-weight: bold;
}
.content {
	font-size: 12px;
}
</style>
<?php 
	$ColNum = "";
	$Class ="";
	  $dataOfEx = "";
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
if(isset($_GET['prepaedBy']))
{

	$query = mysql_query("SELECT * FROM  `LessonPlan` where DateOfEx = '".$_GET['printDate']."' and prepared_By ='".$_GET['prepaedBy']."'") or die(mysql_error());
   while($data = mysql_fetch_array($query))
   {
	   $ColNum = stripslashes($data['colNum']);
	   $Class = stripslashes($data['class']);
	   $dataOfEx = stripslashes($data['DateOfEx']);
	   $Subject = stripslashes($data['Subject']);
	   $Refrence = stripslashes($data['Ref']);
	   $Time = stripslashes($data['Time']);
	   $Duation =stripslashes($data['Duration']);
	   $Topic = stripslashes($data['Topic']);
	   $Objective = stripslashes($data['Objective']);
	   $RPK = stripslashes($data['RPK']);
	   $Bell_Res1 = stripslashes($data['BeLL_Resource_1']);
	   $Bell_Res2 = stripslashes($data['BeLL_Resource_2']);
	   $Bell_Res3 = stripslashes($data['BeLL_Resource_3']);
	   $Bell_Res4 = stripslashes($data['BeLL_Resource_4']);
	   $Bell_Res5 = stripslashes($data['BeLL_Resource_5']);
	   $Outside_Res1 = stripslashes($data['Other_Resource_1']);
	   $Outside_Res2 = stripslashes($data['Other_Resource_2']);
	   $Outside_Res3 = stripslashes($data['Other_Resource_3']);
	   $Tech1 = stripslashes($data['Tech_Used_1']);
	   $Tech2 = stripslashes($data['Tech_Used_2']);
	   $Tech3 = stripslashes($data['Tech_Used_3']);
	   $CorePoint = stripslashes($data['Core_Points']);
	   $Intro= stripslashes($data['Introduction']);
	   $PreWrite  = stripslashes($data['Pre_Writing']);
	   $Writing = stripslashes($data['Writing']);
	   $Post_Writing  = stripslashes($data['Post_Writing']);
	   $Conclu = stripslashes($data['Conclusion']);
	   $LowThink1  = stripslashes($data['Low_Order_Thinking_1']);
	   $LowThink2  = stripslashes($data['Low_Order_Thinking_2']);
	   $LowThink3  = stripslashes($data['Low_Order_Thinking_3']);
	   $LowThink4  = stripslashes($data['Low_Order_Thinking_4']);
	   $LowThink5  = stripslashes($data['Low_Order_Thinking_5']);
	   $HighThink1  = stripslashes($data['High_Order_Thinking_1']);
	   $HighThink2  = stripslashes($data['High_Order_Thinking_2']);
	   $HighThink3  = stripslashes($data['High_Order_Thinking_3']);
	   $HighThink4  = stripslashes($data['High_Order_Thinking_4']);
	   $HighThink5  = stripslashes($data['High_Order_Thinking_5']);
	   $TeacherRem  = stripslashes($data['Teacher_Remark']);
	   $HeadRem  = stripslashes($data['Head_Remark']);
	   $CoachRem  = stripslashes($data['Coach_Remark']);
	   $UpdateDtate  = stripslashes($data['DateUpdated']);
	   
   }
} else if(isset($_GET['printDate']))
{

	$query = mysql_query("SELECT * FROM  `LessonPlan` where DateOfEx = '".$_GET['printDate']."' and prepared_By = '".$_SESSION['name']."'") or die(mysql_error());
   while($data = mysql_fetch_array($query))
   {
	   $ColNum = stripslashes($data['colNum']);
	   $Class = stripslashes($data['class']);
	   $dataOfEx = stripslashes($data['DateOfEx']);
	   $Subject = stripslashes($data['Subject']);
	   $Refrence = stripslashes($data['Ref']);
	   $Time = stripslashes($data['Time']);
	   $Duation =stripslashes($data['Duration']);
	   $Topic = stripslashes($data['Topic']);
	   $Objective = stripslashes($data['Objective']);
	   $RPK = stripslashes($data['RPK']);
	   $Bell_Res1 = stripslashes($data['BeLL_Resource_1']);
	   $Bell_Res2 = stripslashes($data['BeLL_Resource_2']);
	   $Bell_Res3 = stripslashes($data['BeLL_Resource_3']);
	   $Bell_Res4 = stripslashes($data['BeLL_Resource_4']);
	   $Bell_Res5 = stripslashes($data['BeLL_Resource_5']);
	   $Outside_Res1 = stripslashes($data['Other_Resource_1']);
	   $Outside_Res2 = stripslashes($data['Other_Resource_2']);
	   $Outside_Res3 = stripslashes($data['Other_Resource_3']);
	   $Tech1 = stripslashes($data['Tech_Used_1']);
	   $Tech2 = stripslashes($data['Tech_Used_2']);
	   $Tech3 = stripslashes($data['Tech_Used_3']);
	   $CorePoint = stripslashes($data['Core_Points']);
	   $Intro= stripslashes($data['Introduction']);
	   $PreWrite  = stripslashes($data['Pre_Writing']);
	   $Writing = stripslashes($data['Writing']);
	   $Post_Writing  = stripslashes($data['Post_Writing']);
	   $Conclu = stripslashes($data['Conclusion']);
	   $LowThink1  = stripslashes($data['Low_Order_Thinking_1']);
	   $LowThink2  = stripslashes($data['Low_Order_Thinking_2']);
	   $LowThink3  = stripslashes($data['Low_Order_Thinking_3']);
	   $LowThink4  = stripslashes($data['Low_Order_Thinking_4']);
	   $LowThink5  = stripslashes($data['Low_Order_Thinking_5']);
	   $HighThink1  = stripslashes($data['High_Order_Thinking_1']);
	   $HighThink2  = stripslashes($data['High_Order_Thinking_2']);
	   $HighThink3  = stripslashes($data['High_Order_Thinking_3']);
	   $HighThink4  = stripslashes($data['High_Order_Thinking_4']);
	   $HighThink5  = stripslashes($data['High_Order_Thinking_5']);
	   $TeacherRem  = stripslashes($data['Teacher_Remark']);
	   $HeadRem  = stripslashes($data['Head_Remark']);
	   $CoachRem  = stripslashes($data['Coach_Remark']);
	   $UpdateDtate  = stripslashes($data['DateUpdated']);
	   
   }
}
?>
</head>

<body>
<table width="67%" align="center" cellpadding="2">
  <tr>
    <td width="116" valign="top" class="prntTitle">&nbsp;</td>
    <td width="348" valign="top">&nbsp;</td>
    <td width="144" align="left" valign="top"><span class="prntTitle"><b>Class </b>: <?php echo $Class;?></span></td>
</tr>
  <tr>
    <td valign="top"><span class="prntTitle"><b class="prntTitle" id="prntTitle">Date</b></span></td>
    <td width="348" valign="top" class="content"><?php echo $dataOfEx;?></td>
    <td width="144" valign="top" class="content">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><span class="prntTitle"><b>Subject</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $Subject;?></td>
</tr>
  <tr>
    <td valign="top"><span class="prntTitle"><b>References</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $Refrence;?></td>
</tr>
  <tr>
    <td valign="top"><span class="prntTitle"><b>Time</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $Time;?></td>
</tr>
  <tr>
    <td valign="top"><span class="prntTitle"><b>Duration</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $Duation;?></td>
</tr>
  <tr>
    <td valign="top"><span class="prntTitle"><b>Aspect / Topic</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $Topic;?></td>
</tr>
  <tr>
    <td valign="top"><span class="prntTitle"><b>Objective(s)</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $Objective;?></td>
</tr>
  <tr>
    <td valign="top"><span class="prntTitle"><b>RPK</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $RPK;?></td>
</tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2" valign="top" class="content">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" valign="top"><span class="prntTitle"><b>T &amp; L resources selcted from BeLL</b></span></td>
  </tr>
  <tr>
    <td align="right" valign="top"><span class="prntTitle"><b>1</b></span></td>
    <td colspan="2" valign="top" class="content">
	<?php
			 $query = mysql_query("SELECT * FROM `resources` where resrcID='".$Bell_Res1."'") or die(mysql_error());
			 while($data = mysql_fetch_array($query))
			 {
				 	echo stripslashes($data['title']);
				 
			 }
    ?>
    </td>
  </tr>
  <tr>
    <td align="right" valign="top"><span class="prntTitle"><b>2</b></span></td>
    <td colspan="2" valign="top" class="content"><?php
			 $query = mysql_query("SELECT * FROM `resources` where resrcID='".$Bell_Res2."'") or die(mysql_error());
			 while($data = mysql_fetch_array($query))
			 {
				 	echo stripslashes($data['title']);
				 
			 }
    ?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><span class="prntTitle"><b>3</b></span></td>
    <td colspan="2" valign="top" class="content"><?php
			 $query = mysql_query("SELECT * FROM `resources` where resrcID='".$Bell_Res3."'") or die(mysql_error());
			 while($data = mysql_fetch_array($query))
			 {
				 	echo stripslashes($data['title']);
				 
			 }
    ?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><span class="prntTitle"><b>4</b></span></td>
    <td colspan="2" valign="top" class="content"><?php
			 $query = mysql_query("SELECT * FROM `resources` where resrcID='".$Bell_Res4."'") or die(mysql_error());
			 while($data = mysql_fetch_array($query))
			 {
				 	echo stripslashes($data['title']);
				 
			 }
    ?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><span class="prntTitle"><b>5</b></span></td>
    <td colspan="2" valign="top" class="content"><?php
			 $query = mysql_query("SELECT * FROM `resources` where resrcID='".$Bell_Res4."'") or die(mysql_error());
			 while($data = mysql_fetch_array($query))
			 {
				 	echo stripslashes($data['title']);
				 
			 }
    ?></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
    <td colspan="2" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" valign="top"><span class="prntTitle"><b>T &amp; L resources selcted from outside the BeLL</b></span></td>
  </tr>
  <tr>
    <td align="right" valign="top"><span class="prntTitle"><b>1</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $Outside_Res1;?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><span class="prntTitle"><b>2</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $Outside_Res2;?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><span class="prntTitle"><b>3</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $Outside_Res3;?></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
    <td colspan="2" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" valign="top"><span class="prntTitle"><b>Proposed Technology tools to be used in the lesson</b></span></td>
  </tr>
  <tr>
    <td align="right" valign="top"><span class="prntTitle"><b>1</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $Tech1;?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><span class="prntTitle"><b>2</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $Tech2;?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><span class="prntTitle"><b>3</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $Tech3;?></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
    <td colspan="2" valign="top" class="content">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top"><span class="prntTitle"><b>Core Points / Literacy Skill to be developed</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $CorePoint;?></td>
</tr>
  <tr>
    <td colspan="3" align="left" valign="top"><span class="prntTitle"><b style="color:#666;">Teaching and Learning Activities (include 1) how RPK will be used 2) how technology selected will be used 3) 21st century skills that would be used in the teaching to make it fun, participatory and self- discovery)</b></span></td>
  </tr>
  <tr>
    <td align="left" valign="top"><span class="prntTitle"><b>Introduction</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $Intro;?></td>
</tr>
  <tr>
    <td align="left" valign="top"><span class="prntTitle"><b>Pre –Writing / Reading stage</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $PreWrite;?></td>
</tr>
  <tr>
    <td align="left" valign="top"><span class="prntTitle"><b>Writing / Reading Stage</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $Writing;?></td>
</tr>
  <tr>
    <td align="left" valign="top"><span class="prntTitle"><b>Post – Writing / Reading Stage</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $Post_Writing;?></td>
</tr>
  <tr>
    <td align="left" valign="top"><span class="prntTitle"><b>Conclusion</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $Conclu;?></td>
</tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td colspan="2" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><span class="prntTitle"><b style="color:#666;">Evaluation Exercises</b></span></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><span class="prntTitle"><b>Low Order Thinking Questions</b></span></td>
  </tr>
  <tr>
    <td align="right" valign="top"><span class="prntTitle"><b>1</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $LowThink1;?></td>
</tr>
  <tr>
    <td align="right" valign="top"><span class="prntTitle"><b>2</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $LowThink2;?></td>
</tr>
  <tr>
    <td align="right" valign="top"><span class="prntTitle"><b>3</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $LowThink3;?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><span class="prntTitle"><b>4</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $LowThink4;?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><span class="prntTitle"><b>5</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $LowThink5;?></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><span class="prntTitle"><b>High Order Thinking Questions</b></span></td>
  </tr>
  <tr>
    <td align="right" valign="top"><span class="prntTitle"><b>1</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $HighThink1;?></td>
</tr>
  <tr>
    <td align="right" valign="top"><span class="prntTitle"><b>2</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $HighThink2;?></td>
</tr>
  <tr>
    <td align="right" valign="top"><span class="prntTitle"><b>3</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $HighThink3;?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><span class="prntTitle"><b>4</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $HighThink4;?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><span class="prntTitle"><b>5</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $HighThink5;?></td>
  </tr>
  <tr>
    <td align="right" valign="top">&nbsp;</td>
    <td colspan="2" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><span class="prntTitle"><b>Remarks on the teaching done / observed by the following</b></span></td>
  </tr>
  <tr>
    <td align="left" valign="top"><span class="prntTitle"><b>Teacher</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $TeacherRem;?><br />
    <br /></td>
</tr>
  <tr>
    <td align="left" valign="top"><span class="prntTitle"><b>Head</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $HeadRem;?><br />      <br /></td>
  </tr>
  <tr>
    <td align="left" valign="top"><span class="prntTitle"><b>Coach</b></span></td>
    <td colspan="2" valign="top" class="content"><?php echo $CoachRem;?><br />
    <br /></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td colspan="2" class="content">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td><input type="hidden" name="systemDateForm" id="systemDateForm" /></td>
    <td><input name="Button" type="button" class="button" value="Print now" onclick="window.print()" /></td>
  </tr>
  <tr> </tr>
  <tr> </tr>
  <tr> </tr>
  <tr> </tr>
  <tr> </tr>
  <tr> </tr>
  <tr> </tr>
  <tr> </tr>
  <tr> </tr>
  <tr> </tr>
  <tr> </tr>
  <tr> </tr>
  <tr> </tr>
  <tr> </tr>
  <tr> </tr>
  <tr> </tr>
  <tr> </tr>
  <tr> </tr>
  <tr> </tr>
</table>
</body>
</html>