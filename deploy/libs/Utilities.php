<?php
function jQueryTimeToUnixTime($time) {
	$time = explode(" ", $time);
	$date = explode("/", $time[0]);
	$timestamp = explode(":", $time[1]);
	return mktime($timestamp[0], $timestamp[1], 0, $date[0], $date[1], $date[2]);
}

function getRoles() {
  $roles = array();
  $query = sprintf("SELECT id,role FROM roles ORDER BY role ASC");
  $query = mysql_query($query);
  while ($row = mysql_fetch_assoc($query)) {
    array_push($roles, $row);
  }
  return $roles;
}
?>
