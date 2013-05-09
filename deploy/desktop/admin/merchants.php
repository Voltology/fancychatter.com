<?php
if (in_array($user->getRole(), array("administrator"))) {
  switch($action) {
    case null:
    case 'delete':
      if ($action === "delete") {
        Merchant::deleteMerchantById($_GET['id']);
        echo "<div class=\"success\"><i class=\"icon-ok\"></i> The user has been successfully deleted.</div>";
      }
  ?>
      <h1>Merchants</h1>
      <button type="button" class="button" onclick="document.location='?p=merchants&a=add'"><i class="icon-plus"></i> Add Merchant</button>
      <table border="0" cellpadding="4" cellspacing="0" width="100%" class="edit-table">
        <tr class="tableheader">
          <th>#</th>
          <th><a href="">Merchant</a></th>
          <th><a href="">Contat Email</a></th>
          <th><a href="">Last Name</a></th>
          <th><a href="">Role</a></th>
          <th><a href="">Joined</a> <i class="icon-chevron-up"></i></th>
          <th>&nbsp;</th>
        </tr>
        <?php
        $merchants = Merchant::getMerchants();
        $bgclass = array("odd","even");
        $count = 0;
        foreach ($merchants as $u) {
        ?>
        <tr class="<?php echo $bgclass[$count % 2]; ?>">
          <td><?php echo ($count + 1); ?></td>
          <td><?php echo "<a href=\"mailto:" . $merchant['email'] . "\">" . $merchant['email'] . "</a>"; ?></td>
          <td><?php echo $merchant['firstname']; ?></td>
          <td><?php echo $merchant['lastname']; ?></td>
          <td><?php echo ucwords($merchant['role']); ?></td>
          <td><?php echo date("F j, Y, g:i a", $merchant['creation']); ?></td>
          <td align="right">
            <i class="icon-pencil"></i> <a href="?p=merchants&a=edit&id=<?php echo $merchant['id']; ?>"> Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<i class="icon-remove"></i> <a href="#" onclick="admin.confirm('delete', 'user', '?p=users&a=delete&id=<?php echo $merchant['id']; ?>')">Delete</a>
          </td>
        </tr>
        <?php
          $count++;
        }
        if ($count === 0) {
          echo "<tr><td colspan=\"6\" align=\"center\">There are currently no merchants.</td></tr>";
        }
        ?>
      </table>
      <button type="button" class="button" onclick="document.location='?p=merchants&a=add'"><i class="icon-plus"></i> Add Merchant</button>
      <?php
      break;
    case "add":
    case "edit":
      if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if ($action === "add") {
          Merchant::addMerchant($brand, $_POST['email'], $_POST['password'], $_POST['firstname'], $_POST['lastname'], 2);
          echo "<div class=\"success\"><i class=\"icon-ok\"></i> Merchant saved successfully.</div>";
        } else if ($action === "edit") {
          $merchant = new Merchant;
          $merchant->setMerchantById($_GET['id']);
        }
      }
  ?>
      <h1><?php echo ucwords($action); ?> Merchant</h1>
      <form action="" method="post">
        <table border="0" cellpadding="2" cellspacing="0" width="500" class="edit-table">
          <tr class="tableheader">
            <th colspan="2">Merchant Information</th>
          </tr>
          <tr>
            <td class="edit-label">Merchant Name</td>
            <td class="edit-field"><input type="text" name="name" value="<?php echo $_POST['name'] ? $_POST['name'] : $merchant['name']; ?>" /></td>
          </tr>
          <tr>
            <td class="edit-label">Admin Email</td>
            <td class="edit-field"><input type="text" name="email" value="<?php echo $_POST['email'] ? $_POST['email'] : $merchant['email']; ?>" /></td>
          </tr>
          <tr>
            <td class="edit-label">Admin Password</td>
            <td class="edit-field"><input type="password" name="password1" /></td>
          </tr>
          <tr>
            <td class="edit-label">Admin Re-enter Password</td>
            <td class="edit-field"><input type="password" name="password2" /></td>
          </tr>
          <tr>
            <td class="edit-label">Address Line 1</td>
            <td class="edit-field"><input type="text" name="address1" /></td>
          </tr>
          <tr>
            <td class="edit-label">Address Line 2</td>
            <td class="edit-field"><input type="text" name="address2" /></td>
          </tr>
          <tr>
            <td class="edit-label">City</td>
            <td class="edit-field"><input type="text" name="city" /></td>
          </tr>
          <tr>
            <td class="edit-label">State</td>
            <td class="edit-field"><input type="text" name="state" /></td>
          </tr>
          <tr>
            <td class="edit-label">Zip</td>
            <td class="edit-field"><input type="text" name="zipcode" /></td>
          </tr>
          <tr>
            <td class="edit-label">Country</td>
            <td class="edit-field">
              <select>
                <option>Select Country</option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="edit-label">Phone</td>
            <td class="edit-field"><input type="text" name="phone" /></td>
          </tr>
          <tr>
            <td class="edit-field" colspan="2" align="right">
              <button type="submit" class="button"><i class="icon-save"></i> Save Merchant</button>
              <button type="button" class="button" onclick="document.location='?p=merchants'"><i class="icon-remove-sign"></i> Cancel</button>
            </td>
          </tr>
        </table>
    <?php
      break;
    default:
      echo "<div class=\"error\"><i class=\"icon-remove-sign\"></i> You do not have permission to view this page.</div>";
      break;
  }
} else {
  echo "<div class=\"error\"><i class=\"icon-remove-sign\"></i> You do not have permission to view this page.</div>";
}
