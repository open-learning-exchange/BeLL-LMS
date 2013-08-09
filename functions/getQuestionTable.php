<?php session_start();include "../secure/talk2db.php";?>
<table width="427" border="0" cellpadding="2" cellspacing="2"  style="color:#FFF;">
  <tr>
    <td width="31" bgcolor="#3366FF">Add</td>
    <td width="294" bgcolor="#3366FF">Question</td>
    <td width="82" bgcolor="#3366FF">Answer</td>
  </tr>
  <?php
   $query = mysql_query("SELECT * FROM `VBQuestion` where `resrcID`= '".$_GET['id']."'") or die(mysql_error());
   $Quencnt=1;
   while($data = mysql_fetch_array($query))
   {
	  echo '<tr>
    <td bgcolor="#3366FF"><span class="clear" style="font-size: 14px; color: #00C; text-align:center;">
      <input name="vbQ[]" type="checkbox" id="vbQ'.$Quencnt.'" value="'.$data['ColNum'].'">
    </span></td>
    <td bgcolor="#3366FF">'.$data['question'].'</td>
    <td bgcolor="#3366FF">'.$data['answer'].'</td>
  </tr>';
  $Quencnt++;
	   
   }
?>
</table>
