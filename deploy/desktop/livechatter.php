      <?php
      if ($_SERVER['REQUEST_METHOD'] === "POST") {
        User::saveSearch($_POST['where'], $_POST['what'], $_POST['distance'], 1);
      }
      if (isset($_GET['search_id'])) {
        $livechatters = LiveChatter::searchById($_GET['search_id']);
      } else {
        $livechatters = LiveChatter::search($_POST['where'], $_POST['what'], $_POST['distance'], 20);
      }
      ?>
      <div class="lead" style="background-color: #eee; border: 1px solid #ccc; border-radius: 6px; text-align: center;">
        <form method="post" action="/livechatter" id="livechatter-search">
          <input type="text" name="where" id="where" value="<?php echo $_POST['where']; ?>" style="font-size: 16px; padding: 5px;" placeholder="Where are you?" />
          <select name="what" id="what">
            <option value="null">What are you looking for?</option>
            <?php
            $categories = getCategories();
            foreach ($categories as $category) {
              echo "<option value=\"" . $category['id'] . "\"";
              if ($_POST['what'] == $category['id']) { echo " selected"; }
              echo ">" . $category['category'] . "</option>";
            }
            ?>
          </select>
          <select name="distance" id="distance">
            <option value="null">How far do you want to go?</option>
            <?php for ($i = 5; $i <= 25; $i += 5) { ?>
            <option value="<?php echo $i; ?>"<?php if ($_POST['distance'] == $i) { echo " selected"; } ?>><?php echo $i; ?> Miles</option>
            <?php } ?>
          </select>
          <button type="button" class="btn btn-mini btn-success search-btn" onclick="livechatter.search();"><i class="icon-search" style="vertical-align: bottom;"></i> Search</button>
        </form>
      </div>
      <div class="row-fluid">
        <div class="span3">
          <ul class="livechatter" style="position: relative; border: 1px solid #ccc; padding: 6px; background-color: #eee; margin: 16px 0 0 0; border-radius: 8px 8px 0 0; width: 100%;">
            <li class="saved" style="display: inline-block; width: 100%; margin-right: 10px; font-weight: bold;">My Favorite Five</li>
          </ul>
          <ul class="livechatter" style="position: relative; border: 1px solid #ccc; padding: 6px; background-color: #f9f9f9; margin: 0;">
            <li style="min-height: 200px; display: inline-block; width: 100%; margin-right: 10px;">
              <?php
              $searches = $user->getSavedSearches();
              foreach ($searches as $search) {
                echo "<input type=\"checkbox\" checked />&nbsp;";
                echo "<a href=\"/livechatter?search_id=" . $search['id'] . "\"><strong>" . $search['category'] . "</strong><br />Within " . $search['distance'] . " miles of " . $search['location'] . "</a><br />";
              }
              ?>
            </li>
          </ul>
        </div>
        <div class="span9">
          <div class="results" style="margin-top: 12px;">
            <div style="font-size: 14px">Found <strong><?php echo count($livechatters); ?></strong> results searching for <strong><?php echo getCategoryById($_POST['what']); ?></strong> within <strong><?php echo $_POST['distance']; ?></strong> miles of <strong><?php echo $_POST['where']; ?></strong>!</div>
            <div style="font-size: 14px; margin-bottom: 5px;">Didn't find what you were looking for?  Click the button below to send a ChitChat!</div>
            <div style="margin-bottom: 8px;"><a href="#" class="btn btn-mini btn-success search-btn" style="margin: 0 auto;" onclick="dialog.open('chitchat', 'ChitChat', 340, 480);"><i class="icon-reply" style="vertical-align: bottom;"></i> Send ChitChat</a></div>
            <ul class="livechatter" style="position: relative; border: 1px solid #ccc; padding: 6px; background-color: #eee; margin: 0; border-radius: 8px 8px 0 0;">
              <li class="logo" style="display: inline-block; width: 70px; margin-right: 10px; overflow-hidden;"></li>
              <li class="body" style="display: inline-block; width: 70%; vertical-align: top;"><strong>Business Name/Message</strong></li>
              <li class="distance" style="display: inline-block; vertical-align: top;"><strong>Distance</strong></li>
            </ul>
            <?php
            foreach ($livechatters as $livechatter) {
            ?>
            <ul class="livechatter" style="position: relative; min-height: 80px; border: 1px solid #ccc; padding: 6px; background-color: #f9f9f9; margin: 0;">
              <li class="logo" style="display: inline-block; width: 70px; border: 1px solid #ccc; margin-right: 10px;"><a href="profile?mid=<?php echo $livechatter['merchant_id']; ?>"><img src="/uploads/logos/<?php if ($livechatter['logo'] == "") { echo "default.png"; } else { echo $livechatter['logo']; } ?>" /></a></li>
              <li class="body" style="display: inline-block; width: 70%; vertical-align: top;"><strong><a href="profile?mid=<?php echo $livechatter['merchant_id']; ?>"><?php echo $livechatter['merchant_name']; ?></a></strong><br /><?php echo $livechatter['body']; ?></li>
              <li class="distance" style="display: inline-block; vertical-align: top;"><?php echo round($livechatter['distance'], 2); ?> miles</li>
            </ul>
            <?php
            }
            if (count($livechatter) === 0) {
            ?>
            <ul class="livechatter" style="position: relative; border: 1px solid #ccc; padding: 6px; background-color: #f9f9f9; margin: 0;">
              <li class="body" style="display: inline-block; width: 100%; text-align: center;"><strong>No LiveChatter found</strong></li>
            </ul>
            <?php
            }
            ?>
            <div style="font-size: 14px;">Didn't find what you were looking for?  <a href="#" onclick="dialog.open('chitchat', 'ChitChat', 340, 480);">Click here</a> to send a ChitChat</div>
          </div>
        </div>
      </div>
