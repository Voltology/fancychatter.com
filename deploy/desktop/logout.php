<?php
unset($_SESSION['user']);
setcookie("password");
header("Location: /");
?>
