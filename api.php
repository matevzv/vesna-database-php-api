<?php	
	function dbQueryReturnId($dbconn, $sql) {
		$result = pg_query($dbconn, $sql);	
		if (!$result) {
			die("An error occurred.");
		}

		$id = null;
		while ($row = pg_fetch_row($result)) {
			$id = $row[0];
		}
		
		return $id;
	}

	ini_set('display_errors', 'On');
	error_reporting(E_ALL);
	
	$requestMethod = $_SERVER['REQUEST_METHOD'];
	if ($requestMethod != 'POST') {
		die("API only accepts POST method!");
	}
	$input = file_get_contents("php://input");	
	$json = json_decode($input);
	$content = $json[0]->{'$content'};
	$sensors = $content->sensors;	
	if (empty($sensors)) {
		die ("Measurements missing!");
	}
	
	$dbconn = pg_connect("dbname=test user=matevz")	
		or die('Could not connect: ' . pg_last_error());
	
	$newNode = false;
	$i = 1;
	$j = 1;
	foreach ($sensors as $sensor) {
		$node_name = $sensor->sensor_node_id;
		$sensor_name = $sensor->sensor_type;
		$quantity_name = $sensor->measured_phenomenon;
		$quantity_unit = $sensor->unit_of_measurement;
		$context_description = $sensor->measurement_context;
		$newSensor = false;
		$newQuantity = false;
		$newUnit = false;
		
		$nodeIdQuery = "INSERT INTO nodes (node_name) ";
		$nodeIdQuery .= "SELECT '$node_name' ";
		$nodeIdQuery .= "WHERE NOT EXISTS (";
		$nodeIdQuery .= "SELECT '$node_name' ";
		$nodeIdQuery .= "FROM nodes ";
		$nodeIdQuery .= "WHERE node_name = '$node_name')";	
		$nodeIdQuery .= "RETURNING node_id;";
		
		$nodeId = dbQueryReturnId($dbconn, $nodeIdQuery);
		
		if (!is_null($nodeId)) {
			$newNode = true;
		} else {
			$nodeIdQuery = "SELECT node_id FROM nodes ";
			$nodeIdQuery .= "WHERE node_name = '$node_name';";
			$nodeId = dbQueryReturnId($dbconn, $nodeIdQuery);	
		}
		
		$sensorIdQuery = "INSERT INTO sensors (sensor_name) ";
		$sensorIdQuery .= "SELECT '$sensor_name' ";
		$sensorIdQuery .= "WHERE NOT EXISTS (";
		$sensorIdQuery .= "SELECT '$sensor_name' ";
		$sensorIdQuery .= "FROM sensors ";
		$sensorIdQuery .= "WHERE sensor_name = '$sensor_name')";
		$sensorIdQuery .= "RETURNING sensor_id;";
		
		$sensorId = dbQueryReturnId($dbconn, $sensorIdQuery);
		
		if (!is_null($sensorId)) {
			$newSensor = true;			
		} else {
			$sensorIdQuery = "SELECT sensor_id FROM sensors ";
			$sensorIdQuery .= "WHERE sensor_name = '$sensor_name';";
			$sensorId = dbQueryReturnId($dbconn, $sensorIdQuery);	
		}
		
		if ($newNode or $newSensor)	 {
			$snIdQuery = "INSERT INTO nodes_sensors (node_id,sensor_id) ";
			$snIdQuery .= "VALUES ($nodeId,$sensorId);";
			$nodeSensorId = dbQueryReturnId($dbconn, $snIdQuery);
		}
		
		$quantityIdQuery = "INSERT INTO quantities (quantity_name) ";
		$quantityIdQuery .= "SELECT '$quantity_name' ";
		$quantityIdQuery .= "WHERE NOT EXISTS (";
		$quantityIdQuery .= "SELECT '$quantity_name' ";
		$quantityIdQuery .= "FROM quantities ";
		$quantityIdQuery .= "WHERE quantity_name = '$quantity_name')";
		$quantityIdQuery .= "RETURNING quantity_id;";		
		
		$quantityId = dbQueryReturnId($dbconn, $quantityIdQuery);
		
		if (!is_null($quantityId)) {
			$newQuantity = true;					
		} else {
			$quantityIdQuery = "SELECT quantity_id FROM quantities ";
			$quantityIdQuery .= "WHERE quantity_name = '$quantity_name';";
			$quantityId = dbQueryReturnId($dbconn, $quantityIdQuery);	
		}
		
		if ($newSensor or $newQuantity)	 {
			$quantityIdQuery = "INSERT INTO sensors_quantities (sensor_id,quantity_id) ";
			$quantityIdQuery .= "VALUES ($sensorId,$quantityId);";
			$sensorQuantityId = dbQueryReturnId($dbconn, $quantityIdQuery);
		}
		
		$unitIdQuery = "INSERT INTO units (unit_name) ";
		$unitIdQuery .= "SELECT '$quantity_unit' ";
		$unitIdQuery .= "WHERE NOT EXISTS (";
		$unitIdQuery .= "SELECT '$quantity_unit' ";
		$unitIdQuery .= "FROM units ";
		$unitIdQuery .= "WHERE unit_name = '$quantity_unit')";
		$unitIdQuery .= "RETURNING unit_id;";
		
		$unitId = dbQueryReturnId($dbconn, $unitIdQuery);
		
		if (!is_null($unitId)) {
			$newUnit = true;			
		} else {
			$unitIdQuery = "SELECT unit_id FROM units ";
			$unitIdQuery .= "WHERE unit_name = '$quantity_unit';";
			$unitId = dbQueryReturnId($dbconn, $unitIdQuery);				
		}
		
		if ($newQuantity or $newUnit) {
			$unitIdQuery = "INSERT INTO quantities_units (quantity_id,unit_id) ";
			$unitIdQuery .= "VALUES ($quantityId,$unitId);";
			$quantityUnitId = dbQueryReturnId($dbconn, $unitIdQuery);
		}		
		
		$contextIdQuery = "INSERT INTO contexts (context_description) ";
		$contextIdQuery .= "SELECT '$context_description' ";
		$contextIdQuery .= "WHERE NOT EXISTS (";
		$contextIdQuery .= "SELECT '$context_description' ";
		$contextIdQuery .= "FROM contexts ";
		$contextIdQuery .= "WHERE context_description = '$context_description');";
		$contextIdQuery .= "SELECT context_id FROM contexts ";
		$contextIdQuery .= "WHERE context_description = '$context_description';";		
		
		$contextId = dbQueryReturnId($dbconn, $contextIdQuery);
		
		$measurementsIdQuery = "INSERT INTO measurements (node_id,";
		$measurementsIdQuery .= "sensor_id,";
		$measurementsIdQuery .= "quantity_id,";
		$measurementsIdQuery .= "location_id,";
		$measurementsIdQuery .= "context_id,";
		$measurementsIdQuery .= "measurement_ts,";
		$measurementsIdQuery .= "measurement_value,";
		$measurementsIdQuery .= "unit_id) VALUES ";
		$measurements = $sensor->measurements;
		foreach ($measurements as $measurement) {			
			$ts = gmdate("Y-m-d\TH:i:s\Z", $measurement->timestamp);
			$lat = $measurement->latitude;
			$long = $measurement->longitude;
			$value = $measurement->value;
		
			$locationIdQuery = "INSERT INTO locations (latitude, longitude) ";
			$locationIdQuery .= "SELECT $lat,$long ";
			$locationIdQuery .= "WHERE NOT EXISTS (";
			$locationIdQuery .= "SELECT $lat,$long ";
			$locationIdQuery .= "FROM locations ";
			$locationIdQuery .= "WHERE latitude = $lat AND longitude = $long)";
			$locationIdQuery .= "RETURNING location_id;";		
		
			$locationId = dbQueryReturnId($dbconn, $locationIdQuery);
		
			if (!is_null($locationId)) {
				$locationIdQuery = "INSERT INTO nodes_locations ";
				$locationIdQuery .= "(node_id,location_id,node_location_ts) ";
				$locationIdQuery .= "VALUES ($nodeId,$locationId,'$ts');";
				$nodelocationId = dbQueryReturnId($dbconn, $locationIdQuery);					
			} else {
				$locationIdQuery = "SELECT location_id FROM locations ";
				$locationIdQuery .= "WHERE latitude = $lat AND longitude = $long";
				$locationId = dbQueryReturnId($dbconn, $locationIdQuery);	
			}
			
			$measurementsIdQuery .= "($nodeId,$sensorId,$quantityId,";	
			$measurementsIdQuery .= "$locationId,$contextId,'$ts',$value,$unitId),";		
			$j++;			
		}
		$measurementsIdQuery = substr_replace($measurementsIdQuery, ";", -1);		
		$measurementId = dbQueryReturnId($dbconn, $measurementsIdQuery);
		$i++;
	}
	echo ($j . ' measurements successfully uploaded!');
?>
