<?php
include("header.php");
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  ChitChat::respond($_POST['cc-id'], $user->getId(), null, $_POST['body']);
}
?>
<div class="row-fluid">
  <div class="span4">
    <div class="row-fluid">
      <div class="span6">
        <div class="profile-image" style="border: 1px solid #ccc; width: 100%;">
          <img src="/uploads/profile/default.png" />
        </div>
      </div>
      <div class="span6">
        <div class="profile-data">
          <h4 style="margin: 0;"><?php echo $user->getFirstName(); ?> <?php echo $user->getLastName(); ?></h4>
          <p>Chicago, IL</p>
          <p><i class="icon-pencil"></i> <a href="#" onclick="profile.edit()">Edit Profile</a></p>
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
          <h4>Recent Activity</h4>
        </div>
      </div>
    </div>
  </div>
  <div class="span8">
    <h4>Your Recent ChitChats</h4>
    <div class="chitchat">
      <?php
      $chitchats = ChitChat::getByUserId($user->getId());
      foreach ($chitchats as $chitchat) {
      ?>
      <ul style="margin: 0; list-style-type: none; padding: 5px;">
        <li style="display: inline-block; width: 13%; vertical-align: top; margin-right: 5px;">
          <div style="min-height: 8px; width: 80px; border: 1px solid #ccc; overflow: hidden;">
            <img src="/uploads/profile/default.png" />
          </div>
        </li>
        <li style="display: inline-block; min-height: 84px; width: 84%; position: relative; border-bottom: 1px solid #ccc; padding-bottom: 5px;">
          <strong><?php echo $user->getFirstName(); ?> <?php echo $user->getLastName(); ?></strong><br />
          <div style="color: #aaa; font-style: italic; margin-top: -6px;">Sent to Automotive within 25 miles of 60611</div>
          <?php echo $chitchat['body']; ?>
          <div style="position: absolute; top: 0px; right: 5px; color: #666;"><?php echo date("F j, Y, g:i a", $chitchat['creation']); ?></div>
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
                <div style="min-height: 8px; width: 80px; border: 1px solid #ccc; overflow: hidden;">
                  <?php
                  if ($response['user_id'] > 0) {
                  ?>
                    <img src="/uploads/profile/default.png" />
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
                <div style="min-height: 8px; width: 80px; border: 1px solid #ccc; overflow: hidden;">
                  <img src="/uploads/profile/default.png" />
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
      ?>
    </div>
  </div>
</div>
<?php
include("footer.php");
?>
