<?php
	include 'template.php';
	
	$sf_url = "http://localhost/test-post.php";
	
	function sendPost($url,$data) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	  	curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 1);
		curl_exec($ch);
		curl_close($ch);
	}
	
	function forwardData($data) {
		$xml = new SimpleXMLElement($xmlRegTemplate);
		$ns=$xml->getNameSpaces(true);
		echo $xml->children($ns["wfs"])->Insert->children($ns["cts"])->Sensors->attributes($ns["gml"])->id;
		echo "<br>";
		echo $xml->children($ns["wfs"])->Insert->children($ns["cts"])->Sensors->sensorProviderId->attributes($ns["xlink"])->href;
		echo "<br>";
		echo $xml->children($ns["wfs"])->Insert->children($ns["cts"])->Sensors->idsensor;
		echo "<br>";
		echo $xml->children($ns["wfs"])->Insert->children($ns["cts"])->Sensors->name;
		echo "<br>";
		echo $xml->children($ns["wfs"])->Insert->children($ns["cts"])->Sensors->description;
		echo "<br>";
		echo $xml->children($ns["wfs"])->Insert->children($ns["cts"])->Sensors->dateregistration;
		echo "<br>";
		echo $xml->children($ns["wfs"])->Insert->children($ns["cts"])->Sensors->descriptiveword1;
		echo "<br>";
		echo $xml->children($ns["wfs"])->Insert->children($ns["cts"])->Sensors->language;
		echo "<br>";
	
		$xml->children($ns["wfs"])->Insert->children($ns["cts"])->Sensors->sensorProviderId->attributes($ns["xlink"])->href = "test";
		echo $xml->children($ns["wfs"])->Insert->children($ns["cts"])->Sensors->sensorProviderId->attributes($ns["xlink"])->href;
	}	
?>
