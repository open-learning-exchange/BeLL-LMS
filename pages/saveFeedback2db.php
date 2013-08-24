<?php session_start(); include "../secure/talk2db.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Open Learning Exchange - Ghana</title>
</head>
<?php
$feedStatus ="Feedback already saved. Please ensure syncing of tablets are completed before 'Saving Feedback' ";
$counter=0;
if ($handle = opendir('../feedbacks/')) {
    while (false !== ($Fileentry = readdir($handle))) {
        if ($Fileentry != "." && $Fileentry != "..") {
		/// WRITE feedback tags into xml files to make it a valid file for reading ///////
			$fullpath ="../feedbacks/$Fileentry";
			////////////////////////////////////////
			////////////////////////////////////////
			$file = $fullpath;
			
			// set up basic connection
			$conn_id = ftp_connect("192.168.0.111") or die("Server error. Cant locate server");
			
			// login with username and password
			$login_result = ftp_login($conn_id,"pi","oleole") or die("Login error");
			
			// try to chmod $file to 644
			if (ftp_chmod($conn_id, 0777, $file) !== false) {
			 //////////////////echo "$file chmoded successfully to 777\n";
			} else {
			 ////////////////echo "could not chmod $file\n";
			}
			
			// close the connection
			ftp_close($conn_id);

			////////////////////////////////////////
			////////////////////////////////////////
			
			$old_lines = file($fullpath);
			$new_content = join('',$old_lines);
			$new_content="<feedback>\n".$new_content."\n</feedback>";
			///echo $fullpath;
			///echo $new_content;
			$fp = fopen($fullpath,'w');
	 		$write = fwrite($fp, $new_content);
 	 		fclose($fp);
			//////////// Read feedback into database ///////
			$feed = file_get_contents("../feedbacks/$Fileentry");
			$xml = new SimpleXmlElement($feed);
			///echo "Starting";
			
			foreach ($xml->usage as $entry){
			$instertQuery = mysql_query("INSERT INTO `feedback` (`colNum`, `fbdate`, `fbresourceTitle`, `fbresourceID`, `fbstudentID`, `fbstudentName`, `fbstudentClass`) VALUES (NULL, '".$entry->fbdate."', '".$entry->fbresourceTitle."', '".$entry->fbresourceID."', '".$entry->fbstudentID."', '".$entry->fbstudentName."', '".$entry->fbstudentClass."')") or die(mysql_error());
			
			$feedStatus ="Saving tablet feedback successfully completed.. ";
		}
		$counter++;
		echo $counter.". Feedback saved for : ".preg_replace('/\.[^.]*$/', '', $Fileentry )."<br />";
		
     }
    }
    closedir($handle);
	recordActionObject($_SESSION['lmsUserID'],"Saved tablet usage feedback into db","");
} else
{
	 echo "System folder acces error";
}

			  //echo $entry->fbdate;
//			  echo $entry->fbresourceTitle;
//			  echo $entry->fbresourceID;
//			  echo $entry->fbstudentID;
//			  echo $entry->fbstudentName;
//			  echo $entry->fbstudentClass;
//<usage>
//<fbdate>02-20-1988</fbdate>
//<fbresourceTitle>Ananse and Me</fbresourceTitle>
//<fbresourceID>7238</fbresourceID>
//<fbstudentID>889929</fbstudentID>
//<fbstudentName>Leonad Mensah</fbstudentName>
//<fbstudentClass>P1</fbstudentClass>
//<usage>
?>

<body>
<?php echo $feedStatus;?>
</body>
</html>