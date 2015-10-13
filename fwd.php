<?php
	include 'template.php';
	include 'http-client.php';

	$sfUrl = "https://test.citisense.snowflakesoftware.com/wfst";
	$staticId = "CITISENSE-JSI-";

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
		$xml->children($ns["wfs"])->Insert->children($ns["cts"])->SensorDevice->sensorProviderID->attributes($ns["xlink"])->href = $jsiCityId;
		$xml->children($ns["wfs"])->Insert->children($ns["cts"])->SensorDevice->identifier = $sensorId;
		$xml->children($ns["wfs"])->Insert->children($ns["cts"])->SensorDevice->description = $context;
		$xml->children($ns["wfs"])->Insert->children($ns["cts"])->SensorDevice->registrationDate = date('Y-m-d\TH:i:s');

		sendPostXml($sfUrl, $xml->asXML());
	}

	function insertData($id, $measurements, $unit, $property) {
		global $xmlDataTemplate;
		global $jsiCityId;
		global $sfUrl;
		global $pilotCityId;
		$xml = new SimpleXMLElement($xmlDataTemplate);
		$ns=$xml->getNameSpaces(true);
		$xml->children($ns["wfs"])->Insert->children($ns["cts"])->Observation->cityID->attributes($ns["xlink"])->href = $pilotCityId;
		$xml->children($ns["wfs"])->Insert->children($ns["cts"])->Observation->sensorID->attributes($ns["xlink"])->href = $id;

		$counter = 0;
		foreach ($measurements as $measurement) {
			$ts = $measurement->timestamp;
			$lat = $measurement->latitude;
			$long = $measurement->longitude;
			$value = $measurement->value;

			if($counter == 0) {
				$xml->children($ns["wfs"])->Insert->children($ns["cts"])->Observation->starttime = gmdate("Y-m-d\TH:i:s", $ts);
			}

			$content = $xml->children($ns["wfs"])->Insert->children($ns["cts"])->Observation->contains->addChild("Measurement");
			$content->addChild("measurementID", $counter);
			$content->addChild("value", $value);
			$content->addChild("uom", $unit);
			$content->addChild("observedProperty", $property);
			$content->addChild("measuretime", gmdate("Y-m-d\TH:i:s", $ts));
			$content->addChild("latitude", $lat);
			$content->addChild("longitude", $long);

			$counter++;
		}
		$xml->children($ns["wfs"])->Insert->children($ns["cts"])->Observation->finishtime = gmdate("Y-m-d\TH:i:s", $ts);

		sendPostXml($sfUrl, $xml->asXML());
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

	$dbconn = pg_connect("host=localhost port=5433 dbname=snowflake2 user=postgres")
		or die('Could not connect: ' . pg_last_error());

	$newNode = false;
	$sensorCounter = 0;
	foreach ($sensors as $sensor) {
		$node_name = $sensor->sensor_node_id;
		$sensor_name = $sensor->sensor_type;
		$quantity_name = $sensor->measured_phenomenon;
		$quantity_unit = $sensor->unit_of_measurement;
		$context_description = $sensor->context;

		if(isset($sensor->sensor_id)) {
			$sensor_id = $sensor->sensor_id;
			$sfSensorId = "$staticId$node_name$sensor_name$sensor_id";
		} else {
			$sfSensorId = "$staticId$node_name$sensor_name$sensorCounter";
		}

		if($sensorCounter == 0) {
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

		insertData($sfSensorId, $sensor->measurements, $quantity_unit, $quantity_name);

		$sensorCounter++;
	}
?>
