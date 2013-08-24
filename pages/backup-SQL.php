<?php session_start(); error_reporting(1);include "../secure/talk2db.php";?>
<link rel="stylesheet" type="text/css" href="../css/style.css">
<title>OLE Ghana</title>
<?

/* backup the db OR just a table */
function backup_tables($host,$user,$pass,$name,$tables = '*')
{
  
  $link = mysql_connect($host,$user,$pass);
  mysql_select_db($name,$link);
  
  //get all of the tables
  if($tables == '*')
  {
    $tables = array();
    $result = mysql_query('SHOW TABLES');
    while($row = mysql_fetch_row($result))
    {
      $tables[] = $row[0];
    }
  }
  else
  {
    $tables = is_array($tables) ? $tables : explode(',',$tables);
  }
  
  //cycle through
  foreach($tables as $table)
  {
    $result = mysql_query('SELECT * FROM '.$table);
    $num_fields = mysql_num_fields($result);
    
    $return.= 'DROP TABLE '.$table.';';
    $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
    $return.= "\n\n".$row2[1].";\n\n";
    
    for ($i = 0; $i < $num_fields; $i++) 
    {
      while($row = mysql_fetch_row($result))
      {
        $return.= 'INSERT INTO '.$table.' VALUES(';
        for($j=0; $j<$num_fields; $j++) 
        {
          $row[$j] = addslashes($row[$j]);
          $row[$j] = ereg_replace("\n","\\n",$row[$j]);
          if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
          if ($j<($num_fields-1)) { $return.= ','; }
        }
        $return.= ");\n";
      }
    }
    $return.="\n\n\n";
  }
  $query = mysql_query("SELECT schoolName FROM `schoolDetails`") or die(mysql_error());
  $schoolName="-";
  while($data = mysql_fetch_array($query))
  {
	$schoolName=$data['schoolName'];
  }
  //save file
 
  ////
  $date = new DateTime();
  ////$justName = $schoolName.'-'.$date->format('Y-m-d H-i-s').'.zip';
  /////$_GET['dat']
  $justName = $schoolName.'-'.$_GET['dat'].'.zip';
  $fullFileName = 'backup/'.$justName;
  $handle = fopen($fullFileName,'w+');
  fwrite($handle,$return);
  fclose($handle);
  
  
  set_time_limit(0); // for slow connections
 
	// validate the request, fetch info from database etc
	 echo $justName;
	$fileName = $justName; // retrieved from a database
	$targetFile = $fullFileName; // absolute path
	 
	if ( ! file_exists($targetFile) ) {
		// output a nice error page
		exit;
	}
	 
	$file = $justName;
	 
	header('Content-type: audio/mpeg3');
    header('Content-Disposition: attachment; filename="'.$file.'"');
    readfile($fullFileName,true);
	 
	////readfile($targetFile,true); // send file to client
}
die("Please go sync with Sync Pi");
backup_tables('localhost','schoolbell','oleole','schoolbell');

?>

<!--<form action="force_download.php" method="post" name="downloadform">
  <input name="file_name" value="track1.mp3" type="hidden">
  <input type="submit" value="Download the MP3">
</form>-->
<!--echo "<script type='text/javascript'>function DoOpen(){window.open('".$fullFileName."');}</script>";-->

