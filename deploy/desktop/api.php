<?php
header("Content-type: application/json");
include("../.local.inc.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $json['errors'] = array();
  $json['result'] = "success";
  $action = $_POST['a'] ? $_POST['a'] : null;
  switch($action) {
    case "chitchat-respond":
      $chitchat = new ChitChat();
      //$chitchat->respone($user->getId(), 1, $msg);
      break;
    case "chitchat-send":
      $msg = $_POST['msg'];
      if ($msg == "") {
        $json['result'] = "failed";
        array_push($json['errors'], "ChitChat message cannot be blank");
      } else {
        $chitchat = new ChitChat();
        $chitchat->send($user->getId(), 1, $msg);
      }
      break;
    case "login":
      if (!$user->checkPassword($_POST['email'], md5($_POST['password']))) {
        $json['result'] = "failed";
        array_push($json['errors'], "Incorrect Username/Password");
      } else {
        setcookie("email", $_POST['email']);
        setcookie("password", md5($_POST['password']));
      }
      break;
    case "signup":
      $user = new User();
      $errors = $user->validate($_POST['email'], $_POST['password1'], $_POST['password2'], $_POST['firstname'], $_POST['lastname'], 1);
      if (count($errors) === 0) {
        $id = $user->add($_POST['email'], $_POST['password1'], $_POST['firstname'], $_POST['lastname'], 1);
        $user->setId($id);
        $user->set();
      } else {
        $json['result'] = "failed";
        foreach ($errors as $error) {
          array_push($json['errors'], $error);
        }
      }
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
echo json_encode($json);
