<?php session_start(); error_reporting(1);?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
</head>
<?php
$SaveClass = "";
if(isset($_POST['dateexecTast']))
{
	if($SaveClass=="KG")
	{
		$SaveClass = "student/Ex_KG";
	}
	else if($SaveClass=="P1")
	{
		$SaveClass = "student/Ex_P1";
	} 
	if($SaveClass=="P2")
	{
		$SaveClass = "student/Ex_P2";
	}
	else if($SaveClass=="P3")
	{
		$SaveClass = "student/Ex_KG";
	} 
	foreach($_POST['checklist'] as $check) {
            echo $check; 
    } 
	if($SaveClass=="KG")
	{
		$SaveClass = "student/Ex_KG";
	}
	else if($SaveClass=="KG")
	{
		$SaveClass = "student/Ex_P3";
	}  
	if($SaveClass=="P4")
	{
		$SaveClass = "student/Ex_P4";
	}
	else if($SaveClass=="P5")
	{
		$SaveClass = "student/Ex_P5";
	} 
	else if($SaveClass=="P6")
	{
		$SaveClass = "student/Ex_P6";
	} 
	
	foreach($_POST['checklist'] as $check) {
            echo $check; 
    }
}
?>

<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:550px; margin-left:auto; margin-right:auto;">
    <form name="form1" method="post" action="">
      <table width="101%">
        <tr>
          <td width="147"><b>Resourse Title</b></td>
          <td width="262"><b>Resourse Discription</b></td>
          <td width="54" align="center"><b>Select</b></td>
          <td width="62" align="center"><b>Optional</b></td>
        </tr>
        
        <?php
		$document = new DOMDocument(); 
		$document->load('Resources/resources.xml'); 
		$sites = $document->getElementsByTagName("resource"); 
		$i=1; 
		foreach( $sites as $site ) 
		{ 
			if($i%2==0)
			{
				$theTtle = $site->getElementsByTagName("title");
				$theDescrip = $site->getElementsByTagName("description");
				$theType = $site->getElementsByTagName("type");
				$theResc = $site->getElementsByTagName("Rec_id");
				echo '<tr>
			   <td>'.$theTtle->item(0)->nodeValue.'</td>
			  <td>'.$theDescrip->item(0)->nodeValue.'</td>
			  <td align="center"><input type="checkbox" name="checklist[]" value="'.$theResc->item(0)->nodeValue.'"></td>
			  <td align="center"><input type="button" class="button" value="View" onclick="ViewResource(\''.$theResc->item(0)->nodeValue.'.'.$theType->item(0)->nodeValue.'\')"></td>
			</tr>';
			}
			else
			{
				$theTtle = $site->getElementsByTagName("title");
				$theDescrip = $site->getElementsByTagName("description");
				$theType = $site->getElementsByTagName("type");
				$theResc = $site->getElementsByTagName("Rec_id");
				echo '<tr bgcolor="#EBEBEB">
			  <td>'.$theTtle->item(0)->nodeValue.'</td>
			  <td>'.$theDescrip->item(0)->nodeValue.'</td>
			  <td align="center"><input type="checkbox" name="checklist[]" value="'.$theResc->item(0)->nodeValue.'"></td>
			  <td align="center"><input type="button" class="button" value="View" onclick="ViewResource(\''.$theResc->item(0)->nodeValue.'.'.$theType->item(0)->nodeValue.'\')"></td>
			</tr>';
			}
			$i++;
		}
        ?>
        <tr>
          <td><b>Corresponding Lesson Plan ID</b></td>
          <td><select name="select">
            <option selected>-- pilihan --</option>
            <option value="">Pilihan</option>
          </select></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><b>Date of Execution</b></td>
          <td><span id="sprytextfield1">
            <input type="text" name="dateexecTast" id="dateexecTast" style="width:100px;">
          <span class="textfieldRequiredMsg">A value is required.</span></span>eg. 22/08/2012</td>
          <td>Task ID</td>
          <td><input name="textfield" type="text" id="textfield" style="width:40px;" value="<?php echo rand(0,999);?>" readonly></td>
        </tr>
        <tr>
          <td></td>
          <td colspan="3"><input type="submit" class="button" value="Update Task">
            <input type="reset" class="button" value="Reset"></td>
        </tr>
      </table>
    </form>
  </div>
<div class="clear"></div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
<script type="text/javascript">
function ViewResource(url)
{
	var Foldlink ="Resources/";
	window.open(Foldlink+url);
}
</script>
</body>
</html>