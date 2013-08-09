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
	$count=0;
	while($count<$_POST['totRes'])
	{
		$itemString ="R".$count;
		$columnNumb = "Col".$count;
		///echo "UPDATE `usedResources` SET  `rating` = '".$_POST[$itemString]."' WHERE `colNum` = ".$_POST[$columnNumb]."";
		$save = mysql_query("UPDATE `usedResources` SET  `rating` = '".$_POST[$itemString]."' WHERE `colNum` = ".$_POST[$columnNumb]."") or die(mysql_error());
		$count++;
	}
	recordActionDate($_SESSION['name'],"Rate Resources",$_POST['systemDateForm']);
	echo '<script type="text/javascript">alert("Resources ratings done successfully");</script>';
 
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
	$cnt = 1;
	$query = mysql_query("SELECT * FROM  `usedResources` where usedby='".$_SESSION['name']."' and rating = 0") or die(mysql_error());
			 
			 while($data = mysql_fetch_array($query))
			 {
				 echo '<tr>
	    <td width="256" height="11"  valign="top">'.$data['title'].'</td>
	    <td width="75"  valign="top">'.$data['dateUsed'].'</td>
	    <td width="73"  valign="top">'.$data['subject'].'</td>
	    <td width="140"  valign="bottom">
<b><input type="radio" name="R'.$cnt.'" id="R'.$cnt.'_1" value="1" checked onclick="resetMe(\'1\',\'R'.$cnt.'_\')"><label for="R'.$cnt.'_1"></label></b>
<b><input type="radio" name="R'.$cnt.'" id="R'.$cnt.'_2" value="2" onclick="resetMe(\'2\',\'R'.$cnt.'_\')"><label for="R'.$cnt.'_2"></label></b>
<b><input type="radio" name="R'.$cnt.'" id="R'.$cnt.'_3" value="3" onclick="resetMe(\'3\',\'R'.$cnt.'_\')"><label for="R'.$cnt.'_3"></label></b>
<b><input type="radio" name="R'.$cnt.'" id="R'.$cnt.'_4" value="4" onclick="resetMe(\'4\',\'R'.$cnt.'_\')"><label for="R'.$cnt.'_4"></label></b>
<b><input type="radio" name="R'.$cnt.'" id="R'.$cnt.'_5" value="5" onclick="resetMe(\'5\',\'R'.$cnt.'_\')"><label for="R'.$cnt.'_5"></label></b>
<input name="Col'.$cnt.'" type="hidden" value="'.$data['colNum'].'">

		
		</td>
      </tr>';
				$cnt++;
			 }
      ?>
      <tr>
	    <td width="245" height="5">&nbsp;</td>
	    <td width="102">&nbsp;</td>
	    <td width="63">&nbsp;</td>
	    <td><input name="totRes" type="hidden" value="<?php echo $cnt?>">
        <?php 
		if($cnt>=1)
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