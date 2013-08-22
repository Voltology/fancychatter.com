<?php
class Database {
    private $_dbhost;
    private $_dbuser;
    private $_dbpass;
    private $_dbname;
    private $_dbconn;

    public $error = false;

    function Database($dbhost = DB_HOST, $dbuser = DB_USER, $dbpass = DB_PASS, $dbname = DB_NAME) {
        $this->_dbhost = $dbhost;
        $this->_dbuser = $dbuser;
        $this->_dbpass = $dbpass;
        $this->_dbname = $dbname;
        $this->_dbconn = mysql_connect($this->_dbhost, $this->_dbuser, $this->_dbpass);
        if (!$this->_dbconn) {
          die('Could not connect: ' . mysql_error());
        }
        $db = mysql_select_db($this->_dbname, $this->_dbconn);
    }

    public function close() {
        mysql_close($this->_dbconn);
    }

    public function query($query) {
        return mysql_query($query, $this->_dbconn);
    }
}
?>
