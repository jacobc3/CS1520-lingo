<!DOCTYPE html>
<html>
<head>
<title>Lingo the game</title>
<STYLE type=text/css>
BODY {
	MARGIN-TOP: 100px;
	FONT-SIZE: 14pt;
	MARGIN-LEFT: 100px;
	MARGIN-RIGHT: 100px;
	text-align: center;
	font-weight: bold;
}

h1 {
	font-size: 30px;
	font-weight: bold;
	color: #CC00CC;
}

input {
	font-size: 24px;
	font-weight: bold;
}

.STYLE2 {
	font-size: 40px;
	color: #330066;
}

table {
	/*border: 1px solid;*/
	width: 200px;
	text-align: center;
	horizontal-align: center;
	margin: 10px auto;
	border-collapse: collapse;
	border: 1px solid gray;
}

td {
	text-align: center; /* center checkbox horizontally */
	vertical-align: middle; /* center checkbox vertically */
	/* border:1px;*/
}

tr {
	/* border:1px;*/
	
}
</STYLE>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
var word_list = new Array();
var total_count;
var win_count;
var username;
var played_list = new Array();
var max_play = 5;
var game_finished = false;
var starting_number = -1;


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
                
                document.getElementById("welcome").innerHTML="Welcome user "+username.toLocaleUpperCase()+" To LINGO!";
                document.getElementById("game_status").innerHTML="Game Status</br>Total Play:"+total_count+"</br>Win Count:"+win_count+"</br>Word List "
                +word_list.toString()+"</br>Played:"+ played_list.toString();
                
                document.getElementById("visible_game_status").innerHTML="Game Status</br>Total Play:"+total_count+"</br>Win Count:"+win_count+"</br>";
                startGame();
            } else {
            	username = prompt("What's your name?");
            	//document.write("<p> Paragraph here</p>");
            	document.getElementById("welcome").innerHTML="welcome user "+username;
            	win_count = 0;
            	total_count = starting_number;
            	played_list = [];
            	//word_list = getWordsFromServer(); 
            	getWordsFromServer();    	
            	document.getElementById("game_status").innerHTML="Game Status</br>Total Play:"+total_count+"</br>Win Count:"+win_count+"</br>Word List "
            	+word_list.toString()+"</br>Played:"+ played_list.toString();
            	document.getElementById("visible_game_status").innerHTML="Game Status</br>Total Play:"+total_count+"</br>Win Count:"+win_count+"</br>";
                
            	startGame();
            }
        } else {
        	document.getElementById("welcome").innerHTML= "OMG WHAT BROWSER YOU USING? </br>";
        }
        if(!game_finished){
	        localStorage.word_list = JSON.stringify(word_list);
	        localStorage.username = JSON.stringify(username);
	        localStorage.win_count = JSON.stringify(win_count);
	        localStorage.total_count = JSON.stringify(total_count);
	        localStorage.played_list = JSON.stringify(played_list);
        }
    }
    
    var httpRequest;
    function getWordsFromServer(){    	
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
    	//xmlhttp.open("GET","cd_catalog.xml",false);
    	httpRequest.onreadystatechange=stateChanged;
        httpRequest.open('GET', 'getWord.php', true);
        httpRequest.setRequestHeader('Content-Type', 'text/xml');
        httpRequest.send();
    	//var words = ['absde','bawef','cwefw','dwwwd','edfes'];
    	//return word_list;
    }
    
	function stateChanged() { 
		if (httpRequest.readyState==4 || httpRequest.readyState=="complete"){ 
     	document.getElementById("welcome").innerHTML = httpRequest.responseText;
     	//alert(httpRequest.responseText);
     	var root = httpRequest.responseXML.documentElement;
	       // Get the setup and punchline through their XML tags
	       //word_list = new Array();
			for(var i = 0; i<5;i++){
				var setup = root.getElementsByTagName('Word')[i].childNodes[0].nodeValue;
		       	//alert(setup);
				word_list.push(setup);			       	
			}
			//alert(word_list.toString());
			localStorage.word_list = JSON.stringify(word_list);
			
			location.reload();
	       
     	}
		
    }
var word;
    function getNewWord(){
       // var word;
    	var maximum = word_list.length - 1;
        var minimum = 0;
    	var random_number = Math.floor(Math.random() * (maximum - minimum + 1)) + minimum;
    	word =  word_list[random_number];
    	if(played_list.indexOf(word) > -1){ //contains
        	//alert("duplcated "+word);
        	word = getNewWord();
    	}
        return word;
    	
    }

    
    function startGame(){
        if(total_count < max_play){
        	total_count++;
	    	this_word = getNewWord();
	    	document.getElementById("this_word").innerHTML = "This word is: "+this_word+"</br>";
	    	document.getElementById("game_status").innerHTML="Game Status</br>Total Play:"+total_count+"</br>Win Count:"+win_count+"</br>Word List "
	        +word_list.toString()+"</br>Played:"+ played_list.toString();
	    	document.getElementById("visible_game_status").innerHTML="Game Status</br>Total Play:"+total_count+"</br>Win Count:"+win_count+"</br>";
            
	        if(this_word){
		    	document.getElementById('input00').value = this_word.charAt(0).toUpperCase();
		    	document.getElementById('input00').readOnly = true;
		    	document.getElementById('input10').focus();
	        }
        } else {
            //game finished!
            game_finished = true;
        	document.getElementById("my_log").innerHTML= "GAME IS FINISHED</br>";
        	//document.getElementById("game_status").innerHTML ="Game Summary</br>Total Play:"+total_count+"</br>Win Count:"+win_count+"</br>Word List "
	        //+word_list.toString()+"</br>";
	        var game_summary = "Game Summary\nTotal Play:"+total_count+"\nWin Count:"+win_count+"\nWord List "
	        +word_list.toString()+"\n";
	        alert(game_summary+"\nclick to start new game");
	        erase();
        }
    }
    
    function erase(){   
    	total_count = starting_number;
	    win_count = 0;
	    username = "";
	    word_list = "";
	    played_list = "";
	    localStorage.removeItem('word_list');
	    localStorage.removeItem('username');
	    localStorage.removeItem('win_count');
	    localStorage.removeItem('total_count');
	    localStorage.removeItem('played_list');
    	localStorage.clear();
    	window.localStorage.clear();
    	document.getElementById("game_status").innerHTML="Erased</br>";
    	//location.reload();
    	window.setTimeout(function(){location.reload()},1000);
    }

</script>


<SCRIPT language=javascript id=clientEventHandlersJS>
	function endingColumnKeyup(placement) {
		var game_win = true;
		var number = parseInt(placement);
		var next = number+6;
		var next_label;
		var this_label;
		if(placement<10){
			next_label = "input"+next;
			this_label = "input0"+number;
		}else if (placement ==54){//if this == 54, then finished
			this_label = "input"+number;
			next_label = this_label;		
		} else {
			next_label = "input"+next;
			this_label = "input"+number;
		}
		
		var line_number = Math.floor(placement/10);//range 1~5
		
		document.getElementById("my_log").innerHTML= "placement:"+this_label+" next:"+next_label+"line number: "+line_number+"</br>";
		if (document.getElementById(this_label).value.length == 1) {
			document.getElementById(next_label).focus();
			//document.getElementById(this_label).style.color = "#FF0000";
			document.getElementById(this_label).readOnly=true;
			document.getElementById(this_label).value = document.getElementById(this_label).value.toLocaleUpperCase();
			for(var x = 0; x<5; x++){
				var label = document.getElementById('input'+line_number+""+x);
				label.value = label.value.toLocaleLowerCase();
				document.getElementById("my_log").innerHTML += 'input'+line_number+x+" thisValue:"+label.value+"    Correct:"+this_word.charAt(x)+"</br>";
				if(label.value == this_word.charAt(x)){
					document.getElementById("my_log").innerHTML += "CORRECT!!!</br>";
					//totally correct, Captical & red
					label.style.color = "#FF0000";
					label.value = label.value.toLocaleUpperCase();
				} else if (this_word.indexOf(label.value)!=-1){
					//wrong location, captical & blue #0000FF
					document.getElementById("my_log").innerHTML += "PARTIAL CORRECT</br>";
					label.style.color = "#0000FF";
					label.value = label.value.toLocaleUpperCase();
					game_win = false;
				} else {
					//totally wrong
					document.getElementById("my_log").innerHTML += "WRONG</br>";
					//label.value = label.value.toLocaleLowerCase();
					game_win = false;	
				}
			}
		}
		
		if(game_win == true){
			alert("YOU WIN!!!");
			win_count++;
			played_list.push(this_word);
			//unchanged
			localStorage.word_list = JSON.stringify(word_list);
	        localStorage.username = JSON.stringify(username);
	        //changed
	        localStorage.win_count = JSON.stringify(win_count);
	        localStorage.total_count = JSON.stringify(total_count);
	        localStorage.played_list = JSON.stringify(played_list);
			//startGame();
			//win_count ++;
			document.getElementById("my_log").innerHTML += "YOU WIN!!!</br>";
			location.reload();
		} else if(placement == 54){
			alert("YOU LOSE!!!");
			played_list.push(this_word);
			//unchanged
			localStorage.word_list = JSON.stringify(word_list);
	        localStorage.username = JSON.stringify(username);	       
	        localStorage.win_count = JSON.stringify(win_count);
	        //changed
	        localStorage.total_count = JSON.stringify(total_count);
	        localStorage.played_list = JSON.stringify(played_list);
	        location.reload();
		} else { //NOT FINISHED YET
			
		}
		
	}
	function columnKeyup(placement) {
		var number = parseInt(placement);
		var next = number+1;
		document.getElementById("my_log").innerHTML= "placement:"+number+" next:"+next+"</br>";
		var next_label;
		var this_label;
		
		if(placement<10){
			this_label = "input0"+number;
			next_label = "input0"+next;
		} else {
			next_label = "input"+next;
			this_label = "input"+number;
		}
		
		if (document.getElementById(this_label).value.length == 1) {
			document.getElementById(next_label).focus();
			//document.getElementById(this_label).style.color = "#FF0000";
			document.getElementById(this_label).readOnly=true;
		}
	}
//-->
</script>
</head>
<body onload="onLoad()">
	<ol id="theList"></ol>
	<h1>
		<p id="welcome"></p>
	</h1>

	</br>
	<p hidden>hidden?</p>
	<p id="game_status" hidden></p>
	<p id="visible_game_status"></p>
	<p id="this_word">This word:</p>
	<p id="my_log" hidden>LOG</p>
	<input type='button' value='Erase local storage' onClick='erase()' />
	</br>
	</br>
	<?php 
	echo '<table id = "table">'."\n";
	echo "\t".'<tr>'."\n";
	$i = 0;
	$j = 0;
	echo "\t"."\t".'<td >'."\n";//"'.$i.$j.'"
	echo "\t"."\t"."\t".'<input maxLength=1 size=1 id=input'.$i.$j.'>'."\n";
	echo "\t"."\t".'</td>'."\n";
	for($j = 1; $j<5; $j++){
		echo "\t"."\t".'<td>'."\n";//"'.$i.$j.'"
		echo "\t"."\t".'</td>'."\n";
	}
	echo "\t".'</tr>'."\n";
	for($i = 1; $i<6; $i++){
		echo "\t".'<tr>'."\n";
		for($j = 0; $j<5; $j++){
			if($j!=4){
				echo "\t"."\t".'<td>'."\n";//"'.$i.$j.'"
				echo "\t"."\t"."\t".'<input language=javascript onKeyUp="return columnKeyup(\''.$i.$j.'\')" maxLength=1 size=1 id=input'.$i.$j.'>'."\n";
				//<INPUT language=javascript onkeyup="return T1_onkeyup()"
				//				maxLength=4 size=4 name=T1>
				echo "\t"."\t".'</td>'."\n";
			} else {
				echo "\t"."\t".'<td>'."\n";//"'.$i.$j.'"
				echo "\t"."\t"."\t".'<input language=javascript onKeyUp="return endingColumnKeyup(\''.$i.$j.'\')" maxLength=1 size=1 id=input'.$i.$j.'>'."\n";
				//<INPUT language=javascript onkeyup="return T1_onkeyup()"
				//				maxLength=4 size=4 name=T1>
				echo "\t"."\t".'</td>'."\n";
			}

		}
		echo "\t".'</tr>'."\n";
	}



	echo '</table>'."\n";
	?>

</body>
<script type="text/javascript">
document.getElementById("my_log").innerHTML = "running last line";
</script>
</html>
