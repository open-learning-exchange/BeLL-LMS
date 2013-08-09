<?php session_start(); error_reporting(1);?>
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
<?php
if($_SESSION['role']=="Admin")
{
	$menu= '<ul>
		<li><a href="dasboard.php">Teacher</a></li>
		<li><a href="coach.php">Coach</a></li>
        <li><a href="headteacher.php">Head</a></li>
		<li><a href="leadteacher.php">Lead T.</a></li>
	</ul>';
} else if ($_SESSION['role']=="Teacher")
{
	$menu= '<ul>
		<li><a href="dasboard.php">Teacher</a></li>
	</ul>';
} else if ($_SESSION['role']=="Coach")
{
	$menu=  '<ul>
        <li><a href="coach.php">Coach</a></li>
	</ul>';
}else if ($_SESSION['role']=="Head")
{
	$menu=  '<ul>
        <li><a href="headteacher.php">Head</a></li>
	</ul>';
}
else if ($_SESSION['role']=="Lead")
{
	$menu=  '<ul>
        <li><a href="leadteacher.php">Lead T./a></li>
	</ul>';
}
else
{
	$mystring = "index.php";
	die('<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$mystring.'">');
}
?>
<body>
<div id="header">
	<div class="inHeader">
	  <div class="mosAdmin">Hello,  <?php echo $_SESSION['name'];?><br>
	    | <a href="index.php">Sign Out</a> | <a href="index.php">Help</a> </div>
	  <div class="clear"></div>
	</div>
</div>

<div id="wrapper" style="background: #fff url(images/bg_kiri.png) repeat-y;">
  <div id="leftBar">
    <?php echo $menu;?>
  </div>
  <div id="rightContent">
    <h3>Coach</h3>
    <div class="shortcutHome"></div>
    <div class="shortcutHome"> <a href="pages/uploadRes.php" target="DashScreen"><img src="images/upload.png" alt=""><br>
      Upload Resources</a> </div>
    <div class="shortcutHome"> <a href="pages/view_LPlan.php"  target="DashScreen"><img src="images/assignTask.png" alt=""><br>
      Lesson Plan</a></div>
      <div class="shortcutHome"> <a href="pages/view_feedback.php"  target="DashScreen"><img src="images/feedback.png" alt=""><br>
      View Feedback
    </a> </div>
      <div class="shortcutHome"> <a href="pages/studentsList.php"  target="DashScreen"><img src="images/students.png" alt=""><br>View all Students</a> </div>
      <div class="shortcutHome"> <a href="pages/all_resources.php"  target="DashScreen"><img src="images/listRes.png" alt=""><br>
      Available Resources
      </a> </div>
      <div class="shortcutHome">
         <a href="pages/Teacher_resource.php" target="DashScreen"><img src="images/teacher.png" alt=""><br>
Teacher Resources</a>
		 </div>
    <div class="clear"></div>
    <div id="smallRight">
      <table align="center" style="border: none;font-size: 12px;color: #5b5b5b;width: 100%;margin: 10px 0 10px 0;">
        <tr>
          <td colspan="2" style="border: none;padding: 4px;"><iframe height="570" frameborder="0" width="640" src="pages/uploadRes.php" name="DashScreen"></iframe>
            &nbsp;</td>
        </tr>
      </table>
    </div>
  </div>
  <div class="clear"></div>
<div id="footer">&copy; 2012 Open Learning Exchange - Ghana </div>
</div>
</body>
</html>