<?php

class CrossOriginProxy
{
	public static function proxy($whitelist = [], $timeout = 30, $maxredirs = 10)
	{
		require dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'proxy.php';
	}
}