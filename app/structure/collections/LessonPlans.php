<?php

function collection__LessonPlans() {
  
  global $db;
  
  try {
     $view = $db->bell_lcms->include_docs(TRUE)->getView('ghana-reads','LessonPlans');
  } catch (Exception $e) {
     echo "something weird happened: ".$e->getMessage()."<BR>\n";
  }

  return $docs;

}
