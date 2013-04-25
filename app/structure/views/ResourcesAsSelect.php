<?php

function view__ResourcesAsSelect($docs, $options = null) {

  // Defaults
  if ($option == null) {
    $options = array(
      "fieldName" => "resources"
    );
  }

  // Start output
  $output .= "<select name='" . $options['fieldName'] . "'>";

  foreach ($docs as $doc) {

    // Generate the $forClass string
    $forClass = "";
    foreach ($doc->levels as $level) 
      $forClass .= $level . " : "; 
    
    $output .= '<option value="'.$doc->_id.'">'.$forClass.'- '.$doc->title.'</option>';

  }

  // Finish output
  $output .= "</select>";

  return $output;
}
