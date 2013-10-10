<?php ini_set("session.gc_maxlifetime","949999"); session_start();include "secure/talk2db.php";?>
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

<script type="text/javascript" src="../js/jquery.js"></script>
<?php
$cntVal =0;
$messageLog = "";
if(isset($_POST['loginid']))
{
	global $couchUrl;
	$members = new couchClient($couchUrl, "members");
	// Get member
	global $facilityId;
	$key = $facilityId . $_POST['loginid'];
	
	///print $key;
	$viewResults = $members->include_docs(TRUE)->key($key)->getView('api', 'facilityLogin');
	//print_r($viewResults);
	foreach($viewResults->rows as $row) {
		///print_r($row);
		
	}
	$member = $viewResults->rows[0]->doc;
	$password = $_POST['pass'];
	
	if($member->pass == md5($password)) {
		
		$_SESSION['lmsUserID'] = $viewResults->rows[0]->id;
		
		$_SESSION['role'] = $member->roles;
		$_SESSION['name'] = $member->firstName." ".$member->middleNames." ".$member->lastName;
		$_SESSION['facilityID'] = $facilityId;
		$_SESSION['dateTime'] = $_POST['systemDateForm'];
		// Redirect user to dashboard page
		recordActionObject($_SESSION['lmsUserID'],"Loged in",$_POST['systemDateForm']);
		die('<script type="text/javascript">window.location.replace("dasboard.php")</script>');
	} else{
		///$messageLog = "Login ID & Password Mismatch. Try again ";
	}
} 
else {
	
	if(isset($_GET['sesEnded']))
	{
		recordActionObjectDate($_SESSION['lmsUserID'],"Session Timed-out","",$_GET['systemDateForm']);
		$messageLog = "Login Session Timed-out. Please login again";
	}
	else if(isset($_GET['signout']))
	{
		recordActionObjectDate($_SESSION['lmsUserID'],"Loged out","",$_GET['systemDateForm']);
		$messageLog = "Welcome Please login";
		session_destroy();
	}
	else{
		session_destroy();
	}
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
  <div class="inHeaderLogin">
    <div style="width: 200px; height: 50px; padding-top: 10px; float: right; text-align: left; color: #3C429A;"><b><!--<a href="TM/oms/">TM OMS</a> </b>&nbsp;&nbsp;&nbsp;&nbsp;|| &nbsp;&nbsp;&nbsp;&nbsp;<b><a href="TM/games/">TM STUDENT&nbsp;</a>--></b><span style="text-align: left">Learning Management System<br>
  Language : English<br>
  Version 1.01</span></div>
  </div>
</div>

<div id="loginForm">
	<div class="headLoginForm">
	Login Administrator
	<iframe src="set-server-time/go.html" width="10" height="5" style="display:none;"></iframe></div>
    <div class="fieldLogin">
	<form method="POST" action=""><br>
    
	<label>Login ID</label><br>
	<input name="loginid" type="text" class="login" id="loginid"><br>
	<label>Password</label><br>
	<input name="pass" type="password" class="login" id="pass"><br>
	<input type="submit" class="button" value="Login">
    <input type="hidden" name="systemDateForm" id="systemDateForm">
    <br><br>
	<span style="text-align: center; color:#F00; font-size:12px;"><?php echo $messageLog;?><br>
</span>
	</form>
	</div>
</div>
</body>
<script src="set-server-time/jquery-1.9.1.js"></script>
<script src="set-server-time/moment.min.js"></script>
<script type="application/javascript">
$(document).ready(function() {
	var now = new Date() 
	Date.prototype.mmddyyyy = function() {
		var yyyy = this.getFullYear().toString();
		  var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
			var dd  = this.getDate().toString();
			 return (mm[1]?mm:"0"+mm[0])+ "/" + (dd[1]?dd:"0"+dd[0]) + "/" + yyyy; // padding
	};

	d = new Date();
	var fmat = d.mmddyyyy();
	 document.getElementById('systemDateForm').value = fmat;
})
   </script>
</html>
