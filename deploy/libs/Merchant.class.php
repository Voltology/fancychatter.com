<?php
class Merchant {
  private $_id;
  private $_name;
  private $_latitude;
  private $_longitude;
  private $_creation;

  public function LiveChatter($id) {
    $this->_id = $id;
    $this->set();
  }

  public function add($name, $latitude, $longitude) {
    $query = sprintf("INSERT INTO merchant SET name='%s', latitude='%s', longitude='%s'",
      mysql_real_escape_string($name),
      mysql_real_escape_string($latitude),
      mysql_real_escape_string($longitude));
    mysql_query($query);
  }

  public function delete($id) {
    $query = sprintf("DELETE FROM merchant WHERE id='%s'",
      mysql_real_escape_string($id));
    mysql_query($query);
  }

  public function getCreation() {
    return $this->_creation;
  }

  public static function getMerchants($count = 20, $index = "0", $order = "creation", $direction = "ASC") {
    $merchant = array();
    $query = sprintf("SELECT id,name,latitude,longitude,creations FROM merchant ORDER BY %s %s LIMIT %s,%s",
      mysql_real_escape_string($order),
      mysql_real_escape_string($direction),
      mysql_real_escape_string($index),
      mysql_real_escape_string($count));
    $query = mysql_query($query);
    while ($row = mysql_fetch_assoc($query)) {
      array_push($merchant, $row);
    }
    return $merchant;
  }

  public function getName() {
    return $this->_name;
  }

  public function save() {
    $query = "UPDATE";
  }
  public function setId($id) {
    $this->_id = $id;
  }

  public function setName($name) {
    $this->_name = $name;
  }

  public function set($id) {
    $query = sprintf("SELECT id,name,latitude,longitude FROM merchant WHERE id='%s' LIMIT 1",
      mysql_real_escape_string($this->_id));
    $query = mysql_query($query);
    if (mysql_num_rows($query) > 0) {
      $merchant = mysql_fetch_assoc($query);
      $this->setName($merchant['name']);
      return true;
    } else {
      $this->setId(null);
      return false;
    }
  }

  public function update($name, $latitude, $longitude) {
    $query = sprintf("UPDATE merchant SET email='%s', password='%s', firstname='%s', lastname='%s' WHERE id='%s'",
      mysql_real_escape_string($email),
      mysql_real_escape_string(md5($password)),
      mysql_real_escape_string($firstname),
      mysql_real_escape_string($lastname),
      mysql_real_escape_string($id));
    mysql_query($query);
  }
}
?>
