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

      <!-- Jumbotron -->
      <div class="jumbotron">
        <div id="banner"></div>
          <h1>Get what you want, when you want it</h1>
          <h2>Connect with local businesses in real time</h2>
          <div class="lead" style="background-color: #eee; border: 1px solid #ccc; border-radius: 6px; text-align: center;">
            <form method="post" action="/livechatter" >
              <input type="text" name="where" style="font-size: 16px; padding: 5px;" placeholder="Where are you?" />
              <select name="what">
                <option value="null">What are you looking for?</option>
                <?php
                $categories = getCategories();
                foreach ($categories as $category) {
                  echo "<option value=\"" . $category['id'] . "\">" . $category['category'] . "</option>";
                }
                ?>
              </select>
              <select name="distance">
                <option value="null">How far do you want to go?</option>
                <?php for ($i = 5; $i <= 25; $i+=5) { ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?> Miles</option>
                <?php } ?>
              </select>
              <button type="submit" class="btn btn-mini btn-success search-btn"><i class="icon-search" style="vertical-align: bottom;"></i> Search</button>
            </form>
          </div>
      </div>


      <div class="row-fluid">
        <div class="span4">
          <h2>Go Mobile</h2>
          <p>The Fancychatter.com mobile and iphone application was developed and is designed to enhance your purchasing experience by engaging the merchant you choose, by category, as you travel. This isn't your ordinary, "find the best deal" application. If getting what you want, when you want, and at the right price are important to you. Then Fancychatter.com is for you.</p>
          <p><a class="btn" href="#">Go Mobile &raquo;</a></p>
        </div>
        <div class="span4">
          <h2>Another Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
       </div>
        <div class="span4">
          <h2>FAQ</h2>
          <p>
            <a href="?p=about">What is FancyChatter?</a><br />
            <a href="?p=suggest">Suggest a Business</a><br />
            <a href="?p=contact">Contact Us</a>
            <a href="?p=faq">Frequently Asked Questions</a><br />
            <a href="?p=addbusiness">Add Your Business</a><br />
            <a href="<?php echo ADMIN_PATH; ?>">Merchant Administration Area</a>
          </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
      </div>
