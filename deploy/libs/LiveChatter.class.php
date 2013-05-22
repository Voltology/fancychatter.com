<?php
class LiveChatter {
  private $_id;
  private $_merchantid;
  private $_body;
  private $_starttime;
  private $_endtime;
  private $_creation;

  public function __construct($id, $merchantid) {
    $this->_id = $id;
    $this->_merchantid = $merchantid;
    $this->set();
  }

  public function activate() {
    $query = sprintf("UPDATE livechatter SET status = (SELECT id FROM livechatter_statuses WHERE livechatter_statuses.status='activated' LIMIT 1) WHERE id='%s' AND merchant_id='%s'",
      mysql_real_escape_string($this->_id),
      mysql_real_escape_string($this->_merchantid));
    mysql_query($query);
  }

  public static function add($merchant_id, $body, $starttime, $endtime, $gmtoffset) {
    $offset = $gmtoffset * 60 * 60;
    $query = sprintf("INSERT INTO livechatter SET merchant_id='%s', body='%s', starttime='%s', endtime='%s', status='1', creation='%s'",
      mysql_real_escape_string($merchant_id),
      mysql_real_escape_string($body),
      mysql_real_escape_string($starttime + $offset),
      mysql_real_escape_string($endtime + $offset),
      mysql_real_escape_string(time() + $offset));
    $query = mysql_query($query);
  }

  public function deactivate() {
    $query = sprintf("UPDATE livechatter SET status = (SELECT id FROM livechatter_statuses WHERE livechatter_statuses.status='deactivated' LIMIT 1) WHERE id='%s' AND merchant_id='%s'",
      mysql_real_escape_string($this->_id),
      mysql_real_escape_string($this->_merchantid));
    mysql_query($query);
  }

  public function delete() {
    $query = sprintf("UPDATE livechatter SET status = (SELECT id FROM livechatter_statuses WHERE livechatter_statuses.status='deleted' LIMIT 1) WHERE id='%s' AND merchant_id='%s'",
      mysql_real_escape_string($this->_id),
      mysql_real_escape_string($this->_merchantid));
    mysql_query($query);
  }

  public function getBody() {
    return $this->_body;
  }

  public function getEndTime() {
    return $this->_endtime;
  }

  public function getId() {
    return $this->_id;
  }

  public static function getByMerchantId($merchantid) {
    $livechatter = array();
    $query = sprintf("SELECT livechatter.id,body,starttime,endtime,livechatter_statuses.status AS status FROM livechatter LEFT JOIN livechatter_statuses ON livechatter.status=livechatter_statuses.id WHERE merchant_id='%s' AND livechatter_statuses.status != 'deleted' ORDER BY creation DESC",
      mysql_real_escape_string($merchantid));
    $query = mysql_query($query);
    while ($row = mysql_fetch_assoc($query)) {
      array_push($livechatter, $row);
    }
    return $livechatter;
  }

  public function getStartTime() {
    return $this->_starttime;
  }

  public function pause() {
    $query = sprintf("UPDATE livechatter SET status = (SELECT id FROM livechatter_statuses WHERE livechatter_statuses.status='paused' LIMIT 1) WHERE id='%s' AND merchant_id='%s'",
      mysql_real_escape_string($this->_id),
      mysql_real_escape_string($this->_merchantid));
    mysql_query($query);
  }

  public function save() {
    $query = sprintf("UPDATE livechatter SET body='%s', starttime='%s', endtime='%s' WHERE id='%s' AND merchant_id='%s'",
      mysql_real_escape_string($this->getBody()),
      mysql_real_escape_string($this->getStartTime()),
      mysql_real_escape_string($this->getEndTime()),
      mysql_real_escape_string($this->_id),
      mysql_real_escape_string($this->_merchantid));
    mysql_query($query);
  }

  public function search($citystatezip, $category, $page, $amount) {
    $livechatter = array();
    $query = sprintf("SELECT id, SQRT((69.1*(" . $lat . " - latitude)*69.1*(" . $lat . "-latitude))+(53*(" . $long . "-longitude)*53*(" . $long . "-longitude))) AS distance,body FROM livechatter ORDER BY distance ASC");
    $query = mysql_query($query);
    while ($row = mysql_fetch_assoc($query)) {
      array_push($livechatter, $row);
    }
    return $livechatter;
  }

  public function setBody($body) {
    $this->_body = $body;
  }

  public function setEndTime($endtime) {
    $this->_endtime = $endtime;
  }

  public function setId($id) {
    $this->_id = $id;
  }

  public function set() {
    $query = sprintf("SELECT body,starttime,endtime,status FROM livechatter WHERE merchant_id='%s' AND id='%s' LIMIT 1",
      mysql_real_escape_string($this->_merchantid),
      mysql_real_escape_string($this->_id));
    $query = mysql_query($query);
    if (mysql_num_rows($query) > 0) {
      $lc = mysql_fetch_assoc($query);
      $this->setBody($lc['body']);
      $this->setStartTime($lc['starttime']);
      $this->setEndTime($lc['endtime']);
      return true;
    } else {
      $this->setId(null);
      $this->setMerchantId(null);
      return false;
    }
  }

  public function setMerchantId($merchantid) {
    $this->_merchantid = $merchantid;
  }

  public function setStartTime($starttime) {
    $this->_starttime = $starttime;
  }

  public static function validate($body, $starttime, $endtime) {
    $errors = array();
    if (trim($body) === "") { $errors[] = "The body cannot be blank."; }
    if ($endtime < $starttime) { $errors[] = "The end date cannot be before the start date."; }
    if ($endtime < time()) { $errors[] = "The end date must be later than the current date."; }
    return $errors;
  }
}
?>
