<?php

if(isset($_POST['Vbook']))
{
	
	if( isset($_POST['vbQ']) && is_array($_POST['vbQ']) ) {
		$whatQuestions ="";
		foreach($_POST['vbQ'] as $vbQ) {
			// eg. "I have a grapefruit!"
			$whatQuestions =$whatQuestions.":".$vbQ;
			
		}
		mysql_query("INSERT INTO `VBTask` (`ColNum`, `resrcID`, `questColNum`, `usedby`, `dateUsed`, `class`) VALUES (NULL, '".$_POST['vbTitle']."', '".substr($whatQuestions, 1)."', '".$_SESSION['name']."', '".$_POST['dateExec']."', '".$_POST['class']."')") or die(mysql_error());
			// -- insert into database call might go here
	}
	///recordActionObjectDate($_SESSION['lmsUserID'],"Assigned Task To Group",$_GET['groupID'],$_GET['systDate']);
	
}
if(isset($_POST['AStory']))
{
	die("Audio Story");
}
if(isset($_POST['Phons']))
{
	die("Phonics");
}
if(isset($_POST['WordP']))
{
	die("Word Power");
}
?>