<?php
//Seperate the choice from the command
$guess = mb_strtolower(substr($msg, 5));
//Generate either 1 or 2
$upside = rand(1,2);

//Figure out what side lands up
if ($upside == 1) {
$sidemessage = "The coin lands heads up.<br /><br />";

if ($guess == "heads") {
$didtheywin = "You win!";
} elseif ($guess == "tails") {
$didtheywin = "Sorry, you lose.";
} else {
$didtheywin = "If you want to play a game by guessing which side comes up, use the command <br />!coin (heads | tails)";
}

} else {
$sidemessage = "The coin lands tails up.<br /><br />";

if ($guess == "heads") {
$didtheywin = "Sorry, you lose.";
} elseif ($guess == "tails") {
$didtheywin = "You win!";
} else {
$didtheywin = "If you want to play a game by guessing which side comes up, use the command <br />!coin <i>heads/tails</i><br /><br />Example:<br />!coin heads";
}

}

$catbotreply = $sidemessage . $didtheywin;
?>