<?php
date_default_timezone_set('UTC');
$limit = 100000;
if(array_key_exists("limit", $_GET)) {
	$tmpLimit = $_GET['limit'];	
	if(is_numeric($tmpLimit)) {
		$tmpLimit += 0;
		if(is_int($tmpLimit)) {
			$limit = $tmpLimit;
		}
	}
}

if(array_key_exists("id", $_GET)) {
	$sn_id = $_GET['id'];
} else {
	die ("Error: Id parameter missing!");
}

$timezone = 0;
if(array_key_exists("tz", $_GET)) {
	$tmpTz = $_GET['tz'];	
	if(is_numeric($tmpTz)) {
		$tmpTz += 0;
		if(is_int($tmpTz)) {
			$timezone = $tmpTz;
		}
	}
}

if (!empty($sn_id) && strlen($sn_id) <= 5) {
	$dbconn = pg_connect("dbname=test user=matevz")	
		or die('Could not connect: ' . pg_last_error());
	
	$query = "SELECT measurement_id,node_name,sensor_name,";
	$query .= "quantity_name,unit_name,context_description,latitude,longitude,";
	$query .= "EXTRACT(epoch FROM measurement_ts AT TIME ZONE 'UTC'),";
	$query .= "measurement_value ";
	$query .= "FROM measurements,nodes,sensors,quantities,";
	$query .= "units,contexts,locations ";
	$query .= "WHERE measurements.node_id = nodes.node_id AND ";
	$query .= "measurements.sensor_id = sensors.sensor_id AND ";
	$query .= "measurements.quantity_id = quantities.quantity_id AND ";
	$query .= "measurements.unit_id = units.unit_id AND ";
	$query .= "measurements.context_id = contexts.context_id AND ";
	$query .= "measurements.location_id = locations.location_id AND ";
	$query .= "nodes.node_name = '$sn_id' ";
	$query .= "ORDER BY measurements.measurement_id DESC ";
	$query .= "LIMIT $limit;";
	
	$result = pg_query($dbconn, $query);	
	if (!$result) {
		die("An error occurred.");
	} else if (pg_num_rows ($result) == 0) {
		die ("Error: No such sensor node!");
	} else {		
		header("Content-Disposition: attachment; filename=\"$sn_id.csv\"");
		$firstLine = "node_name,sensor_name,quantity_name,unit_name,";
		$firstLine .= "context_description,latitude,longitude,measurement_timestamp,";
		$firstLine .= "measurement_value\r\n";
		echo $firstLine;
		while ($row = pg_fetch_row($result)) {
			$ts = date('Y-m-d H:i:s', $row[8] + $timezone*3600);		
			$line = $row[1] . "," . $row[2] . ",";
			$line .= $row[3] . "," . $row[4] . ",";
			$line .= $row[5] . "," . $row[6]. ",";
			$line .= $row[7] . "," . $ts . ",";
			$line .= $row[9] . "\r\n";
			echo $line;
		}
	}
	die();
} else {
	die ("Error: Incorrect sensor node id!");
}
?>
