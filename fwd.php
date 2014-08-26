<?php
	
	include 'template.php';
	include 'http-client.php';
	
	$sfUrl = "http://localhost/test-post.php";
	$staticId = "CITISENSE-JSI-";
	
	error_reporting(-1);
	
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
	
	function registerSensor($sensorId, $context, $phenomenon, $unit) {
		global $xmlRegTemplate;
		global $jsiCityId;
		global $sfUrl;
		$xml = new SimpleXMLElement($xmlRegTemplate);
		$ns=$xml->getNameSpaces(true);
		$xml->children($ns["wfs"])->Insert->children($ns["cts"])->Sensors->sensorProviderId->attributes($ns["xlink"])->href = $jsiCityId;
		$xml->children($ns["wfs"])->Insert->children($ns["cts"])->Sensors->idsensor = $sensorId;
		$xml->children($ns["wfs"])->Insert->children($ns["cts"])->Sensors->name = $sensorId;
		$xml->children($ns["wfs"])->Insert->children($ns["cts"])->Sensors->description = $context;
		$xml->children($ns["wfs"])->Insert->children($ns["cts"])->Sensors->dateregistration = date('Y-m-d\TH:i:s');
		$xml->children($ns["wfs"])->Insert->children($ns["cts"])->Sensors->descriptiveword1 = $phenomenon;
		$xml->children($ns["wfs"])->Insert->children($ns["cts"])->Sensors->descriptiveword2 = $unit;
		
		sendPostXml($sfUrl,$xml->asXML());
	}
	
	function insertData() {
		
	}

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

	$dbconn = pg_connect("host=localhost port=5433 dbname=snowflake user=postgres")	
		or die('Could not connect: ' . pg_last_error());

	$newNode = false;
	$counter = 0;
	foreach ($sensors as $sensor) {
		$node_name = $sensor->sensor_node_id;
		$sensor_name = $sensor->sensor_type;
		$quantity_name = $sensor->measured_phenomenon;
		$quantity_unit = $sensor->unit_of_measurement;
		$context_description = $sensor->context;
		
		$sfSensorId = "$staticId$node_name$sensor_name$counter";
		
		if($counter == 0) {
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
			}			
		}
		
		if($newNode) {
			registerSensor($sfSensorId, $context_description, $quantity_name, $quantity_unit);
		}
		
		// TODO insert data in WFS
		
		$counter++;
	}	
?>