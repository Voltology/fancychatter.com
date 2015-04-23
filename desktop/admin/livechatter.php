<?php
if (in_array($user->getRole(), array("administrator", "merchant_admin", "merchant_editor"))) {
  switch ($action) {
    case null:
    case "activate":
    case "add":
    case "deactivate":
    case "delete":
    case "edit":
    case "pause":
    case "save":
      if (count($errors) > 0) {
        echo "<div class=\"error\">";
        foreach ($errors as $error) {
          echo "<i class=\"icon-remove\"></i> " . $error . "<br />";
        }
        echo "</div>";
      } else {
        if ($action === "activate") {
          echo "<div class=\"success\"><i class=\"icon-ok\"></i> The LiveChatter has been activated.</div>";
        } else if ($action === "deactivate") {
          echo "<div class=\"success\"><i class=\"icon-ok\"></i> The LiveChatter has been deactivated.</div>";
        } else if ($action === "delete") {
          echo "<div class=\"success\"><i class=\"icon-ok\"></i> The LiveChatter has been deleted.</div>";
        } else if ($action === "pause") {
          echo "<div class=\"success\"><i class=\"icon-ok\"></i> The LiveChatter has been paused.</div>";
        }
      }
      $livechatter = LiveChatter::getByMerchantId($user->getMerchantId());
      ?>
      <h1>LiveChatter</h1>
      <form enctype="multipart/form-data" action="<? echo $_SERVER['REQUEST_URI']; ?>" method="POST">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="container-table">
          <tr>
            <td valign="top" width="40%">
              <table border="0" cellpadding="4" cellspacing="0" width="100%" class="edit-table">
                <tr class="tableheader">
                  <th colspan="2">Compose New LiveChatter</th>
                </tr>
                <tr>
                  <td class="edit-label" width="100">Body</td>
                  <td class="edit-field">
                    <textarea name="body" class="livechatter-body"><?php if (count($errors) > 0) { echo $_POST['body']; } else if ($action === "edit" && $lc->getId()) { echo $lc->getBody(); } ?></textarea>
                  </td>
                </tr>
                <tr>
                  <td class="edit-label">Start Time</td>
                  <td class="edit-field">
                    <input type="text" class="field-time" id="startdate" name="startdate" value="<?php if (count($errors) > 0) { echo $_POST['startdate']; } else if ($action === "edit" && $lc->getId()) { echo date("m/d/Y h:i", $lc->getStartTime()); } ?>" placeholder="Enter start time" />
                    <select name="starttime-hour" style="vertical-align: middle; width: 50px;">
                      <?php for ($i = 1; $i <= 12; $i++) { ?>
                        <option value="<?php echo $i; ?>"<?php echo $i == preg_replace('/^0/', "", date("h")) ? " selected" : ""; ?>><?php echo strlen($i) === 1 ? "0" . $i : $i; ?></option>
                      <?php } ?>
                    </select><strong>&nbsp;:</strong>
                    <select name="starttime-minute" style="width: 50px;">
                      <?php for ($i = 0; $i <= 59; $i++) { ?>
                        <option value="<?php echo $i; ?>"<?php echo $i == preg_replace('/^0/', "", date("i")) ? " selected" : ""; ?>><?php echo strlen($i) === 1 ? "0" . $i : $i; ?></option>
                      <?php } ?>
                    </select>
                    <select name="starttime-suffix" style="width: 50px;">
                      <option value="am"<?php echo date("a") === "am" ? " selected" : ""; ?>>AM</option>
                      <option value="pm"<?php echo date("a") === "pm" ? " selected" : ""; ?>>PM</option>
                    </select>
                    <!--<input type="checkbox" name="now" value="true" /> <span><strong>Now</strong></span>-->
                  </td>
                </tr>
                <tr>
                  <td class="edit-label">End Time</td>
                  <td class="edit-field">
                    <input type="text" class="field-time" id="enddate" name="enddate" value="<?php if (count($errors) > 0) { echo $_POST['enddate']; } else if ($action === "edit" && $lc->getId()) { echo date("m/d/Y h:i", $lc->getEndTime()); } ?>" placeholder="Enter end time" />
                    <select name="endtime-hour" style="vertical-align: middle; width: 50px;">
                      <?php for ($i = 1; $i <= 12; $i++) { ?>
                        <option value="<?php echo $i; ?>"<?php echo $i == preg_replace('/^0/', "", date("h")) ? " selected" : ""; ?>><?php echo strlen($i) === 1 ? "0" . $i : $i; ?></option>
                      <?php } ?>
                    </select><strong>&nbsp;:</strong>
                    <select name="endtime-minute" style="width: 50px;">
                      <?php for ($i = 0; $i <= 59; $i++) { ?>
                        <option value="<?php echo $i; ?>"<?php echo $i == preg_replace('/^0/', "", date("i")) ? " selected" : ""; ?>><?php echo strlen($i) === 1 ? "0" . $i : $i; ?></option>
                      <?php } ?>
                    </select>
                    <select name="endtime-suffix" style="width: 50px;">
                      <option value="am"<?php echo date("a") === "am" ? " selected" : ""; ?>>AM</option>
                      <option value="pm"<?php echo date("a") === "pm" ? " selected" : ""; ?>>PM</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="edit-field" colspan="2" align="right">
                    <?php if ($action === "edit" && $lc->getId()) { ?>
                    <input type="hidden" name="a" value="id" />
                    <input type="hidden" name="a" value="edit" />
                    <?php } else { ?>
                    <input type="hidden" name="a" value="add" />
                    <?php } ?>
                    <input type="hidden" name="formpage" value="livechatter" />
                    <button type="submit" class="button"><i class="icon-save"></i> Save LiveChatter</button>
                  </td>
                </tr>
              </table>
            </td>
            <td valign="top" width="50%">
              <table border="0" cellpadding="4" cellspacing="0" width="100%" class="edit-table">
                <tr class="tableheader">
                  <th colspan="2">Active LiveChatter</th>
                </tr>
                <?php
                $count = 0;
                foreach ($livechatter as $chatter) {
                  if ($chatter['status'] === "activated" && (time() + $user->getGmtOffset() > $chatter['starttime'] && time() + $user->getGmtOffset() < $chatter['endtime'])) {
                ?>
                  <tr class="livechatter">
                    <td align="center" valign="top" width="20">
                      <img src="/img/bullet_green.png" />
                    </td>
                    <td>
                      <strong>Message: </strong> <?php echo $chatter['body']; ?><br />
                      <strong>Start Date: </strong> <?php echo date("F j, Y, g:i a", $chatter['starttime']); ?><br />
                      <strong>End Date: </strong> <?php echo date("F j, Y, g:i a", $chatter['endtime']); ?>
                    </td>
                  </tr>
                  <tr class="livechatter-controls">
                    <td align="right" colspan="2"><!--<i class="icon-pencil"> <a href="?p=livechatter&formpage=livechatter&a=edit&id=<?php echo $chatter['id']; ?>">Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;--><i class="icon-pause"> <a href="?p=livechatter&formpage=livechatter&a=pause&id=<?php echo $chatter['id']; ?>">Pause</a></td>
                  </tr>
                <?php
                    $count++;
                  }
                }
                if ($count === 0) {
                ?>
                <tr>
                  <td align="center" colspan="2">You do not currently have any active LiveChatter</td>
                </tr>
                <?php
                }
                ?>
              </table>
              <table border="0" cellpadding="4" cellspacing="0" width="100%" class="edit-table">
                <tr class="tableheader">
                  <th colspan="2">Queued/Paused LiveChatter</th>
                </tr>
                <?php
                $count = 0;
                foreach ($livechatter as $chatter) {
                  if ($chatter['status'] !== "activated" || (time() + $user->getGmtOffset() < $chatter['starttime'] || time() + $user->getGmtOffset() > $chatter['endtime'])) {
                ?>
                  <tr class="livechatter">
                    <td align="center" valign="top" width="20">
                      <?php if ($chatter['status'] === "paused") { ?>
                      <img src="/img/bullet_yellow.png" />
                      <?php } else if ($chatter['status'] === "deactivated") { ?>
                      <img src="/img/bullet_red.png" />
                      <?php } ?>
                    </td>
                    <td>
                      <strong>Message: </strong> <?php echo $chatter['body']; ?><br />
                      <strong>Start Date: </strong> <?php echo date("F j, Y, g:i a", $chatter['starttime']); ?><br />
                      <strong>End Date: </strong> <?php echo date("F j, Y, g:i a", $chatter['endtime']); ?>
                    </td>
                  </tr>
                  <tr class="livechatter-controls">
                    <td align="right" colspan="2">
                      <i class="icon-pencil"> <a href="?p=livechatter&formpage=livechatter&&a=edit&id=<?php echo $chatter['id']; ?>">Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                      <i class="icon-play"> <a href="?p=livechatter&formpage=livechatter&a=activate&id=<?php echo $chatter['id']; ?>">Activate</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                      <i class="icon-remove"></i> <a href="?p=livechatter&formpage=livechatter&a=delete&id=<?php echo $chatter['id']; ?>">Delete</a></td>
                  </tr>
                <?php
                    $count++;
                  }
                }
                if ($count++ === 0) {
                ?>
                <tr>
                  <td align="center" colspan="2">You do not currently have any queued/paused LiveChatter</td>
                </tr>
                <?php
                }
                ?>
              </table>
            </td>
          </tr>
        </table>
      </form>
      <?
      break;
    default:
      echo "<div class=\"error\"><i class=\"icon-remove-sign\"></i> You do not have permission to view this page.</div>";
      break;
  }
} else {
  echo "<div class=\"error\"><i class=\"icon-remove-sign\"></i> You do not have permission to view this page.</div>";
}
?>
