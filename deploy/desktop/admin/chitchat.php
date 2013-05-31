<?php
if (in_array($user->getRole(), array("administrator", "merchant_admin"))) {
  switch ($action) {
    case null:
?>
      <h1>ChitChat</h1>
      <form action="<? echo $_SERVER['REQUEST_URI']; ?>" method="POST">
        <table border="0" cellpadding="4" cellspacing="0" width="60%" class="edit-table">
          <tr class="tableheader">
            <th>New ChitChat</th>
          </tr>
          <tr>
            <td>
              <ul style="margin: 0; list-style-type: none; padding: 5px; width: 100%;">
              <?php
              $chitchats = ChitChat::getAll();
              foreach ($chitchats as $chitchat) {
              ?>
                <li style="display: inline-block; width: 50px; vertical-align: top; margin-right: 5px;">
                  <div style="background-color: #eee; height: 50px; width: 100%; border: 1px solid #ccc;"></div>
                </li>
                <li style="display: inline-block; width: 75%; position: relative; border-bottom: 1px solid #ccc;">
                  <strong>chris@fancychatter.com</strong><br /><p><?php echo $chitchat['body']; ?></p>
                  <div style="position: absolute; top: 0px; right: 5px; color: #666;"><?php echo date("F j, Y, g:i a", $chitchat['creation']); ?></div>
                </li>
                <li>
                  <ul>
                    <li style="list-style-type: none; border-bottom: 1px solid #ccc; margin-bottom: 10px; width: 540px;">
                      <form>
                        <textarea style="height: 80px; width: 500px; margin: 15px 0 5px 20px;"></textarea>
                        <button class="button" style="margin: 0 0 10px 20px;">Send Response</button>
                      </form>
                    </li>
                  </ul>
                </li>
              <?php
              }
              ?>
              </ul>
            </td>
          </tr>
        </table>
<?php
    break;
  }
}
?>
