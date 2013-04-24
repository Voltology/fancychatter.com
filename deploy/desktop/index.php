<?php
require("../.local.inc.php");
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
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 60px;
      }

      /* Custom container */
      .container {
        margin: 0 auto;
        max-width: 1000px;
      }
      .container > hr {
        margin: 60px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 40px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 100px;
        line-height: 1;
      }
      .jumbotron .lead {
        font-size: 24px;
        line-height: 1.25;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }

      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
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

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
  </head>

  <body>

    <div class="container">
    <!--
    <form>
      <label for="email">Email</label>
      <input type="text" id="email" name="email" />
      <label for="password">Password</label>
      <input type="password" id="password" name="password" />
      <input type="button" value="Log In" onclick="user.login()" />
    </form>
    -->
      <div class="masthead">
        <h3 class="muted"><img src="img/logo.png" /></h3>
        <div class="navbar">
          <div class="navbar-inner">
            <div class="container">
              <ul class="nav">
                <li<?php if ($page === null) { echo " class=\"active\""; } ?>><a href="./">Home</a></li>
                <li<?php if ($page === "livechatter") { echo " class=\"active\""; } ?>><a href="/livechatter">Search</a></li>
                <li<?php if ($page === "profile") { echo " class=\"active\""; } ?>><a href="/profile">Profile</a></li>
                <li<?php if ($page === "about") { echo " class=\"active\""; } ?>><a href="/about">About</a></li>
                <li<?php if ($page === "contact") { echo " class=\"active\""; } ?>><a href="/contact">Contact</a></li>
              </ul>
            </div>
          </div>
        </div><!-- /.navbar -->
      </div>

      <!-- Jumbotron -->
      <div class="jumbotron">
        <h1>Realtime Deals</h1>
        <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        <a class="btn btn-large btn-success" href="#" onclick="dialog.open('login', 'Log In', 180, 400);">Get started today</a>
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

    </div> <!-- /container -->
    <div class="dialog" id="dialog">
      <div class="dialog-header" id="dialog-header"></div>
      <div class="dialog-body" id="dialog-body">test</div>
    </div>
    <div class="dialog-blanket" id="dialog-blanket"></div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/<?php echo JQUERY_VERSION; ?>/jquery.min.js"></script>
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

