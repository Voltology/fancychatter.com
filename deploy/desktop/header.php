<?php
require("../.local.inc.php");
$page = $_GET['p'] ? $_GET['p'] : "home";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FancyChatter.com - Find local deals in real time!</title>
    <meta name="description" content="">
    <meta name="author" content="">
		<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/<?php echo JQUERY_VERSION; ?>/jquery.min.js"></script>-->
		<script src="/js/jquery.js"></script>
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
          if (count > 6) { count = 1; }
      }, 5000);
    });
    </script>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', '<?php echo GA_ID; ?>', 'fancychatter.com');
      ga('send', 'pageview');
    </script>
    <!--[if lt IE 9]>
      <script src="/js/html5shiv.js"></script>
    <![endif]-->
  </head>
  <body class="<?php echo preg_replace('/\//', "", $_SERVER['REQUEST_URI']); ?>">
    <div class="container">
      <div class="masthead" style="padding: 4px; 0; border: 1px solid #ccc;">
        <div style="display: inline-block; margin: 5px 5px;"><a href="/"><img src="img/logo.png" width="140" border="0" /></a></div>
        <div style="display: inline-block; float: right; color: #000; margin: 14px 14px; font-size: 13px;" class="hidden-tablet hidden-phone">
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
          <a href="#" onclick="dialog.open('login', 'Log In', 206, 316);">Log In</a>&nbsp;&nbsp;|&nbsp;
          <?php if (!B2B) { ?><a href="#" onclick="dialog.open('signup', 'Sign Up', 336, 316);">Sign Up</a>&nbsp;&nbsp;|&nbsp; <?php } ?>
          <a href="">Help</a>
          <?php } ?>
        </div>
      </div>
      <div class="navbar">
        <div class="navbar-inner">
          <div class="container">
            <ul class="nav">
              <?php if ($user->getIsLoggedIn()) { ?>
              <li<?php if ($page === null) { echo " class=\"active\""; } ?>><a href="./">Home</a></li>
              <li<?php if ($page === "profile") { echo " class=\"active\""; } ?>><a href="/profile">Profile (<?php echo Alerts::count($user->getId()); ?>)</a></li>
              <li<?php if ($page === "contact") { echo " class=\"active\""; } ?>><a href="/logout">Log Out</a></li>
              <?php } else { ?>
              <li<?php if ($page === null) { echo " class=\"active\""; } ?>><a href="./">Home</a></li>
              <li<?php if ($page === "contact") { echo " class=\"active\""; } ?>><a href="#" onclick="dialog.open('signup', 'Sign Up', 336, 316);">Sign Up</a></li>
              <li<?php if ($page === "contact") { echo " class=\"active\""; } ?>><a href="#" onclick="dialog.open('login', 'Log In', 206, 316);">Log In</a></li>
              <?php } ?>

            </ul>
          </div>
        </div>
      </div>
