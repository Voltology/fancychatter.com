<?php
class User {
  private $_email;
  private $_role;
  private $_isloggedin = false;

  public function checkPassword($email, $password) {
    $this->_isloggedin = true;
    return true;
  }

  public function getRole() {
    return $this->_role;
  }

  public function isLoggedIn() {
    return $this->_isloggedin;
  }

  public function setRole($role) {
    $this->_role = $role;
  }
}
