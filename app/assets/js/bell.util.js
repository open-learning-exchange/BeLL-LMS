$(document).ready(function() {


// Tweak how browsers interpret default value of select fields
// If a select field has a value set for data-attribue-selected, it will be set as selected
$('option').each(function() {
    if($(this).parent().attr('data-attribute-selected') == $(this).attr('value')) {
      $(this).attr('selected','selected')
    }
})


})
