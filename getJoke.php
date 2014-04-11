<?php
// CS 1520
// Simple script to retrieve a joke and its punchline from a database and

$jokes = array();
$jokes[] = array("What do dinosaurs have that no other animals have?", "Baby Dinosaurs.");
$jokes[] = array("Where does a Tyrannosaurus sit when he comes to stay?", "Anywhere he wants to.");
$jokes[] = array("What did they call prehistoric sailing disasters?", "Tyrannosaurus wrecks.");
$jokes[] = array("Can you name 10 dinosaurs in 10 seconds?", "Yes, 8 iguanadons and 2 stegasaurus.");
$jokes[] = array("What do you call a dinosaur as tall as a house, with long sharp teeth, and 12 claws on each foot?", "Sir.");
$jokes[] = array("What do you call a dinosaur as tall as a house, with long sharp teeth, 12 claws on each foot and a personal stereo over his ears?", "Anything you like, he won't hear you!");
$jokes[] = array("What do you get if you cross a mouse with a triceratops?", "Enormous holes in the skirting board.");
$jokes[] = array("How can you tell if there is a dinosaur in bed with you?", "By the `D' on his pajamas.");
$jokes[] = array("How do you know if there is a brachiosaurus in bed with you?", "By the dinosnores.");

$joke = $jokes[rand(0, (count($jokes) - 1))];

$setup = $joke[0];
$punch = $joke[1];
$ans = '<?xml version="1.0" encoding="utf-8"?>';
$ans .= "<Joke><Setup>$setup</Setup><Punchline>$punch</Punchline></Joke>";
echo "$ans";
?>