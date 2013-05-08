<?php
class User {
  private $_firstname;
  private $_lastname;
  private $_email;
  private $_role;
  private $_gmtoffset;

  private $_merchantid;
  private $_isloggedin;

  public function addUser($email, $password, $firstname, $lastname, $role = 1) {
    $query = sprintf("INSERT INTO users SET email='%s', password='%s', firstname='%s', lastname='%s', role='%s', creation='%s'",
      mysql_real_escape_string($email),
      mysql_real_escape_string(md5($password)),
      mysql_real_escape_string($firstname),
      mysql_real_escape_string($lastname),
      mysql_real_escape_string($role),
      mysql_real_escape_string(time()));
    mysql_query($query);
  }

  public function checkPassword($email, $password) {
    $query = sprintf("SELECT users.id,roles.role,firstname,lastname,email,merchant_id,gmt_offset FROM users LEFT JOIN roles on users.role=roles.id WHERE email='%s' AND password='%s' LIMIT 1",
      mysql_real_escape_string($email),
      mysql_real_escape_string($password));
    $query = mysql_query($query);
    if (mysql_num_rows($query) > 0) {
      $row = mysql_fetch_assoc($query);
      $this->setUser($row);
      $this->setRole($row['role']);
      $this->setMerchantId($row['merchant_id']);
      $this->setGmtOffset($row['gmt_offset']);
      $this->setIsLoggedIn(true);
      return true;
    } else {
      $this->setIsLoggedIn(false);
      return false;
    }
  }

  public function deleteUserById($id) {
    $query = sprintf("DELETE FROM users WHERE id='%s'",
      mysql_real_escape_string($id));
    mysql_query($query);
  }

  public function getCreation() {
    return 0;
  }

  public function getEmail() {
    return $this->_email;
  }

  public function getFirstName() {
    return $this->_firstname;
  }

  public function getGmtOffset() {
    return $this->_gmtoffset * 60 * 60;
  }

  public function getMerchantId() {
    return $this->_merchantid;
  }

  public function getIsLoggedIn() {
    return $this->_isloggedin;
  }

  public function getLastName() {
    return $this->_lastname;
  }

  public function getRole() {
    return $this->_role;
  }

  public static function getUsers($count = 20, $index = "0", $order = "creation", $direction = "ASC") {
    $users = array();
    $query = sprintf("SELECT users.id,email,firstname,lastname,creation,roles.role as role FROM users JOIN roles ON users.role=roles.id ORDER BY %s %s LIMIT %s,%s",
      mysql_real_escape_string($order),
      mysql_real_escape_string($direction),
      mysql_real_escape_string($index),
      mysql_real_escape_string($count));
    $query = mysql_query($query);
    while ($row = mysql_fetch_assoc($query)) {
      array_push($users, $row);
    }
    return $users;
  }

  public function save() {
    $query = "UPDATE";
  }

  public function setEmail($email) {
    $this->_email = $email;
  }

  public function setFirstName($firstname) {
    $this->_firstname = $firstname;
  }

  public function setGmtOffset($gmtoffset) {
    $this->_gmtoffset = $gmtoffset;
  }

  public function setLastName($lastname) {
    $this->_lastname = $lastname;
  }

  public function setMerchantId($merchantid) {
    $this->_merchantid = $merchantid;
  }

  public function setUserById($id) {
    return false;
  }

  public function setIsLoggedIn($isloggedin) {
    $this->_isloggedin = $isloggedin;
  }

  public function setRole($role) {
    $this->_role = $role;
  }

  public function setUser($data) {
    $this->setFirstName($data['firstname']);
    $this->setLastName($data['lastname']);
    $this->setEmail($data['email']);
  }

  public function updateUser($id, $email, $password, $firstname, $lastname) {
    $query = sprintf("UPDATE users SET email='%s', password='%s', firstname='%s', lastname='%s' WHERE id='%s'",
      mysql_real_escape_string($email),
      mysql_real_escape_string(md5($password)),
      mysql_real_escape_string($firstname),
      mysql_real_escape_string($lastname),
      mysql_real_escape_string($id));
    mysql_query($query);
  }
}
?>
