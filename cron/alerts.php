<?php
require("/var/www/.local.inc.php");
$query = sprintf("SELECT livechatter.id,body,livechatter.latitude,livechatter.longitude,starttime,endtime,livechatter_statuses.status AS status,merchants.category_id AS category FROM livechatter LEFT JOIN livechatter_statuses ON livechatter.status=livechatter_statuses.id LEFT JOIN merchants ON livechatter.merchant_id=merchants.id WHERE alerted='0' AND livechatter_statuses.status!='deleted' AND starttime<%s AND endtime>%s",
  mysql_real_escape_string(time()),
  mysql_real_escape_string(time()));
$query = mysql_query($query);
while ($newlc =  mysql_fetch_assoc($query)) {
  $query2 = sprintf("SELECT user_id,distance,location,category_id,SQRT((69.1 * (%s - latitude) * 69.1 * (%s - latitude)) + (53 * (%s - longitude) * 53 * (%s - longitude))) AS lcdistance FROM searches WHERE saved='1' AND active='1' AND category_id='%s' HAVING lcdistance<distance",
    mysql_real_escape_string($newlc['latitude']),
    mysql_real_escape_string($newlc['latitude']),
    mysql_real_escape_string($newlc['longitude']),
    mysql_real_escape_string($newlc['longitude']),
    mysql_real_escape_string($newlc['category']));
  $query2 = mysql_query($query2);
  while ($search = mysqL_fetch_assoc($query2)) {
    Alerts::add($search['user_id'], "<a href=\"/livechatter?where=" . $search['location'] . "&what=" . $search['category_id'] . "&distance=" . $search['distance'] . "\">There is new LiveChatter that matches one of your Favorite Five!</a>");
  }
}

$query = sprintf("UPDATE livechatter SET alerted='1' WHERE alerted='0' AND starttime<%s AND endtime>%s",
  mysql_real_escape_string(time()),
  mysql_real_escape_string(time()));
mysql_query($query);
?>
