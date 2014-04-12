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
        } else {
        	document.getElementById("welcome").innerHTML= "OMG WHAT BROWSER YOU USING? </br>";
        }
        localStorage.word_list = JSON.stringify(word_list);
        localStorage.username = JSON.stringify(username);
        localStorage.win_count = JSON.stringify(win_count);
        localStorage.total_count = JSON.stringify(total_count);
        localStorage.played_list = JSON.stringify(played_list);
    }
    
    function getWordsFromServer(){
    	var words = ['absde','bawef','cwefw','dwwwd','eeeee'];
    	return words;
    }

    function startGame(){
        while(total_count < 5){
	        var maximum = word_list.length - 1;
	        var minimum = 0;
	    	var random_number = Math.floor(Math.random() * (maximum - minimum + 1)) + minimum;
	    	this_word = word_list[random_number];
	    	document.getElementById("this_word").innerHTML = "This word is: "+this_word+"</br>";
	    	document.getElementById("game_status").innerHTML="Game Status</br>Total Play:"+total_count+"</br>Win Count:"+win_count+"</br>Word List "
	        +word_list.toString()+"</br>Played:"+ played_list.toString();
	        total_count++;
        }
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
	<p id="this_word">This word:</p>
	<input type='button' value='Erase local storage' onClick='erase()' />
	<p>
	<?php 
	echo '<table id = "table" border="1">';
	echo '<td>';
	echo '<tr>~~~~~~~~~~~</tr>';
	echo '</td>';
	echo '</table>';
	?>
</body>
</html>
