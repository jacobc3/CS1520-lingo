
<!DOCTYPE html>
<html>
<head>
<title>Lingo the game</title>
<script type="text/javascript">

var word_list;
var total_count;
var win_count;
var username;
var played_list;
    function onLoad() { 
    	//
        // check that storage is supported
        if (typeof(Storage) !== "undefined") {
            if (localStorage.username) {
                // note that values still must be stored as strings
                word_list = JSON.parse(localStorage.word_list);
                played_list = JSON.parse(localStorage.played_list);
                win_count = JSON.parse(localStorage.win_count);
                username = JSON.parse(localStorage.username);
                total_count = JSON.parse(localStorage.total_count);
                
                document.getElementById("welcome").innerHTML="welcome user "+username;
                document.getElementById("game_status").innerHTML="Game Status</br>Total Play:"+total_count+"</br>Win Count:"+win_count+"</br>Word List "
                +word_list.toString()+"</br>Played:"+ played_list.toString();
                startGame();
            } else {
            	username = prompt("What's your name?");
            	//document.write("<p> Paragraph here</p>");
            	document.getElementById("welcome").innerHTML="welcome user "+username;
            	win_count = 0;
            	total_count = 0;
            	played_list = [];
            	word_list = getWordsFromServer();             	
            	document.getElementById("game_status").innerHTML="Game Status</br>Total Play:"+total_count+"</br>Win Count:"+win_count+"</br>Word List "
            	+word_list.toString()+"</br>Played:"+ played_list.toString();
            	startGame();
            }
        }
        localStorage.word_list = JSON.stringify(word_list);
        localStorage.username = JSON.stringify(username);
        localStorage.win_count = JSON.stringify(win_count);
        localStorage.total_count = JSON.stringify(total_count);
        localStorage.played_list = JSON.stringify(played_list);
    }
    function getWordsFromServer(){
    	var words = ['aaaa','bbbbb','ccccc','ddddd','eeeee'];
    	return words;
    }

    function startGame(){
    	while(total_count < 5){ //0~4
    		
    	}
    	
    }
    // prompt the user for a new value, add it to the localStorage and add it to the list
    function add() {
        var response = prompt("What is something fun to do?");

        if (typeof(Storage) !== "undefined") {
            var data_list;
            if (localStorage.data_list) {
                data_list = JSON.parse(localStorage.data_list);
                data_list.push(response);
            }
            else {
                data_list = new Array(response);
            }

            localStorage.data_list = JSON.stringify(data_list);
        }

        // add the response to the ordered list
        var ord_list = document.getElementById("theList");
        var list_item = document.createElement("li");
        list_item.appendChild(document.createTextNode(response));
        ord_list.appendChild(list_item);
    }
    
    function erase(){    	
    	localStorage.clear();
    	document.getElementById("game_status").innerHTML="Erased</br>";
    }

</script>
</head>
<body onload="onLoad()">
	<h1>Your list of fun things to do:</h1>
	<ol id="theList"></ol>
	<p id="welcome"></p>
	<p id="game_status"></p>
	<input type='button' value='Add to the list' onClick='add()' />
	<input type='button' value='Erase local storage' onClick='erase()' />
	<?php 
	/*
	 <tr>
	<td>data1</td>
	<td name="tcol1" class="bold"> data2</td>
	</tr>
	<tr>
	<td>data1</td>
	<td name="tcol1" class="bold"> data2</td>
	</tr>
	<tr>
	<td>data1</td>
	<td name="tcol1" class="bold"> data2</td>
	</tr>
	*/
	echo '
<table>
  <tr>
    <td>Customer Name</td>
    <td>', $var1, '</td>
  </tr>
  <tr>
    <td>Customer Age</td>
    <td>', $var2, '</td>
  </tr>
  <tr>
    <td>Customer ...</td>
    <td>', $var3, '</td>
  </tr>
</table>';
	?>
</body>
</html>
