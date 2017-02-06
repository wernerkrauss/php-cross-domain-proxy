<?php

require '../vendor/autoload.php';

// Example of a whitelist
$whitelist = [
	
	// Exact matching
	['http://www.yr.no/place/Sweden/Stockholm/Stockholm/forecast.xml'],

	// URL component matching
	['host' => 'localhost'],
	['host' => 'example.com', 'scheme' => 'http'],
	
	// Regex matching
	['regex' => '%^http://www.yr.no/place/Norway/%'],
];


// Call/Use the proxy
Geekality\CrossOriginProxy::proxy($whitelist);
