<?php
class LiveChatter {
  private $_id;
  private $_merchantid;
  private $_body;
  private $_latitude;
  private $_logo;
  private $_longitude;
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

  public static function add($merchant_id, $body, $latitude, $longitude, $starttime, $endtime, $gmtoffset) {
    $offset = $gmtoffset * 60 * 60;
    $query = sprintf("INSERT INTO livechatter SET merchant_id='%s', body='%s', latitude='%s', longitude='%s', starttime='%s', endtime='%s', status='1', creation='%s'",
      mysql_real_escape_string($merchant_id),
      mysql_real_escape_string($body),
      mysql_real_escape_string($latitude),
      mysql_real_escape_string($longitude),
      mysql_real_escape_string($starttime),
      mysql_real_escape_string($endtime),
      mysql_real_escape_string(time()));
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

  public function getLatitude() {
    return $this->_latitude;
  }

  public function getLogo() {
    return $this->_logo;
  }

  public function getLongitude() {
    return $this->_longitude;
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

  public static function search($citystatezip, $category, $distance, $amount) {
    $location = getLatLongByZip($citystatezip);
    $livechatter = array();
    $query = sprintf("SELECT livechatter.id,merchant_id,body,endtime,SQRT((69.1 * (%s - livechatter.latitude) * 69.1 * (%s - livechatter.latitude)) + (53 * (%s - livechatter.longitude) * 53 * (%s - livechatter.longitude))) AS distance,merchants.name AS merchant_name,merchants.logo AS logo,merchants.category_id AS category FROM livechatter LEFT JOIN merchants ON merchants.id=livechatter.merchant_id WHERE livechatter.status='1' HAVING category='%s' AND distance < %s ORDER BY distance ASC, livechatter.creation DESC",
      mysql_real_escape_string($location['latitude']),
      mysql_real_escape_string($location['latitude']),
      mysql_real_escape_string($location['longitude']),
      mysql_real_escape_string($location['longitude']),
      mysql_real_escape_string($category),
      mysql_real_escape_string($distance));
    $query = mysql_query($query);
    while ($row = mysql_fetch_assoc($query)) {
      array_push($livechatter, $row);
    }
    return $livechatter;
  }

  public static function searchById($id) {
    $livechatter = array();
    $query = sprintf("SELECT location,category_id,distance FROM searches WHERE id='%s' LIMIT 1",
      mysql_real_escape_string($id));
    $query = mysql_query($query);
    $search = mysql_fetch_assoc($query);
    $location = getLatLongByZip($search['location']);
    $query = sprintf("SELECT livechatter.id,merchant_id,body,endtime,SQRT((69.1 * (%s - livechatter.latitude) * 69.1 * (%s - livechatter.latitude)) + (53 * (%s - livechatter.longitude) * 53 * (%s - livechatter.longitude))) AS distance,merchants.name AS merchant_name,merchants.logo AS logo,merchants.category_id AS category FROM livechatter LEFT JOIN merchants ON merchants.id=livechatter.merchant_id WHERE livechatter.status='1' HAVING category='%s' AND distance < %s ORDER BY distance ASC, livechatter.creation DESC",
      mysql_real_escape_string($location['latitude']),
      mysql_real_escape_string($location['latitude']),
      mysql_real_escape_string($location['longitude']),
      mysql_real_escape_string($location['longitude']),
      mysql_real_escape_string($search['category']),
      mysql_real_escape_string($search['distance']));
    $query = mysql_query($query);
    while ($row = mysql_fetch_assoc($query)) {
      array_push($livechatter, $row);
    }
    return $livechatter;
  }

  public function set() {
    $query = sprintf("SELECT body,latitude,longitude,starttime,endtime,status FROM livechatter WHERE merchant_id='%s' AND id='%s' LIMIT 1",
      mysql_real_escape_string($this->_merchantid),
      mysql_real_escape_string($this->_id));
    $query = mysql_query($query);
    if (mysql_num_rows($query) > 0) {
      $lc = mysql_fetch_assoc($query);
      $this->setBody($lc['body']);
      $this->setLatitude($lc['latitude']);
      $this->setLongitude($lc['longitude']);
      $this->setStartTime($lc['starttime']);
      $this->setEndTime($lc['endtime']);
      return true;
    } else {
      $this->setId(null);
      $this->setMerchantId(null);
      return false;
    }
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

  public function setLatitude($latitude) {
    $this->_latitude = $latitude;
  }

  public function setLongitude($longitude) {
    $this->_longitude = $longitude;
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
