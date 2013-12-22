<?php
include("header_new.php");
?>
<div class="mobile-search hidden-desktop hidden-tablet">
  <div class="search-container">
    <form method="post" action="/livechatter" id="livechatter-search-mobile">
      <h3>Get what you want, when you want it.</h3>
      <h4>Connect with local businesses in real time.</h4>
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
      <button type="button" class="btn btn-mini btn-success search-btn" onclick="<?php if ($user->getIsLoggedIn()) { echo "livechatter.searchmobile();"; } else { if (!B2B) { echo "dialog.open('signup', 'Sign Up', 336, 316, true);"; } else { echo "dialog.open('login', 'Log In', 206, 316, true);"; } } ?>"><i class="icon-search" style="vertical-align: bottom;"></i> Search</button>
    </form>
  </div>
</div>
<div id="autocomplete-box" style="background-color: #fff; border: 1px solid #ccc; font-size: 15px; position: absolute; display: none; top: 42px; width: 280px; z-index: 1000;"></div>
<div class="jumbotron">
  <div id="banner"></div>
    <h1>Get what you want, when you want it</h1>
    <h2>Connect with local businesses in real time</h2>
    <div class="lead" style="background-color: #eee; border: 1px solid #ccc; border-radius: 6px; text-align: center; display: relative; overflow: visible;">
      <form method="post" action="/livechatter" id="livechatter-search">
        <input type="text" name="where" id="where" style="padding: 5px;" placeholder="Where are you?" autocomplete="off" onkeyup="livechatter.autocomplete();" />
        <select name="what" id="what">
          <option value="null">What are you looking for?</option>
          <?php
          $categories = getCategories();
          foreach ($categories as $category) {
            echo "<option value=\"" . $category['id'] . "\">" . $category['category'] . "</option>";
          }
          ?>
        </select>
        <select name="distance" id="distance">
          <option value="null">How far do you want to go?</option>
          <?php for ($i = 5; $i <= 25; $i+=5) { ?>
          <option value="<?php echo $i; ?>"><?php echo $i; ?> Miles</option>
          <?php } ?>
        </select>
        <button type="button" class="btn btn-mini btn-success search-btn" onclick="<?php if ($user->getIsLoggedIn()) { echo "livechatter.search();"; } else { if (!B2B) { echo "dialog.open('signup', 'Sign Up', 336, 316, true);"; } else { echo "dialog.open('login', 'Log In', 206, 316, true);"; } } ?>"><i class="icon-search" style="vertical-align: bottom;"></i> Search</button>
      </form>
    </div>
</div>
<?php
include("footer.php");
?>
