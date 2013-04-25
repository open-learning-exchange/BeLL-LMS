<?php
function model__Resource($id = null) {

  global $db;  

  if($id) {
    $resource = $db->bell_lcms->getDoc($id);
  }
  else {
    $resource = new stdClass();
    $resource->_id = "_new";
    $resource->prepared_By = $_SESSION['name'];
  }
  return $resource;
  
}
