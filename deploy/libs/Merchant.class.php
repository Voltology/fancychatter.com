<?php
class Merchant {
  private $_firstname;
  private $_lastname;
  private $_email;
  private $_role;
  private $_isloggedin;

  public function addMerchant($email, $password, $firstname, $lastname, $role) {
    $query = sprintf("INSERT INTO users SET email='%s', password='%s', firstname='%s', lastname='%s', role='%s'",
      mysql_real_escape_string($email),
      mysql_real_escape_string(md5($password)),
      mysql_real_escape_string($firstname),
      mysql_real_escape_string($lastname),
      mysql_real_escape_string($role));
    mysql_query($query);
  }

  public function checkPassword($email, $password) {
    $query = sprintf("SELECT users.id,roles.role,firstname,lastname,email FROM users LEFT JOIN roles on users.role=roles.id WHERE email='%s' AND password='%s' LIMIT 1",
      mysql_real_escape_string($email),
      mysql_real_escape_string($password));
    $query = mysql_query($query);
    if (mysql_num_rows($query) > 0) {
      $row = mysql_fetch_assoc($query);
      $this->setMerchant($row);
      $this->setIsLoggedIn(true);
      $this->setRole($row['role']);
      return true;
    } else {
      $this->setIsLoggedIn(false);
      return false;
    }
  }

  public function deleteMerchantById($id) {
    $query = sprintf("DELETE FROM users WHERE id='%s'",
      mysql_real_escape_string($id));
    mysql_query($query);
  }

  public function getCreationDate() {
    return 0;
  }

  public function getEmail() {
    return $this->_email;
  }

  public function getFirstName() {
    return $this->_firstname;
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

  public static function getMerchants($count = 20, $index = "0", $order = "creation", $direction = "ASC") {
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

  public function setLastName($lastname) {
    $this->_lastname = $lastname;
  }

  public function setMerchantById($id) {
    return false;
  }

  public function setIsLoggedIn($isloggedin) {
    $this->_isloggedin = $isloggedin;
  }

  public function setRole($role) {
    $this->_role = $role;
  }

  public function setMerchant($data) {
    $this->setFirstName($data['firstname']);
    $this->setLastName($data['lastname']);
    $this->setEmail($data['email']);
  }

  public function updateMerchant($id, $email, $password, $firstname, $lastname) {
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
