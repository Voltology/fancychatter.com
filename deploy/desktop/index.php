<?php
include("header.php");
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
<div class="row-fluid">
  <div class="span4">
    <h3>What is FancyChatter?</h3>
    <p>FancyChatter makes your area's businesses available to everyone. At the center of FancyChatter is a network of leading businesses from: Restaurants, Grocery Stores, Auto Dealerships and Doctors... you name it. You connect with them immediately and they respond. FancyChatter is available to anyone who needs help when making a buying decision.</p>
    <p><a class="btn" href="/about">View details &raquo;</a></p>
  </div>
  <div class="span4">
    <h3>Go Mobile!</h3>
    <p>The FancyChatter mobile application was developed and is designed to enhance your purchasing experience by engaging the merchant you choose, by category, as you travel. This isn't your ordinary, "find the best deal" application. If getting what you want, when you want, and at the right price are important to you, then FancyChatter is for you.</p>
    <p><a class="btn" href="/mobile">Go Mobile &raquo;</a></p>
  </div>
  <div class="span4">
    <h3>Get Started.</h3>
    <p>
      <a href="/add">Add Your Business to FancyChatter</a><br />
      <a href="/admin/">Merchant Administration Area</a>
    </p>
  </div>
</div>
<?php
include("footer.php");
?>
