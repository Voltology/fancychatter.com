<?php
require("../.local.inc.php");
if ($_POST['logintype'] === "admin") {
  header("Location: admin/");
} else {
  header("Location: /");
}
?>
