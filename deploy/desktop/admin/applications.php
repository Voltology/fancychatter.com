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
      <h1>Applications</h1>
      <button type="button" class="button" onclick="document.location='?p=merchants&a=add'"><i class="icon-plus"></i> Add Application</button>
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
        $applications = Application::getAll();
        $bgclass = array("odd","even");
        $count = 0;
        foreach ($applications as $application) {
        ?>
        <tr class="<?php echo $bgclass[$count % 2]; ?>">
          <td valign="top"><?php echo ($count + 1); ?></td>
          <td valign="top"><?php echo $applications['name']; ?></td>
          <td valign="top"><?php echo "<a href=\"mailto:" . $application['contact_email'] . "\">" . $application['contact_email'] . "</a>"; ?></td>
          <td>
            <?php
            echo $application['address1'];
            if ($application['address2']) { echo "<br />" . $application['address2']; }
            ?></td>
          <td valign="top"><?php echo $application['city']; ?></td>
          <td valign="top"><?php echo $application['state']; ?></td>
          <td valign="top"><?php echo ucwords($application['zipcode']); ?></td>
          <td valign="top"><?php echo ucwords($application['phone']); ?></td>
          <td valign="top"><?php echo date("F j, Y, g:i a", $application['creation']); ?></td>
          <td align="right" valign="top">
            <i class="icon-pencil"></i> <a href="?p=applications&a=edit&id=<?php echo $application['id']; ?>"> Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<i class="icon-remove"></i> <a href="#" onclick="admin.confirm('delete', 'user', '?p=users&a=delete&id=<?php echo $application['id']; ?>')">Delete</a>
          </td>
        </tr>
        <?php
          $count++;
        }
        if ($count === 0) {
          echo "<tr><td colspan=\"6\" align=\"center\">There are currently no applications.</td></tr>";
        }
        ?>
      </table>
      <button type="button" class="button" onclick="document.location='?p=applications&a=add'"><i class="icon-plus"></i> Add Application</button>
      <?php
      break;
    case "add":
    case "edit":
      $logo_path = "../uploads/logos/";
      $merch = new Merchant($_GET['id']);
      if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if ($action === "add") {
          if (!empty($_FILES['logo']['name'])) {
            $filename = slugify($_POST['name']);
            $file = uploadImage($_FILES['logo'], $filename, $logo_path);
          }
          $errors = $merch->validate($action, $_POST['name'], $file, $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password1'], $_POST['password2'], $_POST['role']);
          if (count($errors) === 0) {
            $mid = $merch->add($_POST['name'], $_POST['category'], $file, $_POST['latitude'], $_POST['longitude'], $_POST['address1'], $_POST['address2'], $_POST['city'], $_POST['state'], $_POST['zipcode']);
            $uid = User::add($_POST['email'], $_POST['password1'], $_POST['firstname'], "merchant_admin");
            echo "<div class=\"success\"><i class=\"icon-ok\"></i> Merchant added successfully.</div>";
          } else {
            echo "<div class=\"error\">";
            foreach ($errors as $error) {
              echo "<i class=\"icon-remove\"></i> " . $error . "<br />";
            }
            echo "</div>";
          }
        } else if ($action === "edit") {
          if (!empty($_FILES['logo']['name'])) {
            $filename = slugify($_POST['name']);
            $file = uploadImage($_FILES['logo'], $filename, $logo_path);
          }
          $errors = $merch->validate($action, $_POST['name'], $file, $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password1'], $_POST['password2'], $_POST['role']);
          if (count($errors) === 0) {
            $merch->setName($_POST['name']);
            $merch->setCategory($_POST['category']);
            $merch->setLogo($file);
            $merch->save();
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
              <?php if ($merch->getLogo()) { ?>
              <img src="<?php echo $logo_path . $merch->getLogo(); ?>" height="100" />
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
                var_dump($states);
                foreach ($states as $state) {
                  echo "<option value=\"" . $state['state'] . "\"";
                  if ($merch->getState() === $state['state']) { echo " selected"; }
                  echo ">" . strtoupper($state['state']) . "</option>";
                }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td class="edit-label">Zip</td>
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
