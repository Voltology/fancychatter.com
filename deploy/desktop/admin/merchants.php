<?php
if (in_array($user->getRole(), array("administrator"))) {
  switch($action) {
    case null:
    case 'delete':
      if ($action === "delete") {
        Merchant::delete($_GET['id']);
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
          <th><a href="">Address</a></th>
          <th><a href="">City</a></th>
          <th><a href="">State</a></th>
          <th><a href="">Zip Code</a></th>
          <th><a href="">Phone</a></th>
          <th><a href="">Joined</a> <i class="icon-chevron-up"></i></th>
          <th>&nbsp;</th>
        </tr>
        <?php
        $merchants = Merchant::getMerchants();
        $bgclass = array("odd","even");
        $count = 0;
        foreach ($merchants as $merchant) {
        ?>
        <tr class="<?php echo $bgclass[$count % 2]; ?>">
          <td valign="top"><?php echo ($count + 1); ?></td>
          <td valign="top"><?php echo $merchant['name']; ?></td>
          <td valign="top"><?php echo "<a href=\"mailto:" . $merchant['contact_email'] . "\">" . $merchant['contact_email'] . "</a>"; ?></td>
          <td>
            <?php
            echo $merchant['address1'];
            if ($merchant['address2']) { echo "<br />" . $merchant['address2']; }
            ?></td>
          <td valign="top"><?php echo $merchant['city']; ?></td>
          <td valign="top"><?php echo $merchant['state']; ?></td>
          <td valign="top"><?php echo ucwords($merchant['zipcode']); ?></td>
          <td valign="top"><?php echo ucwords($merchant['phone']); ?></td>
          <td valign="top"><?php echo date("F j, Y, g:i a", $merchant['creation']); ?></td>
          <td align="right" valign="top">
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
      $logo_path = "../uploads/logos/";
      $merchant = new Merchant($_GET['id']);
      if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if ($action === "add") {
          if (!empty($_FILES['logo']['name'])) {
            $filename = slugify($_POST['name']);
            $file = uploadImage($_FILES['logo'], $filename, $logo_path);
          }
          $errors = Merchant::validate($_POST['name'], $file, $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password1'], $_POST['password2'], $_POST['role']);
          if (count($errors) === 0) {
            $mid = Merchant::add($_POST['name'], $file, $_POST['latitude'], $_POST['longitude']);
            $uid = User::add($_POST['email'], $_POST['password1'], $_POST['firstname'], $_POST['lastname'], "merchant_admin");
            echo "<div class=\"success\"><i class=\"icon-ok\"></i> Merchant added successfully.</div>";
          } else {
            echo "<div class=\"error\"><i class=\"icon-remove\"></i></div>";
          }
        } else if ($action === "edit") {
          if (!empty($_FILES['logo']['name'])) {
            $filename = slugify($_POST['name']);
            $file = uploadImage($_FILES['logo'], $filename, $logo_path);
          }
          $errors = Merchant::validate($_POST['name'], $file, $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password1'], $_POST['password2'], $_POST['role']);
          if (count($errors) === 0) {
            $merchant->setName($_POST['name']);
            $merchant->setLogo($file);
            $merchant->save();
            echo "<div class=\"success\"><i class=\"icon-ok\"></i> Merchant saved successfully.</div>";
          } else {
            echo "<div class=\"error\">";
            foreach ($errors as $error) {
              echo "<i class=\"icon-remove\"></i> " . $error . "<br />";
            }
            echo "</div>";
          }
        }
      } else if ($action === "edit") {
        $merchant = new Merchant($_GET['id']);
      }
  ?>
      <h1><?php echo ucwords($action); ?> Merchant</h1>
      <form action="" method="post" enctype="multipart/form-data">
        <table border="0" cellpadding="2" cellspacing="0" width="500" class="edit-table">
          <tr class="tableheader">
            <th colspan="2">Merchant Information</th>
          </tr>
          <tr>
            <td class="edit-label">Merchant Name</td>
            <td class="edit-field"><input type="text" name="name" value="<?php echo $_POST['name'] ? $_POST['name'] : $merchant->getName(); ?>" /></td>
          </tr>
          <tr>
            <td class="edit-label">Logo</td>
            <td class="edit-field">
              <input type="file" name="logo" /><br />
              <?php if ($merchant->getLogo()) { ?>
              <img src="<?php echo $logo_path . $merchant->getLogo(); ?>" height="100" />
              <?php } ?>
            </td>
          </tr>
          <tr>
            <td class="edit-label">Category</td>
            <td class="edit-field">
              <select name="category">
                <?php
                $categories = getCategories();
                foreach ($categories as $category) {
                  echo "<option value=\"" . $category['id'] . "\">" . $category['category'] . "</option>";
                }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td class="edit-label">Admin First Name</td>
            <td class="edit-field"><input type="text" name="firstname" value="<?php echo $_POST['firstname'] ? $_POST['firstname'] : ""; ?>" /></td>
          </tr>
          <tr>
            <td class="edit-label">Admin Last Name</td>
            <td class="edit-field"><input type="text" name="lastname" value="<?php echo $_POST['lastname'] ? $_POST['lastname'] : ""; ?>" /></td>
          </tr>
          <tr>
            <td class="edit-label">Admin Email</td>
            <td class="edit-field"><input type="text" name="email" value="<?php echo $_POST['email'] ? $_POST['email'] : ""; ?>" /></td>
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
            <td class="edit-field"><input type="text" name="address1" value="<?php echo $_POST['address1'] ? $_POST['address1'] : ""; ?>" /></td>
          </tr>
          <tr>
            <td class="edit-label">Address Line 2</td>
            <td class="edit-field"><input type="text" name="address2" value="<?php echo $_POST['address2'] ? $_POST['address2'] : ""; ?>" /></td>
          </tr>
          <tr>
            <td class="edit-label">City</td>
            <td class="edit-field"><input type="text" name="city" value="<?php echo $_POST['city'] ? $_POST['city'] : ""; ?>" /></td>
          </tr>
          <tr>
            <td class="edit-label">State</td>
            <td class="edit-field">
              <select>
                <option>Select State</option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="edit-label">Zip</td>
            <td class="edit-field"><input type="text" name="zipcode" value="<?php echo $_POST['zipcode'] ? $_POST['zipcode'] : ""; ?>" /></td>
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
            <td class="edit-field"><input type="text" name="phone" value="<?php echo $_POST['phone'] ? $_POST['phone'] : ""; ?>" /></td>
          </tr>
          <tr>
            <td class="edit-field" colspan="2" align="right">
              <?php if ($_GET['a'] === "add") { ?>
              <input type="hidden" name="a" value="add" />
              <?php } else if ($_GET['a'] === "edit") { ?>
              <input type="hidden" name="a" value="edit" />
              <?php } ?>
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
