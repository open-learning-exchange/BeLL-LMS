<?php
$time = $_GET['time'];
echo $time;
exec("date -s '".$time."'");
?>
