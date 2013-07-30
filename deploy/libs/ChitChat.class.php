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
    $query = sprintf("DELETE FROM chitchat WHERE id='%s'",
      mysql_real_escape_string($this->_id));
    mysql_query($query);
  }

  public function get() {
    return $this->_chitchat;
  }

  public static function getAll() {
    $chitchat = array();
    $query = sprintf("SELECT chitchat.id,user_id,category_id,body,chitchat.creation,users.firstname,users.lastname FROM chitchat LEFT JOIN users ON users.id=chitchat.user_id ORDER BY creation DESC");
    $query = mysql_query($query);
    while ($row = mysql_fetch_assoc($query)) {
      array_push($chitchat, $row);
    }
    return $chitchat;
  }

  public static function getByCategory($category) {
    $chitchat = array();
    $query = sprintf("SELECT chitchat.id,user_id,category_id,body,chitchat.creation,users.firstname,users.lastname FROM chitchat LEFT JOIN users ON users.id=chitchat.user_id WHERE category_id='%s' ORDER BY creation DESC",
      mysql_real_escape_string($category));
    $query = mysql_query($query);
    while ($row = mysql_fetch_assoc($query)) {
      array_push($chitchat, $row);
    }
    return $chitchat;
  }

  public static function getByUserId($id) {
    $chitchat = array();
    $query = sprintf("SELECT chitchat.id,user_id,category_id,livechatter_categories.category,body,location,distance,creation FROM chitchat LEFT JOIN livechatter_categories ON category_id=livechatter_categories.id WHERE user_id='%s' ORDER BY creation DESC",
      mysql_real_escape_string($id));
    $query = mysql_query($query);
    while ($row = mysql_fetch_assoc($query)) {
      array_push($chitchat, $row);
    }
    return $chitchat;
  }

  public static function getCount() {
    $chitchat = array();
    $query = sprintf("SELECT id FROM chitchat ORDER BY creation DESC");
    $query = mysql_query($query);
    return mysql_num_rows($query);
  }

  public function getResponsesById($id) {
    $responses = array();
    $query = sprintf("SELECT chitchat_responses.id,user_id,chitchat_responses.merchant_id,body,users.firstname,users.lastname,merchants.name AS merchant_name,merchants.logo,chitchat_responses.creation FROM chitchat_responses LEFT JOIN users ON users.id=chitchat_responses.user_id LEFT JOIN merchants ON merchants.id=chitchat_responses.merchant_id WHERE chitchat_id='%s' ORDER BY creation ASC",
      mysql_real_escape_string($id));
    $query = mysql_query($query);
    while ($row = mysql_fetch_assoc($query)) {
      array_push($responses, $row);
    }
    return $responses;
  }

  public static function respond($ccid, $uid, $mid, $msg) {
    $query = sprintf("INSERT INTO chitchat_responses SET chitchat_id='%s', user_id='%s', merchant_id='%s', body='%s', creation='%s'",
      mysql_real_escape_string($ccid),
      mysql_real_escape_string($uid),
      mysql_real_escape_string($mid),
      mysql_real_escape_string($msg),
      mysql_real_escape_string(time()));
    $query = mysql_query($query);
  }

  public static function send($user, $location, $category, $distance, $msg) {
    if (preg_match('/^[0-9]{5}$/', $location)) {
      $latlng = getLatLongByZip($location);
    } else {
      list($city, $state, $zip) = preg_split('/,\s?|\s/', $location);
      $latlng = getLatLongByCityState($city, $state, $zip);
    }
    $query = sprintf("INSERT INTO chitchat SET user_id='%s', category_id='%s', location='%s', distance='%s', body='%s', latitude='%s', longitude='%s', creation='%s'",
      mysql_real_escape_string($user),
      mysql_real_escape_string($category),
      mysql_real_escape_string($location),
      mysql_real_escape_string($distance),
      mysql_real_escape_string($msg),
      mysql_real_escape_string($latlng['latitude']),
      mysql_real_escape_string($latlng['longitude']),
      mysql_real_escape_string(time()));
    $query = mysql_query($query);
  }

  public function set() {
    $query = sprintf("SELECT id,user_id,category_id,body,creation FROM chitchat WHERE id='%s' LIMIT 1",
      mysql_real_escape_string($this->_id));
    $query = mysql_query($query);
    $this->_chitchat = mysql_fetch_assoc($query);
    $query = sprintf("SELECT id,user_id,merchant_id,body,creation FROM chitchat_responses WHERE chitchat_id='%s'",
      mysql_real_escape_string($this->_id));
    $query = mysql_query($query);
    while ($row = mysql_fetch_assoc($query)) {
      array_push($this->_responses, $row);
    }
  }
}
?>
