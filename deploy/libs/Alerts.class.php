<?php
class Alerts {
	public static function add($id, $msg) {
    $query = sprintf("INSERT INTO alerts SET user_id='%s', message='%s', viewed='0', creation='%s'",
      mysql_real_escape_string($id),
      mysql_real_escape_string($msg),
      mysql_real_escape_string(time()));
    mysql_query($query);
	}

	public static function count($id) {
    $query = sprintf("SELECT id FROM alerts WHERE user_id='%s' AND viewed='0'",
      mysql_real_escape_string($id));
    $query = mysql_query($query);
    return mysql_num_rows($query);
	}

  public static function get($id) {
    $alerts = array();
    $query = sprintf("SELECT id,message,viewed,creation FROM alerts WHERE user_id='%s' ORDER BY creation DESC",
      mysql_real_escape_string($id));
    $query = mysql_query($query);
    while ($row = mysql_fetch_assoc($query)) {
      array_push($alerts, $row);
    }
    return $alerts;
  }

	public static function delete() {
    $query = sprintf("DELETE FROM alerts WHERE id='%s'",
      mysql_real_escape_string($id));
    mysql_query($query);
	}

	public static function view($id) {
    $query = sprintf("UPDATE alerts SET viewed='1' WHERE user_id='%s'",
      mysql_real_escape_string($id));
    mysql_query($query);
	}
}
?>
