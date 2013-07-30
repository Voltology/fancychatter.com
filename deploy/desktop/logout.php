<?php
session_destroy();
setcookie("password");
header("Location: /");
?>
