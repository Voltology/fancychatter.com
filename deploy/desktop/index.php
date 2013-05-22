<?php
require("../.local.inc.php");
include("header.php");
$page = $_GET['p'] ? $_GET['p'] : null;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>FancyChatter.com - Find local deals in real time!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/<?php echo JQUERY_VERSION; ?>/jquery.min.js"></script>
    <link rel="stylesheet" href="/css/font-awesome.css">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <style type="text/css">
      body {
        background-color: #fafafa;
        padding-bottom: 60px;
      }

      /* Custom container */
      .container {
        margin: 0 auto;
        max-width: 1000px;
      }
      .container > hr {
        margin: 30px 0 10px 0;
      }

      /* Main marketing message and sign up button */
      .masthead {
        background-color: #f3f3f3; /* Old browsers */
        border-radius: 0 0 8px 8px;
        margin-bottom: 12px;
      }
      .masthead a {
        color: #000;
        font-weight: bold;
      }
      .jumbotron {
        background-color: #000;
        border-radius: 8px;
        color: #fff;
        min-height: 360px;
        overflow: hidden;
        position: relative;
      }
      #banner {
        background-image: url(../img/carousel/1.jpg);
        min-height: 360px;
        overflow: hidden;
        padding: 40px 0;
        position: absolute;
        width: 100%;
        z-index: 50;
      }
      .jumbotron h1 {
        font-size: 40px;
        line-height: 1;
        margin: 100px 20px 0 84px;
        position: relative;
        text-align; left;
        text-shadow: 0px 0px 12px #000;
        z-index: 100;
      }
      .jumbotron h2 {
        font-size: 20px;
        line-height: 1;
        margin: 4px 20px 0 86px;
        position: relative;
        text-align; left;
        text-shadow: 0px 0px 12px #000;
        z-index: 100;
      }
      .jumbotron .lead {
        box-shadow: 0px 0px 6px #000;
        font-size: 24px;
        line-height: 1.25;
        margin: 8px auto;
        padding: 6px 0;
        position: relative;
        width: 828px;
        z-index: 100;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 7px 24px;
      }

      /* Customize the navbar links to be fill the entire space of the .navbar */
      .navbar .navbar-inner {
        padding: 0;
      }
      .navbar .nav {
        margin: 0;
        display: table;
        width: 100%;
      }
      .navbar .nav li {
        display: table-cell;
        width: 1%;
        float: none;
      }
      .navbar .nav li a {
        font-weight: bold;
        text-align: center;
        border-left: 1px solid rgba(255,255,255,.75);
        border-right: 1px solid rgba(0,0,0,.1);
      }
      .navbar .nav li:first-child a {
        border-left: 0;
        border-radius: 3px 0 0 3px;
      }
      .navbar .nav li:last-child a {
        border-right: 0;
        border-radius: 0 3px 3px 0;
      }
    </style>
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
          if (count > 2) { count = 1; }
      }, 5000);
    });
    </script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <div class="masthead" style="padding: 4px; 0; border: 1px solid #ccc;">
        <div style="display: inline-block; margin: 5px 5px;"><img src="img/logo.png" width="140" /></div>
        <div style="display: inline-block; float: right; color: #000; margin: 14px 14px;">
          <a href="">Sign Up</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="">Log In</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="">Help</a>
        </div>
        <!--
        <div class="navbar">
          <div class="navbar-inner">
            <div class="container">
              <ul class="nav">
                <li<?php if ($page === null) { echo " class=\"active\""; } ?>><a href="./">Home</a></li>
                <li<?php if ($page === "profile") { echo " class=\"active\""; } ?>><a href="/profile">Profile</a></li>
                <li<?php if ($page === "about") { echo " class=\"active\""; } ?>><a href="/about">About</a></li>
                <li<?php if ($page === "contact") { echo " class=\"active\""; } ?>><a href="/contact">Contact</a></li>
              </ul>
            </div>
          </div>
        </div>
        -->
      </div>

      <!-- Jumbotron -->
      <div class="jumbotron">
        <div id="banner"></div>
          <h1>Get what you want, when you want it</h1>
          <h2>Search for deals in your area in real time</h2>
          <div class="lead" style="background-color: #eee; border: 1px solid #ccc; border-radius: 6px; text-align: center;">
            <input type="text" style="font-size: 16px; padding: 5px;" placeholder="Where are you?" />
            <select><option>What are you looking for?</option></select>
            <select><option>How far do you want to go?</option></select>
            <a href="#" class="btn btn-mini btn-success" onclick="dialog.open('login', 'Log In', 180, 400);"><i class="icon-search" style="vertical-align: bottom;"></i> Search</a>
          </div>
      </div>


      <!-- Example row of columns -->
      <div class="row-fluid">
        <div class="span4">
          <h2>Go Mobile</h2>
          <p>The Fancychatter.com mobile and iphone application was developed and is designed to enhance your purchasing experience by engaging the merchant you choose, by category, as you travel. This isn't your ordinary, "find the best deal" application. If getting what you want, when you want, and at the right price are important to you. Then Fancychatter.com is for you.</p>
          <p><a class="btn" href="#">Go Mobile &raquo;</a></p>
        </div>
        <div class="span4">
          <h2>Another Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
       </div>
        <div class="span4">
          <h2>FAQ</h2>
          <p>
            <a href="?p=about">What is FancyChatter?</a><br />
            <a href="?p=suggest">Suggest a Business</a><br />
            <a href="?p=contact">Contact Us</a>
            <a href="?p=faq">Frequently Asked Questions</a><br />
            <a href="?p=addbusiness">Add Your Business</a><br />
            <a href="<?php echo ADMIN_PATH; ?>">Merchant Administration Area</a>
          </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
      </div>

      <hr>

      <div class="footer">
        <p>&copy; <a href="http://www.fancychatter.com">FancyChatter.com</a> 2013</p>
      </div>

    </div>
    <div class="dialog" id="dialog">
      <div class="dialog-header" id="dialog-header"></div>
      <div class="dialog-body" id="dialog-body">test</div>
    </div>
    <div class="dialog-blanket" id="dialog-blanket"></div>
    <script src="/js/ajax.js"></script>
    <script src="/js/alerts.js"></script>
    <script src="/js/chitchat.js"></script>
    <script src="/js/constants.js"></script>
    <script src="/js/dialog.js"></script>
    <script src="/js/maps.js"></script>
    <script src="/js/livechatter.js"></script>
    <script src="/js/user.js"></script>
    <script src="/js/utilities.js"></script>
  </body>
</html>
<?php
include("footer.php");
?>
