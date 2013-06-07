<?php 
/***********************************************************
 * PHP version by Jesse Price 
 * original Pearl version by R. Don Henning 
 * 
 * More Info @: http://www.jesseprice.com
 * 
 * Files: zip_insert.php, zipcodes_2006.txt
 * Instructions: Please edit the mysql connection below.
 * You can also edit the database table creation if needed.
 * 
 * The format of the arrays from the zipcodes_2006.txt file:
 * 00501||40.817967||-73.045257||NY||HOLTSVILLE||SUFFOLK
 *
 * Version 3.0 Updates
 * Removed split function since it is deprecated as of php version 5.3.
 * Used file rather than file_get_contents.
 *
 * Version 2.0 Updates:
 * There was a minor bug with leading zeros not being inserted. Fixed.
 * Added the unsigned attribute to keep things tidy...
 */

	
	// MySql connection
	$db_host = 'localhost'; // usually localhost
	$db_user = 'dev_fc';  // your db username
	$db_pass = '3CwdJQ%glgZg';  // password
	$db_name = 'dev_fc';  // database name
	
	$database = mysql_connect($db_host, $db_user, $db_pass) or die ("<b><font color=\"#CC0000\">Failed to connect to database:</font></b> ".mysql_error());
	mysql_select_db($db_name, $database);
	
	$tbl_create = "CREATE TABLE `locations` (
				  `zip_code` int(5) UNSIGNED ZEROFILL NOT NULL,
				  `latitude` float(10,8) default NULL,
				  `longitude` float(10,8) default NULL,
				  `state` varchar(2) default NULL,
				  `city` varchar(128) default NULL,
				  `county` varchar(128) default NULL,
				  PRIMARY KEY  (`zip_code`)
				) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	mysql_query($tbl_create);
	
	$data_array = file('zipcodes_2006.txt');
    foreach($data_array as $line) {
		$record = explode("||", $line);
		$zip_code	= $record[0];
		$latitude	= $record[1];
		$longitude	= $record[2];
		$state		= strtolower($record[3]);
		$city		= strtolower($record[4]);
		$county		= strtolower($record[5]);
        
		$query = "INSERT INTO zip_codes VALUES ($zip_code,$latitude,$longitude,'$state','$city','$county')";
		mysql_query($query);
		unset($zip_code,$latitude,$longitude,$state,$city,$county,$query,$record);
    }
	print "Database populated. You may remove this file from the server.\n";
?>
