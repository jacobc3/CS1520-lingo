<html>
<head>
<title>Joke of the Minute Page</title>
<script type="text/javascript">
    // CS 1520 Summer 2013
    // Simple example using XML rather than text with AJAX

    // The basic AJAX framework was taken from the handout that I gave to you
    // in class.  See: http://developer.mozilla.org/en/docs/AJAX
    function processData() {
        var httpRequest;
        if (window.XMLHttpRequest) { // Mozilla, Safari, ...
            httpRequest = new XMLHttpRequest();
            if (httpRequest.overrideMimeType) {
                httpRequest.overrideMimeType('text/xml');
            }
        }
        else if (window.ActiveXObject) { // IE
            try {
                httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
                }
            catch (e) {
                try {
                    httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
                }
                catch (e) {}
            }
        }
        if (!httpRequest) {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
 
        httpRequest.open('GET', 'getJoke.php', true);
        httpRequest.setRequestHeader('Content-Type', 'text/xml');

        httpRequest.onreadystatechange = function() { showJoke(httpRequest); };
        httpRequest.send(null);
	
	    t = setTimeout("processData()",60000);
    }

    function showJoke(httpRequest)
    {
        if (httpRequest.readyState == 4)
        {
           if (httpRequest.status == 200)
           {
	       // Uncomment the lines below if you want to see the raw xml file
               //var temp = httpRequest.responseText;
               //alert(temp);
	
	       // Get the root of the document
           var root = httpRequest.responseXML.documentElement;
	       // Get the setup and punchline through their XML tags
	       var setup = root.getElementsByTagName('Setup')[0].childNodes[0].nodeValue;
	       alert(setup);
	       var punchline= root.getElementsByTagName('Punchline')[0].childNodes[0].nodeValue;
	       alert(punchline);
           }
           else
           {   alert('Problem with request'); }
       }
    }
</script>
</head>
<body onload = "processData()">
</body>
</html>