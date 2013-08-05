if(typeof jQuery === 'undefined'){ 
	document.write(unescape("%3Cscript src='../js/jquery-1.9.1.min.js' type='text/javascript'%3E%3C/script%3E")); 
}

if(typeof jQuery.mobile === 'undefined'){ 
	document.write(unescape("%3Cscript src='../js/jquery.mobile-1.3.1.min.js' type='text/javascript'%3E%3C/script%3E")); 
}

$.each(document.styleSheets, function(i,sheet){
    if(sheet.href=='http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css') {
        var rules = sheet.rules ? sheet.rules : sheet.cssRules;
        if (rules && rules.length == 0) {
          document.write(unescape('%3Clink rel="stylesheet" type="text/css" href="../css/jquery.mobile-1.3.1.min.css" /%3E'));
        }
    }
});
