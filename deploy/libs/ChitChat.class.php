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

  public function get() {
    return $this->_chitchat;
  }

  public static function getAll() {
    $chitchat = array();
    $query = sprintf("SELECT id,user_id,category_id,body,creation FROM chitchat ORDER BY creation DESC");
    $query = mysql_query($query);
    while ($row = mysql_fetch_assoc($query)) {
      array_push($chitchat, $row);
    }
    return $chitchat;
  }

  public function getResponses() {
    return $this->_responses;
  }

  public static function send($user, $category, $msg) {
    $query = sprintf("INSERT INTO chitchat SET user_id='%s', category_id='%s', body='%s', creation='%s'",
      mysql_real_escape_string($user),
      mysql_real_escape_string($category),
      mysql_real_escape_string($msg),
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
