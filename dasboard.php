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
        <li><a href="leadteacher.php">Lead T.</a></li>
	</ul>';
}
else
{
	$mystring = "index.php";
	die('<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$mystring.'">');
}
?>
<script type='text/javascript'>
var now = new Date() 
var fmat= now.getFullYear()+'-'+ (now.getMonth()+1)+'-'+(now.getDay()+10)+' '+(now.getHours())+':'+(now.getMinutes())+':'+(now.getSeconds());
</script>
<body>
<div id="header">
	<div class="inHeader">
		<div class="mosAdmin">Hello,  <?php echo $_SESSION['name'];?><br>
	    | <a href="index.php" onClick="location.href=this.href+'?systemDateForm='+fmat;return false;" >Sign Out </a>| <a href="#">Help</a> </div>
	  <div class="clear"></div>
	</div>
</div>

<div id="wrapper" style="background: #fff url(images/bg_kiri.png) repeat-y;">
	<div id="leftBar">
	<?php echo $menu;?>
	</div>
	<div id="rightContent">
	<h3>Teacher</h3>
	<div class="shortcutHome"></div>
    <div class="shortcutHome"> <a href="pages/registerStudent.php"  target="DashScreen"><img src="images/students.png" alt="" width="52" height="52"><br>
      Register New Student
      </a> </div>
	<div class="shortcutHome">
	  <a href="pages/Stories4week.php" target="DashScreen"><img src="images/creatTask.png" width="52" height="52"><br>
		 Story for Next Week</a>
      </div>
      <div class="shortcutHome">
	  <!--<a href="pages/Stories4week.php" target="DashScreen"><img src="images/photo.png"><br>
		Assign Task (V-Book ect)</a>-->
        <a href="pages/assign_task.php" target="DashScreen"><img src="images/photo.png" width="52" height="52"><br>
		Assign Task (V-Book ect)</a>
      </div>
      
         <div class="shortcutHome">
         <a href="pages/Teacher_resource.php" target="DashScreen"><img src="images/teacher.png" alt="" width="52" height="52"><br>
Teacher Resources</a>
		 </div>
		<div class="shortcutHome">
		<a href="pages/lessonPlan.php" target="DashScreen"><img src="images/assignTask.png" width="52" height="52"><br>
		New Lesson Plan</a>
		</div>
        <div class="shortcutHome">
		<a href="pages/edit_lessonPlan.php" target="DashScreen"><img src="images/editLesson_plane.png" width="52" height="52"><br>
		Edit Lesson Plan</a>
	  </div>
       <div class="shortcutHome">
		<a href="pages/rateResourses.php" target="DashScreen"><img src="images/editPlane.jpg" width="52" height="52"><br>
		Rate Used Resources</a>
	  </div>
      <div class="shortcutHome"> <a href="pages/all_resources.php"  target="DashScreen"><img src="images/listRes.png" alt="" width="52" height="52"><br>
      Available Resources
      </a> </div>
		
		<div class="clear"></div>
		
		<div id="smallRight">
		  <table align="center" style="border: none;font-size: 12px;color: #5b5b5b;width: 100%;margin: 10px 0 10px 0;">
			<tr><td colspan="2" style="border: none;padding: 4px;"><iframe height="570" frameborder="0" width="640" src="pages/registerStudent.php" name="DashScreen"></iframe>&nbsp;</td></tr>
		  </table>
		</div>
	</div>
<div class="clear"></div>
<div id="footer">
	&copy; 2012 Open Learning Exchange - Ghana <br>
</div>
</div>
</body>
</html>