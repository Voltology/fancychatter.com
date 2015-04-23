      <hr>
      <div class="footer">
        <p style="margin: 0;"><a href="/terms">Terms of Service</a> &bull; <a href="/privacy">Privacy Policy</a><!-- &bull; <a href="/sitemap">Site Map</a>--></p>
        <p>&copy; <?php echo date("Y"); ?> <a href="http://www.fancychatter.com">FancyChatter.com</a> All Rights Reserved.</p>
      </div>
    <div class="dialog" id="dialog">
      <div class="dialog-close" onclick="dialog.close()"><i class="icon-remove"></i></div>
      <div class="dialog-header" id="dialog-header"></div>
      <div class="dialog-body" id="dialog-body"></div>
    </div>
    <div class="dialog-blanket" id="dialog-blanket"></div>
    <script src="/js/ajax.js"></script>
    <script src="/js/alerts.js"></script>
    <script src="/js/chitchat.js"></script>
    <script src="/js/constants.js"></script>
    <script src="/js/dialog<?php if (B2B) { echo "-b2b"; } ?>.js"></script>
    <script src="/js/maps.js"></script>
    <script src="/js/livechatter.js"></script>
    <script src="/js/profile.js"></script>
    <script src="/js/user.js"></script>
    <script src="/js/utilities.js"></script>
  </body>
</html>
<?php
if ($_GET['debug'] === "true" || ($_SESSION['debug'] === "true" && $_GET['debug'] !== "false")) {
  $mtime = explode(' ', microtime());
  $totaltime = $mtime[0] + $mtime[1] - $starttime;
  printf("<div style=\"background-color: #fff; color; #000; text-align: center;\">Page loaded in %.3f seconds.</div>", $totaltime);
}
?>
