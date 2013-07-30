<?php
class Merchant {
  private $_id;
  private $_name;
  private $_logo;
  private $_firstname;
  private $_lastname;
  private $_email;
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

  private $_followers = array();

  function __construct($id = null) {
    if ($id) {
      $this->_id = $id;
      $this->set();
    }
  }

  public function add($data) {
    $query = sprintf("INSERT INTO merchants SET name='%s', category_id='%s', logo='%s', latitude='%s', longitude='%s', address1='%s', address2='%s', city='%s', state='%s', zipcode='%s', phone='%s', creation='%s'",
      mysql_real_escape_string($data['name']),
      mysql_real_escape_string($data['category']),
      mysql_real_escape_string($data['logo']),
      mysql_real_escape_string($data['latitude']),
      mysql_real_escape_string($data['longitude']),
      mysql_real_escape_string($data['address1']),
      mysql_real_escape_string($data['address2']),
      mysql_real_escape_string($data['city']),
      mysql_real_escape_string($data['state']),
      mysql_real_escape_string($data['zipcode']),
      mysql_real_escape_string($data['phone']),
      mysql_real_escape_string(time()));
    mysql_query($query);
    return mysql_insert_id();
  }

  public function delete($id) {
    $query = sprintf("DELETE FROM merchants WHERE id='%s'",
      mysql_real_escape_string($id));
    mysql_query($query);
  }

  public function getAddress1() {
    return $this->_address1;
  }

  public function getAddress2() {
    return $this->_address2;
  }

  public function getCategory() {
    return $this->_category;
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
    return $this->_followers;
  }

  public function getId() {
    return $this->_id;
  }

  public function getJSONData() {
    $query = sprintf("SELECT id,name,logo,address1,address2,city,state,zipcode,phone FROM merchants WHERE merchants.id='%s' LIMIT 1",
      mysql_real_escape_string($this->_id));
    $query = mysql_query($query);
    return mysql_fetch_assoc($query);
  }

  public function getLastName() {
    return $this->_lastname;
  }

  public function getLatitude() {
    return $this->_latitude;
  }

  public function getLogo() {
    return $this->_logo;
  }

  public function getLongitude() {
    return $this->_longitude;
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

  public function getPhone() {
    return $this->_phone;
  }

  public function getName() {
    return $this->_name;
  }

  public function getState() {
    return $this->_state;
  }

  public function getZipCode() {
    return $this->_zipcode;
  }

  public function save() {
    $query = sprintf("UPDATE merchants SET name='%s', category='%s', logo='%s' WHERE id='%s'",
      mysql_real_escape_string($this->_name),
      mysql_real_escape_string($this->_category),
      mysql_real_escape_string($this->_logo),
      mysql_real_escape_string($this->_id));
    mysql_query($query);
  }

  public function set() {
    $query = sprintf("SELECT merchants.id,name,merchants.category_id,logo,address1,address2,merchants.city,merchants.state,zipcode,latitude,longitude,phone,users.firstname,users.lastname,users.email FROM merchants LEFT JOIN users ON users.merchant_id=merchants.id WHERE merchants.id='%s' LIMIT 1",
      mysql_real_escape_string($this->_id));
    $query = mysql_query($query);
    if (mysql_num_rows($query) > 0) {
      $merchant = mysql_fetch_assoc($query);
      $this->_name = $merchant['name'];
      $this->_category= $merchant['category_id'];
      $this->_firstname = $merchant['firstname'];
      $this->_lastname = $merchant['lastname'];
      $this->_email = $merchant['email'];
      $this->_address1 = $merchant['address1'];
      $this->_address2 = $merchant['address2'];
      $this->_city = $merchant['city'];
      $this->_state = $merchant['state'];
      $this->_zipcode = $merchant['zipcode'];
      $this->_phone = $merchant['phone'];
      $this->_latitude = $merchant['latitude'];
      $this->_longitude = $merchant['longitude'];
      $this->_logo = $merchant['logo'];
      return true;
    } else {
      $this->setId(null);
      return false;
    }
  }

  public function setCategory($category) {
    $this->_category = $category;
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

  public function update($data) {
    $query = sprintf("UPDATE merchants SET name='%s', category_id='%s', logo='%s', latitude='%s', longitude='%s', address1='%s', address2='%s', city='%s', state='%s', zipcode='%s', phone='%s' WHERE id='%s'",
      mysql_real_escape_string($data['name']),
      mysql_real_escape_string($data['category']),
      mysql_real_escape_string($data['logo']),
      mysql_real_escape_string($data['latitude']),
      mysql_real_escape_string($data['longitude']),
      mysql_real_escape_string($data['address1']),
      mysql_real_escape_string($data['address2']),
      mysql_real_escape_string($data['city']),
      mysql_real_escape_string($data['state']),
      mysql_real_escape_string($data['zipcode']),
      mysql_real_escape_string($data['phone']),
      mysql_real_escape_string($this->_id));
    mysql_query($query);
  }

  public function validate($action, $data) {
    $errors = array();
    if ($data['firstname'] === "") { $errors[] = "You must enter a first name."; }
    if ($data['lastname'] === "") { $errors[] = "You must enter a last name."; }
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) && $action === "add") { $errors[] = "You must enter a valid email."; }
    if (strlen($data['password1']) < 6 && $action === "add") { $errors[] = "The password must be at least 6 characters."; }
    if ($data['password1'] != $data['password2'] && $action === "add") { $errors[] = "The passwords must match."; }
    return $errors;
  }
}
?>
