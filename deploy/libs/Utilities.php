<?php
function jQueryTimeToUnixTime($time) {
	$time = explode(" ", $time);
	$date = explode("/", $time[0]);
	$timestamp = explode(":", $time[1]);
	return mktime($timestamp[0], $timestamp[1], 0, $date[0], $date[1], $date[2]);
}

function getCategories() {
  $categories = array();
  $query = sprintf("SELECT id,category FROM livechatter_categories ORDER BY category ASC");
  $query = mysql_query($query);
  while ($row = mysql_fetch_assoc($query)) {
    array_push($categories, $row);
  }
  return $categories;
}
function getCategoryById($id) {
  $query = sprintf("SELECT category FROM livechatter_categories WHERE id='%s' LIMIT 1",
    mysql_real_escape_string($id));
  $query = mysql_query($query);
  $result = mysql_fetch_assoc($query);
  return $result['category'];
}

function getLatLongByZip($zip) {
  $query = sprintf("SELECT latitude,longitude FROM locations WHERE zipcode='%s' LIMIT 1",
    mysql_real_escape_string($zip));
  $query = mysql_query($query);
  return mysql_fetch_assoc($query);
}

function getLatLongByCityState($city, $state, $zip) {
  if (preg_match('/^[0-9]{5}$/', $zip)) {
    return getLatLongByZip($zip);
  } else {
    $query = sprintf("SELECT latitude,longitude FROM locations WHERE city='%s' AND state='%s' LIMIT 1",
      mysql_real_escape_string($city),
      mysql_real_escape_string($state),
      mysql_real_escape_string($zipcode));
    $query = mysql_query($query);
    return mysql_fetch_assoc($query);
  }
}

function getLocationsByCity($city, $limit = 8) {
  $locations = array();
  $query = sprintf("SELECT DISTINCT CONCAT(CONCAT(UCASE(LEFT(city, 1)), LCASE(SUBSTRING(city, 2))), ', ', UPPER(state)) AS location FROM locations WHERE city LIKE '%s%%' ORDER BY city ASC LIMIT %s",
    mysql_real_escape_string($city),
    mysql_real_escape_string($limit));
  $query = mysql_query($query);
  while ($row = mysql_fetch_assoc($query)) {
    array_push($locations, $row);
  }
  return $locations;
}

function getLocationsByZip($zip, $limit = 8) {
  $locations = array();
  $query = sprintf("SELECT zipcode AS location FROM locations WHERE zipcode LIKE '%s%%' ORDER BY zipcode ASC LIMIT %s",
    mysql_real_escape_string($zip),
    mysql_real_escape_string($limit));
  $query = mysql_query($query);
  while ($row = mysql_fetch_assoc($query)) {
    array_push($locations, $row);
  }
  return $locations;
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

function getStates() {
  $states = array();
  $query = sprintf("SELECT DISTINCT state FROM locations ORDER BY state ASC");
  $query = mysql_query($query);
  while ($row = mysql_fetch_assoc($query)) {
    array_push($states, $row);
  }
  return $states;
}

function getUsersAndMerchants($search) {
  $results = array();
  $query = sprintf("SELECT id,firstname,lastname,profile_img,city,UPPER(state) AS state FROM users WHERE (firstname LIKE '%s%%' OR lastname LIKE '%s%%') AND role='1' ORDER BY id ASC",
    mysql_real_escape_string($search),
    mysql_real_escape_string($search));
  $query = mysql_query($query);
  while ($row = mysql_fetch_assoc($query)) {
    $row['type'] = 'user';
    array_push($results, $row);
  }
  $query = sprintf("SELECT id,name,logo,city,UPPER(state) AS state FROM merchants WHERE name LIKE '%s%%' ORDER BY id ASC",
    mysql_real_escape_string($search),
    mysql_real_escape_string($search));
  $query = mysql_query($query);
  while ($row = mysql_fetch_assoc($query)) {
    $row['type'] = 'merchant';
    array_push($results, $row);
  }
  return $results;
}

function slugify($str, $limit = 240, $delimiter = "-") {
  $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
  $clean = strtolower(trim($clean, $delimiter));
  $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
  return substr($clean, 0, $limit) . $delimiter . substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
}

function uploadImage($file, $filename, $upload_path) {
  $errors = array();
  $allowedext = array("gif", "jpeg", "jpg", "png");
  $allowedmime = array("image/gif", "image/jpeg", "image/jpg", "image/png");
  $extension = end(explode(".", $file['name']));
  if (in_array($file['type'], $allowedmime)) {
    if ($file['error'] === 0) {
//        echo "Size: " . ($file["size"] / 1024) . " kB<br>";
      if (file_exists($upload_path . $file['name'])) {
        //echo $file['name'] . " already exists. ";
      } else {
        move_uploaded_file($file['tmp_name'], $upload_path . $filename . "." . $extension);
      }
    }
    return $filename . "." . $extension;
  } else {
    return false;
  }
}
?>
