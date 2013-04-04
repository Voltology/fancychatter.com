<?php
require("../.local.inc.php");
$page = $_REQUEST['p'] ? $_REQUEST['p'] : "home";
?>
<!DOCTYPE html>
<html>
	<head>
    <meta charset='utf-8'>
		<link rel="styleshet"  href="/css/styles.css"></script>
	</head>
	<body>
    <?php
    if (!$user->isLoggedIn()) {
    ?>
    <form>
      <label for="email">Email</label>
      <input type="text" id="email" name="email" />
      <label for="password">Password</label>
      <input type="password" id="password" name="password" />
      <input type="button" value="Log In" onclick="user.login()" />
    </form>
    <?php
    } else {
      require($page . ".php");
    }
    ?>
    <div id="dialog"></div>
    <div id="dialog_blanket"></div>
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
