<?php
header("Content-type: application/json");
include("../.local.inc.php");
if ($_SERVER['REQUEST_METHOD'] === "POST" || $_SERVER['REQUEST_METHOD'] === "GET") {
  $json['errors'] = array();
  $json['result'] = "success";
  $action = $_REQUEST['a'] ? $_REQUEST['a'] : null;
  switch($action) {
    case "autocomplete-profile":
      $json['results'] = getUsersAndMerchants($_REQUEST['search']);
      break;
    case "autocomplete-where":
      if (preg_match('/[0-9]+/', $_REQUEST['where'])) {
        $json['locations'] = getLocationsByZip($_REQUEST['where']);
      } else {
        $json['locations'] = getLocationsByCity($_REQUEST['where']);
      }
      break;
    case "chitchat-respond":
      $chitchat = new ChitChat();
      //$chitchat->respone($user->getId(), 1, $msg);
      break;
    case "chitchat-send":
      $msg = $_REQUEST['msg'];
      if ($msg == "") {
        $json['result'] = "failed";
        array_push($json['errors'], "ChitChat message cannot be blank");
      } else {
        $chitchat = new ChitChat();
        $chitchat->send($user->getId(), 1, $msg);
      }
      break;
    case "follow":
      $user->follow($_REQUEST['id']);
      break;
    case "login":
      if (!$user->checkPassword($_REQUEST['email'], md5($_REQUEST['password']))) {
        $json['result'] = "failed";
        array_push($json['errors'], "Incorrect Username/Password");
      } else {
        setcookie("email", $_REQUEST['email']);
        setcookie("password", md5($_REQUEST['password']));
      }
      break;
    case "post":
      $user->post($id, $msg);
      break;
    case "signup":
      $user = new User();
      $errors = $user->validate($_REQUEST['email'], $_REQUEST['password1'], $_REQUEST['password2'], $_REQUEST['firstname'], $_REQUEST['lastname'], 1);
      if (count($errors) === 0) {
        setcookie("email", $_REQUEST['email']);
        setcookie("password", md5($_REQUEST['password1']));
        $id = $user->add($_REQUEST['email'], $_REQUEST['password1'], $_REQUEST['firstname'], $_REQUEST['lastname'], 1);
        $user->setId($id);
        $user->set();
      } else {
        $json['result'] = "failed";
        foreach ($errors as $error) {
          array_push($json['errors'], $error);
        }
      }
      break;
    case "unfollow":
      $user->unfollow($_REQUEST['id']);
      break;
    default:
      $json['result'] = "failed";
      array_push($json['errors'], "No method defined");
      break;
  }
} else {
  $json['result'] = "failed";
  array_push($json['errors'], "Not authorized");
}
if ($_SERVER['REQUEST_METHOD'] === "POST") { 
  echo json_encode($json);
} else if ($_SERVER['REQUEST_METHOD'] === "GET") {
  echo $_GET['callback'] . "(" . json_encode($json) . ")";
}
