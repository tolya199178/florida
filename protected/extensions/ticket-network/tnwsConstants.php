<?php
DEFINE('TNWS', true);

if(MODE == 'test'){
	DEFINE('WSDL', 'http://tnwebservices-test.ticketnetwork.com/tnwebservice/v3.2/tnwebservicestringinputs.asmx?WSDL');
}else{
	DEFINE('WSDL', 'http://tnwebservices.ticketnetwork.com/tnwebservice/v3.2/tnwebservicestringinputs.asmx?WSDL');
}

DEFINE('WEB_CONF_ID', 11150); // make sure you change this to your config id
DEFINE('HIGH_INVENTORY_PERFORMERS_LENGTH', 15);
DEFINE('BROKER_ID', 1447);
DEFINE('SITE_ID', 6);


DEFINE('UNITED_STATES', 217);