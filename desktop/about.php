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

<!-- Jumbotron -->
<div class="jumbotron">
  <div id="banner"></div>
  <h1>Get what you want, when you want it</h1>
  <h2>Connect with local businesses in real time</h2>
</div>
<h2>What is FancyChatter?</h2>
<ul>
  <li>LOCATION-BASED OFFERS – Search our advanced location-based "LiveChatters" to find specials and offers in real time as you shop.</li>
  <li>CUSTOMIZE YOUR SHOPPING EXPERIENCE – with our “My Favorite Five” determine what you want to purchase, and then be alerted based on your desire to purchase.</li>
  <li>SHOPPING TOOLS -  Find your own new deals and specials just by sending out a "Chat" that will open a dialogue with you and the businesses directly</li>
</ul>
<p>FancyChatter is an application that was developed and is designed to enhance your purchasing experience by engaging the merchant you choose, by category. This isn't your ordinary, "find the best deal" application.  If getting what you want, when you want, and at the right price are important to you. Then Fancychatter is for you.</p>
<h2>How it Works</h2>
<ul>
  <li>Users sign up for free</li>
  <li>Businessess send "LiveChatter" in real-time to their target audience</li>
  <li>Users are alerted in real-time for what they are in the market for and can find what they want in their designated area</li>
  <li>Business's and Users "Chat" directly to make a sale</li>
</ul>
<?php
include("footer.php");
