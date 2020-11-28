getInfo = document.getElementById("btngetInfo");

getInfo.onclick = function () {
    var xhttp;

    if ( window.XMLHttpRequest ) {
        xhttp = new XMLHttpRequest;
    } else {
        xhttp = new ActiveXObject('Microsoft.XMLHTTP');
    }
    
    xhttp.onreadystatechange = function () {
        if ( xhttp.readyState === 4 && xhttp.status === 200 ) {
            document.getElementById("result").innerHTML = xhttp.responseText;
        } else {
            document.getElementById("result").innerHTML = '<img width=50 height=50 src="loading.gif" />';
        }
    }
    
    xhttp.open("GET", "testAjax.php?getInfo=true", false);
    
    xhttp.send();
}
