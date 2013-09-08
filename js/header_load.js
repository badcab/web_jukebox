var head = document.getElementsByTagName('head')[0];

if(typeof jQuery === 'undefined'){
	var script = document.createElement('script');
	script.src = '../js/jquery-1.9.1.min.js';//alternate jQuery file loc
	script.type = 'text/javascript';
	head.appendChild(script);
}

if(typeof jQuery.mobile === 'undefined'){
	var script = document.createElement('script');
	script.src = '../js/jquery.mobile-1.3.1.min.js';//alternate jQuery.mobile file loc
	script.type = 'text/javascript';
	head.appendChild(script);
}

if (!$("link[href='http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css']").length){
	$('head').append( $('<link rel="stylesheet" type="text/css" />').attr('href', '../css/jquery.mobile-1.3.1.min.css') );
}
