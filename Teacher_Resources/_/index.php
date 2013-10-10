<html>
<head>
  <title>PHP File Browser</title>
  <style type="text/css">
    .error{ color:red; font-weight:bold; }
	
	#directory {
	width: 500px;
	float: left;
	padding: 0 0 10px 10px;
	border-right: 0px solid #dcdcdc;
	text-align: left;
}
#directory ul {list-style: none;padding: 0; margin: 0;font-size: 12px;}
#directory ul li {
	width: 400px;
	height:20px;
	background: url(../../images/icon-left.png) no-repeat left center, url(../../images/green.jpg) repeat left center;
	padding: 10px 4px 4px 4px; margin-top: 8px;margin-left: 9px;
	border: 1px solid #dcdcdc;
	-moz-border-radius-topleft: 8px;-moz-border-radius-bottomleft: 8px;
	-webkit-border-top-left-radius: 8px;-webkit-border-bottom-left-radius: 8px;
	-o-border-top-left-radius: 8px;-o-border-bottom-right-radius: 8px;
	-moz-border-radius-topright: 8px;-moz-border-radius-bottomright: 8px;
	-webkit-border-top-right-radius: 8px;-webkit-border-bottom-right-radius: 8px;
	-o-border-top-right-radius: 8px;-o-border-bottom-right-radius: 8px;
	}
#directory ul li a {
	width: 100%;
	color: #FFCC00;
    cursor: pointer;
	padding: 10px 10px 10px 30px;
    -webkit-transition: padding-left 250ms ease-out;
	-moz-transition: padding-left 250ms ease-out;
	-o-transition: padding-left 250ms ease-out;
}
#directory ul li a:hover {
    padding-left: 30px;
	text-decoration: none;
	color: #fff;
	text-shadow: 1px 1px #496d2a;
}

#file {
	width: 500px;
	float: left;
	padding: 0 0 10px 10px;
	border-right: 0px solid #dcdcdc;
	text-align: left;
}
#file ul {list-style: none;padding: 0; margin: 0;font-size: 12px;}
#file ul li {
	width: 450px;
	height:20px;
	background: url(../../images/yellow.jpg) repeat left center;
	padding: 10px 4px 4px 4px; margin-top: 8px;margin-left: 9px;
	border: 1px solid #dcdcdc;
	-moz-border-radius-topleft: 8px;-moz-border-radius-bottomleft: 8px;
	-webkit-border-top-left-radius: 8px;-webkit-border-bottom-left-radius: 8px;
	-o-border-top-left-radius: 8px;-o-border-bottom-right-radius: 8px;
	-moz-border-radius-topright: 8px;-moz-border-radius-bottomright: 8px;
	-webkit-border-top-right-radius: 8px;-webkit-border-bottom-right-radius: 8px;
	-o-border-top-right-radius: 8px;-o-border-bottom-right-radius: 8px;
	}
#file ul li a {
	width: 100%;
	color: #000000;
    cursor: pointer;
	padding: 10px 10px 10px 30px;
    -webkit-transition: padding-left 250ms ease-out;
	-moz-transition: padding-left 250ms ease-out;
	-o-transition: padding-left 250ms ease-out;
}
#file ul li a:hover {
    padding-left: 30px;
	text-decoration: none;
	color: #900;
}
  a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
  </style>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<span style="float:none; margin-left:auto; margin-right:auto; width:550px; margin-left:auto; margin-right:auto;"><span style="color:#00C; font-weight: bold;">Teacher Resources</span> -</span><br>
<br>
<br>
<?php
  // Explore the files via a web interface.   
  $script = basename(__FILE__); // the name of this script
  $path = !empty($_REQUEST['path']) ? $_REQUEST['path'] : dirname(__FILE__); // the path the script should access
  
  ///echo "<h1>Directory Browser</h1>";
  ///echo "<p>Browsing Location: {$path}</p>";
  
  $directories = array();
  $files = array();
  
  // Check we are focused on a dir
  if (is_dir($path)) {
    chdir($path); // Focus on the dir
	//echo "<br>".substr($path, 28)."<br>";
   if ($handle = opendir('.')) {
      while (($item = readdir($handle)) !== false) {
        // Loop through current directory and divide files and directorys
        if(is_dir($item)){
          array_push($directories, realpath($item)); 
        }
        else
        {
          array_push($files, ($item));
        }
   }
   closedir($handle); // Close the directory handle
   }
    else {
      echo "<p class=\"error\">Directory handle could not be obtained.</p>";
    }
  }
  else
  {
    echo "<p class=\"error\">Path is not a directory</p>";
  }
  
  // There are now two arrays that contians the contents of the path. 
  
  // List the directories as browsable navigation
  
  //// echo "<h2>Document files</h2>";
  echo "<div id='file'><ul>";
  foreach( $files as $file ){
    // Comment the next line out if you wish see hidden files while browsing
    if(preg_match("/^\./", $file) || $file == $script): continue; endif; // This line will hide all invisible files. 
    echo '<li><a href="'.substr($path, 8) .'/' . basename($file) . '" target="_blank">' . $file . '</a></li>';
  }
  echo "</ul></div>";
  
  ///echo "<h2>Directories</h2>";
  $allDirs = explode('/',$path);
 // print_r( $previousDir);
  $previousDir="";
  try{
	  $previousDir=$allDirs[sizeof($allDirs)-2];
	 }catch(Exception $err){}
	 
  echo "<div id='directory'><ul>";
  
  foreach( $directories as $directory ){
	  if(basename($directory)=="_"){
		  $toDisplay ="<li><a href=\"{$script}?path={$directory}\" style='font-weight:bold;color: #FF0000;'> &nbsp;&nbsp;&nbsp;<< &nbsp;&nbsp;&nbsp;GO BACK &nbsp;&nbsp;&nbsp;<< &nbsp;&nbsp;&nbsp;</a></li>";
		  }
		else if(basename($directory) !="Teacher_Resources"){
			if(basename($directory) != $previousDir){
    			echo ($directory != $path) ? "<li><a href=\"{$script}?path={$directory}\">".basename($directory)."</a></li>" : "";
			}
			else{
				$toDisplay ="<li><a href=\"{$script}?path={$directory}\" style='font-weight:bold;color: #FF0000;'> &nbsp;&nbsp;&nbsp;<< &nbsp;&nbsp;&nbsp;GO BACK &nbsp;&nbsp;&nbsp;<< &nbsp;&nbsp;&nbsp;</a></li>";
				// display home
			}
	  }else{
		  $toDisplay="";
	  }
  }
  if($toDisplay !=""){
		  echo $toDisplay;
	  }
  echo "</ul></div>";
  
 
?>

</body>
</html>