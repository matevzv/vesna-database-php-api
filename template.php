<?php

$jsiCityId="#10";
$pilotCityId="#6";

$xmlRegTemplate = <<<XML
<?xml version="1.0"?>
<wfs:Transaction version="2.0.0" service="WFS" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:cts="http:www.citi-sense.eu/citisense" xmlns:gml="http://www.opengis.net/gml/3.2" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:gmd="http://www.isotc211.org/2005/gmd" xmlns:gco="http://www.isotc211.org/2005/gco" xmlns:gss="http://www.isotc211.org/2005/gss" xmlns:gts="http://www.isotc211.org/2005/gts" xmlns:gsr="http://www.isotc211.org/2005/gsr" xmlns:wfs="http://www.opengis.net/wfs/2.0" xmlns:ows="http://www.opengis.net/ows/1.1" xmlns:fes="http://www.opengis.net/fes/2.0">
	<wfs:Insert>
		<cts:SensorDevice gml:id="LOCAL_ID_0">
			<cts:sensorProviderID xlink:href="#1"/>
			<cts:identifier>CITISENSE-Test-00000004</cts:identifier>
			<cts:description>NO2,CO2,PM</cts:description>
			<cts:registrationDate>2012-12-17T09:30:47.000</cts:registrationDate>
			<cts:type>mobile</cts:type>
			<cts:status>inactive</cts:status>
			<cts:location>Ljubljana</cts:location>
		</cts:SensorDevice>
	</wfs:Insert>
</wfs:Transaction>
XML;

$xmlDataTemplate = <<<XML
<?xml version="1.0"?>
<wfs:Transaction version="2.0.0" service="WFS" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:cts="http:www.citi-sense.eu/citisense" xmlns:gml="http://www.opengis.net/gml/3.2" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:gmd="http://www.isotc211.org/2005/gmd" xmlns:gco="http://www.isotc211.org/2005/gco" xmlns:gss="http://www.isotc211.org/2005/gss" xmlns:gts="http://www.isotc211.org/2005/gts" xmlns:gsr="http://www.isotc211.org/2005/gsr" xmlns:wfs="http://www.opengis.net/wfs/2.0" xmlns:ows="http://www.opengis.net/ows/1.1" xmlns:fes="http://www.opengis.net/fes/2.0">
    <wfs:Insert>
        <cts:Observation gml:id="LOCAL_ID_0">
            <cts:cityID xlink:href="#1"/>
            <cts:sensorID xlink:href="#1"/>
            <cts:contains>
            </cts:contains>
            <cts:observationID>1</cts:observationID>
            <cts:starttime>2014-03-01T10:23:54.000</cts:starttime>
            <cts:finishtime>2014-02-12T10:24:54.000</cts:finishtime>
        </cts:Observation>
    </wfs:Insert>
</wfs:Transaction>
XML;

?>
