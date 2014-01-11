<?php
header("Content-type: application/json");
include("../../../.local.inc.php");
if ($_SERVER['REQUEST_METHOD'] === "POST" || $_SERVER['REQUEST_METHOD'] === "GET") {
  $json['errors'] = array();
  $json['result'] = "success";
  $action = $_REQUEST['a'] ? $_REQUEST['a'] : null;
  $source = $_REQUEST['s'] ? $_REQUEST['s'] : null;
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
    case "chitchat-get":
      $merchant = new Merchant($_REQUEST['merchant-token']);
      $chitchats = ChitChat::getByCategory($merchant->getCategory());
      $count = 0;
      foreach ($chitchats as $chitchat) {
        if ($chitchat['user_id']) {
          $userid = $chitchat['user_id'];
          $chitchats[$count]['responses'] = ChitChat::getResponsesByIdAndUser($chitchat['id'], $chitchat['user_id'], $merchant->getId());
          $count++;
        }
      }
      $json['merchant']['logo'] = $merchant->getLogo();
      $json['merchant']['name'] = $merchant->getName();
      $json['chitchat'] = $chitchats;
      break;
    case "chitchat-respond":
      if ($source === "admin-app") {
        if ($user->checkPassword($_GET['email'], $_GET['password'])) {
          $merchant = new Merchant($_REQUEST['merchant-token']);
          $chitchat = new ChitChat();
          $chitchat->respond($_REQUEST['chitchat-id'], $user->getId(), null, $_REQUEST['body']);
        }
      }
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
    case "create-livechatter":
      break;
    case "delete-chitchat":
      $chitchat = new ChitChat($_GET['id']);
      $chitchat->delete();
      break;
    case "delete-livechatter":
      break;
    case "follow":
      $type = $_REQUEST['type'] == "1" ? 1 : 0;
      $user->follow($_REQUEST['id'], $type);
      Alerts::add($_REQUEST['id'], "<a href=\"/profile?id=" . $user->getId() . "\">" . $user->getFirstName() . " " . $user->getLastName() . "</a> is now following you!");
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
    case "getcitystatebylatlong":
      $location = getCityStateByLatLong($_GET['lat'], $_GET['lng']);
      break;
    case "getfeed":
      if ($user->checkPassword($_GET['email'], $_GET['password'])) {
        $json['feed'] = $user->getFeed();
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
    case "livechatter-get":
      if ($source === "admin-app") {
        $merchant = new Merchant($_REQUEST['merchant-token']);
        $json['livechatter'] = LiveChatter::getByMerchantId($merchant->getId());
      }
      break;
    case "livechatter-send":
      if ($source === "admin-app") {
        $merchant = new Merchant($_REQUEST['merchant-token']);
        LiveChatter::add($merchant->getId(), $_REQUEST['body'], $merchant->getLatitude(), $merchant->getLongitude(), $start, $end, 0);
      }
      break;
    case "login":
      if ($source === "admin-app") {
        if (!$user->checkPassword($_GET['email'], md5($_GET['password']))) {
          $json['result'] = "failed";
          array_push($json['errors'], "Incorrect Username/Password");
        } else if ($user->getMerchantId() === ""){
          $json['result'] = "failed";
          array_push($json['errors'], "You must have a merchant account to use this application");
        } else {
          $json['id'] = $user->getId();
          $json['email'] = $_GET['email'];
          $json['firstname'] = $user->getFirstName();
          $json['password'] = md5($_GET['password']);
          $json['token'] = md5($_GET['password']);
          $json['merchant-token'] = $user->getMerchantId();
          $json['alert_count'] = Alerts::count($user->getId());
        }
      } else if ($source === "public-app") {
        if (!$user->checkPassword($_GET['email'], md5($_GET['password']))) {
          $json['result'] = "failed";
          array_push($json['errors'], "Incorrect Username/Password");
        } else {
          $json['id'] = $user->getId();
          $json['email'] = $_GET['email'];
          $json['firstname'] = $user->getFirstName();
          $json['password'] = md5($_GET['password']);
          $json['token'] = md5($_GET['password']);
          $json['merchant-token'] = $user->getMerchantId();
          $json['alert_count'] = Alerts::count($user->getId());
        }
      } else {
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
        $json['token'] = md5($_GET['password']);
        $json['merchant-token'] = $user->getMerchantId();
        $json['alert_count'] = Alerts::count($user->getId());
      }
      break;
    case "login-app-check":
      if (!$user->checkPassword($_GET['email'], $_GET['password'])) {
        $json['result'] = "failed";
        array_push($json['errors'], "Incorrect Username/Password");
      }
      break;
    case "pause-livechatter":
      break;
    case "post":
      if ($user->getId() != $_REQUEST['id']) {
        Alerts::add($_REQUEST['id'], $user->getFirstName() . " " . $user->getLastName() . " has posted something on your profile!");
      }
      $json['post']['id'] = $user->post($_REQUEST['id'], $_REQUEST['msg']);
      $json['post']['profile_img'] = $user->getProfileImage() !== "" ? $user->getProfileImage() : "default.png";
      $json['post']['name'] = $user->getFirstName() . " " . $user->getLastName();
      $json['post']['timestamp'] = date("F j, Y, g:i a", time());
      break;
    case "redeem":
      $livechatter = new LiveChatter($_REQUEST['id']);
      $merchant = new Merchant($livechatter->getMerchantId());
      $user->redeem($_REQUEST['id']);
      Alerts::add($user->getId(), "You have redeemed a LiveChatter from " . $merchant->getName() . "!");
      break;
    case "removechitchat":
      ChitChat::remove($_REQUEST['id']);
      break;
    case "removealert":
      Alerts::remove($_REQUEST['id']);
      break;
    case "removepost":
      $user->removePost($_REQUEST['id']);
      break;
    case "removesearch":
      $user->removeSearch($_REQUEST['id']);
      break;
    case "share":
      //$livechatter->share($users);
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
      $type = $_REQUEST['type'] == "1" ? 1 : 0;
      $user->unfollow($_REQUEST['id'], $type);
      break;
    case "unpause-livechatter":
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
