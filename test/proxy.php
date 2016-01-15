<?php

require '../vendor/autoload.php';

CrossOriginProxy::proxy([
	// Exact matching
	['http://www.yr.no/place/Sweden/Stockholm/Stockholm/forecast.xml'],

	// URL component matching
	['host' => 'localhost'],
	['host' => 'example.com', 'scheme' => 'http'],
	
	// Regex matching
	['regex' => '%^http://www.yr.no/place/Norway/%'],

]);
