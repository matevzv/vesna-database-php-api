<?php

$jsiCityId="#10";

$xmlRegTemplate = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<wfs:Transaction xmlns:wfs="http://www.opengis.net/wfs/2.0" xmlns:cts="http:www.citi-sense.eu/citisense" xmlns:fes="http://www.opengis.net/fes/2.0" xmlns:gco="http://www.isotc211.org/2005/gco" xmlns:gmd="http://www.isotc211.org/2005/gmd" xmlns:gml="http://www.opengis.net/gml/3.2" xmlns:gsr="http://www.isotc211.org/2005/gsr" xmlns:gss="http://www.isotc211.org/2005/gss" xmlns:gts="http://www.isotc211.org/2005/gts" xmlns:ows="http://www.opengis.net/ows/1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" version="2.0.0" service="WFS">
   <wfs:Insert>
      <cts:Sensors gml:id="SEN_10">
         <cts:sensorProviderId xlink:href="#11" />
         <cts:idsensor>GPS-TestDtom09062014</cts:idsensor>
         <cts:name>GPS-TestDtom09062014</cts:name>
         <cts:description>Interior</cts:description>
         <cts:dateregistration>2014-05-06T16:00:00.000</cts:dateregistration>
         <cts:descriptiveword1>m</cts:descriptiveword1>
         <cts:descriptiveword2>x</cts:descriptiveword2>
         <cts:language>English</cts:language>
      </cts:Sensors>
   </wfs:Insert>
</wfs:Transaction>
XML;

$xmlDataTemplate = <<<XML
<?xml version="1.0"?>
<wfs:Transaction version="2.0.0" service="WFS" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:ns1="urn:ietf:params:xml:ns:senml" xmlns:gml="http://www.opengis.net/gml" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:smil20="http://www.w3.org/2001/SMIL20/" xmlns:smil20lang="http://www.w3.org/2001/SMIL20/Language" xmlns:wfs="http://www.opengis.net/wfs/2.0" xmlns:ows="http://www.opengis.net/ows/1.1" xmlns:fes="http://www.opengis.net/fes/2.0" xsi:schemaLocation="urn:ietf:params:xml:ns:senml schema/sensorML/senml.xsd http://www.opengis.net/wfs/2.0 schema/wfs/2.0/wfs.xsd" >
    <wfs:Insert>
        <ns1:senml bn="GPS-TestDtom09062014" bt="1396541478">
        </ns1:senml>
    </wfs:Insert>
</wfs:Transaction>
XML;

?>
