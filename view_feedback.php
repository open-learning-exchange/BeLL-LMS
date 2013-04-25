<?php session_start(); error_reporting(1);include "talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>


<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:550px; margin-left:auto; margin-right:auto;"><span style="color:#00C; font-weight: bold;">Student usage feedback</span> - &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="javascript:window.print()" style="color: #CC0000">|| Print Page ||</A><br>
    <br>
    <a href="view_feedback.php?cls=KG">KG only</a> || <a href="view_feedback.php?cls=P1">P1 only</a> || <a href="view_feedback.php?cls=P2">P2 only</a> || <a href="view_feedback.php?cls=P3">P3 only</a> || <a href="view_feedback.php?cls=P4">P4 only</a> || <a href="view_feedback.php?cls=P5">P5 only </a>|| <a href="view_feedback.php?cls=P6">P6 only</a><br><br>
	<table width="105%">
	  <tr>
	    <td width="75" height="24"><b>Student ID</b></td>
	    <td width="211"><b>Student name</b></td>
	    <td width="56"><b>Class</b></td>
	    <td width="68"><b>No. Used</b></td>
	    <td width="133"><b>Last date used</b></td>
      </tr>
      <?php
	if(isset($_GET['cls']))
	{
			 $query = mysql_query("SELECT colNum, Max(fbdate) as theDdate, fbstudentID, fbstudentName, fbstudentClass, count(fbresourceID) as NOTIME FROM `feedback` where fbstudentClass ='".$_GET['cls']."' Group By fbstudentID ") or die(mysql_error());
			 $cnt = 0;
			 while($data = mysql_fetch_array($query))
			 {
				 if($cnt%2==0)
				 {
				 echo '<tr>
						<td width="75" height="24">'.$data['fbstudentID'].'</td>
						<td width="211">'.$data['fbstudentName'].'</td>
						<td width="56">'.$data['fbstudentClass'].'</td>
						<td width="68">'.$data['NOTIME'].'</td>
						<td width="133">'.$data['theDdate'].'</td>
					  </tr>';
				 }
				 else
				 {
					 echo '<tr bgcolor="#F0F0F0">
						<td width="75" height="24">'.$data['fbstudentID'].'</td>
						<td width="211">'.$data['fbstudentName'].'</td>
						<td width="56">'.$data['fbstudentClass'].'</td>
						<td width="68">'.$data['NOTIME'].'</td>
						<td width="133">'.$data['theDdate'].'</td>
					  </tr>';
				 }
				$cnt++;
			 }
	}
	else
	{
				 $query = mysql_query("SELECT colNum, Max(fbdate) as theDdate, fbstudentID, fbstudentName, fbstudentClass, count(fbresourceID) as NOTIME FROM `feedback` Group By fbstudentID ") or die(mysql_error());
			 $cnt = 0;
			 while($data = mysql_fetch_array($query))
			 {
				 if($cnt%2==0)
				 {
				 echo '<tr>
						<td width="75" height="24">'.$data['fbstudentID'].'</td>
						<td width="211">'.$data['fbstudentName'].'</td>
						<td width="56">'.$data['fbstudentClass'].'</td>
						<td width="68">'.$data['NOTIME'].'</td>
						<td width="133">'.$data['theDdate'].'</td>
					  </tr>';
				 }
				 else
				 {
					 echo '<tr bgcolor="#F0F0F0">
						<td width="75" height="24">'.$data['fbstudentID'].'</td>
						<td width="211">'.$data['fbstudentName'].'</td>
						<td width="56">'.$data['fbstudentClass'].'</td>
						<td width="68">'.$data['NOTIME'].'</td>
						<td width="133">'.$data['theDdate'].'</td>
					  </tr>';
				 }
				$cnt++;
			 }
	}
      ?>
	</table>
  </div>
<div class="clear"></div>
</div>
</body>
<script type="text/javascript">
function openRes(pNumber)
{
	window.open('viewResource.php?resid='+pNumber);
	///alert('Yes'); 
}
</script>
</html>