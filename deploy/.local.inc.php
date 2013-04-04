<?php
switch($_SERVER['HTTP_HOST']) {
  case "fancychatter":
  case "api.fancychatter":
  case "m.fancychatter":
  case "dev.fancychatter.com":
  case "dev.api.fancychatter.com":
  case "dev.m.fancychatter.com":
    define("ENV", "dev");
    break;
  case "staging.fancychater.com":
  case "staging.api.fancychater.com":
  case "staging.m.fancychater.com":
    define("ENV", "staging");
    break;
  case "fancychater.com":
  case "api.fancychater.com":
  case "m.fancychater.com":
    define("ENV", "production");
    break;
  default:
    die("An error has occurred.  No environment has been set.");
}

if (ENV === "dev") {
  define("DB_HOST", "localhost");
  define("DB_NAME", "dev_fancychatter");
  define("DB_USER", "fancychatter");
  define("DB_PASS", "3CwdJQ%glgZg");

  define("API_URL", "http://api.fancychatter/");
  define("DESKTOP_URL", "http://fancychatter/");
  define("MOBILE_URL", "http://dev.m.fancychatter.com/");

  define("LIB_PATH", "/Users/christopher.vuletich/Development/Web/php/fancychatter/deploy/libs/");
  define("JQUERY_VERSION", "1.9.0");
} else if (ENV === "staging") {
  define("DB_HOST", "localhost");
  define("DB_NAME", "staging_fancychatter");
  define("DB_USER", "fancychatter");
  define("DB_PASS", "gXf3RPcvFiEh");

  define("API_URL", "staging.api.fancychatter.com/");
  define("DESKTOP_URL", "staging.fancychatter.com/");
  define("MOBILE_URL", "staging.m.fancychatter.com/");

  define("LIB_PATH", "");
  define("JQUERY_VERSION", "1.9.0");
} else if (ENV === "production") {
  define("DB_HOST", "localhost");
  define("DB_NAME", "fancychatter");
  define("DB_USER", "fancychatter");
  define("DB_PASS", "Js4kyNU!LWaq");

  define("API_URL", "api.fancychatter.com/");
  define("DESKTOP_URL", "fancychatter.com/");
  define("MOBILE_URL", "m.fancychatter.com/");

  define("LIB_PATH", "");
  define("JQUERY_VERSION", "1.9.0");
}

require(LIB_PATH . "Database.class.php");
require(LIB_PATH . "User.class.php");

$db = new Database();
session_start();
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = new User();
}
$user =& $_SESSION['user'];
$user->checkPassword($_COOKIE['email'], $_COOKIE['password']);
?>
