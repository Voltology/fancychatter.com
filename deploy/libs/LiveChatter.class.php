<?php
class LiveChatter {
  private $_id;
  private $_merchantid;
  private $_body;
  private $_starttime;
  private $_endtime;
  private $_creation;

  public function LiveChatter($id, $merchantid) {
    $this->_id = $id;
    $this->_merchantid = $merchantid;
    $this->setLiveChatter();
  }

  public static function addLiveChatter($merchant_id, $body, $starttime, $endtime) {
    $query = sprintf("INSERT INTO livechatter SET merchant_id='%s', body='%s', starttime='%s', endtime='%s', creation='%s'",
      mysql_real_escape_string($merchant_id),
      mysql_real_escape_string($body),
      mysql_real_escape_string($starttime),
      mysql_real_escape_string($endtime),
      mysql_real_escape_string(time()));
    $query = mysql_query($query);
  }

  public function deleteLiveChatter() {
    $query = sprintf("DELETE FROM livechatter WHERE merchant_id='%s' AND id='%s' LIMIT 1",
      mysql_real_escape_string($this->_merchantid),
      mysql_real_escape_string($this->_id));
    $query = mysql_query($query);
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

  public static function getLiveChatterByMerchantId($merchantid) {
    $livechatter = array();
    $query = sprintf("SELECT id,body,starttime,endtime,status FROM livechatter WHERE merchant_id='%s' ORDER BY creation DESC",
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

  public function save() {
    $query = sprintf("UPDATE livechatter SET body='%s', starttime='%s', endtime='%s' WHERE id='%s' AND merchant_id='%s'",
      mysql_real_escape_string($this->getBody()),
      mysql_real_escape_string($this->getStartTime()),
      mysql_real_escape_string($this->getEndTime()),
      mysql_real_escape_string($this->_id),
      mysql_real_escape_string($this->_merchantid));
    mysql_query($query);
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

  public function setLiveChatter() {
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
    return $errors;
  }
}
?>
