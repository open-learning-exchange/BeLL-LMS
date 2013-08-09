<?php session_start();include "../secure/talk2db.php";include "../functions/processClassTask.php";?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/jquery.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" media="all" href="../css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../js/jsDatePick.min.1.3.js"></script>
<title>Open Learning Exchange - Ghana</title>
</head>
<script type="text/javascript">
$(document).ready(function(){
	$('#Vbook').click(function () {
    	$("#videoBooks").slideToggle("slow");
	});
	$('#AStory').click(function () {
    	$("#audioStory").slideToggle("slow");
	});
	$('#Phons').click(function () {
    	$("#phonomics").slideToggle("slow");
	});
	$('#WordP').click(function () {
    	$("#wordPower").slideToggle("slow");
	});
});
</script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"dateExec",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
<body>
<form name="form1" method="post" action="">
  <div id="wrapper" style="background-color:#FFF; width:600px;">
    <div id="rightContent" style="float:none; text-align:center; margin-left:auto; margin-right:auto; width:580px; margin-left:auto; margin-right:auto;"><span style="color:#00C; font-weight: bold;">Assign Task To Class</span><br /><hr align="center" color="#0033FF">
      <br>
      <table width="478" border="0">
        <tr>
          <td width="116"><b>Week starting on</b></td>
          <td width="178">
            <input type="text" name="dateExec" id="dateExec" style="width:50%"></td>
          <td width="35">&nbsp;</td>
          <td width="131"><b>Class </b>: 
          <select name="class" id="class">
            <option value="KG">KG</option>
            <option value="P1">P1</option>
            <option value="P2">P2</option>
            <option value="P3">P3</option>
            <option value="P4">P4</option>
            <option value="P5">P5</option>
            <option value="P6">P6</option>
          </select>
          </td>
        </tr>
      </table>
    </div>
    <div class="clear" style="font-size: 14px; color: #00C; text-align:center;"><span class="clear" style="font-size: 14px; color: #00C;"> <span style="float:none; margin-left:auto; margin-right:auto; width:600px; margin-left:auto; margin-right:auto;">&nbsp;&nbsp;&nbsp;</span></span>Video Book
      <input name="Vbook" type="checkbox" id="Vbook" value="Yes">
      <span style="float:none; margin-left:auto; margin-right:auto; width:600px; margin-left:auto; margin-right:auto;">&nbsp;&nbsp;&nbsp;</span>      || <span style="float:none; margin-left:auto; margin-right:auto; width:600px; margin-left:auto; margin-right:auto;">&nbsp;&nbsp;&nbsp;</span>Audio Stories
<input name="AStory" type="checkbox" id="AStory" value="Yes">
<span style="float:none; margin-left:auto; margin-right:auto; width:600px; margin-left:auto; margin-right:auto;">&nbsp;&nbsp;&nbsp;</span>
      ||
<label for="Vbook"></label>
    <span style="float:none; margin-left:auto; margin-right:auto; width:600px; margin-left:auto; margin-right:auto;">&nbsp;&nbsp;&nbsp;</span>Phonomics 
    <input name="Phons" type="checkbox" id="Phons" value="Yes">
    <span style="float:none; margin-left:auto; margin-right:auto; width:600px; margin-left:auto; margin-right:auto;">&nbsp;&nbsp;&nbsp;</span>    || <span style="float:none; margin-left:auto; margin-right:auto; width:600px; margin-left:auto; margin-right:auto;">&nbsp;&nbsp;&nbsp;</span>Word Power
<input name="WordP" type="checkbox" id="WordP" value="Yes">
    </div>
    <div style="float:none; margin-left:auto; margin-right:auto; width:600px; margin-left:auto; margin-right:auto;">
      <div id="videoBooks">
        <table width="557" border="0" align="center" cellpadding="1" cellspacing="2" style="color: #2437C4;">
          <tr>
            <td colspan="2" align="center" bgcolor="#FFFFFF"><strong style="font-weight: bold; font-size: 18px;">Video Book</strong></td>
          </tr>
          <tr>
            <td width="110" bgcolor="#FFFFFF">Select Video Book</td>
            <td width="437" bgcolor="#FFFFFF">
            <select name="vbTitle" id="vbTitle" onChange="getQuestions()">
              <option value="00">Select</option>
              <?php
			  $cnt =1;
$query = mysql_query("SELECT * FROM `resources` where TLR='' AND type='mp4' order by KG, P1, P2, P3, P4, P5, P6") or die(mysql_error());
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
            <td bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Discription</td>
            <td bgcolor="#FFFFFF"><p id="descriptionDisp"></p></td>
          </tr>
          <tr>
            <td valign="top" bgcolor="#FFFFFF">Select 10 Questions</td>
            <td valign="top" bgcolor="#FFFFFF"><p id="Allquestions"></p>
              <input type="submit" class="button" value="Submit" style="width:90px; height:30px;"></td>
          </tr>
        </table>
      </div>
      <div id="audioStory"></div>
    <div id="phonomics"></div>
    <div id="wordPower"></div>
    </div>
  </div>
</form>

<script type="text/javascript">
function getQuestions(){
	var resID = document.getElementById("vbTitle").value;
	$("#Allquestions").load("../functions/getQuestionTable.php?id="+resID+"");
	$("#descriptionDisp").load("../functions/getDiscription.php?id="+resID+"");
}

</script>
<script type="text/javascript">
	var now = new Date()
	///now = now.toGMTString();
	var fmat= now.getFullYear()+'-'+ (now.getMonth()+1)+'-'+(now.getDay()+10)+' '+(now.getHours())+':'+(now.getMinutes())+':'+(now.getSeconds());
	document.getElementById('systemDateForm').value = fmat;
</script>
</body>
</html>
