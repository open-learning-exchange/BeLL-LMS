<?php session_start(); error_reporting(1);include "../secure/talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>


<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:550px; margin-left:auto; margin-right:auto;"><span style="color:#00C; font-weight: bold;">Teacher Resources</span><br><br>
	<table width="105%">
	  <tr>
	    <td height="24"><b>Resource Title</b></td>
	    <td width="65">Option</td>
      </tr>
      <?php
			 $query = mysql_query("SELECT * FROM `resources` where TLR='YES'") or die(mysql_error());
			 $cnt = 0;
			 while($data = mysql_fetch_array($query))
			 {
				 if($cnt%2==0)
				 {
				 echo '<tr>
						<td>'.$data['title'].'</td>
						<td><input type="submit" class="button" value="View" onclick=openRes('.$data['colNum'].')></td>
					  </tr>';
				 }
				 else
				 {
					 echo '<tr bgcolor="#F0F0F0">
						<td>'.$data['title'].'</td>
						<td><input type="submit" class="button" value="View" onclick=openRes('.$data['colNum'].')></td>
					  </tr>';
				 }
				$cnt++;
			 }
      ?>
		</table>
	</div>
<div class="clear"></div>
</div>
</body>
<script type="text/javascript">
function openRes(pNumber)
{
	window.open('viewResource.php?resid='+pNumber);
	///alert('Yes'); 
}
</script>
</html>