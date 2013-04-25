<?php

function collection__LessonPlans_by_prepared_By($prepared_By) {
  
  global $db;
  
  try {
     $view = $db->bell_lcms->include_docs(TRUE)->key($prepared_By)->getView('ghana-reads','LessonPlans_by_prepared_By');
  } catch (Exception $e) {
     echo "something weird happened: ".$e->getMessage()."<BR>\n";
  }
  
   
  foreach($view->rows as $row) {
    $docs[] = $row->doc;
  }
  return $docs;

}
