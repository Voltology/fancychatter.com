<?php
date_default_timezone_set("Amercian/Chicago");
define("LIB_PATH", __DIR__ . "/libs/");

require(LIB_PATH . "Database.class.php");
require(LIB_PATH . "Alerts.class.php");
require(LIB_PATH . "Application.class.php");
require(LIB_PATH . "ChitChat.class.php");
require(LIB_PATH . "LiveChatter.class.php");
require(LIB_PATH . "Merchant.class.php");
require(LIB_PATH . "Message.class.php");
require(LIB_PATH . "User.class.php");
require(LIB_PATH . "Utilities.php");

session_start();
if ($_GET['debug'] === "true" || ($_SESSION['debug'] === "true" && $_GET['debug'] !== "false")) {
  $_SESSION['debug'] = "true";
  $starttime = explode(' ', microtime());
  $starttime = $starttime[1] + $starttime[0];
  error_reporting(E_ALL);
  ini_set('display_errors', '1');
} else {
  $_SESSION['debug'] = "false";
}

switch ($_SERVER['HTTP_HOST']) {
  case "b2b.fancychatter":
  case "b2b.fancychatter.com":
  case "stgaing.b2b.fancychatter.com":
    define("B2B", true);
    break;
  default:
    define("B2B", false);
    break;
}

switch ($_SERVER['HTTP_HOST']) {
  case "fancychatter":
  case "api.fancychatter":
  case "b2b.fancychatter":
    define("ENV", "dev");
    break;
  case "staging.fancychatter.com":
  case "staging.api.fancychatter.com":
  case "staging.b2b.fancychatter.com":
    define("ENV", "staging");
    break;
  case "173.203.81.65":
  case "fancychatter.com":
  case "www.fancychatter.com":
  case "api.fancychatter.com":
  case "b2b.fancychatter.com":
    define("ENV", "production");
    break;
  default:
    die("An error has occurred.  No environment has been set.");
}


if (ENV === "dev") {
  define("DB_HOST", "localhost");
  define("DB_NAME", "dev_fancychatter");
  define("DB_USER", "dev_fancychatter");
  define("DB_PASS", "3CwdJQ%glgZg");

  define("API_URL", "http://api.fancychatter/");
  define("DESKTOP_URL", "http://fancychatter/");

  define("JQUERY_VERSION", "1.9.1");
} else if (ENV === "staging") {
  define("DB_HOST", "localhost");
  define("DB_NAME", "staging_fc");
  define("DB_USER", "staging_fc");
  define("DB_PASS", "gXf3RPcvFiEh");

  define("API_URL", "staging.api.fancychatter.com/");
  define("DESKTOP_URL", "staging.fancychatter.com/");

  define("JQUERY_VERSION", "1.9.1");
} else if (ENV === "production") {
  define("DB_HOST", "fc-db01");
  define("DB_NAME", "fancychatter");
  define("DB_USER", "fancychatter");
  define("DB_PASS", "Js4kyNU!LWaq");

  define("API_URL", "api.fancychatter.com/");
  define("DESKTOP_URL", "fancychatter.com/");

  define("JQUERY_VERSION", "1.9.1");
}
$db = new Database();
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = new User();
}
$user =& $_SESSION['user'];
$user->checkPassword($_COOKIE['email'], $_COOKIE['password']);
?>
