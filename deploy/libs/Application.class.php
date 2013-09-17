<?php
class Application {
  private $_id;
  private $_name;
  private $_email;
  private $_logo;
  private $_firstname;
  private $_lastname;
  private $_address1;
  private $_address2;
  private $_city;
  private $_state;
  private $_zipcode;
  private $_phone;
  private $_creation;
  private $_approval = false;

  function __construct($id = null) {
    if ($id) {
      $this->_id = $id;
      $this->set();
    }
  }

  public function add() {
    $query = sprintf("INSERT INTO applications SET name='%s', contact_email='%s', logo='%s', address1='%s', address2='%s', city='%s', state='%s', zipcode='%s', phone='%s', creation='%s'",
      mysql_real_escape_string($this->_name),
      mysql_real_escape_string($this->_email),
      mysql_real_escape_string($this->_logo),
      mysql_real_escape_string($this->_address1),
      mysql_real_escape_string($this->_address2),
      mysql_real_escape_string($this->_city),
      mysql_real_escape_string($this->_state),
      mysql_real_escape_string($this->_zipcode),
      mysql_real_escape_string($this->_phone),
      mysql_real_escape_string(time()));
    mysql_query($query);
  }

  public function delete() {
  }

  public function save() {
  }

  public function set() {
  }

  public function setAddress1($address1) {
    $this->_address1 = $address1;
  }

  public function setAddress2($address2) {
    $this->_address2 = $address2;
  }

  public function setCity($city) {
    $this->_city = $city;
  }

  public function setEmail($email) {
    $this->_email = $email;
  }

  public function setLogo($logo) {
    $this->_logo = $logo;
  }

  public function setName($name) {
    $this->_name = $name;
  }

  public function setPhone($phone) {
    $this->_phone = $phone;
  }

  public function setState($state) {
    $this->_state = $state;
  }

  public function setZipCode($zipcode) {
    $this->_zipcode = $zipcode;
  }

  public function validate() {
    $errors = array();
    if ($this->_name === "") { $errors[] = "You must enter a business name."; }
    if ($this->_address1 === "") { $errors[] = "You must enter an address."; }
    if ($this->_city === "") { $errors[] = "You must enter a city."; }
    if ($this->_state === "null") { $errors[] = "You must enter a state."; }
    if ($this->_zipcode === "") { $errors[] = "You must enter a zip code."; }
    if ($this->_phone === "") { $errors[] = "You must enter a phone number."; }
    return $errors;
  }
}
?>
