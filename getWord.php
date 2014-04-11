<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
/*
 * your game should request 5 random 5-letter words from a
*  PHP script running on the server. These words must be pulled from this file:
*  words5.txt
*  Each word must be randomly selected from all of the words in the list.
*   The five words for the round should be requested and sent to the client via AJAX.
*   The should be sent formatted as either XML or JSON.
*/

$handle = fopen("words5.txt", "r");
$lines = array();
$i = 0;
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        // process the line read.
        $line = trim($line);
        $lines[] = $line;
        
        if($i<10){
        	//echo $line;
        }
        $i++;
    }
} else {
    // error opening the file.
} 
fclose($handle);
//print_r($lines);

//$joke = $lines[rand(0, (count($lines) - 1))];
$numbers = randomNumber(0,(count($lines) - 1),5);
//print_r($numbers);


//echo "============================".$joke."============";
$ans = '<?xml version="1.0" encoding="utf-8"?>';
$ans .="<Words>";
foreach($numbers as $n){
	$ans .= "<Word>$lines[$n]</Word>";
}
$ans.= "</Words>";
echo "$ans";


function randomNumber($min, $max, $quantity) {
	$numbers = range($min, $max);
	shuffle($numbers);
	return array_slice($numbers, 0, $quantity);
}
?>