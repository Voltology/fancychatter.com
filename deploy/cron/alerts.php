<?php
require("../.local.inc.php");
$query = sprintf("SELECT livechatter.id,body,latitude,longitude,starttime,endtime,livechatter_statuses.status AS status FROM livechatter LEFT JOIN livechatter_statuses ON livechatter.status=livechatter_statuses.id WHERE alerted='0' AND livechatter_statuses.status!='deleted' AND starttime<%s AND endtime>%s ORDER BY creation DESC",
  mysql_real_escape_string(time()),
  mysql_real_escape_string(time()));
  echo $query;
//$query = mysql_query($query);
while ($newlc =  mysql_fetch_assoc($query)) {
  $query2 = sprintf("SELECT user_id,distance,SQRT((69.1 * (%s - latitude) * 69.1 * (%s - latitude)) + (53 * (%s - longitude) * 53 * (%s - longitude))) AS lcdistance FROM searches WHERE saved='1' AND active='1' HAVING category='%s' AND lcdistance < distance",
    mysql_real_escape_string($newlc['latitude']),
    mysql_real_escape_string($newlc['latitude']),
    mysql_real_escape_string($newlc['longitude']),
    mysql_real_escape_string($newlc['longitude']),
    mysql_real_escape_string($newlc['category']));
  while ($search = mysqL_fetch_assoc($query2)) {
    Alerts::add($search['user_id'], "There is a new LiveChatter that matches one of your saved searches!");
  }
}

$query = sprintf("UPDATE livechatter SET alerted='1' WHERE alerted='0' AND starttime<%s AND endtime>%s",
  mysql_real_escape_string(time()),
  mysql_real_escape_string(time()));
mysql_query($query);
?>
