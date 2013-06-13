<?php
if ($user->getIsLoggedIn()) {
?>
  <h1>Welcome, <?php echo $user->getFirstName(); ?>!</h1>
  <table border="0" cellpadding="0" cellspacing="0" class="edit-table">
    <tr class="tableheader">
      <th colspan="2">User Information</th>
    </tr>
    <tr>
      <td class="edit-label">Member Since</td>
      <td class="edit-field"><?php echo date("m/d/Y h:i", $user->getCreation()); ?></td>
    </tr>
    <tr>
      <td class="edit-label">Email</td>
      <td class="edit-field"><?php echo $user->getEmail(); ?></td>
    </tr>
    <tr>
      <td class="edit-label">First Name</td>
      <td class="edit-field"><?php echo $user->getFirstName(); ?></td>
    </tr>
    <tr>
      <td class="edit-label">Last Name</td>
      <td class="edit-field"><?php echo $user->getLastName(); ?></td>
    </tr>
    <tr>
      <td class="edit-label">Role</td>
      <td class="edit-field"><?php echo ucwords(preg_replace('/_/', " ", $user->getRole())); ?></td>
    </tr>
  </table>
  <i class="icon-pencil"></i> <a href="?p=settings">Edit Settings</a>
<?php
} else {
  if ($_GET['error'] === "true") {
    echo "<div class=\"error\"><i class=\"icon-remove\"></i> Username/password incorrect.</div>";
  }
?>
  <h1>Log In</h1>
  <form method="post" action="/login.php">
    <table border="0" cellpadding="0" cellspacing="0" class="edit-table">
      <tr class="tableheader">
        <th colspan="2">User Information</th>
      </tr>
      <tr>
        <td class="edit-label">Email</td>
        <td class="edit-field"><input type="text" name="email" /></td>
      </tr>
      <tr>
        <td class="edit-label">Password</td>
        <td class="edit-field"><input type="password" name="password" /></td>
      </tr>
      <tr>
        <td class="edit-field" colspan="2" align="right">
          <input type="hidden" name="logintype" value="admin" />
          <button type="submit" class="button"><i class="icon-arrow-up"></i> Log In</button>
        </td>
      </tr>
    </table>
  </form>
<?php
}
?>
