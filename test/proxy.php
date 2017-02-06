<?php

require '../vendor/autoload.php';

// Example of a whitelist
$whitelist = [
	
	// Exact matching
	['http://www.yr.no/place/Sweden/Stockholm/Stockholm/forecast.xml'],
	
	// URL component matching
	['host' => 'localhost'],
	['host' => 'example.com', 'scheme' => 'https'],
	
	// Regex matching
	['regex' => '%^http://www.yr.no/place/Norway/%'],
];

// For the test page
if(isset($_GET['whitelist']))
{
	header("content-type: text/plain; charset=utf-8");
	preg_match('/\$whitelist = [^;]+;/sm', file_get_contents(__FILE__), $m);
	echo $m[0];
	return;
}

// Call/Use the proxy
Geekality\CrossOriginProxy::proxy($whitelist);
