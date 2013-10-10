<?php session_start(); error_reporting(1);include "secure/talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="js/jquery.js"></script>
</head>


<body  style="background-color:#FFF">
<div id="wrapper" style="background-color: #FFF; width: 600px;">
  <div id="rightContent" style="float: none; margin-left: auto; margin-right: auto; width: 550px; margin-left: auto; margin-right: auto; font-size: 14px;"><span style="color:#00C; font-weight: bold;">All Updates from OLE</span><br>
    <br>
    <form action="" method="post">
    <fieldset>
    <legend><br>
    </legend>
    </fieldset>
    </form>
      <p id="results"></p>
  </div><span style="color: #900; font-weight:bold; font-style:italic"></span>  
<div class="clear"></div>
</div>
</body>
<script type="text/javascript">
function openRes(pNumber)
{
	var now = new Date()
	///now = now.toGMTString();
	var fmat= now.getFullYear()+'-'+ (now.getMonth()+1)+'-'+(now.getDay()+10)+' '+(now.getHours())+':'+(now.getMinutes())+':'+(now.getSeconds());
	window.open('viewResource.php?resid='+pNumber+'&systDate='+fmat);
	///alert('Yes'); 
}
</script>

<script type="text/javascript">

function requestLoadLanguage(){
	var lang = document.getElementById("Language").value;
	var subject =  document.getElementById("subject").value;
	var level = $('input:radio[name=rdLevel]:checked').val();
	$("#results").load("functions/getResByLangLevel.php?sLanguage="+lang+"&sLevel="+level+"&sSubject="+subject);
}
</script>
</html>