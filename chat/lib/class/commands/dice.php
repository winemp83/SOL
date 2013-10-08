<?php
//Seperate the choice from the command
$command = substr($msg, 5);
//If there's no # of sides, assume it's a standard 6-sided die.
if($command == "") {
$command = 6;
$sides = 6;
}

//Check if the number of sides is an integer
if(!is_numeric($command)) {
$catbotreply = "That's not a valid number of sides.<br /><br />Roll a dice.<br />Format:<br />!dice <i>sides</i><br /><br />Example:<br />!dice 20";
} else {
$sides = $command;

//Roll the random number
$number = rand(1, $sides);

if($sides == 2) {

if($number == 1) {
$coin = "heads up.";
} else {
$coin = "tails up.";
}
$catbotreply = "There's no such thing as a two-sided dice, so I've flipped a coin instead.<br /><br />It lands " . $coin;
} elseif ($sides == 1) {
$catbotreply = "There's no such thing as a one-sided dice, silly.";

} else {

$catbotreply = "You roll the dice. It lands on " . $number . ".";
}
}



?>