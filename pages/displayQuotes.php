<?php session_start();error_reporting(1);include "../secure/talk2db.php";?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link rel="stylesheet" type="text/css" media="all" href="../css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../js/jsDatePick.min.1.3.js"></script>
</head>
<?php
$quoteMessage = "";
global $arrayQuotes;
$quoteMessage = $arrayQuotes[rand(0,sizeof($arrayQuotes)-1)];

?>

<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:600px;">
  <div id="rightContent" style="float: none; margin-left: auto; margin-right: auto; width: 500px; margin-left: auto; margin-right: auto; font-size: 22px; text-align:justify; padding-top:50px; padding-bottom:80px;"><img name="" src="../images/motiv.jpg" width="201" height="162" alt="" style="float:left;"><br><?php echo $quoteMessage;?>
      <table width="98%">
      <tr>        </tr>
      </table>
    
    <table width="72%" align="center">
      <tr> </tr>
        <tr> </tr>
    </table>
  </div>
<div class="clear"></div>
</div>
</body>
</html>