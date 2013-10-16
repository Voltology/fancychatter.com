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
      $this->set();
    }
  }

  public function activateSearch($id) {
    global $mysqli;
    $query = sprintf("UPDATE searches SET active='1' WHERE id='%s' AND user_id='%s'",
      $mysqli->real_escape_string($id),
      $mysqli->real_escape_string($this->_id));
    $mysqli->query($query);
  }

  public function add($data, $role = 1) {
    global $mysqli;
    $query = sprintf("INSERT INTO users SET email='%s', password='%s', firstname='%s', lastname='%s', merchant_id='%s', role='%s', creation='%s'",
      $mysqli->real_escape_string($data['email']),
      $mysqli->real_escape_string(md5($data['password1'])),
      $mysqli->real_escape_string($data['firstname']),
      $mysqli->real_escape_string($data['lastname']),
      $mysqli->real_escape_string($data['merchant_id']),
      $mysqli->real_escape_string($role),
      $mysqli->real_escape_string(time()));
    $mysqli->query($query);
    return $mysqli->insert_id;
  }

  public function checkPassword($email, $password) {
    global $mysqli;
    $query = sprintf("SELECT users.id,roles.role,firstname,lastname,email,password,profile_img,merchant_id,city,state,gmt_offset,creation FROM users LEFT JOIN roles on users.role=roles.id WHERE email='%s' AND password='%s' LIMIT 1",
      $mysqli->real_escape_string($email),
      $mysqli->real_escape_string($password));
    $query = $mysqli->query($query);
    if ($query->num_rows > 0) {
      $row = $query->fetch_assoc();
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
    global $mysqli;
    $query = sprintf("UPDATE users SET role='0' WHERE id='%s'",
      $mysqli->real_escape_string($this->_id));
    $mysqli->query($query);
  }

  public function follow($id, $type) {
    global $mysqli;
    $query = sprintf("INSERT INTO followers SET type='%s', follower_id='%s', followee_id='%s', creation='%s'",
      $mysqli->real_escape_string($type),
      $mysqli->real_escape_string($this->_id),
      $mysqli->real_escape_string($id),
      $mysqli->real_escape_string(time()));
    $query = $mysqli->query($query);
    if ($type === 0) {
      $query = sprintf("SELECT followers.type,followee_id,users.firstname,users.lastname,users.profile_img FROM followers LEFT JOIN users ON followee_id=users.id WHERE follower_id='%s' AND followee_id='%s' LIMIT 1",
        $mysqli->real_escape_string($this->_id),
        $mysqli->real_escape_string($id));
    } else {
      $query = sprintf("SELECT followers.type,followee_id,merchants.name,merchants.logo FROM followers LEFT JOIN merchants ON followee_id=merchants.id WHERE follower_id='%s' AND followee_id='%s' LIMIT 1",
        $mysqli->real_escape_string($this->_id),
        $mysqli->real_escape_string($id));
    }
    $query = $mysqli->query($query);
    $this->_followers[] = $query->fetch_assoc();
  }

  public static function getById($id) {
    global $mysqli;
    $users = array();
    $query = sprintf("SELECT id,email,firstname,lastname,profile_img,city,state,creation FROM users WHERE id='%s' LIMIT 1",
      $mysqli->real_escape_string($id));
    $query = $mysqli->query($query);
    return $query->fetch_assoc();
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

  public function getFeed() {
    $feed = array();
    $feed = array_merge($feed, Alerts::get($this->_id));
    $feed = array_merge($feed, $this->getPosts());
    $feed = array_merge($feed, ChitChat::getByUserId($this->_id));
    $feed = array_merge($feed, $this->getRedemptions());
    usort($feed, function($a, $b) { return $b['creation'] - $a['creation']; });
    return $feed;
  }

  public function getFirstName() {
    return $this->_firstname;
  }

  public function getFollowers() {
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

  public function getPosts() {
    global $mysqli;
    $posts = array();
    $query = sprintf("SELECT posts.id,poster_id,body,posts.creation,users.firstname,users.lastname,users.profile_img FROM posts LEFT JOIN users ON poster_id=users.id WHERE user_id='%s' AND status='1' ORDER BY creation DESC LIMIT 10",
      $mysqli->real_escape_string($this->_id));
    $query = $mysqli->query($query);
    while ($row = $query->fetch_assoc()) {
      $row['type'] = "post";
      array_push($posts, $row);
    }
    return $posts;
  }

  public function getProfileImage() {
    return $this->_profileimage;
  }

  public function getRedemptions() {
    $redemptions = array();
    return $redemptions;
  }

  public function getRole() {
    return $this->_role;
  }

  public function getSavedSearches() {
    global $mysqli;
    $searches = array();
    $query = sprintf("SELECT searches.id,searches.location,searches.category_id,searches.distance,searches.saved,searches.active,searches.creation,livechatter_categories.category AS category FROM searches LEFT JOIN livechatter_categories ON category_id=livechatter_categories.id WHERE searches.user_id='%s' AND searches.saved='1' ORDER BY searches.creation DESC LIMIT 5",
      $mysqli->real_escape_string($this->_id));
    $query = $mysqli->query($query);
    while ($row = $query->fetch_assoc()) {
      array_push($searches, $row);
    }
    return $searches;
  }

  public function getState() {
    return $this->_state;
  }

  public static function getUserCount() {
    global $mysqli;
    $query = "SELECT COUNT(*) FROM users";
    $query = $mysqli->query($query);
    $users = $query->fetch_row();
    return $users[0];
  }

  public static function getUsers($count = 20, $index = 0, $order = "creation", $direction = "ASC") {
    global $mysqli;
    $users = array();
    $query = sprintf("SELECT users.id,email,firstname,lastname,creation,roles.role as role FROM users JOIN roles ON users.role=roles.id ORDER BY %s %s LIMIT %s,%s",
      $mysqli->real_escape_string($order),
      $mysqli->real_escape_string($direction),
      $mysqli->real_escape_string($index),
      $mysqli->real_escape_string($count));
    $query = $mysqli->query($query);
    while ($row = $query->fetch_assoc()) {
      array_push($users, $row);
    }
    return $users;
  }

  public static function getUsersByMerchant($id, $count = 20, $index = "0", $order = "creation", $direction = "ASC") {
    global $mysqli;
    $users = array();
    $query = sprintf("SELECT users.id,email,firstname,lastname,creation,roles.role as role FROM users JOIN roles ON users.role=roles.id WHERE merchant_id='%s' ORDER BY %s %s LIMIT %s,%s",
      $mysqli->real_escape_string($id),
      $mysqli->real_escape_string($order),
      $mysqli->real_escape_string($direction),
      $mysqli->real_escape_string($index),
      $mysqli->real_escape_string($count));
    $query = $mysqli->query($query);
    while ($row = $query->fetch_assoc()) {
      array_push($users, $row);
    }
    return $users;
  }

  public function inactivateSearch($id) {
    global $mysqli;
    $query = sprintf("UPDATE searches SET active='0' WHERE id='%s' AND user_id='%s'",
      $mysqli->real_escape_string($id),
      $mysqli->real_escape_string($this->_id));
    $mysqli->query($query);
  }

  public function login($email, $password) {
    global $mysqli;
    $query = sprintf("SELECT users.id,roles.role,firstname,lastname,email,password,profile_img,city,state,merchant_id,gmt_offset,creation FROM users LEFT JOIN roles on users.role=roles.id WHERE email='%s' AND password='%s' LIMIT 1",
      $mysqli->real_escape_string($email),
      $mysqli->real_escape_string($password));
    $query = $mysqli->query($query);
    if ($query->num_rows > 0) {
      $row = $query->fetch_assoc();
      $this->_id = $row['id'];
      $this->_isloggedin = true;
      $this->set($row);
      $this->setFollowers();
      return true;
    } else {
      $this->_isloggedin = false;
      return false;
    }
  }

  public function post($id, $msg) {
    global $mysqli;
    $query = sprintf("INSERT INTO posts SET user_id='%s', poster_id='%s', body='%s', status='1', creation='%s'",
      $mysqli->real_escape_string($id),
      $mysqli->real_escape_string($this->_id),
      $mysqli->real_escape_string($msg),
      $mysqli->real_escape_string(time()));
    $mysqli->query($query);
    return $mysqli->insert_id;
  }

  public function redeem($id) {
    global $mysqli;
    $query = sprintf("INSERT INTO redemptions SET user_id='%s', livechatter_id='%s', creation='%s'",
      $mysqli->real_escape_string($this->_id),
      $mysqli->real_escape_string($id),
      $mysqli->real_escape_string(time()));
    $mysqli->query($query);
  }

  public function removePost($id) {
    global $mysqli;
    $query = sprintf("UPDATE posts SET status='0' WHERE id='%s' AND (user_id='%s' OR poster_id='%s')",
      $mysqli->real_escape_string($id),
      $mysqli->real_escape_string($this->_id),
      $mysqli->real_escape_string($this->_id));
    $mysqli->query($query);
  }

  public function removeSearch($id) {
    global $mysqli;
    $query = sprintf("UPDATE searches SET saved='0' WHERE id='%s' AND user_id='%s'",
      $mysqli->real_escape_string($id),
      $mysqli->real_escape_string($this->_id));
    $mysqli->query($query);
  }

  public function save() {
    global $mysqli;
    $query = "UPDATE users SET " . substr($this->_savequery, 0, strrpos($this->_savequery, ",")) . sprintf(" WHERE id='%s'", $mysqli->real_escape_string($this->_id));
    $mysqli->query($query);
    $this->_savequery = null;
  }

  public function saveSearch($location, $category, $distance, $saved = 0, $active = 0) {
    global $mysqli;
    if (preg_match('/^[0-9]{5}$/', trim($location))) {
      $latlng = getLatLongByZip($location);
    } else {
      list($city, $state, $zip) = preg_split('/,\s/', $location);
      $latlng = getLatLongByCityState($city, $state, $zip);
    }
    $query = sprintf("INSERT INTO searches SET user_id='%s', location='%s', category_id='%s', distance='%s', latitude='%s', longitude='%s', saved='%s', active='%s', creation='%s'",
      $mysqli->real_escape_string($this->_id),
      $mysqli->real_escape_string($location),
      $mysqli->real_escape_string($category),
      $mysqli->real_escape_string($distance),
      $mysqli->real_escape_string($latlng['latitude']),
      $mysqli->real_escape_string($latlng['longitude']),
      $mysqli->real_escape_string($saved),
      $mysqli->real_escape_string($active),
      $mysqli->real_escape_string(time()));
    $query = $mysqli->query($query);
  }

  public function set($data = null) {
    global $mysqli;
    if (!$data) {
      $query = sprintf("SELECT users.id,roles.role,firstname,lastname,email,password,profile_img,city,state,merchant_id,gmt_offset,creation FROM users LEFT JOIN roles on users.role=roles.id WHERE users.id='%s' LIMIT 1",
        $mysqli->real_escape_string($this->_id));
      $query = $mysqli->query($query);
      $data = $query->fetch_assoc();
      $this->setFollowers();
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
    global $mysqli;
    $this->_savequery .= sprintf(" city='%s',", $mysqli->real_escape_string($city));
    $this->_city = $city;
  }

  public function setState($state) {
    global $mysqli;
    $this->_savequery .= sprintf(" state='%s',", $mysqli->real_escape_string($state));
    $this->_state = $state;
  }

  public function setEmail($email) {
    global $mysqli;
    $this->_savequery .= sprintf(" email='%s',", $mysqli->real_escape_string($email));
    $this->_email = $email;
  }

  public function setFirstName($firstname) {
    global $mysqli;
    $this->_savequery .= sprintf(" firstname='%s',", $mysqli->real_escape_string($firstname));
    $this->_firstname = $firstname;
  }

  public function setFollowers($followers = null) {
    global $mysqli;
    if ($followers) {
      $this->_followers = $followers;
    } else {
      $query = sprintf("SELECT type,followee_id,users.firstname,users.lastname,users.profile_img FROM followers LEFT JOIN users ON followee_id=users.id WHERE follower_id='%s' AND type='0'",
        $mysqli->real_escape_string($this->_id));
      $query = $mysqli->query($query);
      while ($row = $query->fetch_assoc()) {
        array_push($this->_followers, $row);
      }
      $query = sprintf("SELECT followers.type,followee_id,merchants.name,merchants.logo FROM followers LEFT JOIN merchants ON followee_id=merchants.id WHERE follower_id='%s' AND type='1'",
        $mysqli->real_escape_string($this->_id));
      $query = $mysqli->query($query);
      while ($row = $query->fetch_assoc()) {
        array_push($this->_followers, $row);
      }
    }
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
    global $mysqli;
    $this->_savequery .= sprintf(" lastname='%s',", $mysqli->real_escape_string($lastname));
    $this->_lastname = $lastname;
  }

  public function setMerchantId($merchantid) {
    global $mysqli;
    $this->_savequery .= sprintf(" merchant_id='%s',", $mysqli->real_escape_string($merchantid));
    $this->_merchantid = $merchantid;
  }

  public function setPassword($password) {
    global $mysqli;
    $this->_savequery .= sprintf(" password='%s',", $mysqli->real_escape_string(md5($password)));
    $this->_password = $password;
  }

  public function setProfileImage($image) {
    global $mysqli;
    $this->_savequery .= sprintf(" profile_img='%s',", $mysqli->real_escape_string($image));
    $this->_profileimage = $image;
  }

  public function setRole($role) {
    $this->_role = $role;
  }

  public function unfollow($id, $type) {
    global $mysqli;
    $query = sprintf("DELETE FROM followers WHERE type='%s' AND follower_id='%s' AND followee_id='%s'",
      $mysqli->real_escape_string($type),
      $mysqli->real_escape_string($this->_id),
      $mysqli->real_escape_string($id),
      $mysqli->real_escape_string(time()));
    $query = $mysqli->query($query);
    for ($i = 0; $i < count($this->_followers); $i++) {
      if ($this->_followers[$i]['followee_id'] === $id) {
        array_splice($this->_followers, $i, 1);
        break;
      }
    }
  }

  public function update($id, $email, $password, $firstname, $lastname) {
    global $mysqli;
    $query = sprintf("UPDATE users SET email='%s', password='%s', firstname='%s', lastname='%s' WHERE id='%s'",
      $mysqli->real_escape_string($email),
      $mysqli->real_escape_string(md5($password)),
      $mysqli->real_escape_string($firstname),
      $mysqli->real_escape_string($lastname),
      $mysqli->real_escape_string($id));
    $mysqli->query($query);
  }

  public static function validate($data, $role = 1, $fields = null) {
    global $mysqli;
    $errors = array();
    $query = sprintf("SELECT id FROM users WHERE email='%s' LIMIT 1",
      $mysqli->real_escape_string($data['email']));
    $query = $mysqli->query($query);
    if ($data['firstname'] === "" && !($fields)) { $errors[] = "You must enter a first name."; }
    if ($data['lastname'] === "" && !($fields)) { $errors[] = "You must enter a last name."; }
    if ($query->num_rows > 0) { $errors[] = "That email address is already in use."; }
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) && !($fields)) { $errors[] = "You must enter a valid email."; }
    if (strlen($data['password1']) < 6 && !($fields)) { $errors[] = "The password must be at least 6 characters."; }
    if ($data['password1'] != $data['password2'] && !($fields)) { $errors[] = "The passwords must match."; }
    if ($role === "null" && !($fields)) { $errors[] = "You must select a role."; }
    return $errors;
  }
}
?>
