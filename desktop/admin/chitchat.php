<?php
if (in_array($user->getRole(), array("administrator", "merchant_admin"))) {
  switch ($action) {
    case null:
    case "delete":
      if ($action === "delete") {
        $chitchat = new ChitChat($_GET['id']);
        $chitchat->delete();
      }
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
              $chitchats = ChitChat::getByCategory($merchant->getCategory());
              foreach ($chitchats as $chitchat) {
                if ($chitchat['user_id']) {
                  $userid = $chitchat['user_id'];
                }
              ?>
                <ul style="margin: 0; padding: 0;">
                  <li style="display: inline-block; width: 54px; vertical-align: top; margin-right: 5px;">
                    <div style="background-color: #eee; height: 50px; width: 50px; border: 1px solid #ccc;"><img src="/uploads/profile/default.png" height="100%" width="100%" /></div>
                  </li>
                  <li style="display: inline-block; width: 80%; position: relative; border-bottom: 1px solid #ccc; min-height: 80px; padding: 5px;">
                    <!--<div style="position: absolute; top: 5px; right: 5px; cursor: pointer;" onclick="document.location='?p=chitchat&a=delete&id=<?php echo $chitchat['id']; ?>'"><i class="icon-remove"></i></div>-->
                    <strong><?php echo $chitchat['firstname']; ?> <?php echo $chitchat['lastname']; ?></strong><br /><p><?php echo $chitchat['body']; ?></p>
                    <div style="position: absolute; top: 5px; right: 25px; color: #666;"><?php echo date("F j, Y, g:i a", $chitchat['creation']); ?></div>
                  </li>
                </ul>
                <?php
                $responses = ChitChat::getResponsesByIdAndUser($chitchat['id'], $chitchat['user_id'], $merchant->getId());
                foreach ($responses as $response) {
                ?>
                <ul>
                  <li style="padding-left: 0; min-height: 60px; list-style-type: none;">
                    <ul>
                      <li style="list-style-type: none; padding: 4px 0; width: 55px; display: inline-block;">
                        <div style="height: 50px; width: 50px; border: 1px solid #ccc; overflow: hidden;">
                          <?php
                          if ($response['last_response'] === "user") {
                          ?>
                          <img src="/uploads/profile/default.png" width="50" />
                          <?php
                          } else {
                          ?>
                          <img src="/uploads/logos/<?php echo $merchant->getLogo(); ?>" width="50" />
                          <?php
                          }
                          ?>
                        </div>
                      </li>
                      <li style="list-style-type: none; border-bottom: 1px solid #ccc; margin-bottom: 10px; width: 440px; display: inline-block; vertical-align: top; padding: 4px 0;">
                        <?php
                        if ($response['last_response'] === "user") {
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
                </ul>
                <?php
                }
                ?>
                <li>
                  <ul>
                    <li style="list-style-type: none; border-bottom: 1px solid #ccc; margin-bottom: 10px; width: 640px;">
                      <form method="post">
                        <textarea name="body" style="height: 80px; width: 440px; margin: 15px 0 5px 40px;"></textarea>
                        <input type="hidden" name="user-id" id="user-id" value="<?php echo $userid; ?>" /><br />
                        <input type="hidden" name="cc-id" id="cc-id" value="<?php echo $chitchat['id']; ?>" /><br />
                        <input type="hidden" name="formpage" value="chitchat" />
                        <button type="submit" class="button" style="margin: 0 0 10px 40px;">Send Response</button>
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
