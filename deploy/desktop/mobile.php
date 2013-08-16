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
<div class="row-fluid">
  <div class="span12">
    <h2>Go Mobile</h2>
    <strong>Save on your shopping, dining and service experiences with the one and onlyFancyChatter Mobile!</strong>
    <p>In today’s busy world we all like to have access to what we want and FAST! Now FancyChatter has many ways for you to stay connected and get some GREAT DEALS at the businesses you choice and when you are on the GO!</p>
<p>Explore what you want to purchase and then customize deals based on your current location. Browse hundreds of specific locations who want your business and discover deep discounts on the stores YOU want to SHOP!</p>

    <ul>
      <li>LOCATION-BASED OFFERS - Search our advanced location-based "LiveChatters" to find specials and offers in real time as you shop.</li>
      <li>CUSTOMIZE YOUR SHOPPING EXPERIENCE - with our “My Favorite Five” determine what you want to purchase, and then be alerted based on your desire to purchase.</li>
      <li>SHOPPING TOOLS -  Find your own new deals and specials just by sending out a "Chat" that will open a dialogue with you and the businesses directly</li>
  </div>
</div>
<?php
include("footer.php");
?>
