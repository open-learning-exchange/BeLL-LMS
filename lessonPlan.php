<?php 



include("bootstrap.php");



//
// App
// 

// If we are going to edit a LessonPlan, load the lesson plan
if($_GET['_id']) {
  $lessonPlan = model__LessonPlan($_GET['_id']);  
}
else {
  $lessonPlan = model__LessonPlan();
}


//
// Form submit handler
//

// The default new _id for LessonPlan model is _new, so that's how we know we have a 
// new couch doc to save.
if ($_POST['_id'] == "_new") {

  // The saved doc needs to be an object, not an array
  $doc = (object) $_POST;
  // _id and _rev need to not exist for storeDoc() to not fail
  unset($doc->_id);
  unset($doc->_rev);
  // Save the new doc
  $response = $db->bell_lcms->storeDoc($doc);

} 
else if ($_POST['_id'] != "_new") {
  $doc = (object) $_POST;
  $response = $db->bell_lcms->storeDoc($doc);
}

// Queue resources for sync
if($_POST['_id']) {
  tabletSync_queueResource($_POST['bellRes1']);
  tabletSync_queueResource($_POST['bellRes2']);
  tabletSync_queueResource($_POST['bellRes3']);
  tabletSync_queueResource($_POST['bellRes4']);
  tabletSync_queueResource($_POST['bellRes5']);
  tabletSync_queueResource($_POST['bellRes6']);

  // REDIRECT
  header("Location: http://raspberrypi.local/lessonPlan.php?_id=" . $response->id);
}



//
// Scaffolding
//

?>

<html>
<head>

<script type='text/javascript' src='app/vendor/js/jquery/jquery.js'></script>
<script type='text/javascript' src='app/assets/js/bell.util.js'></script>

<?php
if($_SESSION['name']== null){
	$mystring = "index.php?sesEnded=true&systemDateForm='+fmat";
	die('<script type="text/javascript">window.parent.location.href= "'.$mystring.'";</script>');
}
?>

<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"dateExec",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>

</head>


<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:600px; margin-left:auto; margin-right:auto;">&nbsp;&nbsp;&nbsp;<span style="color:#00C; font-weight: bold;">Prepare Lesson Plan</span><br><br>

    <?php print view__LessonPlanEdit($lessonPlan); ?>
   
  </div>
<div class="clear"></div>
</div>
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2");
var sprytextarea3 = new Spry.Widget.ValidationTextarea("sprytextarea3");
var sprytextarea4 = new Spry.Widget.ValidationTextarea("sprytextarea4");
var sprytextarea5 = new Spry.Widget.ValidationTextarea("sprytextarea5");
var sprytextarea6 = new Spry.Widget.ValidationTextarea("sprytextarea6");
var sprytextarea7 = new Spry.Widget.ValidationTextarea("sprytextarea7");
var sprytextarea8 = new Spry.Widget.ValidationTextarea("sprytextarea8");
var sprytextarea9 = new Spry.Widget.ValidationTextarea("sprytextarea9");
var sprytextarea10 = new Spry.Widget.ValidationTextarea("sprytextarea10");
var sprytextarea11 = new Spry.Widget.ValidationTextarea("sprytextarea11");
var sprytextarea12 = new Spry.Widget.ValidationTextarea("sprytextarea12");
var sprytextarea13 = new Spry.Widget.ValidationTextarea("sprytextarea13");
var sprytextarea14 = new Spry.Widget.ValidationTextarea("sprytextarea14", {isRequired:false});
</script>
</body>

<script type="text/javascript">
        var now = new Date() 
        var fmat= now.getFullYear()+'-'+ (now.getMonth()+1)+'-'+(now.getDay()+10)+' '+(now.getHours())+':'+(now.getMinutes())+':'+(now.getSeconds());
	var now = new Date()
	///now = now.toGMTString();
	var fmat= now.getFullYear()+'-'+ (now.getMonth()+1)+'-'+(now.getDay()+10)+' '+(now.getHours())+':'+(now.getMinutes())+':'+(now.getSeconds());
	document.getElementById('systemDateForm').value = fmat;
</script>

</html>
