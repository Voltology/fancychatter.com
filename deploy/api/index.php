<?php
header('Content-type: application/json');
include('../.local.inc.php');
$action = $_REQUEST['action'] ? $_REQUEST['action'] : null;
//if ($_SERVER['HTTP_HOST'] === PERMISSIONED_SERVER && $_SERVER['REQUEST_METHOD'] == "GET") {
if ($_SERVER['REQUEST_METHOD'] == "GET") {
  if ($action === "login") {
    $json['result'] = "success";
  } else if ($action === "logout") {
  } else {
    $json['result'] = "error";
  }
} else {
  $json['result'] = "error";
  array_push($json['errors'], "Not Authorized");
}
echo "json(" . json_encode($json) . ")";
?>
