<?php
include("header.php");
?>
<div class="navbar">
  <div class="navbar-inner">
    <div class="container">
      <ul class="nav">
        <li<?php if ($page === null) { echo " class=\"active\""; } ?>><a href="./">Home</a></li>
        <li<?php if ($page === "profile") { echo " class=\"active\""; } ?>><a href="/profile">Profile</a></li>
        <li<?php if ($page === "about") { echo " class=\"active\""; } ?>><a href="/about">About</a></li>
        <li<?php if ($page === "contact") { echo " class=\"active\""; } ?>><a href="/contact">Contact</a></li>
      </ul>
    </div>
  </div>
</div>
<div class="jumbotron">
  <div id="banner"></div>
    <h1>Get what you want, when you want it</h1>
    <h2>Connect with local businesses in real time</h2>
    <div class="lead" style="background-color: #eee; border: 1px solid #ccc; border-radius: 6px; text-align: center;">
      <form method="post" action="/livechatter" id="livechatter-search">
        <input type="text" name="where" id="where" style="font-size: 16px; padding: 5px;" placeholder="Where are you?" />
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
        <button type="button" class="btn btn-mini btn-success search-btn" onclick="<?php if ($user->getIsLoggedIn()) { echo "livechatter.search();"; } else { echo "dialog.open('signup', 'Sign Up', 320, 310, true);"; } ?>"><i class="icon-search" style="vertical-align: bottom;"></i> Search</button>
      </form>
    </div>
</div>
<div class="row-fluid">
  <div class="span4">
    <h3>What is FancyChatter?</h3>
    <p>Fancychatter.com makes your area's businesses available to everyone. At the center of Fancychatter.com is a network of leading businesses from: Restaurants, Grocery Stores, Auto Dealerships and Doctors... you name it. You connect with them immediately and they respond. Fancychatter.com is available to anyone who needs help when making a buying decision.</p>
    <p><a class="btn" href="/about">View details &raquo;</a></p>
  </div>
  <div class="span4">
    <h3>Go Mobile!</h3>
    <p>The Fancychatter.com mobile and iphone application was developed and is designed to enhance your purchasing experience by engaging the merchant you choose, by category, as you travel. This isn't your ordinary, "find the best deal" application. If getting what you want, when you want, and at the right price are important to you. Then Fancychatter.com is for you.</p>
    <p><a class="btn" href="/mobile">Go Mobile &raquo;</a></p>
  </div>
  <div class="span4">
    <h3>Links</h3>
    <p>
      <a href="/suggest">Suggest a Business</a><br />
      <a href="/contact">Contact Us</a><br />
      <a href="/faq">Frequently Asked Questions</a><br />
      <a href="/add">Add Your Business</a><br />
      <a href="/admin/">Merchant Administration Area</a>
    </p>
    <p><a class="btn" href="#">View details &raquo;</a></p>
  </div>
</div>
<?php
include("footer.php");
?>
