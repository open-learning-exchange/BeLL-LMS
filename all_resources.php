<?php session_start(); error_reporting(1);include "talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>


<body  style="background-color:#FFF">
<div id="wrapper" style="background-color: #FFF; width: 600px;">
  <div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:550px; margin-left:auto; margin-right:auto;"><span style="color:#00C; font-weight: bold;">All Available Student Resources</span><br><br>
	<table width="105%">
	  <tr>
	    <td width="275" height="24"><b>Resource Title</b></td>
	    <td width="203"><b>Can Be Used For</b></td>
	    <td width="73">Option</td>
      </tr>
      <?php
	  $image="";
	  $button="";
	$query = mysql_query("SELECT * FROM `resources` where TLR='' order by KG,P1,P2,P3,P4,P5,P6") or die(mysql_error());
			 $cnt = 1;
			 while($data = mysql_fetch_array($query))
			 {
				 $forClass ="";
				 if($data['KG']=="YES"){$forClass=$forClass."KG: ";}
				 if($data['P1']=="YES"){$forClass=$forClass."P1: ";}
				 if($data['P2']=="YES"){$forClass=$forClass."P2: ";}
				 if($data['P3']=="YES"){$forClass=$forClass."P3: ";}
				 if($data['P4']=="YES"){$forClass=$forClass."P4: ";}
				 if($data['P5']=="YES"){$forClass=$forClass."P5: ";}
				 if($data['P5']=="YES"){$forClass=$forClass."P6: ";}
				 if($data['type']=='mp3')
				 {
					 $image='<img src="images/audio.png" width="15" height="15">';
					 $button="Listen";
				 }else if($data['type']=='pdf')
				 {
					 $image='<img src="images/pdf.png" width="18" height="18">';
					 $button="Read";
				 }
				 else if($data['type']=='mp4'||$data['type']=='avi'||$data['type']=='flv')
				 {
					 $image='<img src="images/video.png" width="18" height="18">';
					 $button="Watch";
				 }
				 if($cnt%2==0)
				 {
				 echo '<tr>
					<td>'.$cnt.': <span style="color: #900;font-weight:bold;">'.$data['title'].'</span><br>
					<span style="font-style:italic">'.$data['description'].'</span>
					</td>
					<td width="203"><span style="color: #900;font-weight:bold;">'.$forClass.'</span></td>
				<td><input type="submit" class="button" value="'.$button.'" onclick=openRes('.$data['colNum'].')>'.$image.'</td>
					  </tr>';
				 }
				 else
				 {
					 echo '<tr bgcolor="#F0F0F0">
						<td>'.$cnt.': <span style="color: #900;font-weight:bold;">'.$data['title'].'</span><br>
					<span style="font-style:italic">'.$data['description'].'</span>
					</td>
					<td width="203"><span style="color: #900;font-weight:bold;">'.$forClass.'</span></td>
				<td><input type="submit" class="button" value="'.$button.'" onclick=openRes('.$data['colNum'].')>'.$image.'</td>
					  </tr>';
				 }
				$cnt++;
			 }
      ?>
		</table>
	</div><span style="color: #900; font-weight:bold; font-style:italic"></span>  
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