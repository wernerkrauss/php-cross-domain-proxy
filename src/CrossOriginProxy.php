<?php

/**
 * Cross-origin request proxy for client-side scripts.
 *
 * @see https://github.com/Svish/php-cross-domain-proxy
 */
class CrossOriginProxy
{
	/**
	 * Proxies the incoming request and outputs the response, including headers.
	 *
	 * @param whitelist       Array of acceptable request URLs.
	 * @param curl_timeout    Timeout for the request.
	 * @param curl_maxredirs  Maximum number of allowed redirects.
	 */
	public static function proxy($whitelist = [], $curl_timeout = 30, $curl_maxredirs = 10)
	{
		require dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'proxy.php';
	}
}
