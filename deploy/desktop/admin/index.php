<?php
require("../../.local.inc.php");
$page = $_GET['p'] ? $_GET['p'] : "home";
$action = $_GET['a'] ? $_GET['a'] : null;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>FancyChatter &raquo; Admin</title>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="/css/admin.css" />
    <link rel="stylesheet" href="/css/font-awesome.css">
    <script src="/js/admin.js"></script>
    <!--[if IE 7]>
    <link rel="stylesheet" href="/css/global/font-awesome-ie7.min.css">
    <![endif]-->
  </head>
  <body>
    <table width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2" valign="middle" class="header">
          <div class="header-logo">
            <a href="<?php echo DESKTOP_URL; ?>"><img src="/img/logo-admin.png" /></a>
          </div>
          <div class="header-admin">Administration Area</div>
        </td>
      </tr>
      <tr>
        <td valign="top" class="sidebar-cell" width="120">
          <div id="sidebar" style="line-height: 1.3em;">
          <?php
          if ($user->getIsLoggedIn()) {
          ?>
            <div class="<?php if ($page === "home") { echo "active"; } ?>menuitem"><a href="?p=home">Home</a></div>
            <div class="<?php if ($page === "livechatter") { echo "active"; } ?>menuitem"><a href="?p=livechatter">LiveChatter</a></div>
            <div class="menuheader tableheader">ChitChat</div>
            <div class="submenu">
              <div class="<?php if ($page === "archive" && $brand === "pb") { echo "active"; } ?>submenuitem"><a href="?p=archive">Archive</a></div>
            </div>
            <div class="<?php if ($page === "merchants") { echo "active"; } ?>menuitem"><a href="?p=merchants">Merchants</a></div>
            <div class="<?php if ($page === "users") { echo "active"; } ?>menuitem"><a href="?p=users">Users</a></div>
            <div class="<?php if ($page === "messages") { echo "active"; } ?>menuitem"><a href="?p=messages">Messages (1)</a></div>
            <div class="<?php if ($page === "settings") { echo "active"; } ?>menuitem"><a href="?p=settings">Settings</a></div>
            <a href="/logout.php" class="logout">Log Out</a>
          <?php
          }
          ?>
          </div>
        </td>
        <td valign="top" align="left" class="page">
        <?php
        require($page . ".php");
        ?>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <div id="footer">&copy; <?php echo date("Y"); ?> <a href="<?php echo DESKTOP_URL; ?>">FancyChatter.com</a>, All Rights Reserved.</div>
        </td>
      </tr>
    </table>
    <br />
    <br />
    <br />
  </body>
</html>
