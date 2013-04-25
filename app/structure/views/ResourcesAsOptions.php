<?php

function view__ResourcesAsOptions($docs, $options = null) {
  foreach ($docs as $doc) {

    // Generate the $forClass string
    $forClass = "";
    foreach ($doc->levels as $level) 
      $forClass .= $level . " : "; 
    
    $output .= '<option value="' . $doc->_id.'">' . $doc->title . $forClass . '- ' . '</option> ';

  }

  // Finish output
  return $output;

}
