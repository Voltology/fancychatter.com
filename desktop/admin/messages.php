<?php
if (in_array($user->getRole(), array("administrator", "merchant_admin", "merchant_publisher", "merchant_editor"))) {
  switch($action) {
    case null:
    ?>
      <h1>Messages</h1>
      <button type="button" class="button" onclick="document.location='?p=messages&a=compose'"><i class="icon-plus"></i> Compose New Message</button>
      <table border="0" cellpadding="4" cellspacing="0" width="100%" class="edit-table">
        <tr class="tableheader">
          <th>#</th>
          <th><a href="">Subject</a></th>
          <th><a href="">From</a></th>
          <th><a href="">Received</a></th>
          <th>&nbsp;</th>
        </tr>
      </table>
      <button type="button" class="button" onclick="document.location='?p=messages&a=compose'"><i class="icon-plus"></i> Compose New Message</button>
    <?php
      break;
    default:
      echo "<div class=\"error\"><i class=\"icon-remove-sign\"></i> You do not have permission to view this page.</div>";
      break;
  }
} else {
  echo "<div class=\"error\"><i class=\"icon-remove-sign\"></i> You do not have permission to view this page.</div>";
}
?>
