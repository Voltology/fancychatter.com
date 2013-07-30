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
        foreach ($merchants as $merch) {
        ?>
        <tr class="<?php echo $bgclass[$count % 2]; ?>">
          <td valign="top"><?php echo ($count + 1); ?></td>
          <td valign="top"><?php echo $merch['name']; ?></td>
          <td>
            <?php
            echo $merch['address1'];
            if ($merch['address2']) { echo "<br />" . $merch['address2']; }
            ?></td>
          <td valign="top"><?php echo $merch['city']; ?></td>
          <td valign="top"><?php echo strtoupper($merch['state']); ?></td>
          <td valign="top"><?php echo ucwords($merch['zipcode']); ?></td>
          <td valign="top"><?php echo ucwords($merch['phone']); ?></td>
          <td valign="top"><?php echo date("F j, Y, g:i a", $merch['creation']); ?></td>
          <td align="right" valign="top">
            <i class="icon-pencil"></i> <a href="?p=merchants&a=edit&id=<?php echo $merch['id']; ?>"> Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<i class="icon-remove"></i> <a href="#" onclick="admin.confirm('delete', 'user', '?p=users&a=delete&id=<?php echo $merch['id']; ?>')">Delete</a>
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
      $merch = new Merchant($_GET['id']);
      if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if ($action === "add") {
          $data = $_POST;
          if (!empty($_FILES['logo']['name'])) {
            $filename = slugify($_POST['name']);
            $data['logo'] = uploadImage($_FILES['logo'], $filename, $logo_path);
          }
          $errors = $merch->validate($action, $data);
          if (count($errors) === 0) {
            $mid = $merch->add($data);
            $data = $_POST;
            $uid = User::add($data, "merchant_admin");
            echo "<div class=\"success\"><i class=\"icon-ok\"></i> Merchant added successfully.</div>";
          } else {
            echo "<div class=\"error\">";
            foreach ($errors as $error) {
              echo "<i class=\"icon-remove\"></i> " . $error . "<br />";
            }
            echo "</div>";
          }
        } else if ($action === "edit") {
          $data = $_POST;
          if (!empty($_FILES['logo']['name'])) {
            $filename = slugify($_POST['name']);
            $data['logo'] = uploadImage($_FILES['logo'], $filename, $logo_path);
          }
          $errors = $merch->validate($action, $data);
          if (count($errors) === 0) {
            $merch->update($data);
            echo "<div class=\"success\"><i class=\"icon-ok\"></i> Merchant saved successfully.</div>";
          } else {
            echo "<div class=\"error\">";
            foreach ($errors as $error) {
              echo "<i class=\"icon-remove\"></i> " . $error . "<br />";
            }
            echo "</div>";
          }
        }
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
            <td class="edit-field"><input type="text" name="name" value="<?php echo $_POST['name'] ? $_POST['name'] : $merch->getName(); ?>" /></td>
          </tr>
          <tr>
            <td class="edit-label">Logo</td>
            <td class="edit-field">
              <input type="file" name="logo" /><br />
              <?php if ($merch->getLogo() || $data['logo']) { ?>
              <img src="<?php echo $logo_path;  echo $data['logo'] ? $data['logo'] : $merch->getLogo(); ?>" height="100" />
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
                  $cat = $_POST['category'] ? $_POST['category'] : $merch->getCategory();
                  echo "<option value=\"" . $category['id'] . "\"";
                  if ($cat === $category['id']) { echo " selected"; }
                  echo ">" . $category['category'] . "</option>";
                }
                ?>
              </select>
            </td>
          </tr>
          <?php
          if ($action === "add") {
          ?>
          <tr>
            <td class="edit-label">Admin First Name</td>
            <td class="edit-field"><input type="text" name="firstname" value="<?php echo $_POST['firstname'] ? $_POST['firstname'] : $merch->getFirstName(); ?>" /></td>
          </tr>
          <tr>
            <td class="edit-label">Admin Last Name</td>
            <td class="edit-field"><input type="text" name="lastname" value="<?php echo $_POST['lastname'] ? $_POST['lastname'] : $merch->getLastName(); ?>" /></td>
          </tr>
          <tr>
            <td class="edit-label">Admin Email</td>
            <td class="edit-field"><input type="text" name="email" value="<?php echo $_POST['email'] ? $_POST['email'] : $merch->getEmail(); ?>" /></td>
          </tr>
          <tr>
            <td class="edit-label">Admin Password</td>
            <td class="edit-field"><input type="password" name="password1" /></td>
          </tr>
          <tr>
            <td class="edit-label">Admin Re-enter Password</td>
            <td class="edit-field"><input type="password" name="password2" /></td>
          </tr>
          <?php
          }
          ?>
          <tr>
            <td class="edit-label">Address Line 1</td>
            <td class="edit-field"><input type="text" name="address1" value="<?php echo $_POST['address1'] ? $_POST['address1'] : $merch->getAddress1(); ?>" /></td>
          </tr>
          <tr>
            <td class="edit-label">Address Line 2</td>
            <td class="edit-field"><input type="text" name="address2" value="<?php echo $_POST['address2'] ? $_POST['address2'] : $merch->getAddress2(); ?>" /></td>
          </tr>
          <tr>
            <td class="edit-label">City</td>
            <td class="edit-field"><input type="text" name="city" value="<?php echo $_POST['city'] ? $_POST['city'] : $merch->getCity(); ?>" /></td>
          </tr>
          <tr>
            <td class="edit-label">State</td>
            <td class="edit-field">
              <select name="state">
                <option>Select State</option>
                <?php
                $states = getStates();
                foreach ($states as $state) {
                  echo "<option value=\"" . $state['state'] . "\"";
                  $selection = $data['state'] ? $data['state'] : $merch->getState();
                  if ($selection === $state['state']) { echo " selected"; }
                  echo ">" . strtoupper($state['state']) . "</option>";
                }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td class="edit-label">Zip Code</td>
            <td class="edit-field"><input type="text" name="zipcode" value="<?php echo $_POST['zipcode'] ? $_POST['zipcode'] : $merch->getZipCode(); ?>" /></td>
          </tr>
          <!--
          <tr>
            <td class="edit-label">Country</td>
            <td class="edit-field">
              <select>
                <option>Select Country</option>
              </select>
            </td>
          </tr>
          -->
          <tr>
            <td class="edit-label">Phone</td>
            <td class="edit-field"><input type="text" name="phone" value="<?php echo $_POST['phone'] ? $_POST['phone'] : $merch->getPhone(); ?>" /></td>
          </tr>
          <tr>
            <td class="edit-label">Latitude</td>
            <td class="edit-field"><input type="text" name="latitude" value="<?php echo $_POST['latitude'] ? $_POST['latitude'] : $merch->getLatitude(); ?>" /></td>
          </tr>
          <tr>
            <td class="edit-label">Longitude</td>
            <td class="edit-field"><input type="text" name="longitude" value="<?php echo $_POST['longitude'] ? $_POST['longitude'] : $merch->getLongitude(); ?>" /></td>
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
