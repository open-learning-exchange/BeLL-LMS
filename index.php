<?php ini_set("session.gc_maxlifetime","94000"); session_start(); error_reporting(0);include "secure/talk2db.php";?>
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
	global $couchUrl;
	$members = new couchClient($couchUrl, "members");
	// Get member
	global $facilityId;
	$key = $facilityId . $_POST['loginid'];
	
	///print $key;
	$viewResults = $members->include_docs(TRUE)->key($key)->getView('api', 'facilityLogin');
	///print_r($viewResults);
	foreach($viewResults->rows as $row) {
		///print_r($row);
		
	}
	$member = $viewResults->rows[0]->doc;
	//echo $member->pass;
	if($member->pass == $_POST['pass']) {
		$_SESSION['lmsUserID'] = $viewResults->rows[0]->id;
		$_SESSION['role'] = $member->role;
		$_SESSION['name'] = $member->firstName." ".$member->middleNames." ".$member->lastName;
		$_SESSION['facilityID'] = $facilityId;
		///echo $_SESSION['facilityID'];
		// Redirect user to dashboard page
		recordActionDate($_SESSION['lmsUserID'],"Loged in",$_POST['systemDateForm']);
		die('<META HTTP-EQUIV=Refresh CONTENT="0; URL= dasboard.php">');
	} else{
		$messageLog = "Login ID & Password Mismatch. Try again ";
	}
} 
else {
	
	if(isset($_GET['sesEnded']))
	{
		recordActionDate($_SESSION['lmsUserID'],"Session Timed-out",$_GET['systemDateForm']);
		$messageLog = "Login Session Timed-out. Please login again";
	}
	else if(isset($_GET['signout']))
	{
		recordActionDate($_SESSION['lmsUserID'],"Loged out",$_GET['systemDateForm']);
		$messageLog = "Welcome Please login";
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
	</div>
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
<script type="text/javascript">
	var now = new Date()
	///now = now.toGMTString();
	var fmat= now.getFullYear()+'-'+ (now.getMonth()+1)+'-'+(now.getDay()+10)+' '+(now.getHours())+':'+(now.getMinutes())+':'+(now.getSeconds());
	document.getElementById('systemDateForm').value = fmat;
</script>
</html>