<?php
include("header.php");
if ($user->getId() != $_GET['id']) {
  Alerts::view($user->getId());
  $id = $_GET['id'] ? $_GET['id'] : null;
} else {
  $id = null;
}
$mid = $_GET['mid'] ? $_GET['mid'] : null;
$cid = $_GET['cid'] ? $_GET['cid'] : null;
$action = $_GET['a'] ? $_GET['a'] : null;
if ($mid) {
  $proftype = 1;
  $merchant = new Merchant($mid);
} else {
  $proftype = 0;
  $profile = $id ? new User($id) : $user;
}
if (!$profile && !$merchant) {
  echo "<div style=\"min-height: 400px; padding-top: 100px; \"><div class=\"error\"><strong>This user does not exist.</strong></div></div>";
} else if (($id || $profile) && $user->getIsLoggedIn()) {
  if ($_SERVER['REQUEST_METHOD'] === "POST") {
    ChitChat::respond($_POST['cc-id'], $profile->getId(), $_POST['merchant-id'], $_POST['body'], "user");
  }
?>
<div class="row-fluid">
  <div class="span4">
    <div class="row-fluid">
      <div class="span6">
        <div class="profile-image" style="border: 1px solid #ccc; max-height: 200px; overflow: hidden; width: 100%;">
          <img src="/uploads/profile/<?php echo $profile->getProfileImage() ? $profile->getProfileImage() : "default.png"; ?>" style="width: 100%;" />
        </div>
      </div>
      <div class="span6">
        <div class="profile-data">
          <h4 style="margin: 0;"><?php echo $profile->getFirstName(); ?> <?php echo $profile->getLastName(); ?></h4>
          <p style="font-size: 13px;">
            <?php
            if ($profile->getCity() && $profile->getState()) {
              echo $profile->getCity(); ?>, <?php echo strtoupper($profile->getState());
            } else {
              echo $profile->getCity() . $profile->getState();
            } ?>
          </p>
          <?php if (!$id) { ?>
            <?php if ($action === "edit") { ?>
            <p style="font-size: 13px;"><i class="icon-arrow-left"></i> <a href="/profile">Back to Profile</a></p>
            <?php } else { ?>
            <p style="font-size: 13px;"><i class="icon-pencil"></i> <a href="?a=edit">Edit Profile</a></p>
            <?php } ?>
          <?php } else { ?>
            <?php
            $following = $user->getFollowers();
            $followflag = false;
            foreach ($following as $follow) {
              if ($follow['followee_id'] === $profile->getId()) {
                $followflag = true;
                break;
              }
            }
            if ($followflag) {
            ?>
            <button type="button" class="btn btn-mini btn-danger search-btn" id="follow-button" style="font-size: 18px; width: 140px;" onclick="user.unfollow(<?php echo $profile->getId() ?>, 0);"><i class="icon-minus" style="vertical-align: bottom;"></i> Unfollow</button>
            <?php
            } else {
            ?>
            <button type="button" class="btn btn-mini btn-success search-btn" id="follow-button" style="font-size: 18px; width: 140px;" onclick="user.follow(<?php echo $profile->getId() ?>, 0);"><i class="icon-plus" style="vertical-align: bottom;"></i> Follow</button>
            <?php
            }
          } ?>
        </div>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
        <div class="profile-recent-activity" style="width: 100%; min-height: 300px;">
          <h4><?php echo $id ? $profile->getFirstName($profile->getId()) . "'s" : "My"; ?> Favorite Five</h4>
          <?php
          $searches = $profile->getSavedSearches();
          $count = 0;
          foreach ($searches as $search) {
            echo "<div class=\"favorite-box\" id=\"saved-search-box-" . $search['id'] . "\" style=\"position: relative;\">";
            echo "<div style=\"cursor: pointer; position: absolute; top: 4px; right: 4px;\" alt=\"Remove\" title=\"Remove\" onclick=\"profile.removesearch('" . $search['id'] . "')\"><i class=\"icon-remove-sign\"></i></div>";
            if ($search['active'] == 1) {
              echo "<input type=\"checkbox\" id=\"saved-search-" . $search['id'] . "\" onclick=\"profile.inactivatesearch('" . $search['id'] . "')\" checked />&nbsp;";
            } else {
              echo "<input type=\"checkbox\" id=\"saved-search-" . $search['id'] . "\" onclick=\"profile.activatesearch('" . $search['id'] . "')\" />&nbsp;";
            }
            echo "<a href=\"/livechatter?where=" . $search['location'] . "&what=" . $search['category_id'] . "&distance=" . $search['distance'] . "\"><strong style=\"font-size: 14px;\">" . $search['category'] . "</strong><br /><span style=\"font-size: 13px;\">Within " . $search['distance'] . " miles of " . $search['location'] . "</span></a>";
            echo "</div>";
            $count++;
          }
          if ($count === 0) {
            echo "<p style=\"font-size: 13px;\">" . ($id ? $profile->getFirstName($profile->getId()) . " does " : "You do") . " not have any saved searches.</p>";
          }
          $following = $profile->getFollowers();
          $count = 0;
          echo "<h4>Following (" . count($following) . ")</h4>";
          echo "<ul style=\"list-style-type: none; margin: 0 -4px;\">";
          foreach ($following as $follow) {
            if ($follow['type'] == 0) {
              echo "<li style=\"display: inline-block; height: 80px; margin: 0 5px; width: 64px;\"><a href=\"/profile?id=" . $follow['followee_id'] . "\"><img src=\"/uploads/profile/" . ($follow['profile_img'] ? $follow['profile_img'] : "default.png") . "\" style=\"width: 100%;\" alt=\"" . $follow['firstname'] . " " . $follow['lastname'] . "\" title=\"" . $follow['firstname'] . " " . $follow['lastname'] . "\" /></a></li>";
            } else {
              echo "<li style=\"display: inline-block; height: 80px; margin: 0 5px; width: 64px;\"><a href=\"/profile?mid=" . $follow['followee_id'] . "\"><img src=\"/uploads/logos/" . ($follow['logo'] ? $follow['logo'] : "default.png") . "\" style=\"width: 100%;\" alt=\"" . $follow['name'] . "\" title=\"" . $follow['namename'] . "\" /></a></li>";
            }
            $count++;
          }
          echo "</ul>";
          if ($count === 0) {
            echo "<p style=\"font-size: 13px;\">" . ($id ? $profile->getFirstName($profile->getId()) . " is " : "You are") . " not following anyone.</p>";
          }
          ?>
        </div>
      </div>
    </div>
  </div>
  <div class="span8" id="interactions-panel">
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
        <textarea style="height: 70px; width: 100%;" id="postbox" placeholder="Post something on <?php echo $id ? $profile->getFirstName($profile->getId()) . "'s" : "your"; ?> profile..."></textarea>
        <button type="button" class="btn btn-mini btn-success search-btn" id="follow-button" style="font-size: 18px; width: 140px; margin-left: 4px;" onclick="profile.post(<?php echo $profile->getId(); ?>);">Submit</button>
        <div class="interactions" id="interactions">
          <?php
          $count = 0;
          $feeds = $profile->getFeed();
          foreach ($feeds as $feed) {
            switch($feed['type']) {
              case "alert":
                if (!$id) {
                ?>
                <div style="border-bottom: 1px solid #ccc; font-weight: bold; font-size: 13px; padding: 10px 0; position: relative" id="alert-<?php echo $feed['id']; ?>">
                  <i class="icon-bell"></i> <?php echo $feed['body']; ?>
                  <span style="font-size: 12px; font-weight: normal;"> - <?php echo date("F j, Y, g:i a", $feed['creation']); ?></span>
                  <div style="font-size: 12px; position: absolute; top: 4px; right: 2px; cursor: pointer;" onclick="profile.removealert(<?php echo $feed['id']; ?>)"><i class="icon-remove-sign"></i></div>
                </div>
                  <?php
                  }
                break;
              case "post": ?>
                <table width="100%" cellpadding="2" cellspacing="0" border="0" style="position: relative; margin-top: 12px;" id="post-<?php echo $feed['id']; ?>">
                  <tr>
                    <td rowspan="2" width="60" style="padding-top: 4px;" valign="top">
                      <div style="max-height: 60px; overflow: hidden; width: 60px;">
                        <?php if ($feed['poster_id'] !== $profile->getId()) { ?>
                          <a href="/profile?id=<?php echo $feed['poster_id']; ?>"><img src="/uploads/profile/<?php echo $feed['profile_img'] !== null ? $feed['profile_img']  : "default.png"; ?>" style="width: 100%;" /></a>
                        <?php } else { ?>
                          <img src="/uploads/profile/<?php echo $feed['profile_img'] !== null ? $feed['profile_img']  : "default.png"; ?>" style="width: 100%;" />
                        <?php } ?>
                        <img src="/uploads/profile/<?php echo $feed['profile_img'] !== null ? $feed['profile_img']  : "default.png"; ?>" style="width: 100%;" />
                      </div>
                    </td>
                    <td valign="top" style="padding-top: 4px;">
                      <?php if ($feed['poster_id'] !== $profile->getId()) { ?>
                      <strong style="font-size: 14px; padding-left: 3px;"><a href="/profile?id=<?php echo $feed['poster_id']; ?>"><?php echo $feed['firstname']; ?> <?php echo $feed['lastname']; ?></a></strong><br />
                      <?php } else { ?>
                      <strong style="font-size: 14px; padding-left: 3px;"><?php echo $feed['firstname']; ?> <?php echo $feed['lastname']; ?></strong><br />
                      <?php } ?>
                    </td>
                    <td align="right" valign="top" style="padding: 4px 30px 0 0;">
                      <?php echo date("F j, Y, g:i a", $feed['creation']); ?>
                      <div style="position: absolute; top: 4px; right: 5px; cursor: pointer;" onclick="profile.removepost(<?php echo $feed['id']; ?>)"><i class="icon-remove-sign"></i></div>
                    </td>
                  </tr>
                  <tr><td colspan="2" valign="top" style="border-bottom: 1px solid #ccc; font-size: 13px; padding-left: 5px;"><?php echo $feed['body']; ?></td></tr>
                </table>
                <?php
                break;
              case "chitchat":
                if (!$id) {
                ?>
                <table width="100%" cellpadding="2" cellspacing="0" border="0" style="position: relative; margin-top: 12px;" id="chitchat-<?php echo $feed['id'] ;?>">
                  <tr>
                    <td rowspan="2" width="60" style="padding-top: 4px;">
                      <div style="max-height: 60px; overflow: hidden; width: 60px;">
                        <img src="/uploads/profile/<?php echo $profile->getProfileImage() !== "" ? $profile->getProfileImage() : "default.png"; ?>" style="width: 100%;" />
                      </div>
                    </td>
                    <td valign="top" style="padding-top: 4px; padding-left: 3px;">
                      <strong style="font-size: 14px;"><?php echo $profile->getFirstName(); ?> <?php echo $profile->getLastName(); ?></strong><br />
                      <div style="color: #aaa; font-style: italic; margin-top: -6px;">Sent to <?php echo $feed['category']; ?> within <?php echo $feed['distance']; ?> miles of <?php echo $feed['location']; ?></div>
                    </td>
                    <td align="right" valign="top" style="padding: 4px 30px 0 0;">
                      <?php echo date("F j, Y, g:i a", $feed['creation']); ?>
                      <div style="position: absolute; top: 0px; right: 5px; cursor: pointer;" onclick="profile.removechitchat(<?php echo $feed['id']; ?>);"><i class="icon-remove-sign"></i></div>
                    </td>
                  </tr>
                  <tr><td colspan="2" valign="top" style="border-bottom: 1px solid #ccc; padding-left: 5px; font-size: 13px;"><?php echo $feed['body']; ?></td></tr>
                  <!--Needs responses-->
                      <?php
                      $responses = ChitChat::getResponsesById($feed['id']);
                      $count = 0;
                      foreach ($responses as $response) {
                        if ($merchantid !== $response['merchant_id'] && $count !== 0) {
                          if ($response['last_response'] !== "merchant") {
                        ?>
                            <tr>
                              <td></td>
                              <td colspan="2">
                                <table width="100%" cellpadding="2" cellspacing="0" border="0" style="position: relative; margin-top: 12px;">
                                  <tr>
                                    <td width="60" valign="top" style="padding-left: 66px;">
                                      <div style="max-height: 60px; overflow: hidden; width: 60px;">
                                        <img src="/uploads/profile/<?php echo $profile->getProfileImage() !== "" ? $profile->getProfileImage() : "default.png"; ?>" />
                                      </div>
                                    </td>
                                    <td valign="top">
                                      <form method="post">
                                        <textarea name="body" style="margin-bottom: 8px; height: 74px; width: 100%;"></textarea>
                                        <input type="hidden" name="merchant-id" id="merchant-id" value="<?php echo $merchantid; ?>" />
                                        <input type="hidden" name="cc-id" id="cc-id" value="<?php echo $feed['id']; ?>" />
                                        <button type="submit" class="btn btn-mini btn-success search-btn" style="font-size: 18px;"><i class="icon-reply" style="vertical-align: bottom;"></i> Send Response</button>
                                      </form>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          <?php
                          }
                          $count = 0;
                        }
                        if ($response['merchant_id']) {
                          $merchantid = $response['merchant_id'];
                        }
                        if ($count === 0) {
                        ?>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2">
                              <table width="100%" cellpadding="2" cellspacing="0" border="0" style="position: relative; margin-top: 12px;">
                                <tr>
                                  <td rowspan="2" width="60">
                                    <div style="max-height: 60px; overflow: hidden; width: 60px;">
                                      <?php if ($response['last_response'] === "user") { ?>
                                      <img src="/uploads/profile/<?php echo $profile->getProfileImage() !== "" ? $profile->getProfileImage() : "default.png"; ?>" />
                                      <?php } else {?>
                                      <a href="/profile?mid=<?php echo $response['merchant_id']; ?>"><img src="/uploads/logos/<?php echo $response['logo']; ?>" /></a>
                                      <?php } ?>
                                    </div>
                                  </td>
                                  <td valign="top">
                                    <?php if ($response['last_response'] === "user") { ?>
                                    <strong style="font-size: 14px;"><?php echo $response['firstname']; ?> <?php echo $response['lastname']; ?></strong><br />
                                    <?php } else { ?>
                                    <strong style="font-size: 14px;"><a href="/profile?mid=<?php echo $response['merchant_id']; ?>"><?php echo $response['merchant_name']; ?></a></strong><br />
                                    <?php } ?>
                                  </td>
                                  <td align="right" valign="top" style="padding: 4px 30px 0 0;">
                                    <?php echo date("F j, Y, g:i a", $response['creation']); ?>
                                    <!--<div style="position: absolute; top: 4px; right: 5px; cursor: pointer;" onclick="document.location='?a=delete&cid=<?php echo $response['id']; ?>'"><i class="icon-remove-sign"></i></div>-->
                                  </td>
                                </tr>
                                <tr><td colspan="2" valign="top" style="border-bottom: 1px solid #ccc; padding-left: 5px; font-size: 13px;"><?php echo $response['body']; ?></td></tr>
                              </table>
                              <?php
                              ?>
                            </td>
                          </tr>
                          <?php
                          $count++;
                        } else {
                          ?>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2">
                              <table width="100%" cellpadding="2" cellspacing="0" border="0" style="position: relative; margin-top: 12px;">
                                <tr>
                                  <td rowspan="2" width="60" style="padding-left: 66px">
                                    <div style="max-height: 60px; overflow: hidden; width: 60px;">
                                      <?php if ($response['last_response'] === "user") { ?>
                                      <img src="/uploads/profile/<?php echo $profile->getProfileImage() !== "" ? $profile->getProfileImage() : "default.png"; ?>" />
                                      <?php } else {?>
                                      <a href="/profile?mid=<?php echo $response['merchant_id']; ?>"><img src="/uploads/logos/<?php echo $response['logo']; ?>" /></a>
                                      <?php } ?>
                                    </div>
                                  </td>
                                  <td valign="top">
                                    <?php if ($response['last_response'] === "user") { ?>
                                    <strong style="font-size: 14px;"><?php echo $response['firstname']; ?> <?php echo $response['lastname']; ?></strong><br />
                                    <?php } else { ?>
                                    <strong style="font-size: 14px;"><a href="/profile?mid=<?php echo $response['merchant_id']; ?>"><?php echo $response['merchant_name']; ?></a></strong><br />
                                    <?php } ?>
                                  </td>
                                  <td align="right" valign="top" style="padding: 4px 30px 0 0;">
                                    <?php echo date("F j, Y, g:i a", $response['creation']); ?>
                                    <!--<div style="position: absolute; top: 4px; right: 5px; cursor: pointer;" onclick="document.location='?a=delete&cid=<?php echo $response['id']; ?>'"><i class="icon-remove-sign"></i></div>-->
                                  </td>
                                </tr>
                                <tr><td colspan="2" valign="top" style="border-bottom: 1px solid #ccc; padding-left: 5px; font-size: 13px;"><?php echo $response['body']; ?></td></tr>
                              </table>
                              <?php
                              ?>
                            </td>
                          </tr>
                        <?php
                        }
                      }
                      $count++;
                      ?>
                    </td>
                  </tr>
                  <?php
                  if ($response['last_response'] === "merchant") {
                  ?>
                    <tr>
                      <td></td>
                      <td colspan="2">
                        <table width="100%" cellpadding="2" cellspacing="0" border="0" style="position: relative; margin-top: 12px;">
                          <tr>
                            <td width="60" valign="top" style="padding-left: 66px;">
                              <div style="max-height: 60px; overflow: hidden; width: 60px;">
                                <img src="/uploads/profile/<?php echo $profile->getProfileImage() !== "" ? $profile->getProfileImage() : "default.png"; ?>" />
                              </div>
                            </td>
                            <td valign="top">
                              <form method="post">
                                <textarea name="body" style="margin-bottom: 8px; height: 74px; width: 100%;"></textarea>
                                <input type="hidden" name="merchant-id" id="merchant-id" value="<?php echo $merchantid; ?>" />
                                <input type="hidden" name="cc-id" id="cc-id" value="<?php echo $feed['id']; ?>" />
                                <button type="submit" class="btn btn-mini btn-success search-btn" style="font-size: 18px;"><i class="icon-reply" style="vertical-align: bottom;"></i> Send Response</button>
                              </form>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  <?php
                }
            }
        }
            $count++;
          }
          echo "</table>";
          if ($count === 0) {
            $who = $id ? $profile->getFirstName() . " has " : "You have";
            echo "<div class=\"neutral\" id=\"no-interactions\" style=\"margin-top: 40px;\"><strong>" . $who . " no recent interactions.</strong></div>";
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
              <div class="profile-image" style="border: 1px solid #ccc; width: 150px; overflow: hidden;">
                <img src="/uploads/profile/<?php echo $profile->getProfileImage(); ?>" width="100%" />
              </div>
              <?php } ?>
            </div>
            <div class="span7" style="padding: 24px;">
              <label>First Name</label><input type="text" name="firstname" value="<?php echo $_POST['firstname'] ? $_POST['firstname'] : $profile->getFirstName(); ?>" />
              <label>Last Name</label><input type="text" name="lastname" value="<?php echo $_POST['lastname'] ? $_POST['lastname'] : $profile->getLastName(); ?>" />
              <label>Email</label><input type="text" name="email" value="<?php echo $_POST['email'] ? $_POST['email'] : $profile->getEmail(); ?>" />
              <label>Password</label><input type="password1" />
              <label>Re-enter Password</label><input type="password2" />
              <label>City</label><input type="text" name="city" value="<?php echo $_POST['city'] ? $_POST['city'] : $profile->getCity(); ?>" />
              <label>State</label>
              <select name="state">
                <option>Select State</option>
                <?php
                $states = getStates();
                foreach ($states as $state) {
                  echo "<option value=\"" . $state['state'] . "\"";
                  $curstate = $_POST['state'] ? strtolower($_POST['state']) : $profile->getState();
                  if ($curstate === strtolower($state['state'])) { echo " selected"; }
                  echo ">" . strtoupper($state['state']) . "</option>";
                }
                ?>
              </select><br /><br />
              <button type="submit" class="btn btn-mini btn-success search-btn">Save Profile</button>
            </div>
          </div>
        </form>
        <?php
        break;
      case "invite":
        ?>
          <h4>Invite a Friend</h4>
          Email: <input type="text" />
          <button type="submit" class="btn btn-mini btn-success search-btn">Send Invite</button>
          <button type="button" class="btn btn-mini btn-danger search-btn" onclick="document.location='/profile'">Cancel</button>
        <? 
        break;

    }
    ?>
  </div>
</div>
<?php
} else if ($mid) {
?>
<div class="row-fluid">
  <div class="span4">
    <div class="row-fluid">
      <div class="span6">
        <div class="profile-image" style="border: 1px solid #ccc; width: 100%;">
          <img src="/uploads/logos/<?php echo $merchant->getLogo() ? $merchant->getLogo() : "default.png"; ?>" />
        </div>
      </div>
      <div class="span6">
        <div class="profile-data">
          <h4 style="margin: 0;"><?php echo $merchant->getName(); ?></h4>
          <p>
            <?php echo $merchant->getAddress1(); ?><br />
            <?php if ($merchant->getAddress2() !== "") { echo $merchant->getAddress2(); } ?>
            <?php echo $merchant->getCity(); ?>, <?php echo strtoupper($merchant->getState()); ?> <?php echo $merchant->getZipCode(); ?><br />
            <?php echo $merchant->getPhone(); ?>
          </p>
          <?php if ($user->getIsLoggedIn()) {
            $following = $user->getFollowers();
            $followflag = false;
            foreach ($following as $follow) {
              if ($follow['followee_id'] === $mid) {
                $followflag = true;
                break;
              }
            }
            if ($followflag) {
            ?>
            <button type="button" class="btn btn-mini btn-danger search-btn" id="follow-button" style="font-size: 18px; width: 140px;" onclick="user.unfollow(<?php echo $merchant->getId() ?>, 1);"><i class="icon-minus" style="vertical-align: bottom;"></i> Unfollow</button>
            <?php
            } else {
            ?>
            <button type="button" class="btn btn-mini btn-success search-btn" id="follow-button" style="font-size: 18px; width: 140px;" onclick="user.follow(<?php echo $merchant->getId() ?>, 1);"><i class="icon-plus" style="vertical-align: bottom;"></i> Follow</button>
            <?php
            }
         } ?>
        </div>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
        <div class="profile-recent-activity" style="width: 100%; min-height: 300px;">
          <?php
          $following = $merchant->getFollowers();
          echo "<h4>Followers (" . count($following) . ")</h4>";
          foreach ($following as $follow) {
            echo "<div style=\"height: 40px; width: 40px;\"><img src=\"" . $follow['profile_img'] . "\" /></div>";
          }
          ?>
        </div>
      </div>
    </div>
  </div>
  <div class="span8">
    <h4>Location</h4>
    <div id="map-canvas" style="height: 550px; width: 100%;"></div>
  </div>
</div>
<script>
$(document).ready(function() {
  maps.data = <?php echo json_encode($merchant->getJSONData()); ?>;
  maps.latitude = <?php echo $merchant->getLatitude(); ?>;
  maps.longitude = <?php echo $merchant->getLongitude(); ?>;
  maps.initialize();
  maps.populatemarkers();
});
</script>
<?php
} else {
  echo "<div style=\"min-height: 400px; padding-top: 100px; \"><div class=\"error\"><i class=\"icon-remove\"></i> <strong>This user does not exist.</strong></div></div>";
}
include("footer.php");
?>
