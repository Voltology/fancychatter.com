<?php
class User {
  private $_id;
  private $_firstname;
  private $_lastname;
  private $_email;
  private $_role;
  private $_gmtoffset;
  private $_creation;
  private $_dst = true;

  private $_merchantid = null;
  private $_isloggedin = false;

  function __construct($id = null) {
    if ($id !== null) {
      $this->_id = $id;
      $this->set($row);
    }
  }

  public function add($email, $password, $firstname, $lastname, $role) {
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
    $query = sprintf("SELECT users.id,roles.role,firstname,lastname,email,merchant_id,gmt_offset,creation FROM users LEFT JOIN roles on users.role=roles.id WHERE email='%s' AND password='%s' LIMIT 1",
      mysql_real_escape_string($email),
      mysql_real_escape_string($password));
    $query = mysql_query($query);
    if (mysql_num_rows($query) > 0) {
      $row = mysql_fetch_assoc($query);
      $this->_id = $row['id'];
      $this->_isloggedin = true;
      $this->set($row);
      return true;
    } else {
      $this->_isloggedin = false;
      return false;
    }
  }

  public function delete() {
    $query = sprintf("UPDATE users SET role='0' WHERE id='%s'",
      mysql_real_escape_string($this->_id));
    mysql_query($query);
  }

  public function getCreation() {
    return $this->_creation;
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

  public function getId() {
    return $this->_id;
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

  public function getSavedSearches() {
    $searches = array();
    $query = sprintf("SELECT searches.id,searches.location,searches.category_id,searches.distance,searches.creation,livechatter_categories.category AS category FROM searches LEFT JOIN livechatter_categories ON category_id=livechatter_categories.id ORDER BY searches.creation DESC");
    $query = mysql_query($query);
    while ($row = mysql_fetch_assoc($query)) {
      array_push($searches, $row);
    }
    return $searches;
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
    $query = sprintf("UPDATE users SET email='%s', firstname='%s', lastname='%s' WHERE id='%s'",
      mysql_real_escape_string($user->_email),
      mysql_real_escape_string($user->_firstname),
      mysql_real_escape_string($user->_lastname),
      mysql_real_escape_string($user->_id));
    mysql_query($query);
  }

  public function saveSearch($location, $category, $distance, $saved = 0) {
    $query = sprintf("INSERT INTO searches SET location='%s', category_id='%s', distance='%s', saved='%s', creation='%s'",
      mysql_real_escape_string($location),
      mysql_real_escape_string($category),
      mysql_real_escape_string($distance),
      mysql_real_escape_string($saved),
      mysql_real_escape_string(time()));
    $query = mysql_query($query);
  }


  public function set($data= null) {
    if (!$data) {
      $query = sprintf("SELECT users.id,roles.role,firstname,lastname,email,merchant_id,gmt_offset,creation FROM users LEFT JOIN roles on users.role=roles.id WHERE id='%s' LIMIT 1",
        mysql_real_escape_string($email),
        mysql_real_escape_string($password));
      $query = mysql_query($query);
      $data = mysql_fetch_assoc($query);
    }
    $this->_firstname = $data['firstname'];
    $this->_lastname = $data['lastname'];
    $this->_email = $data['email'];
    $this->_id = $data['email'];
    $this->_role = $data['role'];
    $this->_merchantid = $data['merchant_id'];
    $this->_gmtoffset = $data['gmt_offset'];
    $this->_creation = $data['creation'];
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

  public function setId($id) {
    $this->_id = $id;
  }

  public function setIsLoggedIn($isloggedin) {
    $this->_isloggedin = $isloggedin;
  }

  public function setLastName($lastname) {
    $this->_lastname = $lastname;
  }

  public function setMerchantId($merchantid) {
    $this->_merchantid = $merchantid;
  }

  public function setRole($role) {
    $this->_role = $role;
  }

  public function update($id, $email, $password, $firstname, $lastname) {
    $query = sprintf("UPDATE users SET email='%s', password='%s', firstname='%s', lastname='%s' WHERE id='%s'",
      mysql_real_escape_string($email),
      mysql_real_escape_string(md5($password)),
      mysql_real_escape_string($firstname),
      mysql_real_escape_string($lastname),
      mysql_real_escape_string($id));
    mysql_query($query);
  }

  public static function validate($email, $password1, $password2, $firstname, $lastname, $role = 1) {
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
