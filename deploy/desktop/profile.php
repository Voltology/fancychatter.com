<?php
include("header.php");
$action = $_GET['a'] ? $_GET['a'] : null;
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  ChitChat::respond($_POST['cc-id'], $user->getId(), null, $_POST['body']);
}
?>
<div class="row-fluid">
  <div class="span4">
    <div class="row-fluid">
      <div class="span6">
        <div class="profile-image" style="border: 1px solid #ccc; width: 100%;">
          <img src="/uploads/profile/<?php echo $user->getProfileImage() !== "" ? $user->getProfileImage() : "default.png"; ?>" />
        </div>
      </div>
      <div class="span6">
        <div class="profile-data">
          <h4 style="margin: 0;"><?php echo $user->getFirstName(); ?> <?php echo $user->getLastName(); ?></h4>
          <p><?php echo $user->getCity(); ?>, <?php echo strtoupper($user->getState()); ?></p>
          <?php if ($action === "edit") { ?>
          <p><a href="/profile">Back to Profile</a></p>
          <?php } else { ?>
          <p><i class="icon-pencil"></i> <a href="?a=edit">Edit Profile</a></p>
          <?php } ?>
          <button type="button" class="btn btn-mini btn-success search-btn"><i class="icon-plus" style="vertical-align: bottom;"></i> Follow</button>
        </div>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
        <div class="profile-recent-activity" style="width: 100%; min-height: 400px;">
          <h4>My Favorite Five</h4>
          <?php
          $searches = $user->getSavedSearches();
          foreach ($searches as $search) {
            echo "<input type=\"checkbox\" checked />&nbsp;";
            echo "<a href=\"/livechatter?where=" . $search['location'] . "&what=" . $search['category_id'] . "&distance=" . $search['distance'] . "\"><strong>" . $search['category'] . "</strong><br />Within " . $search['distance'] . " miles of " . $search['location'] . "</a><br />";
          }
          ?>
          <!--<h4>Recent Activity</h4>-->
        </div>
      </div>
    </div>
  </div>
  <div class="span8">
    <?php
    switch($action) {
      case null:
      case "delete":
        if ($action === "delete") {
          $chitchat = new ChitChat($_GET['id']);
          $chitchat->delete();
        }
    ?>
    <h4>Your Recent ChitChats</h4>
    <div class="chitchat">
      <?php
      $chitchats = ChitChat::getByUserId($user->getId());
      foreach ($chitchats as $chitchat) {
      ?>
      <ul style="margin: 0; list-style-type: none; padding: 5px;">
        <li style="display: inline-block; width: 13%; vertical-align: top; margin-right: 5px;">
          <div style="min-height: 8px; height: 80px; width: 80px; border: 1px solid #ccc; overflow: hidden;">
            <img src="/uploads/profile/<?php echo $user->getProfileImage() !== "" ? $user->getProfileImage() : "default.png"; ?>" />
          </div>
        </li>
        <li style="display: inline-block; min-height: 84px; width: 84%; position: relative; border-bottom: 1px solid #ccc; padding-bottom: 5px;">
          <div style="position: absolute; top: 0px; right: 5px; cursor: pointer;" onclick="document.location='?a=delete&id=<?php echo $chitchat['id']; ?>'"><i class="icon-remove"></i></div>
          <strong><?php echo $user->getFirstName(); ?> <?php echo $user->getLastName(); ?></strong><br />
          <div style="color: #aaa; font-style: italic; margin-top: -6px;">Sent to Automotive within 25 miles of 60611</div>
          <?php echo $chitchat['body']; ?>
          <div style="position: absolute; top: 0px; right: 25px; color: #666;"><?php echo date("F j, Y, g:i a", $chitchat['creation']); ?></div>
        </li>
      </ul>
      <?php
        $responses = ChitChat::getResponsesById($chitchat['id']);
        foreach ($responses as $response) {
        ?>
        <ul>
          <li style="list-style-type: none;">
            <ul style="margin-left: 13%; list-style-type: none; border-bottom: 1px solid #ccc; padding: 5px;">
              <li style="display: inline-block; width: 16%; vertical-align: top; margin-right: 5px;">
                <div style="min-height: 8px; height: 80px; width: 80px; border: 1px solid #ccc; overflow: hidden;">
                  <?php
                  if ($response['user_id'] > 0) {
                  ?>
                    <img src="/uploads/profile/<?php echo $user->getProfileImage() !== "" ? $user->getProfileImage() : "default.png"; ?>" />
                  <?php
                  } else {
                  ?>
                    <img src="/uploads/logos/<?php echo $response['logo']; ?>" />
                  <?php
                  }
                  ?>
                </div>
              </li>
              <li style="display: inline-block; position: relative; width: 78%;">
                <?php
                if ($response['user_id'] > 0) {
                ?>
                <strong><?php echo $response['firstname']; ?> <?php echo $response['lastname']; ?></strong><br />
                <?php
                } else {
                ?>
                <strong><?php echo $response['merchant_name']; ?></strong><br />
                <?php
                }
                ?>
                <?php echo $response['body']; ?>
                <div style="position: absolute; top: 0px; right: -7px; color: #666;"><?php echo date("F j, Y, g:i a", $response['creation']); ?></div>
              </li>
            </ul>
          </li>
        </ul>
        <?php
        }
        if ($response['merchant_id'] > 0) {
        ?>
        <ul>
          <li style="list-style-type: none;">
            <ul style="margin-left: 13%; list-style-type: none; border-bottom: 1px solid #ccc; padding: 5px;">
              <li style="display: inline-block; width: 16%; vertical-align: top; margin-right: 5px;">
                <div style="min-height: 8px; height: 80px; width: 80px; border: 1px solid #ccc; overflow: hidden;">
                  <img src="/uploads/profile/<?php echo $user->getProfileImage() !== "" ? $user->getProfileImage() : "default.png"; ?>" />
                </div>
              </li>
              <li style="display: inline-block; position: relative; width: 78%;">
                <form method="post">
                  <textarea name="body" style="width: 100%;"></textarea>
                  <input type="hidden" name="cc-id" id="cc-id" value="<?php echo $chitchat['id']; ?>" />
                  <button type="submit" class="btn btn-mini btn-success search-btn" onclick="livechatter.search();"><i class="icon-reply" style="vertical-align: bottom;"></i> Send Response</button>
                </form>
              </li>
            </ul>
          </li>
        </ul>
      <?php
        }
      }
        echo "</div>";
        break;
      case "edit":
      case "save":
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
          $img_path = "uploads/profile/";
          $errors = $user->validate($_POST['email'], "blankpass", "blankpass", $_POST['firstname'], $_POST['lastname']);
          if (count($errors) === 0) {
            if (!empty($_FILES['profile-img']['name'])) {
              $filename = slugify($_POST['firstname'] . " " . $_POST['lastname']);
              $file = uploadImage($_FILES['profile-img'], $filename, $img_path);
              $user->setProfileImage($file);
            }
            $user->setFirstName($_POST['firstname']);
            $user->setLastName($_POST['lastname']);
            $user->setEmail($_POST['email']);
            $user->setCity($_POST['city']);
            $user->setState($_POST['state']);
            $user->save();
            echo "<div class=\"success\"><i class=\"icon-ok\"></i> Profile saved successfully.</div>";
          } else {
            echo "<div class=\"error\">";
            foreach ($errors as $error) {
              echo "<i class=\"icon-remove\"></i> " . $error . "<br />";
            }
            echo "</div>";
          }
        }
        ?>
        <h4>Edit Profile</h4>
        <form action="" method="post" enctype="multipart/form-data">
          <label>Profile Image</label>
          <input type="file" name="profile-img" />
          <?php if ($user->getProfileImage()) { ?>
          <div class="profile-image" style="border: 1px solid #ccc; height: 150px; width: 150px; overflow: hidden;">
            <img src="/uploads/profile/<?php echo $user->getProfileImage(); ?>" width="100%" />
          </div>
          <?php } ?>
          <label>First Name</label><input type="text" name="firstname" value="<?php echo $_POST['firstname'] ? $_POST['firstname'] : $user->getFirstName(); ?>" />
          <label>Last Name</label><input type="text" name="lastname" value="<?php echo $_POST['lastname'] ? $_POST['lastname'] : $user->getLastName(); ?>" />
          <label>Email</label><input type="text" name="email" value="<?php echo $_POST['email'] ? $_POST['email'] : $user->getEmail(); ?>" />
          <label>Password</label><input type="text" />
          <label>Re-enter Password</label><input type="text" />
          <label>City</label><input type="text" name="city" value="<?php echo $_POST['city'] ? $_POST['city'] : $user->getCity(); ?>" />
          <label>State</label>
          <select name="state">
            <option>Select State</option>
            <?php
            $states = getStates();
            var_dump($states);
            foreach ($states as $state) {
              echo "<option value=\"" . $state['state'] . "\"";
              $curstate = $_POST['state'] ? strtolower($_POST['state']) : $user->getState();
              if ($curstate === strtolower($state['state'])) { echo " selected"; }
              echo ">" . strtoupper($state['state']) . "</option>";
            }
            ?>
          </select><br /><br />
          <button type="submit" class="btn btn-mini btn-success search-btn"><i class="icon-reply" style="vertical-align: bottom;"></i> Save Profile</button>
        </form>
        <?php
        break;

    }
    ?>
  </div>
</div>
<?php
include("footer.php");
?>
