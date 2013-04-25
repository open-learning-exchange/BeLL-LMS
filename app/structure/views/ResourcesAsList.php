<?php 

function view__ResourcesAsList($docs) {

  // Start output
  $output .= '<ul>';

  $count = 1;

  foreach ($docs as $doc) {

    // Get the single attached file
    foreach ($doc->_attachments as $file_name => $file_info)

    // Generate the $forClass string
    $forClass = "";
    foreach ($doc->levels as $level) $forClass .= $level . " : "; 

    // Generate the icons and buttons specific for this file type
    $file_icon="";
    $button_text="";
    switch($file_info->content_type) {
      case 'audio/mpeg' :
        $file_icon='<img src="images/audio.png" width="15" height="15">';
        $button_text="Listen";
        break;
      case 'application/pdf' :
        $file_icon='<img src="images/pdf.png" width="18" height="18">';
        $button_text="Read";
        break;
    }
    
    // Stripe the table
    $row_color = ($count%2==0) ? "" : "#F0F0F0";

    // Generate output for this doc
    $output .= '
      <li style="background: ' . $row_color . '">' .
        '<span>' .
          $count.': <span style="color: #900;font-weight:bold;">'.$doc->title.'</span><br>' . 
          '<span style="font-style:italic">'.$doc->description.'</span>' .
        '</span>' .
        '<span width="203"><span style="color: #900;font-weight:bold;">'.$forClass.'</span></span>' .
        '<span><input type="submit" class="button" value="'.$button_text.'" onclick=openRes("http://192.168.0.111:5984/bell-lcms/' . $doc->_id . '/' . $file_name . '")>'.$file_icon.'</span>
      </li>'
    ;

    $count++;

  }

  // Finish output
  $output .= '</table>';

  return $output;

}