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
<div class="row-fluid">
  <div class="span12">
    <h2>Go Mobile</h2>
    <p></p>
  </div>
</div>
<?php
include("footer.php");
?>
