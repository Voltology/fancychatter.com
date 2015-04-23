<?php
include("header_new.php");
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
}
?>
<style>
ul.tabs {
  background-color: #eee;
  display: table;
  table-layout: fixed;
  text-align: center;
  margin: 0;
  padding: 0;
  width: 100%;
}
ul.tabs li {
  border-right: 1px solid #ddd;
  cursor: pointer;
  display: table-cell;
  font-size: 16px;
  font-weight: bold;
  height: auto;
  list-style-type: none;
  padding: 9px 1px 9px 0;
  width: 20%;
  vertical-align: bottom;
}
ul.tabs li:last-child {
  border: none;
}
ul.tabs li.active {
  background-color: #666;
  color: #fff;
}
ul.tabs li i {
  font-size: 18px;
  vertical-align: middle;
}
div.history-header {
  background-color: #ccc;
  border-top: 1px solid #eee;
  color: #333;
  font-size: 18px;
  font-weight: bold;
  padding: 14px 14px;
}
div.history-saved div {
  background-color: #eee;
  margin: 0px auto 10px auto;
  min-height: 100px;
  padding: 8px 14px;
  width:100%;
}
</style>
<div style="max-width: 1000px; margin: 0 auto;">
  <img src="/uploads/profile/<?php echo $profile->getProfileImage() ? $profile->getProfileImage() : "default.png"; ?>" />
  <h4><?php echo $profile->getFirstName(); ?> <?php echo $profile->getLastName(); ?></h4>
  <p>
    <?php
    if ($profile->getCity() && $profile->getState()) {
      echo "<i class=\"icon-map-marker\"></i> " . $profile->getCity(); ?>, <?php echo strtoupper($profile->getState());
    } else {
      echo "<i class=\"icon-map-marker\"></i> " . $profile->getCity() . $profile->getState();
    } ?>
  </p>
  <button><i class="icon-pencil"></i> Edit Profile</button>
  <ul class="tabs">
    <li><i class="icon-time"></i> Recent Activity</li>
    <li><i class="icon-star" ></i> Explore</li>
    <li class="active"><i class="icon-heart" ></i> History</li>
    <li><i class="icon-comment" ></i> Followers</li>
    <li><i class="icon-comment-alt" ></i> Following</li>
  </ul>
  <div class="history-header">Your Faves<i class="icon-minus-sign" style="float: right; font-size: 24px;"></i></div>
  <div class="history-saved" style="width:100%; background-color: #eee;">
    <div id="column1" style="float:left; margin:0; width:20%;">
      <h4>Cafe Borgia</h4>
    </div>
    <div id="column2" style="float:left; margin:0;width:60%;">
      <h5>Something Something</h5>
    </div>
    <div id="column3" style="float:left; margin:0;width:20%; text-align: right;">
      <i class="icon-time"></i> Expires 5 hours
      <button>See deal code</button>
      <i class="icon-remove-circle"></i>
    </div>
  </div>
  <div class="history-header">Your Previous Searches<i class="icon-minus-sign" style="float: right; font-size: 24px;"></i></div>
  <div class="history-saved" style="width:100%; background-color: #eee;">
    <div id="column1" style="float:left; margin:0; width:80%;">
      <h4>Cafe Borgia</h4>
    </div>
    <div id="column3" style="float:left; margin:0;width:20%">
      <i class="icon-remove-circle" style="font-size: 24px; float: right;"></i>
    </div>
  </div>
  <div class="history-header">Your ChitChats<i class="icon-minus-sign" style="float: right; font-size: 24px;"></i></div>
  <div class="history-saved" style="width:100%; background-color: #eee;">
    <div id="column1" style="float:left; margin:0; width:20%;">
      <h4>Cafe Borgia</h4>
    </div>
    <div id="column2" style="float:left; margin:0;width:60%;">
      <h5>Something Something</h5>
    </div>
    <div id="column3" style="float:left; margin:0;width:20%">
      <i class="icon-time"></i> Expires 5 hours
      <button>See deal code</button>
      <i class="icon-remove-circle"></i>
    </div>
  </div>
</div>
<?php
include("footer.php");
?>
