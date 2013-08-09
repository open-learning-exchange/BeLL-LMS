<?php session_start(); error_reporting(1);include "../secure/talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:550px; margin-left:auto; margin-right:auto;"><span style="color:#00C; font-weight: bold;">List All Lesson Plan</span><br><br>
	<table width="105%">
	 <tr>
	    <td width="115" height="11"><b>Date</b></td>
	    <td width="116">Prepared By</td>
	    <td width="111">Class</td>
	    <td width="138">Subject</td>
	    <td width="65">Option</td>
      </tr>
	  
      <?php
			 $query = mysql_query("SELECT * FROM  `LessonPlan`  ORDER BY `DateOfEx` DESC") or die(mysql_error());
			 $cnt = 0;
			 while($data = mysql_fetch_array($query))
			 {
				 echo '<tr>
	    <td height="11">'.$data['DateOfEx'].'</td>
		 <td width="116">'.$data['prepared_By'].'</td>
	    <td width="92">'.$data['class'].'</td>
	    <td width="67">'.$data['Subject'].'</td>
	    <td width="77"><input type="submit" class="button" value="View" onclick=openLPlan('.$data['colNum'].')></td>
      </tr>';
				$cnt++;
			 }
      ?>
		</table>
	</div>
<div class="clear"></div>
</div>
</body>
<script type="text/javascript">
function openLPlan(pNumber)
{
	window.location= 'vw_lplan.php?editdate='+pNumber;
	///alert('Yes'); 
}
</script>
</html>