<?php
if (in_array($user->getRole(), array("administrator", "merchant_admin", "merchant_editor", "merchant_publisher"))) {
  if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (count($errors) === 0) {
      echo "<div class=\"success\"><i class=\"icon-ok\"></i> Settings saved successfully.</div>";
    } else {
    }
  }
  ?>
      <h1>Settings</h1>
      <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        <table border="0" cellpadding="2" cellspacing="0" width="500" class="edit-table">
          <tr class="tableheader">
            <th colspan="2">User Settings</th>
          </tr>
          <tr>
            <td class="edit-label">First Name</td>
            <td class="edit-field"><input type="text" name="firstname" value="<?php echo $_POST['firstname'] ? $_POST['firstname'] : $user->getFirstName(); ?>" /></td>
          </tr>
          <tr>
            <td class="edit-label">Last Name</td>
            <td class="edit-field"><input type="text" name="lastname" value="<?php echo $_POST['lastname'] ? $_POST['lastname'] : $user->getLastName(); ?>" /></td>
          </tr>
          <tr>
            <td class="edit-label">Email</td>
            <td class="edit-field"><input type="text" name="email" value="<?php echo $_POST['email'] ? $_POST['email'] : $user->getEmail(); ?>" /></td>
          </tr>
          <tr>
            <td class="edit-label">Password</td>
            <td class="edit-field"><input type="password" name="password1" /></td>
          </tr>
          <tr>
            <td class="edit-label">Re-enter Password</td>
            <td class="edit-field"><input type="password" name="password2" /></td>
          </tr>
          <tr>
            <td class="edit-field" colspan="2" align="right">
              <input type="hidden" name="formpage" value="settings" />
              <button type="submit" class="button"><i class="icon-save"></i> Save Settings</button>
            </td>
          </tr>
        </table>
    <?php
} else {
  echo "<div class=\"error\"><i class=\"icon-remove-sign\"></i> You do not have permission to view this page.</div>";
}
