<?php
unset($_SESSION['user']);
unset($_SESSION['merchant']);
setcookie("password");
header("Location: /");
?>
