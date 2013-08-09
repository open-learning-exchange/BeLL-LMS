<?php session_start();include "../secure/talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<?php
if(isset($_GET['drop']))
{
	$delItem = mysql_query("DELETE FROM `students` WHERE `colNum` = ".$_GET['drop']."") or die(mysql_query());
	recordAction($_SESSION['name'],"Student deleted");
	
	echo '<script type="text/javascript">alert("Student deleted succesfully");</script>';
	die("Deleted Succesfully");
}
?>

<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:500px; margin-left:auto; margin-right:auto;">
  <span style="color:#00C; font-weight: bold;">Manage Students</span><br><br>
  <form name="form1" method="post" action="">
      <table width="72%" align="center">
      <tr>        </tr>
      <tr>        </tr>
      </table>
      <table width="478" height="32" border="1">
        <tr>
          <td width="32" height="26">No.</td>
          <td width="83"><b>Class / Level</b></td>
          <td width="178"><b>Student Name</b></td>
          <td width="93"><b> Login ID</b></td>
          <td width="58"><b>Action</b></td>
        </tr>
         <?php
			 $query = mysql_query("SELECT * FROM `students` order by stuClass") or die(mysql_error());
			 $cnt=1;
			 while($data = mysql_fetch_array($query))
			 {
				 	echo '<tr>
          <td width="32" height="26">No.</td>
          <td width="83">'.$data['stuClass'].'</td>
          <td width="178">'.$data['stuName'].'</td>
          <td width="93">'.$data['stuCode'].'</td>
          <td width="58"><a href="delstudent.php?drop='.$data['colNum'].'">Drop</a></td>
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
</body>
</html>