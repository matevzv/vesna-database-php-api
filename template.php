<?php

$jsiCityId="#10";

$xmlRegTemplate = <<<XML
<?xml version="1.0"?>
<wfs:Transaction version="2.0.0" service="WFS" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:cts="http:www.citi-sense.eu/citisense" xmlns:gml="http://www.opengis.net/gml/3.2" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:gmd="http://www.isotc211.org/2005/gmd" xmlns:gco="http://www.isotc211.org/2005/gco" xmlns:gss="http://www.isotc211.org/2005/gss" xmlns:gts="http://www.isotc211.org/2005/gts" xmlns:gsr="http://www.isotc211.org/2005/gsr" xmlns:wfs="http://www.opengis.net/wfs/2.0" xmlns:ows="http://www.opengis.net/ows/1.1" xmlns:fes="http://www.opengis.net/fes/2.0">
    <wfs:Insert>
        <cts:Sensors gml:id="SEN_10">
            <cts:sensorProviderId xlink:href="#1"/>
            <cts:idsensor>12</cts:idsensor>
            <cts:name>RRRRRR</cts:name>
            <cts:description>Interior</cts:description>
            <cts:dateregistration>2014-05-06T16:00:00.000</cts:dateregistration>
            <cts:descriptiveword1>NO2</cts:descriptiveword1>
            <cts:descriptiveword2>O3</cts:descriptiveword2>
            <cts:language>English</cts:language>
        </cts:Sensors>
    </wfs:Insert>
</wfs:Transaction>
XML;

$xmlDataTemplate = <<<XML
<?xml version="1.0"?>
<wfs:Transaction version="2.0.0" service="WFS" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:cts="http:www.citi-sense.eu/citisense" xmlns:gml="http://www.opengis.net/gml/3.2" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:gmd="http://www.isotc211.org/2005/gmd" xmlns:gco="http://www.isotc211.org/2005/gco" xmlns:gss="http://www.isotc211.org/2005/gss" xmlns:gts="http://www.isotc211.org/2005/gts" xmlns:gsr="http://www.isotc211.org/2005/gsr" xmlns:wfs="http://www.opengis.net/wfs/2.0" xmlns:ows="http://www.opengis.net/ows/1.1" xmlns:fes="http://www.opengis.net/fes/2.0">
    <wfs:Insert>
        <cts:Observations gml:id="LOCAL_ID_0">
            <cts:cityId xlink:href="#1"/>
            <cts:sensorId xlink:href="#1"/>
            <cts:contains>
            </cts:contains>
            <cts:idobservation>1</cts:idobservation>
            <cts:starttime>2014-03-01T10:23:54.000</cts:starttime>
            <cts:finishtime>2014-02-12T10:24:54.000</cts:finishtime>
        </cts:Observations>
    </wfs:Insert>
</wfs:Transaction>
XML;

?>
