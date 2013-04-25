<?php

function collection__Resources() {
  
  global $db;
  
  // Get the list of all Resources
  try {
     $view = $db->bell_lcms->include_docs(TRUE)->getView('ghana-reads','resources');
  } catch (Exception $e) {
     echo "something weird happened: ".$e->getMessage()."<BR>\n";
  }
  // Get the docs and sort them
  foreach ($view->rows as $row) {
    $doc = $row->doc; 
    $docs[$doc->title . $doc->_id] = $doc;
    // TODO $docs = ksort($docs);
  }

  return $docs;

}
