<?php
if ($user->getIsLoggedIn()) {
  if ($action === "set-merchant") {
    $merchant = new Merchant($_POST['merchant']);
    $user->setMerchantId($_POST['merchant']);
    $user->save();
  }
?>
  <h1>Welcome, <?php echo $user->getFirstName(); ?>!</h1>
  <table border="0" cellpadding="0" cellspacing="0" class="edit-table">
    <tr class="tableheader">
      <th colspan="2">User Information</th>
    </tr>
    <?php if ($user->getId() == "162") { ?>
    <tr>
      <td class="edit-label">Select Merchant</td>
      <td class="edit-field">
        <form method="post" action="?a=set-merchant">
          <select name="merchant">
            <option value="73"<?php if ($user->getMerchantId() == 73) { echo " selected"; } ?>>Gino's Steakhouse (Merrillville, IN)</option>
            <option value="74"<?php if ($user->getMerchantId() == 74) { echo " selected"; } ?>>Gino's Steakhouse (Dyer, IN)</option>
            <option value="75"<?php if ($user->getMerchantId() == 75) { echo " selected"; } ?>>Jelly's Pancake House (Dyer, IN)</option>
            <option value="76"<?php if ($user->getMerchantId() == 76) { echo " selected"; } ?>>Jelly's Pancake House (Merrillville, IN)</option>
            <option value="82"<?php if ($user->getMerchantId() == 82) { echo " selected"; } ?>>Gelsosomos Pizzeria and Pub (Cedar Lake, IN)</option>
            <option value="83"<?php if ($user->getMerchantId() == 83) { echo " selected"; } ?>>Gelsosomos Pizzeria and Pub (Highland, IN)</option>
            <option value="84"<?php if ($user->getMerchantId() == 84) { echo " selected"; } ?>>Gelsosomos Pizzeria and Pub (Schererville, IN)</option>
          </select>
          <button type="submit">Go</button>
        </form>
      </td>
    </tr>
    <?php } ?>
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
