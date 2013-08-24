$(document).ready(function() {
  var now = moment.now().unix()
  $.get("go.php?time=" + now, function() {})
})
