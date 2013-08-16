<?php session_start(); error_reporting(1);include "../secure/talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link href="../css/ratingStyle.css" rel="stylesheet" type="text/css">
</head>
<?php
if(isset($_POST['totRes']))
{
	$count=1;
	while($count<$_POST['totRes'])
	{
		$itemString ="R".$count;
		$columnNumb = "Col".$count;
		$feedbacks = new couchClient($couchUrl, "feedback");
		///echo $_POST[$itemString]."<br>";
		$doc = $feedbacks->getDoc($_POST[$columnNumb]);
		$doc->rating = $_POST[$itemString];
		$feedbacks->storeDoc($doc);
		$count++;
	}
	//recordActionDate($_SESSION['name'],"Rate Resources",$_POST['systemDateForm']);
	echo '<script type="text/javascript">alert("Resource ratings completed successfully");</script>';
 
	die("Rating saved. You do not have any unrated resources under your account.");
}
?>

<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:550px; margin-left:auto; margin-right:auto;"><span style="color:#00C; font-weight: bold;">Rate Used Resources</span><br><br>
  <form action="" method="post" enctype="multipart/form-data" >
  <fieldset>
	<table width="105%">
	  <tr>
	    <td width="245" height="4">Resource Title
	      <input type="hidden" name="systemDateForm" id="systemDateForm">
	    </td>
	    <td width="102">Date Used</td>
	    <td width="63">Subject</td>
	    <td width="135">Rating	      </td>
      </tr>
	  
	  
      <?php
	  
	global $couchUrl;
	global $facilityId;
	$feedbacks = new couchClient($couchUrl, "feedback");
	$resources = new couchClient($couchUrl, "resources");
	$viewResults = $feedbacks->include_docs(TRUE)->key($facilityId.$_SESSION['lmsUserID'])->getView('api', 'facilityIdMemberID');
	$docCounter=1;
	foreach($viewResults->rows as $row) {
		$doc = $resources->getDoc($row->doc->resourceId);
		if($row->doc->rating<1){
		echo '<tr>
	    <td width="256" height="11"  valign="top">'.$doc->title.'</td>
	    <td width="75"  valign="top">'.date('Y-m-d',$row->doc->timestamp).'</td>
	    <td width="73"  valign="top">'.$row->doc->context->subject.'</td>
	    <td width="140"  valign="bottom">
		<b><input type="radio" name="R'.$docCounter.'" id="R'.$docCounter.'_1" value="1" checked onclick="resetMe(\'1\',\'R'.$docCounter.'_\')"><label for="R'.$docCounter.'_1"></label></b>
		<b><input type="radio" name="R'.$docCounter.'" id="R'.$docCounter.'_2" value="2" onclick="resetMe(\'2\',\'R'.$docCounter.'_\')"><label for="R'.$docCounter.'_2"></label></b>
		<b><input type="radio" name="R'.$docCounter.'" id="R'.$docCounter.'_3" value="3" onclick="resetMe(\'3\',\'R'.$docCounter.'_\')"><label for="R'.$docCounter.'_3"></label></b>
		<b><input type="radio" name="R'.$docCounter.'" id="R'.$docCounter.'_4" value="4" onclick="resetMe(\'4\',\'R'.$docCounter.'_\')"><label for="R'.$docCounter.'_4"></label></b>
		<b><input type="radio" name="R'.$docCounter.'" id="R'.$docCounter.'_5" value="5" onclick="resetMe(\'5\',\'R'.$docCounter.'_\')"><label for="R'.$docCounter.'_5"></label></b>
		<input name="Col'.$docCounter.'" type="hidden" value="'.$row->doc->_id.'">
				</td>
			  </tr>';
			  $docCounter++;
		}
	}
      ?>
      <tr>
	    <td width="245" height="5">&nbsp;</td>
	    <td width="102">&nbsp;</td>
	    <td width="63">&nbsp;</td>
	    <td><input name="totRes" type="hidden" value="<?php echo ($docCounter)?>">
        <?php 
		if($docCounter>1)
		{
			echo '<input type="submit" class="button" value="Save Rating">'; 
		}
		else
		{
			echo "You do not have any unrated resources under your account.";
		}
		?></td>
      </tr>
		</table>
      </fieldset>
        </form>
  </div>
<div class="clear"></div>
</div>
</body>
<script type="text/javascript">
	var now = new Date()
	///now = now.toGMTString();
	var fmat= now.getFullYear()+'-'+ (now.getMonth()+1)+'-'+(now.getDay()+10)+' '+(now.getHours())+':'+(now.getMinutes())+':'+(now.getSeconds());
	document.getElementById('systemDateForm').value = fmat;
</script>
<script type="text/javascript">
/*document.getElementById("").style = "b:not(#foo) > input[type=checkbox]:active:checked + label,b:not(#foo) > input[type=checkbox]:checked + label:hover:active{ background-position: 0 -121px; }";*/
function resetMe(val, val2){
	//var count =1;
//	while(count<val)
//	{
//		var holdID = val2;
//		///alert(holdID+count);
//		document.getElementById(holdID+count).style.backgroundPosition = "100% -121px;";
//		count++;
//	}
//	
//	document.getElementById("R2_3").style.backgroundPosition = "67";
//	//alert(val2);
}

	
</script>
 </html>