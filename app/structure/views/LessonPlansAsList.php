<?php

function view__LessonPlansAsList($lessonPlans) {

  // Load templates and template engine
  global $templates;
  global $m;

  // Start the variables for the template
  $variables = array("lessonPlans" => $lessonPlans, 'gram' => "zzz");

  // Load the template and return the rendering
  $tpl = $templates->load("LessonPlansAsList");
  return $m->render($tpl, $variables);

}
