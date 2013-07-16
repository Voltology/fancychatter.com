<?php
class User {
  private $_id;
  private $_firstname;
  private $_lastname;
  private $_email;
  private $_password;
  private $_profileimage;
  private $_city;
  private $_state;
  private $_role;
  private $_gmtoffset;
  private $_creation;
  private $_dst = true;

  private $_merchantid = null;
  private $_isloggedin = false;
  private $_savequery = null;
  private $_followers = array();

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
    return mysql_insert_id();
  }

  public function checkPassword($email, $password) {
    $query = sprintf("SELECT users.id,roles.role,firstname,lastname,email,password,profile_img,city,state,merchant_id,gmt_offset,creation FROM users LEFT JOIN roles on users.role=roles.id WHERE email='%s' AND password='%s' LIMIT 1",
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

  public function follow($id) {
    $query = sprintf("INSERT INTO followers SET follower_id='%s', followee_id='%s', creation='%s'",
      mysql_real_escape_string($this->_id),
      mysql_real_escape_string($id),
      mysql_real_escape_string(time()));
    $query = mysql_query($query);
    $this->_followers[] = $id;
  }

  public function getCity() {
    return $this->_city;
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

  public function getFollowers() {
    $query = sprintf("SELECT followee_id FROM followers WHERE follower_id='%s'",
      mysql_real_escape_string($this->_id));
    $query = mysql_query($query);
    while ($row = mysql_fetch_assoc($query)) {
      array_push($this->_followers, $row);
    }
    return $this->_followers;
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

  public function getProfileImage() {
    return $this->_profileimage;
  }

  public function getRole() {
    return $this->_role;
  }

  public function getSavedSearches() {
    $searches = array();
    $query = sprintf("SELECT searches.id,searches.location,searches.category_id,searches.distance,searches.creation,livechatter_categories.category AS category FROM searches LEFT JOIN livechatter_categories ON category_id=livechatter_categories.id ORDER BY searches.creation DESC LIMIT 5");
    $query = mysql_query($query);
    while ($row = mysql_fetch_assoc($query)) {
      array_push($searches, $row);
    }
    return $searches;
  }

  public function getState() {
    return $this->_state;
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
    $query = "UPDATE users SET " . substr($this->_savequery, 0, strrpos($this->_savequery, ",")) . sprintf(" WHERE id='%s'", mysql_real_escape_string($this->_id));
    mysql_query($query);
    $this->_savequery = null;
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


  public function set($data = null) {
    if (!$data) {
      $query = sprintf("SELECT users.id,roles.role,firstname,lastname,email,password,profile_img,city,state,merchant_id,gmt_offset,creation FROM users LEFT JOIN roles on users.role=roles.id WHERE users.id='%s' LIMIT 1",
        mysql_real_escape_string($this->_id));
      $query = mysql_query($query);
      $data = mysql_fetch_assoc($query);
    }
    $this->_id = $data['id'];
    $this->_isloggedin = true;
    $this->_firstname = $data['firstname'];
    $this->_lastname = $data['lastname'];
    $this->_email = $data['email'];
    $this->_city = $data['city'];
    $this->_state = $data['state'];
    $this->_profileimage = $data['profile_img'];
    $this->_role = $data['role'];
    $this->_merchantid = $data['merchant_id'];
    $this->_gmtoffset = $data['gmt_offset'];
    $this->_creation = $data['creation'];
  }

  public function setCity($city) {
    $this->_savequery .= sprintf(" city='%s',", mysql_real_escape_string($city));
    $this->_city = $city;
  }

  public function setState($state) {
    $this->_savequery .= sprintf(" state='%s',", mysql_real_escape_string($state));
    $this->_state = $state;
  }

  public function setEmail($email) {
    $this->_savequery .= sprintf(" email='%s',", mysql_real_escape_string($email));
    $this->_email = $email;
  }

  public function setFirstName($firstname) {
    $this->_savequery .= sprintf(" firstname='%s',", mysql_real_escape_string($firstname));
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
    $this->_savequery .= sprintf(" lastname='%s',", mysql_real_escape_string($lastname));
    $this->_lastname = $lastname;
  }

  public function setMerchantId($merchantid) {
    $this->_merchantid = $merchantid;
  }

  public function setProfileImage($image) {
    $this->_savequery .= sprintf(" profile_img='%s',", mysql_real_escape_string($image));
    $this->_profileimage = $image;
  }

  public function setRole($role) {
    $this->_role = $role;
  }

  public function unfollow($id) {
    $query = sprintf("DELETE FROM followers WHERE follower_id='%s', followee_id='%s'",
      mysql_real_escape_string($this->_id),
      mysql_real_escape_string($id),
      mysql_real_escape_string(time()));
    $query = mysql_query($query);
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

  public static function validate($email, $password1, $password2, $firstname, $lastname, $role = 1, $fields = null) {
    $errors = array();
    if ($firstname === "" && !($fields)) { $errors[] = "You must enter a first name."; }
    if ($lastname === "" && !($fields)) { $errors[] = "You must enter a last name."; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !($fields)) { $errors[] = "You must enter a valid email."; }
    if (strlen($password1) < 6 && !($fields)) { $errors[] = "The password must be at least 6 characters."; }
    if ($password1 != $password2 && !($fields)) { $errors[] = "The passwords must match."; }
    if ($role === "null" && !($fields)) { $errors[] = "You must select a role."; }
    return $errors;
  }
}
?>
