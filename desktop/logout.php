<?php
session_start();
$_SESSION = array();
session_destroy();
setcookie("password");
header("Location: /");
?>
