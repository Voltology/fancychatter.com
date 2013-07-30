<?php
require("../.local.inc.php");
$page = $_GET['p'] ? $_GET['p'] : "home";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>FancyChatter.com - Find local deals in real time!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

		<script src="//ajax.googleapis.com/ajax/libs/jquery/<?php echo JQUERY_VERSION; ?>/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <link rel="stylesheet" href="/css/font-awesome.css">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <script>
    $(document).ready(function() {
      var count = 1;
      var $element = $('#banner');
      setInterval(function () {
          $element.fadeIn(500).delay(0).fadeOut(500, function() {
            $element.css('background-image', 'url(../img/carousel/' + count + '.jpg)');
          });
          $element.fadeIn(500);
          count++;
          if (count > 3) { count = 1; }
      }, 5000);
    });
    </script>
    <!--[if lt IE 9]>
      <script src="/js/html5shiv.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <div class="masthead" style="padding: 4px; 0; border: 1px solid #ccc;">
        <div style="display: inline-block; margin: 5px 5px;"><a href="/"><img src="img/logo.png" width="140" border="0" /></a></div>
        <div style="display: inline-block; float: right; color: #000; margin: 14px 14px;">
          <a href="/">Home</a>&nbsp;&nbsp;|&nbsp;
          <?php if ($user->getIsLoggedIn()) { ?>
            <?php if (in_array($user->getRole(), array("administrator", "user"))) { ?>
              <a href="/profile">My Profile (<?php echo Alerts::count($user->getId()); ?>)</a>&nbsp;&nbsp;|&nbsp;
            <?php } ?>
            <?php if (in_array($user->getRole(), array("administrator", "merchant_admin", "merchant_editor", "merchant_publisher"))) { ?>
            <a href="/admin/">Admin Area</a>&nbsp;&nbsp;|&nbsp;
            <?php } ?>
            <!--<a href="/help">Help</a>&nbsp;&nbsp;|&nbsp;-->
            <a href="/logout">Log Out</a>
          <?php } else { ?>
          <a href="#" onclick="dialog.open('login', 'Log In', 190, 310);">Log In</a>&nbsp;&nbsp;|&nbsp;
          <?php if (!B2B) { ?><a href="#" onclick="dialog.open('signup', 'Sign Up', 320, 310);">Sign Up</a>&nbsp;&nbsp;|&nbsp; <?php } ?>
          <!--<a href="">Help</a>-->
          <?php } ?>
        </div>
      </div>
