<?php
include("header.php");
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $user->saveSearch($_POST['where'], $_POST['what'], $_POST['distance'], 1, 1);
}
if (!$_POST['mobile'] !== "true" && !$_GET['-mobile'] !== "true") {
  $where = $_POST['where'] ? $_POST['where'] : $_GET['where'];
  $what = $_POST['what'] ? $_POST['what'] : $_GET['what'];
  $distance = $_POST['distance'] ? $_POST['distance'] : $_GET['distance'];
} else {
  $where = $_POST['where-mobile'] ? $_POST['where-mobile'] : $_GET['where-mobile'];
  $what = $_POST['what-mobile'] ? $_POST['what-mobile'] : $_GET['what-mobile'];
  $distance = $_POST['distance-mobile'] ? $_POST['distance-mobile'] : $_GET['distance-mobile'];
}
$livechatters = LiveChatter::search($where, $what, $distance, 20);
?>
<div class="mobile-search hidden-desktop hidden-tablet">
  <div class="search-container">
    <form method="post" action="/livechatter" id="livechatter-search-mobile">
      <label for="where">Where are you?</label>
      <input type="text" name="where" id="where-mobile" placeholder="Enter a Zip Code or City, State" autocomplete="off" onkeyup="livechatter.autocomplete('mobile');" />
      <label for="what">What are you looking for?</label>
      <select name="what" id="what-mobile">
        <option value="null">Select Category</option>
        <?php
        $categories = getCategories();
        foreach ($categories as $category) {
          echo "<option value=\"" . $category['id'] . "\">" . $category['category'] . "</option>";
        }
        ?>
      </select>
      <label for="distanc">How far do you want to go?</label>
      <select name="distance" id="distance-mobile">
        <option value="null">Select Distance</option>
        <?php for ($i = 5; $i <= 25; $i+=5) { ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?> Miles</option>
        <?php } ?>
      </select>
      <input type="hidden" name="mobile" value="true" />
      <button type="button" class="btn btn-mini btn-success search-btn" onclick="<?php if ($user->getIsLoggedIn()) { echo "livechatter.searchmobile();"; } else { if (!B2B) { echo "dialog.open('signup', 'Sign Up', 320, 310, true);"; } else { echo "dialog.open('login', 'Log In', 180, 310, true);"; } } ?>"><i class="icon-search" style="vertical-align: bottom;"></i> Search</button>
    </form>
  </div>
</div>
<div id="autocomplete-box" style="background-color: #fff; border: 1px solid #ccc; font-size: 15px; position: absolute; display: none; top: 42px; width: 280px; z-index: 1000;"></div>
<div class="lead hidden-phone" style="background-color: #eee; border: 1px solid #ccc; border-radius: 6px; text-align: center;">
  <form method="post" action="/livechatter" id="livechatter-search">
    <input type="text" name="where" id="where" value="<?php echo $where; ?>" style="padding: 5px;" placeholder="Where are you?" autocomplete="off" onkeyup="livechatter.autocomplete();" />
    <select name="what" id="what">
      <option value="null">What are you looking for?</option>
      <?php
      $categories = getCategories();
      foreach ($categories as $category) {
        echo "<option value=\"" . $category['id'] . "\"";
        if ($what == $category['id']) { echo " selected"; }
        echo ">" . $category['category'] . "</option>";
      }
      ?>
    </select>
    <select name="distance" id="distance">
      <option value="null">How far do you want to go?</option>
      <?php for ($i = 5; $i <= 25; $i += 5) { ?>
      <option value="<?php echo $i; ?>"<?php if ($distance == $i) { echo " selected"; } ?>><?php echo $i; ?> Miles</option>
      <?php } ?>
    </select>
    <button type="button" class="btn btn-mini btn-success search-btn" onclick="livechatter.search();"><i class="icon-search" style="vertical-align: bottom;"></i> Search</button>
  </form>
</div>
<div class="row-fluid">
  <div class="span3 hidden-phone">
    <ul class="livechatter" style="position: relative; border: 1px solid #ccc; padding: 6px; background-color: #eee; margin: 16px 0 0 0; border-radius: 8px 8px 0 0; width: 100%;">
      <li class="saved" style="display: inline-block; width: 100%; margin-right: 10px; font-weight: bold;">My Favorite Five</li>
    </ul>
    <ul class="livechatter" style="position: relative; border: 1px solid #ccc; padding: 6px; background-color: #f9f9f9; margin: 0;">
      <li style="min-height: 200px; display: inline-block; width: 100%; margin-right: 10px;">
        <?php
        $searches = $user->getSavedSearches();
        foreach ($searches as $search) {
          echo "<div class=\"favorite-box\" id=\"saved-search-box-" . $search['id'] . "\" style=\"position: relative;\">";
          echo "<div style=\"cursor: pointer; position: absolute; top: 4px; right: 4px;\" alt=\"Remove\" title=\"Remove\" onclick=\"profile.removesearch('" . $search['id'] . "')\"><i class=\"icon-remove-sign\"></i></div>";
          if ($search['active'] == 1) {
            echo "<input type=\"checkbox\" id=\"saved-search-" . $search['id'] . "\" onclick=\"profile.inactivatesearch('" . $search['id'] . "')\" checked />&nbsp;";
          } else {
            echo "<input type=\"checkbox\" id=\"saved-search-" . $search['id'] . "\" onclick=\"profile.activatesearch('" . $search['id'] . "')\" />&nbsp;";
          }
          echo "<a href=\"/livechatter?where=" . $search['location'] . "&what=" . $search['category_id'] . "&distance=" . $search['distance'] . "\"><strong style=\"font-size: 14px;\">" . $search['category'] . "</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style=\"font-size: 13px;\">Within " . $search['distance'] . " miles of " . $search['location'] . "</span></a>";
          echo "</div>";
        }
        ?>
      </li>
    </ul>
  </div>
  <div class="span9">
    <div class="results" style="margin-top: 12px;">
      <div style="font-size: 14px">Found <strong><?php echo count($livechatters); ?></strong> results searching for <strong><?php echo getCategoryById($what); ?></strong> within <strong><?php echo $distance; ?></strong> miles of <strong><?php echo $where; ?></strong>!</div>
      <div style="font-size: 14px; margin-bottom: 5px;">Didn't find what you were looking for?  Click the button below to send a ChitChat!</div>
      <input type="hidden" id="hidden-location" value="<?php echo $where; ?>" />
      <input type="hidden" id="hidden-category" value="<?php echo $what; ?>" />
      <input type="hidden" id="hidden-distance" value="<?php echo $distance; ?>" />
      <div style="margin-bottom: 8px;"><a href="#" class="btn btn-mini btn-success search-btn" style="margin: 0 auto;" onclick="dialog.open('chitchat', 'ChitChat', 356, 486);"><i class="icon-reply" style="vertical-align: bottom;"></i> Send ChitChat</a></div>
      <table cellpadding="8" cellspacing="2" border="0" width="100%" style="border: 1px solid #ccc; padding: 6px; margin: 0; border-radius: 8px 8px 0 0;">
        <tr style="border: 1px solid #ccc; padding: 6px; background-color: #eee; margin: 0; border-radius: 8px 8px 0 0; font-size: 13px;"><th width="80"></th><th align="left">Business Name/Message</th><th align="left">Distance</th><th align="right">Time Left</th><th></th></tr>
      <?php
      $count = 0;
      foreach ($livechatters as $livechatter) {
      ?>
        <tr style="background-color: #fff;">
          <td valign="top">
            <div style="overflow: hidden; width: 70px;">
              <a href="profile?mid=<?php echo $livechatter['merchant_id']; ?>">
                <img src="/uploads/logos/<?php if ($livechatter['logo'] == "") { echo "default.png"; } else { echo $livechatter['logo']; } ?>" style="width: 100%;" />
              </a>
            </div>
          </td>
          <td valign="top">
            <strong style="font-size: 14px;"><a href="profile?mid=<?php echo $livechatter['merchant_id']; ?>"><?php echo $livechatter['merchant_name']; ?></a></strong> <span style="color: #666; font-style: italic;">(<?php echo $livechatter['city'] . ", " . $livechatter['state']; ?>)</span><br /><span style="font-size: 13px;"><?php echo $livechatter['body']; ?></span><br />
            <span class="share-btn share-fb"><a target="_blank" href="https://www.facebook.com/sharer.php?m2w&s=100&p[title]=FancyChatter.com&p[summary]=<?php echo urlencode("Check out this LiveChatter from " . $livechatter['merchant_name'] . " on FancyChatter.com!" . $livechatter['body']); ?>&p[url]=http://www.fancychatter.com&p[images][0]=<?php echo urlencode("http://www.fancychatter.com/uploads/logos/" . $livechatter['logo']); ?>"><img src="/img/share-fb-18x18.png" alt="Facebook" title="Facebook"></a></span>
            <span class="share-btn share-tw"><a target="_blank" href="https://twitter.com/share?text=<?php echo urlencode("Check out this LiveChatter from " . $livechatter['merchant_name'] . " on FancyChatter.com! " . $livechatter['body']); ?>&url=http://www.fancychatter.com/"><img src="/img/share-tw-19x18.png" alt="Twitter" title="Twitter"></a></span>
          </td>
          <td valign="top" style="font-size: 13px;">
            <?php echo round($livechatter['distance'], 2); ?> miles
          </td>
          <td align="right" valign="top" style="font-size: 13px;">
            <?php echo formatTimeLeft($livechatter['endtime'] - time()); ?>
          </td>
          <td align="right" valign="top">
            <!--<button type="button" class="btn btn-mini btn-success" onclick="livechatter.share(<?php echo $livechatter['id']; ?>);" style="margin-top: 2px; width: 55px;">Share</button>-->
            <button type="button" class="btn btn-mini btn-success" onclick="livechatter.redeem(<?php echo $livechatter['id']; ?>);" style="margin-top: 2px; width: 55px;">Save</button>
          </td>
        </tr>
      <?php
      }
      ?>
      <?
      if (count($livechatter) === 0) {
      ?>
      <td colspan="4" align="center"><strong>There are no LiveChatters that match this search.</strong></td>
      <?php
      }
      ?>
      </table>
      <div style="font-size: 14px;">Didn't find what you were looking for?  <a href="#" onclick="dialog.open('chitchat', 'ChitChat', 356, 486);">Click here</a> to send a ChitChat</div>
    </div>
  </div>
</div>
<?php
include("footer.php");
?>
