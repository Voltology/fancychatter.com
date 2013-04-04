<<<<<<< HEAD
<?php
require("../../.local.inc.php");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>FancyChatter &raquo; Admin</title>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="/css/admin.css" />
    <script src="/js/admin.js"></script>
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
          if ($user->isLoggedIn()) {
          ?>
          test
          <a href="/logout.php">Log Out</a>
          <?php
          }
          ?>
          </div>
        </td>
        <td valign="top" align="left" class="page">
        <?php
        if (!$user->isLoggedIn()) {
        ?>
          <h3>Log In</h3>
          <form method="post" action="/login.php">
            <table class="edit-table">
              <tr>
                <td class="edit-label">Email</td>
                <td class="edit-field"><input type="text" name="email" value="" /></td>
              </tr>
              <tr>
                <td class="edit-label">Password</td>
                <td class="edit-field"><input type="password" name="password" /></td>
              </tr>
              <tr>
                <td class="edit-label">Keep me logged in</td>
                <td class="edit-field"><input type="checkbox" name="remme" value="true" /></td>
              </tr>
            </table>
            <input type="hidden" name="logintype" value="admin" />
            <input type="submit" value="Log In" />
          </form>
          <br />
          <br />
        <?php
        } else {
        }
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
=======
Admin
>>>>>>> dev
