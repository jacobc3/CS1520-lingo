<html>
<head>
<title>EXTREMELY PRIMITIVE RSS Reader</title>
<script type="text/javascript">
    // CS 1520 Summer 2013
    // Simple example using XML rather than text with AJAX.  In this example
    // I am parsing an RSS 2.0 xml file to display the contents in an HTML
    // table.  Note how both the HTML document and the XML document can be
    // parsed in similar ways using DOM functionality.

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
 
        httpRequest.open('GET', 'http://cs1520.cs.pitt.edu/~nomad/xml/rss2sample.xml', true);
        httpRequest.setRequestHeader('Content-Type', 'text/xml');
        httpRequest.setRequestHeader('Cache-Control', 'no-cache');

        httpRequest.onreadystatechange = function() { showFeed(httpRequest); };
        httpRequest.send(null);
    }

    function showFeed(httpRequest)
    {
        if (httpRequest.readyState == 4)
        {
           if (httpRequest.status == 200)
           {
               var root = httpRequest.responseXML.documentElement;
               // Make an HTML table then populate it with the data from
               // the returned XML document

               var oldTable = document.getElementById('theTable');
               var body = document.getElementsByTagName("body")[0];
               if (oldTable != null)
               {
                   body.removeChild(oldTable);
               }
               var theTable = document.createElement('table');
               theTable.setAttribute('id','theTable');
               theTable.border = 1;
               var cap = theTable.createCaption();
               var channel = root.getElementsByTagName('channel')[0];
               var title = channel.getElementsByTagName('title')[0].childNodes[0].nodeValue;
               cap.appendChild(document.createTextNode(title));
               body.appendChild(theTable);
               var fields = new Array('title','link','description','pubDate','guid');
               var hrow = theTable.insertRow(0);
               hrow.align = 'center';
               for (var i = 0; i < fields.length-1; i++)
               {
                   var C = hrow.insertCell(i);
                   var cellContents = document.createTextNode(fields[i]);
                   C.appendChild(cellContents);
               }

	       	   var items = root.getElementsByTagName('item');
               //alert('There are ' + items.length + ' items ');
               for (var i = 0; i < items.length; i++)
               {
                   var R = theTable.insertRow(i+1);
                   R.align = 'center';
                   //alert('Showing item ' + i);
                   var curr = items[i];
                   for (var j = 0; j < fields.length-1; j++)
                   {
                       var currTag = curr.getElementsByTagName(fields[j]);
                       //alert(fields[j] + ' is ' + currTag[0].childNodes[0].nodeValue);
                       C = R.insertCell(j);

		       // We want this data to be a link, so we need to create
		       // the proper element and put the contents into it 
                       if (fields[j] == 'link')
                       {
                          cellContents = document.createElement('a');
                          cellContents.setAttribute('href',currTag[0].childNodes[0].nodeValue);
                          var showIt = document.createTextNode(currTag[0].childNodes[0].nodeValue);
                          cellContents.appendChild(showIt);
                       }
                       else
                       { 
                          cellContents = document.createTextNode(currTag[0].childNodes[0].nodeValue);
                       }
                       C.appendChild(cellContents);
                   }
               }
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