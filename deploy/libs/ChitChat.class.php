<?php
class ChitChat {
  private $_id;
  private $_chitchat;
  private $_responses = array();

  function __construct($id = null) {
    if ($id !== null) {
      $this->_id = $id;
      $this->set();
    }
  }

  public function delete() {
    global $mysqli;
    $query = sprintf("DELETE FROM chitchat WHERE id='%s'",
      $mysqli->real_escape_string($this->_id));
    $mysqli->query($query);
  }

  public function get() {
    return $this->_chitchat;
  }

  public static function getAll() {
    global $mysqli;
    $chitchat = array();
    $query = sprintf("SELECT chitchat.id,user_id,category_id,body,chitchat.creation,users.firstname,users.lastname FROM chitchat LEFT JOIN users ON users.id=chitchat.user_id ORDER BY creation DESC");
    $query = $mysqli->query($query);
    while ($row = $query->fetch_assoc()) {
      array_push($chitchat, $row);
    }
    return $chitchat;
  }

  public static function getByCategory($category) {
    global $mysqli;
    $chitchat = array();
    $query = sprintf("SELECT chitchat.id,user_id,category_id,body,chitchat.creation,users.firstname,users.lastname FROM chitchat LEFT JOIN users ON users.id=chitchat.user_id WHERE category_id='%s' ORDER BY creation DESC",
      $mysqli->real_escape_string($category));
    $query = $mysqli->query($query);
    while ($row = $query->fetch_assoc()) {
      array_push($chitchat, $row);
    }
    return $chitchat;
  }

  public static function getByUserId($id) {
    global $mysqli;
    $chitchat = array();
    $query = sprintf("SELECT chitchat.id,user_id,category_id,livechatter_categories.category,body,location,distance,creation FROM chitchat LEFT JOIN livechatter_categories ON category_id=livechatter_categories.id WHERE user_id='%s' ORDER BY creation DESC LIMIT 10",
      $mysqli->real_escape_string($id));
    $query = $mysqli->query($query);
    while ($row = $query->fetch_assoc()) {
      $row['type'] = "chitchat";
      array_push($chitchat, $row);
    }
    return $chitchat;
  }

  public static function getCount($id) {
    global $mysqli;
    $chitchat = array();
    $query = sprintf("SELECT id FROM chitchat WHERE category_id='%s' ORDER BY creation DESC",
      $mysqli->real_escape_string($id));
    $query = $mysqli->query($query);
    return $query->num_rows;
  }

  public function getResponsesById($cid) {
    global $mysqli;
    $responses = array();
    $query = sprintf("SELECT chitchat_responses.id,user_id,chitchat_responses.merchant_id,last_response,body,users.firstname,users.lastname,merchants.name AS merchant_name,merchants.logo,chitchat_responses.creation FROM chitchat_responses LEFT JOIN users ON users.id=chitchat_responses.user_id LEFT JOIN merchants ON merchants.id=chitchat_responses.merchant_id WHERE chitchat_id='%s' ORDER BY merchant_id ASC, creation ASC",
      $mysqli->real_escape_string($cid),
      $mysqli->real_escape_string($uid));
    $query = $mysqli->query($query);
    while ($row = $query->fetch_assoc()) {
      array_push($responses, $row);
    }
    return $responses;
  }

  public function getResponsesByIdAndUser($cid, $uid, $mid) {
    global $mysqli;
    $responses = array();
    $query = sprintf("SELECT chitchat_responses.id,user_id,chitchat_responses.merchant_id,last_response,body,users.firstname,users.lastname,merchants.name AS merchant_name,merchants.logo,chitchat_responses.creation FROM chitchat_responses LEFT JOIN users ON users.id=chitchat_responses.user_id LEFT JOIN merchants ON merchants.id=chitchat_responses.merchant_id WHERE chitchat_id='%s' AND (chitchat_responses.user_id='%s' AND chitchat_responses.merchant_id='%s') ORDER BY creation ASC",
      $mysqli->real_escape_string($cid),
      $mysqli->real_escape_string($uid),
      $mysqli->real_escape_string($mid));
    $query = $mysqli->query($query);
    while ($row = $query->fetch_assoc()) {
      array_push($responses, $row);
    }
    return $responses;
  }

  public function remove($id) {
    global $mysqli;
    $query = sprintf("DELETE FROM chitchat WHERE id='%s'",
      $mysqli->real_escape_string($id));
    $mysqli->query($query);
  }

  public static function respond($ccid, $uid, $mid, $msg, $who) {
    global $mysqli;
    $query = sprintf("INSERT INTO chitchat_responses SET chitchat_id='%s', user_id='%s', merchant_id='%s', last_response='%s', body='%s', creation='%s'",
      $mysqli->real_escape_string($ccid),
      $mysqli->real_escape_string($uid),
      $mysqli->real_escape_string($mid),
      $mysqli->real_escape_string($who),
      $mysqli->real_escape_string($msg),
      $mysqli->real_escape_string(time()));
    $query = $mysqli->query($query);
  }

  public static function send($user, $location, $category, $distance, $msg) {
    global $mysqli;
    if (preg_match('/^[0-9]{5}$/', $location)) {
      $latlng = getLatLongByZip($location);
    } else {
      list($city, $state, $zip) = preg_split('/,\s?|\s/', $location);
      $latlng = getLatLongByCityState($city, $state, $zip);
    }
    $query = sprintf("INSERT INTO chitchat SET user_id='%s', category_id='%s', location='%s', distance='%s', body='%s', latitude='%s', longitude='%s', creation='%s'",
      $mysqli->real_escape_string($user),
      $mysqli->real_escape_string($category),
      $mysqli->real_escape_string($location),
      $mysqli->real_escape_string($distance),
      $mysqli->real_escape_string($msg),
      $mysqli->real_escape_string($latlng['latitude']),
      $mysqli->real_escape_string($latlng['longitude']),
      $mysqli->real_escape_string(time()));
    $query = $mysqli->query($query);
  }

  public function set() {
    global $mysqli;
    $query = sprintf("SELECT id,user_id,category_id,body,creation FROM chitchat WHERE id='%s' LIMIT 1",
      $mysqli->real_escape_string($this->_id));
    $query = $mysqli->query($query);
    $this->_chitchat = $query->fetch_assoc();
    $query = sprintf("SELECT id,user_id,merchant_id,body,creation FROM chitchat_responses WHERE chitchat_id='%s'",
      $mysqli->real_escape_string($this->_id));
    $query = $mysqli->query($query);
    while ($row = $query->fetch_assoc()) {
      array_push($this->_responses, $row);
    }
  }
}
?>
