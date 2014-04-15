<html>
<head>
<title>Find a Book!</title>
<script type="text/javascript">
    // CS 1520 Fall 2013
    // Another simple AJAX XML example.  This script allows the user 
    // to enter an ISBN.  It then forwards the request to the PHP script
    // getBook.php,  which contacts the ISBN server and returns the
    // resulting XML file.  It then shows a few segments of the resulting book. 

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
        var theisbn=document.getElementById("theInput").value;
        var addr = 'getBook.php';
        var data = 'isbn=' + theisbn;
        var url = addr + '?' + data;
        alert(url);
 
        httpRequest.open('GET', url, true);
        httpRequest.setRequestHeader('Content-Type', 'text/xml');

        httpRequest.onreadystatechange = function() { showBook(httpRequest); };
        httpRequest.send(null);
    }

    function showBook(httpRequest)
    {
        if (httpRequest.readyState == 4)
        {
           if (httpRequest.status == 200)
           {
               var oldTable = document.getElementById('theTable');
               var body = document.getElementsByTagName("body")[0];
               if (oldTable != null)
               {
                   body.removeChild(oldTable);
               }
               var text = httpRequest.responseText;
               alert(text);
               var data = httpRequest.responseXML;
               var root = httpRequest.responseXML.documentElement;
               var list = root.getElementsByTagName('BookList')[0];
               var attr = list.attributes;
               var count = attr.getNamedItem("total_results").value;
               if (count < 1)
               {
                   alert('Sorry, but your book was not found');
               }
               else
               {
                   var theTable = document.createElement('table');
                   theTable.setAttribute('id','theTable');
                   theTable.border = 1;
                   body.appendChild(theTable);
                   var hrow = theTable.insertRow(0);
                   hrow.align = 'center';
                   var C = hrow.insertCell(0);
                   var cellContents = document.createTextNode('ISBN');
                   C.appendChild(cellContents);
                   var C = hrow.insertCell(1);
                   var cellContents = document.createTextNode('Title');
                   C.appendChild(cellContents);
                   C = hrow.insertCell(2);
                   cellContents = document.createTextNode('Author');
                   C.appendChild(cellContents);
                   C = hrow.insertCell(3);
                   cellContents = document.createTextNode('Publisher');
                   C.appendChild(cellContents);
               
                   hrow = theTable.insertRow(1);
                   hrow.align = 'center';
                   var bookD = root.getElementsByTagName('BookData')[0];
                   var isbn = bookD.getAttribute('isbn');
                   C = hrow.insertCell(0);
                   cellContents = document.createTextNode(isbn);
                   C.appendChild(cellContents);

                   var title = root.getElementsByTagName('Title')[0].childNodes[0];
                   C = hrow.insertCell(1);
                   if (title != null)
                   {
                       title = title.nodeValue;
                   }
                   else
                   {
                       title = "";
                   }
                   cellContents = document.createTextNode(title);
                   C.appendChild(cellContents);
                   var author = root.getElementsByTagName('AuthorsText')[0].childNodes[0];
                   C = hrow.insertCell(2);
                   if (author != null)
                   {
                       author = author.nodeValue;
                   }
                   else
                   {
                       author = "";
                   }
                   cellContents = document.createTextNode(author);
                   C.appendChild(cellContents);
                   var publisher = root.getElementsByTagName('PublisherText')[0].childNodes[0];
                   C = hrow.insertCell(3);
                   if (publisher != null)
                   {
                       publisher = publisher.nodeValue;
                   }
                   else
                   {
                       publisher = "";
                   }
                   cellContents = document.createTextNode(publisher);
                   C.appendChild(cellContents);
                   document.getElementById("theInput").value = "";
               }
           }
           else
           {   alert('Problem with request'); }
       }
   }
</script>
</head>
<body>
<h3>Please enter the ISBN of your book:</h3>
<input id="theInput" type="text" value="">
<input id="theButton" type="button" value="Enter" onclick = 'processData()'>
</body>
</html>