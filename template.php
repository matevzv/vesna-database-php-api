<?php

$jsiCityId="#10";

$xmlRegTemplate = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<wfs:Transaction xmlns:wfs="http://www.opengis.net/wfs/2.0" xmlns:cts="http:www.citi-sense.eu/citisense" xmlns:fes="http://www.opengis.net/fes/2.0" xmlns:gco="http://www.isotc211.org/2005/gco" xmlns:gmd="http://www.isotc211.org/2005/gmd" xmlns:gml="http://www.opengis.net/gml/3.2" xmlns:gsr="http://www.isotc211.org/2005/gsr" xmlns:gss="http://www.isotc211.org/2005/gss" xmlns:gts="http://www.isotc211.org/2005/gts" xmlns:ows="http://www.opengis.net/ows/1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" version="2.0.0" service="WFS">
   <wfs:Insert>
      <cts:Sensors gml:id="SEN_11">
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
<?xml version="1.0" encoding="UTF-8"?>
<wfs:Transaction xmlns:wfs="http://www.opengis.net/wfs/2.0" xmlns:fes="http://www.opengis.net/fes/2.0" xmlns:gml="http://www.opengis.net/gml" xmlns:ns1="urn:ietf:params:xml:ns:senml" xmlns:ows="http://www.opengis.net/ows/1.1" xmlns:smil20="http://www.w3.org/2001/SMIL20/" xmlns:smil20lang="http://www.w3.org/2001/SMIL20/Language" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" version="2.0.0" service="WFS" xsi:schemaLocation="urn:ietf:params:xml:ns:senml schema/sensorML/senml.xsd http://www.opengis.net/wfs/2.0 schema/wfs/2.0/wfs.xsd">
   <wfs:Insert>
      <ns1:senml bn="GPS-TestDtom09062014" bt="1396541478">
         <ns1:e sv="2.1950617; 2.19505396" t="-691244" u="m" />
         <ns1:e sv="2.19505339" t="-691245" u="m" />
         <ns1:e sv="2.19491459" t="-691970" u="m" />
         <ns1:e sv="2.19491191" t="-691971" u="m" />
         <ns1:e sv="2.19488452; 2.1950417" t="-691972" u="m" />
         <ns1:e sv="2.1948844" t="-691973" u="m" />
         <ns1:e sv="2.19489147" t="-691975" u="m" />
         <ns1:e sv="2.19489079" t="-691976" u="m" />
         <ns1:e sv="2.19488978" t="-691977" u="m" />
         <ns1:e sv="2.19489159" t="-691978" u="m" />
         <ns1:e sv="2.19489347" t="-691980" u="m" />
         <ns1:e sv="2.19489269" t="-691981" u="m" />
         <ns1:e sv="2.19489432" t="-691982" u="m" />
         <ns1:e sv="2.19489495" t="-691983" u="m" />
         <ns1:e sv="2.19489555" t="-691985" u="m" />
         <ns1:e sv="2.19489289" t="-691986" u="m" />
         <ns1:e sv="2.1948925" t="-691987" u="m" />
         <ns1:e sv="2.19488913" t="-691988" u="m" />
         <ns1:e sv="2.19488336" t="-691990" u="m" />
         <ns1:e sv="2.1948792" t="-691991" u="m" />
         <ns1:e sv="2.1949797" t="-691992" u="m" />
      </ns1:senml>
   </wfs:Insert>
</wfs:Transaction>
XML;

?>
