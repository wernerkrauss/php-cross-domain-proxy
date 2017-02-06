
var sendBtn  = '<button class="send">🛫</button>';
var closeBtn = '<button class="close">❌</button>';
var respOk = '🛬';
var respBad = '💥';


NProgress.configure({showSpinner: false});

// Get whitelist
$.ajax({
	url: 'proxy.php?whitelist',
	async: false,
	success: function(data)
	{
		$('#whitelist').text(data);
	}
});

// Hook up events
$(document)
	.ajaxStart(NProgress.start)
	.ajaxStop(NProgress.done)
	.ajaxSend(onAjaxSend)
	.ajaxComplete(onAjaxComplete)
	.on('click', 'button.close', onClose)
	.on('click', 'button.send', onSend);

// Make fancy
$('pre[contenteditable]')
	.on('keydown', onPreKeydown)
	.wrap('<div>')
	.after(sendBtn);





function onSend()
{
	$('.active').removeClass('active');
	$('output').remove();

	var pre = $(this)
		.siblings('pre')
		.addClass('active');
	try
	{
		var func = new Function(pre.text());
		func();	
	}
	catch(e)
	{
		onAjaxComplete(null, {
			status: '-1',
			statusText: e,
		});
	}

}


function onClose()
{
	$('.active').removeClass('active');
	$(this)
		.parent()
		.fadeOut(function() 
			{
				$(this).remove();
			});
}


function onAjaxSend(e, x, opts)
{
	//if(opts.crossDomain)
	{
		x.setRequestHeader('X-Proxy-Url', opts.url);
		opts.url = 'proxy.php';
		opts.url += '?_='+Date.now();
	}
}

function onAjaxComplete(e, x, opts)
{
	var out = x.status >= 400 ? respBad : respOk;
	out += ' ' + x.status + ' ' + x.statusText;
	out += '\r\n' + x.getAllResponseHeaders()
	if(x.responseText)
		out += '\r\n' + x.responseText;

	$('<output>')
		.text(out)
		.insertAfter('.active')
		.append(closeBtn)
		.hide()
		.fadeIn();

	$('html,window')
		.scrollTop($('.active').offset().top-30);
}

function onPreKeydown(e)
{
	// CTRL+ENTER
	if(e.ctrlKey && e.which == 13)
	{
		$(this)
			.siblings('button.send')
			.trigger('click');
		return false;
	}
	return true;
}
