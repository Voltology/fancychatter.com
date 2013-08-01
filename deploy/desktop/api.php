<?php
header("Content-type: application/json");
include("../.local.inc.php");
if ($_SERVER['REQUEST_METHOD'] === "POST" || $_SERVER['REQUEST_METHOD'] === "GET") {
  $json['errors'] = array();
  $json['result'] = "success";
  $action = $_REQUEST['a'] ? $_REQUEST['a'] : null;
  switch($action) {
    case "activatesearch":
      $user->activateSearch($_REQUEST['id']);
      break;
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
      $chitchat->respond($_REQUEST['cc-id'], $profile->getId(), null, $_REQUEST['body']);
      break;
    case "chitchat-send":
      $msg = $_REQUEST['msg'];
      if ($msg == "") {
        $json['result'] = "failed";
        array_push($json['errors'], "ChitChat message cannot be blank");
      } else {
        $chitchat = new ChitChat();
        $chitchat->send($user->getId(), $_REQUEST['location'], $_REQUEST['category'], $_REQUEST['distance'], $msg);
      }
      break;
    case "chitchat-send-app":
      $msg = $_REQUEST['msg'];
      if ($user->checkPassword($_GET['email'], $_GET['password'])) {
        if ($msg == "") {
          $json['result'] = "failed";
          array_push($json['errors'], "ChitChat message cannot be blank");
        } else {
          $chitchat = new ChitChat();
          $chitchat->send($user->getId(), $_GET['location'], $_GET['category'], $_GET['distance'], $msg);
        }
      } else {
        $json['result'] = "failed";
        array_push($json['errors'], "Not authorized");
        $json['logout'] = true;
      }
      break;
    case "follow":
      $user->follow($_REQUEST['id']);
      break;
    case "getalerts":
      if ($user->checkPassword($_GET['email'], $_GET['password'])) {
        $json['alerts'] = Alerts::get($id);
      } else {
        $json['result'] = "failed";
        array_push($json['errors'], "Not authorized");
        $json['logout'] = true;
      }
      break;
    case "getfeed":
      if ($user->checkPassword($_GET['email'], $_GET['password'])) {
        $json['feed']['chitchats'] = ChitChat::getByUserId($_REQUEST['id']);
        $json['feed']['posts'] = $user->getPosts();
      //$json['feed']['redemptions'] = 
      } else {
        $json['result'] = "failed";
        array_push($json['errors'], "Not authorized");
        $json['logout'] = true;
      }
      break;
    case "getmerchant":
      if ($user->checkPassword($_GET['email'], $_GET['password'])) {
        $json['user'] = User::getById($_REQUEST['id']);
      } else {
        $json['result'] = "failed";
        array_push($json['errors'], "Not authorized");
        $json['logout'] = true;
      }
      break;
    case "getuser":
      if ($user->checkPassword($_GET['email'], $_GET['password'])) {
        $json['user'] = User::getById($_REQUEST['id']);
      } else {
        $json['result'] = "failed";
        array_push($json['errors'], "Not authorized");
        $json['logout'] = true;
      }
      break;
    case "inactivatesearch":
      $user->inactivateSearch($_REQUEST['id']);
      break;
    case "livechatter":
      if ($user->checkPassword($_GET['email'], $_GET['password'])) {
        $json['category_name'] = getCategoryById($_REQUEST['what']);
        $json['livechatter'] = LiveChatter::search($_REQUEST['where'], $_REQUEST['what'], $_REQUEST['distance'], 20);
      } else {
        $json['result'] = "failed";
        array_push($json['errors'], "Not authorized");
        $json['logout'] = true;
      }
      break;
    case "login":
      if (!$user->login($_POST['email'], md5($_POST['password']))) {
        $json['result'] = "failed";
        array_push($json['errors'], "Incorrect Username/Password");
      } else {
        if (!B2B) {
          setcookie("email", $_POST['email']);
          setcookie("password", md5($_POST['password']));
        } else if (in_array($user->getRole(), array("administrator", "merchant_admin", "merchant_editor"))) {
          setcookie("email", $_POST['email']);
          setcookie("password", md5($_POST['password']));
        } else {
          $json['result'] = "failed";
          array_push($json['errors'], "You are not authorized for this site.");
        }
      }
      break;
    case "login-app":
      if (!$user->checkPassword($_GET['email'], md5($_GET['password']))) {
        $json['result'] = "failed";
        array_push($json['errors'], "Incorrect Username/Password");
      } else {
        $json['id'] = $user->getId();
        $json['email'] = $_GET['email'];
        $json['firstname'] = $user->getFirstName();
        $json['password'] = md5($_GET['password']);
        $json['alert_count'] = Alerts::count($user->getId());
      }
      break;
    case "login-app-check":
      if (!$user->checkPassword($_GET['email'], $_GET['password'])) {
        $json['result'] = "failed";
        array_push($json['errors'], "Incorrect Username/Password");
      }
      break;
    case "post":
      if ($user->getId() != $_REQUEST['id']) {
        Alerts::add($_REQUEST['id'], $user->getFirstName() . " " . $user->getLastName() . " has posted something on your profile!");
      }
      $user->post($_REQUEST['id'], $_REQUEST['msg']);
      $json['post']['profile_img'] = $user->getProfileImage() !== "" ? $user->getProfileImage() : "default.png";
      $json['post']['name'] = $user->getFirstName() . " " . $user->getLastName();
      $json['post']['timestamp'] = date("F j, Y, g:i a", time());
      break;
    case "profile":
      $json['profile'] = new User(1);
      break;
    case "redeem":
      $user->redeem($id);
      break;
    case "removepost":
      $user->removePost($_REQUEST['id']);
      break;
    case "removesearch":
      $user->removeSearch($_REQUEST['id']);
      break;
    case "signup":
      $user = new User();
      $data = $_POST;
      $errors = $user->validate($data);
      if (count($errors) === 0) {
        setcookie("email", $_POST['email']);
        setcookie("password", md5($_POST['password1']));
        $id = $user->add($data, 1);
        $user->setId($id);
        $user->set();
      } else {
        $json['result'] = "failed";
        foreach ($errors as $error) {
          array_push($json['errors'], $error);
        }
      }
      break;
    case "signup-app":
      $user = new User();
      $data = $_POST;
      $errors = $user->validate($data);
      if (count($errors) === 0) {
        setcookie("email", $_GET['email']);
        setcookie("password", md5($_GET['password1']));
        $id = $user->add($_GET['email'], $_GET['password1'], $_GET['firstname'], $_GET['lastname'], 1);
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
