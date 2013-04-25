<?php
//if(isset($_POST['RTitle']))
//{
//	$location = "Resources";
//
//   if (is_uploaded_file($_FILES['upLfile']['tmp_name'])) {
//
//      	$name = $_FILES["upLfile"]["name"];
//		$ext = end(explode(".", $name));
//         $name = $_POST['Rid'];
//         $result = move_uploaded_file($_FILES['upLfile']['tmp_name'], $location."/$name.$ext");
//         if ($result == 1) 
//		 {
//			 $target = "";
//			 if(isset($_POST['KG']))
//			 {$target=$target."KG ";}
//			 if(isset($_POST['P1']))
//			 {$target=$target."P1 ";}
//			 if(isset($_POST['P2']))
//			 {$target=$target."P2 ";}
//			 if(isset($_POST['P3']))
//			 {$target=$target."P3 ";}
//			 if(isset($_POST['P4']))
//			 {$target=$target."P4 ";}
//			 if(isset($_POST['P5']))
//			 {$target=$target."P5 ";}
//			 if(isset($_POST['P6']))
//			 {$target=$target."P6 ";}
//$xmldata =  '  <resource>
//	  <title>'.$_POST['RTitle'].'</title>
//	  <subject>'.$_POST['Rsubject'].'</subject>
//	  <target>'.$target.'</target>
//	  <type>'.$ext.'</type>
//	  <description>'.$_POST['Rdiscription'].'</description>
//	  <Rec_id>'.$_POST['Rid'].'</Rec_id>
//  </resource>
//</root>';
//	  				$xmlUrl ="Resources/resources.xml";
//					$xmlFile = fopen($xmlUrl, 'r+');
//					
//				 
//				 ///////////////////////////////
//				 while(1)
//				 {
//					//read line
//					$line = fgets($xmlFile);
//					//if end of file reached then stop reading anymore
//					if($line == null)break;
//					//replace student gpa with new updated gpa
//					if(preg_match("</root>", $line))
//					{
//						///echo "Found root";
//						$new_line = str_replace("</root>", $xmldata, $line);
//					}
//					else
//					{
//						//set file content to a string
//						$str.= $line;
//					}
//				}
//				//append new updated gpa to file content
//				$str.= $new_line;
//				
//				//set pointer back to beginning
//				rewind($xmlFile);
//			
//				//delete everything in the file.
//				ftruncate($xmlFile, filesize($file_name));
//			
//				//write everything back to file with the updated gpa line
//				fwrite($xmlFile, $str);
//				echo "success writing to file";
//				echo "<p>File successfully uploaded.</p>";
//				fclose($xmlFile);
//		}
//		else
//		{
//			echo "file <i>$file_name</i> doesn't exists";
//		}
//		
//	 /// }
//			 //////////////////////////////
//	}
//    else
//	{ 
//		 echo "<p>There was a problem uploading the file.</p>";
//	}
//}