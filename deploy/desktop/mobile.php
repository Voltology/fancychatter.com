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
