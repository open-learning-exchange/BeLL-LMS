<?php
function view__LessonPlanEdit($LessonPlan) {

  // Load templates and template engine
  global $templates;
  global $m;

  // Start the variables for the template
  $variables = (array) $LessonPlan;

  // Resources list is not hardcoded onto the form template, use a View.
  $resources = collection__Resources();
  $variables['ResourcesAsOptions'] = view__ResourcesAsOptions($resources);

  // Load the template and return the rendering
  $tpl = $templates->load("LessonPlanForm");
  return $m->render($tpl, $variables);

}
