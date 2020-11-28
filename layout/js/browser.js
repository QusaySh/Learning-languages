var browser = '';
var browserVersion = 0;

if (/Opera[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
    browser = 'Opera';
} else if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) {
    browser = 'MSIE'; // Explorer
} else if (/Navigator[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
    browser = 'Netscape';
} else if (/Chrome[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
    browser = 'Chrome';
} else if (/Safari[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
    browser = 'Safari';
    /Version[\/\s](\d+\.\d+)/.test(navigator.userAgent);
    browserVersion = new Number(RegExp.$1);
} else if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
    browser = 'Firefox';
}
if(browserVersion === 0){
    browserVersion = parseFloat(new Number(RegExp.$1));
}
if ( browser != "Chrome" && browser != "Firefox" && browser != "Safari" ) {
    window.location.href = "error.php?browser=" + browser;
} else if ( browser == "Chrome" ) {
    if ( browserVersion < 54 ) {
        window.location.href = "error.php?browser=" + browser;
    }
} else if ( browser == 'Firefox' ) {
    if ( browserVersion < 60 ) {
        window.location.href = "error.php?browser=" + browser;
    }
}