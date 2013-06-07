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
      </div>
      <div class="row-fluid">
        <div class="span12">
          <h2>Privacy Policy</h2>
          <p>
          </p>
        </div>
      </div>
