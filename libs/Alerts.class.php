<?php
class Alerts {
	public static function add($id, $msg) {
    global $mysqli;
    $query = sprintf("INSERT INTO alerts SET user_id='%s', body='%s', viewed='0', creation='%s'",
      $mysqli->real_escape_string($id),
      $mysqli->real_escape_string($msg),
      $mysqli->real_escape_string(time()));
    $mysqli->query($query);
	}

	public static function count($id) {
    global $mysqli;
    $query = sprintf("SELECT id FROM alerts WHERE user_id='%s' AND viewed='0'",
      $mysqli->real_escape_string($id));
    $query = $mysqli->query($query);
    return $query->num_rows;
	}

  public static function get($id) {
    global $mysqli;
    $alerts = array();
    $query = sprintf("SELECT id,body,viewed,creation FROM alerts WHERE user_id='%s' ORDER BY creation DESC",
      $mysqli->real_escape_string($id));
    $query = $mysqli->query($query);
    while ($row = $query->fetch_assoc()) {
      $row['type'] = "alert";
      array_push($alerts, $row);
    }
    return $alerts;
  }

	public static function remove($id) {
    global $mysqli;
    $query = sprintf("DELETE FROM alerts WHERE id='%s'",
      $mysqli->real_escape_string($id));
    $mysqli->query($query);
	}

	public static function view($id) {
    global $mysqli;
    $query = sprintf("UPDATE alerts SET viewed='1' WHERE user_id='%s'",
      $mysqli->real_escape_string($id));
    $mysqli->query($query);
	}
}
?>
