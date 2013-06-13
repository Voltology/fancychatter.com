<?php
require("../.local.inc.php");
if ($user->checkPassword($_POST['email'], md5($_POST['password']))) {
  setcookie("email", $_POST['email']);
  setcookie("password", md5($_POST['password']));
  if ($_POST['logintype'] === "admin" && in_array($user->getRole(), array("administrator", "merchant_admin", "merchant_editor", "merchant_publisher"))) {
    header("Location: /admin/");
  } else {
    if (isset($_POST['ref'])) {
      header("Location: " . $_POST['ref']);
    } else {
      header("Location: /");
    }
  }
} else {
  if ($_POST['logintype'] === "admin") {
    header("Location: /admin/?error=true");
  } else {
    header("Location: " . $_POST['ref'] . "?error=true");
  }
}
?>
