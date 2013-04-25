<?php
function model__LessonPlan($id = null) {

  global $db;  

  if($id) {
    $lessonPlan = $db->bell_lcms->getDoc($id);
  }
  else {
    $lessonPlan = new stdClass();
    $lessonPlan->_id = "_new";
    $lessonPlan->prepared_By = $_SESSION['name'];
  }
  return $lessonPlan;
  
}

