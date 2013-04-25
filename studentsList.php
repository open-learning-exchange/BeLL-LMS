<?php session_start(); error_reporting(1);include "talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
</head>
<body>
<div id="wrapper"  style="background-color:#FFF; width:600px;">
<div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:550px; margin-left:auto; margin-right:auto;">
	<h4>&nbsp;&nbsp;&nbsp;<a href="#KG">KG </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;||&nbsp;&nbsp;&nbsp;&nbsp; <a href="#P1">P1</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|| &nbsp;&nbsp;&nbsp;&nbsp;<a href="#P2">P2</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; || &nbsp;&nbsp;&nbsp;&nbsp;<a href="#P3">P3</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|| &nbsp;&nbsp;&nbsp;&nbsp;<a href="#P4">P4</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|| &nbsp;&nbsp;&nbsp;&nbsp;<a href="#P5">P5  </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|| &nbsp;&nbsp;&nbsp;&nbsp;<a href="#P6">P6</a></h4>
	<a name="KG"></a>
    <b>KG </b>
    <table class="data">
		<tr class="data">
				<th class="data" width="29">No</th>
				<th width="201" class="data">Name</th>
				<th width="116" class="data">Code</th>
				<th width="65" class="data">Gender</th>
				<th class="data" width="89">Class / Level</th>
	  </tr>
     <!-- ///////////-->
 <?php
	 $query = mysql_query("SELECT * FROM `students` where stuClass='KG' ORDER BY `stuName` ASC") or die(mysql_error());
	  recordActionDate($_SESSION['name'],"Viewed list of students",$_GET['systemDateForm']);
	 $cnt = 1;
	 while($data = mysql_fetch_array($query))
	 {
		 if($cnt%2==0)
		 {
			 echo '<tr class="data">
				<td class="data" width="29">'.$cnt.'</td>
				<td class="data">'.$data['stuName'].'</td>
				<td class="data">'.$data['stuCode'].'</td>
				<td class="data">'.$data['stuGender'].'</td>
				<td class="data" width="89"><center>'.$data['stuClass'].'</center></td>
			</tr>';
		 } else {
			echo '<tr class="data" bgcolor="#EEEEEE">
				<td class="data" width="29">'.$cnt.'</td>
				<td class="data">'.$data['stuName'].'</td>
				<td class="data">'.$data['stuCode'].'</td>
				<td class="data">'.$data['stuGender'].'</td>
				<td class="data" width="89"><center>'.$data['stuClass'].'</center></td>
			</tr>';
		 }
		 $cnt++;
	}
?>
	</table>
    <br>
	<a name="P1"></a><b>Primary 1</b>
	<table class="data">
	  <tr class="data">
	    <th class="data" width="29">No</th>
	    <th width="201" class="data">Name</th>
	    <th width="116" class="data">Student ID</th>
	    <th width="65" class="data">Gender</th>
	    <th class="data" width="89">Class / Level</th>
      </tr>
	   <?php
	 $query = mysql_query("SELECT * FROM `students` where stuClass='P1' ORDER BY `stuName` ASC") or die(mysql_error());
	 $cnt = 1;
	 while($data = mysql_fetch_array($query))
	 {
		 if($cnt%2==0)
		 {
			 echo '<tr class="data">
				<td class="data" width="29">'.$cnt.'</td>
				<td class="data">'.$data['stuName'].'</td>
				<td class="data">'.$data['stuCode'].'</td>
				<td class="data">'.$data['stuGender'].'</td>
				<td class="data" width="89"><center>'.$data['stuClass'].'</center></td>
			</tr>';
		 } else {
			echo '<tr class="data" bgcolor="#EEEEEE">
				<td class="data" width="29">'.$cnt.'</td>
				<td class="data">'.$data['stuName'].'</td>
				<td class="data">'.$data['stuCode'].'</td>
				<td class="data">'.$data['stuGender'].'</td>
				<td class="data" width="89"><center>'.$data['stuClass'].'</center></td>
			</tr>';
		 }
		 $cnt++;
	}
?>
    </table>
	<br>
	<a name="P2" id="P2"></a><b>Primary 2</b>
	<table class="data">
	  <tr class="data">
	    <th class="data" width="29">No</th>
	    <th width="201" class="data">Name</th>
	    <th width="116" class="data">Student ID</th>
	    <th width="65" class="data">Gender</th>
	    <th class="data" width="89">Class / Level</th>
      </tr>
	  <?php
	 $query = mysql_query("SELECT * FROM `students` where stuClass='P2' ORDER BY `stuName` ASC") or die(mysql_error());
	 $cnt = 1;
	 while($data = mysql_fetch_array($query))
	 {
		 if($cnt%2==0)
		 {
			 echo '<tr class="data">
				<td class="data" width="29">'.$cnt.'</td>
				<td class="data">'.$data['stuName'].'</td>
				<td class="data">'.$data['stuCode'].'</td>
				<td class="data">'.$data['stuGender'].'</td>
				<td class="data" width="89"><center>'.$data['stuClass'].'</center></td>
			</tr>';
		 } else {
			echo '<tr class="data" bgcolor="#EEEEEE">
				<td class="data" width="29">'.$cnt.'</td>
				<td class="data">'.$data['stuName'].'</td>
				<td class="data">'.$data['stuCode'].'</td>
				<td class="data">'.$data['stuGender'].'</td>
				<td class="data" width="89"><center>'.$data['stuClass'].'</center></td>
			</tr>';
		 }
		 $cnt++;
	}
?>
    </table>
	<br>
	<a name="P3" id="P3"></a><b>Primary 3</b>
	<table class="data">
	  <tr class="data">
	    <th class="data" width="29">No</th>
	    <th width="201" class="data">Name</th>
	    <th width="116" class="data">Student ID</th>
	    <th width="65" class="data">Gender</th>
	    <th class="data" width="89">Class / Level</th>
      </tr>
	  <?php
	 $query = mysql_query("SELECT * FROM `students` where stuClass='P3' ORDER BY `stuName` ASC") or die(mysql_error());
	 $cnt = 1;
	 while($data = mysql_fetch_array($query))
	 {
		 if($cnt%2==0)
		 {
			 echo '<tr class="data">
				<td class="data" width="29">'.$cnt.'</td>
				<td class="data">'.$data['stuName'].'</td>
				<td class="data">'.$data['stuCode'].'</td>
				<td class="data">'.$data['stuGender'].'</td>
				<td class="data" width="89"><center>'.$data['stuClass'].'</center></td>
			</tr>';
		 } else {
			echo '<tr class="data" bgcolor="#EEEEEE">
				<td class="data" width="29">'.$cnt.'</td>
				<td class="data">'.$data['stuName'].'</td>
				<td class="data">'.$data['stuCode'].'</td>
				<td class="data">'.$data['stuGender'].'</td>
				<td class="data" width="89"><center>'.$data['stuClass'].'</center></td>
			</tr>';
		 }
		 $cnt++;
	}
?>
    </table>
	<br>
	<a name="P4" id="P4"></a><b>Primary 4</b>
	<table class="data">
	  <tr class="data">
	    <th class="data" width="29">No</th>
	    <th width="201" class="data">Name</th>
	    <th width="116" class="data">Student ID</th>
	    <th width="65" class="data">Gender</th>
	    <th class="data" width="89">Class / Level</th>
      </tr>
	   <?php
	 $query = mysql_query("SELECT * FROM `students` where stuClass='P4' ORDER BY `stuName` ASC") or die(mysql_error());
	 $cnt = 1;
	 while($data = mysql_fetch_array($query))
	 {
		 if($cnt%2==0)
		 {
			 echo '<tr class="data">
				<td class="data" width="29">'.$cnt.'</td>
				<td class="data">'.$data['stuName'].'</td>
				<td class="data">'.$data['stuCode'].'</td>
				<td class="data">'.$data['stuGender'].'</td>
				<td class="data" width="89"><center>'.$data['stuClass'].'</center></td>
			</tr>';
		 } else {
			echo '<tr class="data" bgcolor="#EEEEEE">
				<td class="data" width="29">'.$cnt.'</td>
				<td class="data">'.$data['stuName'].'</td>
				<td class="data">'.$data['stuCode'].'</td>
				<td class="data">'.$data['stuGender'].'</td>
				<td class="data" width="89"><center>'.$data['stuClass'].'</center></td>
			</tr>';
		 }
		 $cnt++;
	}
?>
    </table>
	<br>
	<a name="P5" id="P5"></a><b>Primary 5</b>
	<table class="data">
	  <tr class="data">
	    <th class="data" width="29">No</th>
	    <th width="201" class="data">Name</th>
	    <th width="116" class="data">Student ID</th>
	    <th width="65" class="data">Gender</th>
	    <th class="data" width="89">Class / Level</th>
      </tr>
	   <?php
	 $query = mysql_query("SELECT * FROM `students` where stuClass='P5' ORDER BY `stuName` ASC") or die(mysql_error());
	 $cnt = 1;
	 while($data = mysql_fetch_array($query))
	 {
		 if($cnt%2==0)
		 {
			 echo '<tr class="data">
				<td class="data" width="29">'.$cnt.'</td>
				<td class="data">'.$data['stuName'].'</td>
				<td class="data">'.$data['stuCode'].'</td>
				<td class="data">'.$data['stuGender'].'</td>
				<td class="data" width="89"><center>'.$data['stuClass'].'</center></td>
			</tr>';
		 } else {
			echo '<tr class="data" bgcolor="#EEEEEE">
				<td class="data" width="29">'.$cnt.'</td>
				<td class="data">'.$data['stuName'].'</td>
				<td class="data">'.$data['stuCode'].'</td>
				<td class="data">'.$data['stuGender'].'</td>
				<td class="data" width="89"><center>'.$data['stuClass'].'</center></td>
			</tr>';
		 }
		 $cnt++;
	}
?>
    </table>
	<br>
	<a name="P6" id="P6"></a><b>Primary 6</b>
	<table class="data">
	  <tr class="data">
	    <th class="data" width="29">No</th>
	    <th width="201" class="data">Name</th>
	    <th width="116" class="data">Student ID</th>
	    <th width="65" class="data">Gender</th>
	    <th class="data" width="89">Class / Level</th>
      </tr>
	   <?php
	 $query = mysql_query("SELECT * FROM `students` where stuClass='P6' ORDER BY `stuName` ASC") or die(mysql_error());
	 $cnt = 1;
	 while($data = mysql_fetch_array($query))
	 {
		 if($cnt%2==0)
		 {
			 echo '<tr class="data">
				<td class="data" width="29">'.$cnt.'</td>
				<td class="data">'.$data['stuName'].'</td>
				<td class="data">'.$data['stuCode'].'</td>
				<td class="data">'.$data['stuGender'].'</td>
				<td class="data" width="89"><center>'.$data['stuClass'].'</center></td>
			</tr>';
		 } else {
			echo '<tr class="data" bgcolor="#EEEEEE">
				<td class="data" width="29">'.$cnt.'</td>
				<td class="data">'.$data['stuName'].'</td>
				<td class="data">'.$data['stuCode'].'</td>
				<td class="data">'.$data['stuGender'].'</td>
				<td class="data" width="89"><center>'.$data['stuClass'].'</center></td>
			</tr>';
		 }
		 $cnt++;
	}
?>
    </table>
  </div>
<div class="clear"></div>
</div>
</body>
</html>