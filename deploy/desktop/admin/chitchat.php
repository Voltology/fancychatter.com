<?php
if (in_array($user->getRole(), array("administrator", "merchant_admin"))) {
  switch ($action) {
    case null:
?>
      <h1>ChitChat</h1>
      <form action="<? echo $_SERVER['REQUEST_URI']; ?>" method="POST">
        <table border="0" cellpadding="0" cellspacing="0" width="60%" class="edit-table">
          <tr class="tableheader">
            <th>New ChitChat</th>
          </tr>
          <tr>
            <td>test</td>
          </tr>
        </table>
<?php
    break;
  }
}
?>
