<?php
//Strip off the exclamation point.
$msg = substr($msg, 1);

//Check what the command is
if(mb_strtolower($msg) == 'menu') {
//If it's the menu command, echo a list of commands.
$catbotreply = "Here are the Menu Commands that have been implemented:<br /><br />!m8b - Magic 8 Ball<br />!coin - Guess heads or tails!<br />!addreply and !confirmreply - Add a reply to CatBot<br />!dice - Roll a dice<br />!geoip - Get the physical location of an IP address";

} elseif(mb_strtolower(substr($msg, 0, 3)) == 'm8b') {
//If command is m8b, include m8b command
include "commands/m8b.php";

} elseif(mb_strtolower(substr($msg, 0, 4)) == 'coin') {
//If command is coin, include coin command
include "commands/coin.php";

} elseif(mb_strtolower(substr($msg, 0, 8)) == 'addreply') {
//If command is addreply, open the addreply file - notice that the exclamation point is included - we don't filter out punctuation, because it messes up the replies.
include "commands/addreply.php";

} elseif(mb_strtolower(substr($msg, 0, 12)) == 'confirmreply') {
//If command is confirmreply, open the confirmreply file - notice that the exclamation point is included - we don't filter out punctuation, because it messes up the replies.
include "commands/confirmreply.php";

} elseif(mb_strtolower(substr($msg, 0, 4)) == 'dice') {
//If command is dice, open up the dice roller file.
include "commands/dice.php";

} elseif(mb_strtolower(substr($msg, 0, 5)) == 'geoip') {
//If command is geoip, open up geoip.php
include "commands/geoip.php";

} else {
//If command isn't listed, echo Command Not Found.
$catbotreply = "Command not found.";
}
?>