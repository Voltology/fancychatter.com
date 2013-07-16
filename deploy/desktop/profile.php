<?php
include("header.php");
if ($user->getId() != $_GET['id']) {
  $id = $_GET['id'] ? $_GET['id'] : null;
} else {
  $id = null;
}
$cid = $_GET['cid'] ? $_GET['cid'] : null;
$mid = $_GET['mid'] ? $_GET['mid'] : null;
$action = $_GET['a'] ? $_GET['a'] : null;
$profile = $id ? new User($id) : $user;
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  ChitChat::respond($_POST['cc-id'], $profile->getId(), null, $_POST['body']);
}
if (!$profile->getId()) {
  echo "<div style=\"min-height: 400px; padding-top: 100px; \"><div class=\"error\"><strong>This user does not exist.</strong></div></div>";
} else {
?>
<div class="row-fluid">
  <div class="span4">
    <div class="row-fluid">
      <div class="span6">
        <div class="profile-image" style="border: 1px solid #ccc; width: 100%;">
          <img src="/uploads/profile/<?php echo $profile->getProfileImage() ? $profile->getProfileImage() : "default.png"; ?>" />
        </div>
      </div>
      <div class="span6">
        <div class="profile-data">
          <h4 style="margin: 0;"><?php echo $profile->getFirstName(); ?> <?php echo $profile->getLastName(); ?></h4>
          <p><?php echo $profile->getCity(); ?>, <?php echo strtoupper($profile->getState()); ?></p>
          <?php if (!$id) { ?>
            <?php if ($action === "edit") { ?>
            <p><a href="/profile">Back to Profile</a></p>
            <?php } else { ?>
            <p><i class="icon-pencil"></i> <a href="?a=edit">Edit Profile</a></p>
            <?php } ?>
          <?php } else { ?>
          <button type="button" class="btn btn-mini btn-success search-btn" id="follow-button" style="font-size: 18px; width: 140px;" onclick="user.follow(<?php echo $profile->getId() ?>);"><i class="icon-plus" style="vertical-align: bottom;"></i> Follow</button>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
        <div class="profile-recent-activity" style="width: 100%; min-height: 400px;">
          <h4>My Favorite Five</h4>
          <?php
          $searches = $profile->getSavedSearches();
          foreach ($searches as $search) {
            echo "<div class=\"favorite-box\" onclick=\"document.location='/livechatter?where=" . $search['location'] . "&what=" . $search['category_id'] . "&distance=" . $search['distance'] . "'\">";
            echo "<input type=\"checkbox\" checked />&nbsp;";
            echo "<a href=\"/livechatter?where=" . $search['location'] . "&what=" . $search['category_id'] . "&distance=" . $search['distance'] . "\"><strong>" . $search['category'] . "</strong><br />Within " . $search['distance'] . " miles of " . $search['location'] . "</a>";
            echo "</div>";
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
          $chitchat = new ChitChat($cid);
          $chitchat->delete();
        }
        ?>
        <input type="text" id="search-field" style="margin-top: 14px; width: 100%;" placeholder="Enter the name of a friend or a local business..." onkeyup="profile.autocomplete();" />
        <div id="autocomplete-box" style="background-color: #fff; border: 1px solid #ccc; font-size: 15px; position: absolute; display: none; width: 100%; z-index: 1000;"></div>
        <h4><?php echo $id ? $profile->getFirstName() . "'s" : "Your"; ?> Recent Interactions</h4>
        <textarea style="width: 100%;" placeholder="Post something on <?php echo $id ? $profile->getFirstName() . "'s" : "your"; ?> profile..."></textarea>
        <div class="chitchat">
          <?php
          $count = 0;
          $chitchats = ChitChat::getByUserId($profile->getId());
          foreach ($chitchats as $chitchat) {
          ?>
          <ul style="margin: 0; list-style-type: none; padding: 5px;">
            <li style="display: inline-block; width: 13%; vertical-align: top; margin-right: 5px;">
              <div style="min-height: 8px; height: 80px; width: 80px; border: 1px solid #ccc; overflow: hidden;">
                <img src="/uploads/profile/<?php echo $profile->getProfileImage() !== "" ? $profile->getProfileImage() : "default.png"; ?>" />
              </div>
            </li>
            <li style="display: inline-block; min-height: 84px; width: 84%; position: relative; border-bottom: 1px solid #ccc; padding-bottom: 5px;">
              <div style="position: absolute; top: 0px; right: 5px; cursor: pointer;" onclick="document.location='?a=delete&cid=<?php echo $chitchat['id']; ?>'"><i class="icon-remove"></i></div>
              <strong><?php echo $profile->getFirstName(); ?> <?php echo $profile->getLastName(); ?></strong><br />
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
                        <img src="/uploads/profile/<?php echo $profile->getProfileImage() !== "" ? $profile->getProfileImage() : "default.png"; ?>" />
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
                      <img src="/uploads/profile/<?php echo $profile->getProfileImage() !== "" ? $profile->getProfileImage() : "default.png"; ?>" />
                    </div>
                  </li>
                  <li style="display: inline-block; position: relative; width: 78%;">
                    <form method="post">
                      <textarea name="body" style="margin-bottom: 8px; width: 100%;"></textarea>
                      <input type="hidden" name="cc-id" id="cc-id" value="<?php echo $chitchat['id']; ?>" />
                      <button type="submit" class="btn btn-mini btn-success search-btn" style="font-size: 18px;" onclick="livechatter.search();"><i class="icon-reply" style="vertical-align: bottom;"></i> Send Response</button>
                    </form>
                  </li>
                </ul>
              </li>
            </ul>
          <?php
          }
          $count++;
        }
        if ($count === 0) {
          $who = $id ? $profile->getFirstName() . " has " : "You have";
          echo "<div class=\"neutral\"><strong>" . $who . " no recent interactions.</strong></div>";
        }
        echo "</div>";
        break;
      case "edit":
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
          $img_path = "uploads/profile/";
          $errors = $profile->validate($_POST['email'], "blankpass", "blankpass", $_POST['firstname'], $_POST['lastname']);
          if (count($errors) === 0) {
            if (!empty($_FILES['profile-img']['name'])) {
              $filename = slugify($_POST['firstname'] . " " . $_POST['lastname']);
              $file = uploadImage($_FILES['profile-img'], $filename, $img_path);
              $profile->setProfileImage($file);
            }
            $profile->setFirstName($_POST['firstname']);
            $profile->setLastName($_POST['lastname']);
            $profile->setEmail($_POST['email']);
            $profile->setCity($_POST['city']);
            $profile->setState($_POST['state']);
            $profile->save();
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
        <form action="" method="post" enctype="multipart/form-data">
          <div class="row-fluid">
            <div class="span5" style="padding: 14px;">
              <h4>Edit Profile</h4>
              <label>Profile Image</label>
              <input type="file" name="profile-img" />
              <?php if ($profile->getProfileImage()) { ?>
              <div class="profile-image" style="border: 1px solid #ccc; height: 150px; width: 150px; overflow: hidden;">
                <img src="/uploads/profile/<?php echo $profile->getProfileImage(); ?>" width="100%" />
              </div>
              <?php } ?>
            </div>
            <div class="span7" style="padding: 24px;">
              <label>First Name</label><input type="text" name="firstname" value="<?php echo $_POST['firstname'] ? $_POST['firstname'] : $profile->getFirstName(); ?>" />
              <label>Last Name</label><input type="text" name="lastname" value="<?php echo $_POST['lastname'] ? $_POST['lastname'] : $profile->getLastName(); ?>" />
              <label>Email</label><input type="text" name="email" value="<?php echo $_POST['email'] ? $_POST['email'] : $profile->getEmail(); ?>" />
              <label>Password</label><input type="text" />
              <label>Re-enter Password</label><input type="text" />
              <label>City</label><input type="text" name="city" value="<?php echo $_POST['city'] ? $_POST['city'] : $profile->getCity(); ?>" />
              <label>State</label>
              <select name="state">
                <option>Select State</option>
                <?php
                $states = getStates();
                var_dump($states);
                foreach ($states as $state) {
                  echo "<option value=\"" . $state['state'] . "\"";
                  $curstate = $_POST['state'] ? strtolower($_POST['state']) : $profile->getState();
                  if ($curstate === strtolower($state['state'])) { echo " selected"; }
                  echo ">" . strtoupper($state['state']) . "</option>";
                }
                ?>
              </select><br /><br />
              <button type="submit" class="btn btn-mini btn-success search-btn"><i class="icon-reply" style="vertical-align: bottom;"></i> Save Profile</button>
            </div>
          </div>
        </form>
        <?php
        break;
      case "invite":
        ?>
          <h4>Invite a Friend</h4>
          Email: <input type="text" />
          <button type="submit" class="btn btn-mini btn-success search-btn"><i class="icon-reply" style="vertical-align: bottom;"></i> Send Invite</button>
          <button type="submit" class="btn btn-mini btn-danger search-btn"><i class="icon-reply" style="vertical-align: bottom;"></i> Cancel</button>
        <? 
        break;

    }
    ?>
  </div>
</div>
<?php
}
include("footer.php");
?>
