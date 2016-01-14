PHP Cross Domain Proxy
===

Client-side HTTP requests, are limited by browser cross-origin restrictions.

Preferably fixed by [enabling CORS](http://enable-cors.org/server.html) on the server you're trying to call, but sometimes this just isn't possible because reasons.

A simple workaround is having a server-side proxy script on the same domain as your client-side script (e.g. both at `api.example.com`), and let the server do these cross-domain requests on behalf of the client.

This is such a script.



Installation
---

Since `proxy.php` is completely self-contained, you can just
1. Copy `proxy.php` into your web application
2. Edit the $whitelist array
3. And that's pretty much it

If using [Composer](http://getcomposer.org), you can also add
the following dependency to your `composer.json`:

``` JSON
"require":
{
	"geekality/php-cross-domain-proxy": "dev-master"
},
```

And then add a `proxy.php` like this to your web application:

``` PHP
	<?php
		require 'vendor/autoload.php';

		CrossOriginProxy::proxy([
			'www.example.com',
			'api.example.com',
		]);

```


Usage
---

On the client-side, when performing cross-origin requests:

1. Make `url` point to the `proxy.php` script
2. Set the HTTP header `X-Proxy-URL` to whatever URL you're calling, for example `http://api.example.com/some/path`

All parameters and HTTP headers (except `Cookie`, `Host` and `X-Proxy-URL`) will be used to recreate the request and performed server-side by the proxy. When complete it will mirror the response, including headers, and return it to the client-side script more or less as if it had been called directly.


Using jQuery
---

**Basic GET request**

``` JAVASCRIPT
$.ajax({
    url: 'proxy.php',
    cache: false,
    headers: {
        'X-Proxy-URL': 'http://api.example.com/some/path',
    },
})
```

**Automagic via global [`ajaxSend`](http://api.jquery.com/ajaxSend/) event**


``` JAVASCRIPT
$(function()
{
	// Hook up the event handler
	$(document).ajaxSend(useCrossDomainProxy);
});

function useCrossDomainProxy(event, jqxhr, options)
{
	if(options.crossDomain)
	{
		// Copy URL to HTTP header
		jqxhr.setRequestHeader('X-Proxy-URL', options.url);

		// Set URL to the proxy
		options.url = 'proxy.php';

		// Since all cross-origin URLs will now look the same to the browser, 
		// you can add a timestamp, which will prevent browser caching.
		options.url += '?_='+Date.now();
	}
}

// Later, somewhere else, it's now much cleaner to do a cross-origin request
$.ajax({
	url: 'proxy.php',
    data: {a:1, b:2},
})

```

When using `cache:false` jQuery adds a `_` GET parameter to the URL with the current timestamp to prevent the browser from returning a cached response. This happens *before* the `ajaxSend` event, so in the above case, if you had set `cache:false`, that `_` parameter would just be "moved" to the `X-Proxy-URL` header and no longer have any effect. So instead, leave `cache` at its default value `true`, and add the parameter manually to the proxy url instead.

**More?**

Some more examples can be found in [test/index.html](test/index.html).
