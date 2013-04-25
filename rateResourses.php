<?php session_start(); error_reporting(1);include "talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="css/style.css">
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
	<table width="105%">
	  <tr>
	    <td width="256" height="4"><b>Resource Title
	      <input type="hidden" name="systemDateForm" id="systemDateForm">
	    </b></td>
	    <td width="75">Date Used</td>
	    <td width="50">Subject</td>
	    <td width="166">Rating	      </td>
      </tr>
	  
	  
      <?php
	$cnt = 0;
	$query = mysql_query("SELECT * FROM  `usedResources` where usedby='".$_SESSION['name']."' and rating = 0") or die(mysql_error());
			 
			 while($data = mysql_fetch_array($query))
			 {
				 echo '<tr>
	    <td width="256" height="11"  valign="top">'.$data['title'].'</td>
	    <td width="75"  valign="top">'.$data['dateUsed'].'</td>
	    <td width="73"  valign="top">'.$data['subject'].'</td>
	    <td width="140"  valign="bottom">
1<input type="radio" name="R'.$cnt.'" value="1" checked>
2<input type="radio" name="R'.$cnt.'" value="2">
3<input type="radio" name="R'.$cnt.'" value="3">
4<input type="radio" name="R'.$cnt.'" value="4">
5<input name="R'.$cnt.'" type="radio" value="5">
<input name="Col'.$cnt.'" type="hidden" value="'.$data['colNum'].'">

		
		</td>
      </tr>';
				$cnt++;
			 }
      ?>
      <tr>
	    <td width="256" height="5">&nbsp;</td>
	    <td width="75">&nbsp;</td>
	    <td width="50">&nbsp;</td>
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
		</table></form>
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
</html>