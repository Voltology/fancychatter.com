<?php
require("../../.local.inc.php");
if ($user->getMerchantId() != "") {
  if (!isset($_SESSION['merchant'])) {
      $_SESSION['merchant'] = new Merchant($user->getMerchantId());
  }
  $merchant =& $_SESSION['merchant'];
}
$page = $_GET['p'] ? $_GET['p'] : "home";
$action = $_POST['a'] ? $_POST['a'] : $_GET['a'];
  switch($_REQUEST['formpage']) {
    case "chitchat":
      Alerts::add($_POST['user-id'], $merchant->getName() . " has responded to your ChitChat!");
      ChitChat::respond($_POST['cc-id'], $_POST['user-id'], $merchant->getId(), $_POST['body'], "merchant");
      header("Location: " . $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] . "&action=" . $action);
      break;
    case "livechatter":
      switch ($action) {
        case null:
        case "activate":
        case "add":
        case "deactivate":
        case "delete":
        case "edit":
        case "pause":
        case "save":
          $id = $_POST['id'] ? $_POST['id'] : $_GET['id'];
          if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $lc = new LiveChatter($id, $user->getMerchantId());
            if ($_POST['now'] == "true") {
              $start = time();
            } else {
              $start = jQueryTimeToUnixTime($_POST['startdate'], $_POST['starttime-hour'], $_POST['starttime-minute'], $_POST['starttime-suffix']);
            }
            $end = jQueryTimeToUnixTime($_POST['enddate'], $_POST['endtime-hour'], $_POST['endtime-minute'], $_POST['endtime-suffix']);
            $errors = LiveChatter::validate($_POST['body'], $start, $end);
            if ($action === "add") {
              if (count($errors) === 0) {
                $errors = LiveChatter::add($user->getMerchantId(), $_POST['body'], $merchant->getLatitude(), $merchant->getLongitude(), $start, $end, $user->getGmtOffset());
              }
            } else if ($action === "edit") {
              if (count($errors) === 0) {
                $lc->setBody($_POST['body']);
                $lc->setStartTime($start);
                $lc->setEndTime($end);
                $lc->save();
              }
            }
          } else if ($id) {
            $lc = new LiveChatter($id, $user->getMerchantId());
            if ($lc->getId()) {
              if ($action === "activate") {
                $lc->activate();
              } else if ($action === "deactivate") {
                $lc->deactivate();
              } else if ($action === "delete") {
                $lc->delete();
              } else if ($action === "pause") {
                $lc->pause();
              }
            }
          }
        }
        header("Location: " . $_SERVER['PHP_SELF'] . "?p=" . $page . "&action=" . $action);
      break;
    case "settings":
      $errors = array();
      if ($_SERVER['REQUEST_METHOD'] === "POST") {
        setcookie("email", $_POST['email']);
        $user->setFirstName($_POST['firstname']);
        $user->setLastName($_POST['lastname']);
        $user->setEmail($_POST['email']);
        if ($_POST['password1'] !== "" && $_POST['password2'] !== "") {
          $user->setPassword($_POST['password1']);
          setcookie("password", md5($_POST['password1']));
        }
        $user->save();
      }
      break;
  }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>FancyChatter &raquo; Admin</title>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="/css/admin.css" />
    <link rel="stylesheet" href="/css/font-awesome.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    <script src="/js/jquery-timepicker.js"></script>
    <script src="/js/admin.js"></script>
    <script>
    $(document).ready(function() {
      var startDateTextBox = $('#startdate');
      var endDateTextBox = $('#enddate');
      $(startDateTextBox).datetimepicker({showTimepicker: false});
      $(endDateTextBox).datetimepicker({showTimepicker: false});

      startDateTextBox.datetimepicker({
        onClose: function(dateText, inst) {
          if (endDateTextBox.val() != '') {
            var testStartDate = startDateTextBox.datetimepicker('getDate');
            var testEndDate = endDateTextBox.datetimepicker('getDate');
            if (testStartDate > testEndDate)
              endDateTextBox.datetimepicker('setDate', testStartDate);
          }
          else {
            endDateTextBox.val(dateText);
          }
        },
        onSelect: function (selectedDateTime){
          endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate') );
        }
      });
      endDateTextBox.datetimepicker({
        onClose: function(dateText, inst) {
          if (startDateTextBox.val() != '') {
            var testStartDate = startDateTextBox.datetimepicker('getDate');
            var testEndDate = endDateTextBox.datetimepicker('getDate');
            if (testStartDate > testEndDate)
              startDateTextBox.datetimepicker('setDate', testEndDate);
          }
          else {
//            startDateTextBox.val(dateText);
          }
        },
        onSelect: function (selectedDateTime){
          startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate') );
        }
      });
    });
    </script>
    <!--[if IE 7]>
    <link rel="stylesheet" href="/css/global/font-awesome-ie7.min.css">
    <![endif]-->
  </head>
  <body>
    <div style="position: absolute; top: 5px; right: 5px;"><strong><?php echo date("F j, Y, g:i a", time()); ?></strong></div>
    <table width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2" valign="middle" class="header">
          <div class="header-logo">
            <a href="/"><img src="/img/logo-admin.png" /></a>
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
            <?php if (in_array($user->getRole(), array("merchant_admin", "merchant_editor", "merchant_publisher"))) { ?>
              <div class="<?php if ($page === "livechatter") { echo "active"; } ?>menuitem"><a href="?p=livechatter">LiveChatter</a></div>
              <div class="<?php if ($page === "chitchat") { echo "active"; } ?>menuitem"><a href="?p=chitchat">ChitChat <span class="green">(<?php echo ChitChat::getCount($merchant->getCategory()); ?>)</span></a></div>
            <?php } ?>
            <?php if (in_array($user->getRole(), array("administrator"))) { ?>
              <div class="<?php if ($page === "merchants") { echo "active"; } ?>menuitem"><a href="?p=merchants">Merchants</a></div>
              <!--<div class="<?php if ($page === "applications") { echo "active"; } ?>menuitem"><a href="?p=applications">Applications</a></div>-->
            <?php } ?>
            <?php if (in_array($user->getRole(), array("administrator", "merchant_admin"))) { ?>
              <div class="<?php if ($page === "users") { echo "active"; } ?>menuitem"><a href="?p=users">Users</a></div>
            <?php } ?>
            <!--<div class="<?php if ($page === "messages") { echo "active"; } ?>menuitem"><a href="?p=messages">Messages <span class="green">(1)</span></a></div>-->
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
<?php
if ($_GET['debug'] === "true" || ($_SESSION['debug'] === "true" && $_GET['debug'] !== "false")) {
  $mtime = explode(' ', microtime());
  $totaltime = $mtime[0] + $mtime[1] - $starttime;
  printf("<div style=\"background-color: #fff; color; #000; text-align: center;\">Page loaded in %.3f seconds.</div>", $totaltime);
}
?>
