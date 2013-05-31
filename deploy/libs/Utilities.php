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

function getRoles() {
  $roles = array();
  $query = sprintf("SELECT id,role FROM roles ORDER BY role ASC");
  $query = mysql_query($query);
  while ($row = mysql_fetch_assoc($query)) {
    array_push($roles, $row);
  }
  return $roles;
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
