<?php
if (in_array($user->getRole(), array("administrator", "merchant_admin"))) {
  switch($action) {
    case null:
    case 'delete':
      if ($action === "delete") {
        $u = new User($_GET['id']);
        $u->delete();
        echo "<div class=\"success\"><i class=\"icon-ok\"></i> The user has been successfully deleted.</div>";
      }
  ?>
      <h1>Users</h1>
      <button type="button" class="button" onclick="document.location='?p=users&a=add'"><i class="icon-plus"></i> Add User</button>
      <table border="0" cellpadding="4" cellspacing="0" width="100%" class="edit-table">
        <tr class="tableheader">
          <th>#</th>
          <th><a href="">Email</a></th>
          <th><a href="">First Name</a></th>
          <th><a href="">Last Name</a></th>
          <th><a href="">Role</a></th>
          <th><a href="">Joined</a> <i class="icon-chevron-up"></i></th>
          <th>&nbsp;</th>
        </tr>
        <?php
        $perpage = 20;
        $index = $_GET['i'] ? $_GET['i'] : 1;
        if ($user->getRole() === "administrator") {
          $users = User::getUsers($perpage, ($index - 1) * $perpage);
        } else {
          $users = User::getUsersByMerchant($merchant->getId());
        }
        $bgclass = array("odd","even");
        $count = 0;
        foreach ($users as $u) {
        ?>
        <tr class="<?php echo $bgclass[$count % 2]; ?>">
          <td><?php echo ($count + 1); ?></td>
          <td><?php echo "<a href=\"mailto:" . $u['email'] . "\">" . $u['email'] . "</a>"; ?></td>
          <td><?php echo $u['firstname']; ?></td>
          <td><?php echo $u['lastname']; ?></td>
          <td><?php echo ucwords(preg_replace('/_/', " ", $u['role'])); ?></td>
          <td><?php echo date("F j, Y, g:i a", $u['creation']); ?></td>
          <td align="right">
            <i class="icon-pencil"></i> <a href="?p=users&a=edit&id=<?php echo $u['id']; ?>"> Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<i class="icon-remove"></i> <a href="?p=users&a=delete&id=<?php echo $u['id']; ?>">Delete</a>
          </td>
        </tr>
        <?php
          $count++;
        }
        if ($count === 0) {
          echo "<tr><td colspan=\"6\">There are currently no users.</td></tr>";
        }
        ?>
      </table>
      <button type="button" class="button" onclick="document.location='?p=users&a=add'"><i class="icon-plus"></i> Add User</button>
      <a href="?p=users&i=<?php echo ($index - 1); ?>">&laquo; Previous Page</a> Page <?php echo $index; ?> of <a href="?p=users&i=<?php echo ($index + 1); ?>">Next Page &raquo;</a>
      <?php
      break;
    case "add":
    case "edit":
      $euser = new User();
      if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $data = $_POST;
        if ($action === "add") {
          $errors = User::validate($data, $_POST['role']);
          if (count($errors) === 0) {
            User::add($data, $_POST['role']);
            echo "<div class=\"success\"><i class=\"icon-ok\"></i> User saved successfully.<br /><a href=\"?p=users\">Click here if you are done editing</a></div>";
          } else {
            echo "<div class=\"error\">";
            foreach ($errors as $error) {
              echo "<i class=\"icon-remove\"></i> " . $error . "<br />";
            }
            echo "</div>";
          }
        } else if ($action === "edit") {
          $euser = new User($_GET['id']);
        }
      }
      if ($action === "edit") {
        $euser = new User($_GET['id']);
      }
  ?>
      <h1><?php echo ucwords($action); ?> User</h1>
      <form action="" method="post">
        <table border="0" cellpadding="2" cellspacing="0" width="500" class="edit-table">
          <tr class="tableheader">
            <th colspan="2">User Information</th>
          </tr>
          <tr>
            <td class="edit-label">First Name</td>
            <td class="edit-field"><input type="text" name="firstname" value="<?php echo $_POST['firstname'] ? $_POST['firstname'] : $euser->getFirstName(); ?>" /></td>
          </tr>
          <tr>
            <td class="edit-label">Last Name</td>
            <td class="edit-field"><input type="text" name="lastname" value="<?php echo $_POST['lastname'] ? $_POST['lastname'] : $euser->getLastName(); ?>" /></td>
          </tr>
          <tr>
            <td class="edit-label">Email</td>
            <td class="edit-field"><input type="text" name="email" value="<?php echo $_POST['email'] ? $_POST['email'] : $euser->getEmail(); ?>" /></td>
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
            <td class="edit-label">GMT Offset</td>
            <td class="edit-field">
              <select>
                <option value="null">Select Offset</option>
                <?php
                for ($i = -12; $i <= 14; $i++) {
                  echo "<option value=\"" . $i . "\">" . $i . ":00</option>";
                }
                ?>
              </select><br />
              <input type="checkbox" name="dst" checked /> Daylight Savings Time
            </td>
          </tr>
          <tr>
            <td class="edit-label">Role</td>
            <td class="edit-field">
              <select name="role">
                <option value="null">Select Role</option>
                <?php
                $roles = getRoles();
                foreach ($roles as $role) {
                  echo "<option value=\"" . $role['id'] . "\"";
                  $selection = $_POST['role'] ? $_POST['role'] : $euser->getRole();
                  if ($selection === $role['role']) { echo " selected"; }
                  echo ">" . ucwords(preg_replace('/_/', " ", $role['role'])) . "</option>";
                }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td class="edit-field" colspan="2" align="right">
              <button type="submit" class="button"><i class="icon-save"></i> Save User</button>
              <button type="button" class="button" onclick="document.location='?p=users'"><i class="icon-remove-sign"></i> Cancel</button>
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
