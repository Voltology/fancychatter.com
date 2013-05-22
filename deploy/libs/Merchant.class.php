<?php
class Merchant {
  private $_id;
  private $_name;
  private $_logo;
  private $_address1;
  private $_address2;
  private $_city;
  private $_state;
  private $_zipcode;
  private $_country;
  private $_phone;
  private $_latitude;
  private $_longitude;
  private $_creation;

  function __construct($id) {
    $this->_id = $id;
    $this->set();
  }

  public function add($name, $logo, $latitude, $longitude) {
    $query = sprintf("INSERT INTO merchants SET name='%s', logo='%s', latitude='%s', longitude='%s'",
      mysql_real_escape_string($name),
      mysql_real_escape_string($logo),
      mysql_real_escape_string($latitude),
      mysql_real_escape_string($longitude));
      echo $query;
    mysql_query($query);
    return mysql_insert_id();
  }

  public function delete($id) {
    $query = sprintf("DELETE FROM merchants WHERE id='%s'",
      mysql_real_escape_string($id));
    mysql_query($query);
  }

  public function getCreation() {
    return $this->_creation;
  }

  public function getLogo() {
    return $this->_logo;
  }

  public static function getMerchants($count = 20, $index = "0", $order = "creation", $direction = "ASC") {
    $merchant = array();
    $query = sprintf("SELECT id,name,contact_email,address1,address2,city,state,zipcode,phone,latitude,longitude,creation FROM merchants ORDER BY %s %s LIMIT %s,%s",
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
    $query = sprintf("UPDATE merchants SET name='%s', logo='%s' WHERE id='%s'",
      mysql_real_escape_string($this->_name),
      mysql_real_escape_string($this->_logo),
      mysql_real_escape_string($this->_id));
    mysql_query($query);
  }

  public function set() {
    $query = sprintf("SELECT id,name,logo,latitude,longitude FROM merchants WHERE id='%s' LIMIT 1",
      mysql_real_escape_string($this->_id));
    $query = mysql_query($query);
    if (mysql_num_rows($query) > 0) {
      $merchant = mysql_fetch_assoc($query);
      $this->setName($merchant['name']);
      $this->setLogo($merchant['logo']);
      return true;
    } else {
      $this->setId(null);
      return false;
    }
  }

  public function setId($id) {
    $this->_id = $id;
  }

  public function setLogo($logo) {
    $this->_logo = $logo;
  }

  public function setName($name) {
    $this->_name = $name;
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

  public function validate($name, $logo, $firstname, $lastname, $email, $password1, $password2, $role) {
    $errors = array();
    if ($firstname === "") { $errors[] = "You must enter a first name."; }
    if ($lastname === "") { $errors[] = "You must enter a last name."; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = "You must enter a valid email."; }
    if (strlen($password1) < 6) { $errors[] = "The password must be at least 6 characters."; }
    if ($password1 != $password2) { $errors[] = "The passwords must match."; }
    if ($role === "null") { $errors[] = "You must select a role."; }
    return $errors;
  }
}
?>
