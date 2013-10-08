<?php
//Delete the command from the string
$newmsg = substr_replace($msg, '', 0, 9);

if($newmsg == "") {
$catbotreply = "!addreply - Add a reply to CatBot. <br />Usage: <br /> !addreply ~<b>trigger here </b> #<i>This is CatBot's reply.</i> <br /><br />Example: !addreply ~aloha #Hey!";

} else {
//First, find the message starting at the ~
$msgfromtilde = strstr($newmsg, "~");

//Next, find the message starting at the #
$msgfrompound = strstr($newmsg, "#");

if ($msgfromtilde == FALSE || $msgfrompound == FALSE) {
$catbotreply = "You need to supply both a trigger and a reply.";
} else {
$tildecount = strlen($msgfromtilde);
$tildecountoneup = -($tildecount + 1);

$poundcount = strlen($msgfrompound);
$poundcountoneup = -($poundcount + 1);

//If ~ message has a # in it, then chop off the # to the end
if(stripos($msgfromtilde, "#") == FALSE){
//If there's no # in the rest of the string, then assume that it's before the ~, and get the trigger
$trigger = substr($msgfromtilde, 1);
//The reply, then, is hopefully right before the trigger, so chop off the trigger.
$reply = substr_replace($msgfrompound, "", $tildecountoneup);
//Chop off the #
$reply = substr($reply, 1);
//Check to see if there's both the trigger and reply symbols
} elseif (stripos($msgfrompound, "~") == FALSE) {
//If there is a # in the rest of the string, then assume that it's after the ~, and get the reply
$reply = substr($msgfrompound, 1);
//The trigger, then, is hopefully right before the reply, so chop off the reply.
$trigger = substr_replace($msgfromtilde, "", $poundcountoneup);
//Chop off the ~
$trigger = substr($trigger, 1);
}
//Parse the b64 code. Easier to send both strings combined. Also prevents people from simply bypassing the check.
$confirmcode = $trigger . "-+-" . $reply;
$confirmcode = base64_encode($confirmcode);

$catbotreply = "<br />This is the trigger and reply you entered. <br /> <b>Trigger:</b> " . $trigger . "<br /><b>Reply:</b> " . $reply . "<br /><br />Please make sure that this is correct.<br />If it looks right, type or copy/paste the following command:<br />!confirmreply " . $confirmcode;
}
}
?>