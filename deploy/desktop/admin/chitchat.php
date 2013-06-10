<?php
if (in_array($user->getRole(), array("administrator", "merchant_admin"))) {
  if ($_SERVER['REQUEST_METHOD'] === "POST") {
    ChitChat::respond($_POST['cc-id'], null, $merchant->getId(), $_POST['body']);
  }
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
                  <div style="background-color: #eee; height: 50px; width: 100%; border: 1px solid #ccc;"><img src="/uploads/logos/<?php echo $merchant->getLogo(); ?>" width="50px" /></div>
                </li>
                <li style="display: inline-block; width: 75%; position: relative; border-bottom: 1px solid #ccc;">
                  <strong>chris@fancychatter.com</strong><br /><p><?php echo $chitchat['body']; ?></p>
                  <div style="position: absolute; top: 0px; right: 5px; color: #666;"><?php echo date("F j, Y, g:i a", $chitchat['creation']); ?></div>
                </li>
                <?php
                $responses = ChitChat::getResponsesById($chitchat['id']);
                foreach ($responses as $response) {
                ?>
                  <li style="padding-left: 20px; min-height: 60px;">
                    <ul>
                      <li style="list-style-type: none; padding: 4px 0; width: 55px; display: inline-block;">
                        <div style="height: 50px; width: 50px; border: 1px solid #ccc; overflow: hidden;">
                          <img src="/uploads/profile/default.png" width="50" />
                        </div>
                      </li>
                      <li style="list-style-type: none; border-bottom: 1px solid #ccc; margin-bottom: 10px; width: 440px; display: inline-block; vertical-align: top; padding: 4px 0;">
                        <?php
                        if ($response['user_id'] > 0) {
                        ?>
                        <strong><?php echo $response['firstname']; ?> <?php echo $response['lastname']; ?></strong><br />
                        <?php
                        } else {
                        ?>
                        <strong><?php echo $response['merchant_name']; ?></strong><br />
                        <?php
                        }
                        ?>
                        <p style="min-height: 30px;"><?php echo $response['body']; ?></p>
                      </li>
                    </ul>
                  </li>
                <?php
                }
                if ($response['user_id'] > 0) {
                ?>
                <li>
                  <ul>
                    <li style="list-style-type: none; border-bottom: 1px solid #ccc; margin-bottom: 10px; width: 540px;">
                      <form method="post">
                        <textarea name="body" style="height: 80px; width: 440px; margin: 15px 0 5px 80px;"></textarea>
                        <input type="hidden" name="cc-id" id="cc-id" value="<?php echo $chitchat['id']; ?>" />
                        <button type="submit" class="button" style="margin: 0 0 10px 80px;">Send Response</button>
                      </form>
                    </li>
                  </ul>
                </li>
              <?php
                }
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
