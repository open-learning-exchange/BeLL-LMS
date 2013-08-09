<?php ini_set("session.gc_maxlifetime","94000"); session_start(); error_reporting(1);include "talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Copyright" content="ole.org.gh">
<meta name="description" content="OMS Ole Ghana">
<meta name="keywords" content="Admin Page">
<meta name="author" content="Open Learning Exchang">
<meta name="language" content="English">

<link rel="shortcut icon" href="stylesheet/img/devil-icon.png"> 
<link rel="stylesheet" type="text/css" href="css/style.css">
<?php
$cntVal =0;
$messageLog = "";
if(isset($_POST['loginid']))
{
  $query = mysql_query("SELECT * FROM `teacherClass` where loginId='".$_POST['loginid']."' and pswd= md5('".$_POST['password']."')") or die(mysql_error());
   while($data = mysql_fetch_array($query))
   {
	  $_SESSION['teacherid'] = $data['loginId'];
	  $_SESSION['class-level'] = $data['loginId'];
	  $_SESSION['role'] = $data['Role'];
	  $_SESSION['logColmn'] = $data['colNum'];
	  $_SESSION['name'] = $data['Name'];
	  $_SESSION['classAsigned'] =$data['classAssign'];
	  $cntVal++;
   }
   if($cntVal>0)
   {
	   recordActionDate($_SESSION['name'],"Loged in",$_POST['systemDateForm']);
		if($_SESSION['role']=="Admin")
		{
			$mystring = "dasboard.php?role=".$_SESSION['role']."&cnm=".$_SESSION['logColmn']."";
	   		die('<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$mystring.'">');
			
		} else if ($_SESSION['role']=="Teacher")
		{
			$mystring = "dasboard.php?role=".$_SESSION['role']."&cnm=".$_SESSION['logColmn']."";
	   		die('<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$mystring.'">');
			
		} else if ($_SESSION['role']=="Coach")
		{
			$mystring = "coach.php?role=".$_SESSION['role']."&cnm=".$_SESSION['logColmn']."";
	   		die('<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$mystring.'">');
			
		}else if ($_SESSION['role']=="Head")
		{
			$mystring = "headteacher.php?role=".$_SESSION['role']."&cnm=".$_SESSION['logColmn']."";
	   		die('<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$mystring.'">');
			
		}
		else if ($_SESSION['role']=="Lead")
		{
			$mystring = "leadteacher.php?role=".$_SESSION['role']."&cnm=".$_SESSION['logColmn']."&dat=".$_POST['systemDateForm'];
	   		die('<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$mystring.'">');
		}
		else
		{
			$mystring = "index.php?login=invalid";
			die('<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$mystring.'">');
		}
   }else
	{
			$mystring = "index.php?login=invalid";
			die('<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$mystring.'">');
	}
} 
else
{
	if($_SESSION['name'])
	{
		recordActionDate($_SESSION['name'],"Loged out",$_GET['systemDateForm']);
		session_destroy();
	}
	else
	{
		session_destroy();
	}
}
if(isset($_GET['login'])){
	$messageLog = "Login Id & password mismatch. Try again ";
}
if(isset($_GET['sesEnded'])){
	recordActionDate("User login session ended ","Loged out",$_GET['systemDateForm']);
	$messageLog = "Your session is over. Please login";
}

?>
</head>
<style>

body {
	background: url(images/latar.jpg);
	margin: 0;
	padding: 0;
	font-family: Arial;
	font-size: 12px;
	color: #2e2e2e;
	text-align: center;
}
</style>
<body>
<div id="header">
  <div class="inHeaderLogin"><div style="width:300px;height:50px; padding-top:10px; float:right; text-align:right"><b><!--<a href="TM/oms/">TM OMS</a> </b>&nbsp;&nbsp;&nbsp;&nbsp;|| &nbsp;&nbsp;&nbsp;&nbsp;<b><a href="TM/games/">TM STUDENT&nbsp;</a>--></b>&nbsp;&nbsp;&nbsp;</div></div>
</div>

<div id="loginForm">
	<div class="headLoginForm">
	Login Administrator
	</div>
    <div class="fieldLogin">
	<form method="POST" action=""><br>
    
	<label>Login ID</label><br>
	<input name="loginid" type="text" class="login" id="loginid"><br>
	<label>Password</label><br>
	<input name="password" type="password" class="login" id="password"><br>
	<input type="submit" class="button" value="Login">
    <input type="hidden" name="systemDateForm" id="systemDateForm">
    <br><br>
	<span style="text-align: center; color:#F00; font-size:12px;"><?php echo $messageLog;?><br>
</span>
	</form>
	</div>
</div>
</body>
<script type="text/javascript">
	var now = new Date()
	///now = now.toGMTString();
	var fmat= now.getFullYear()+'-'+ (now.getMonth()+1)+'-'+(now.getDay()+10)+' '+(now.getHours())+':'+(now.getMinutes())+':'+(now.getSeconds());
	document.getElementById('systemDateForm').value = fmat;
</script>
</html>