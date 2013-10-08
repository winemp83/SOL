<?php
//Delete the command from the string
$newmsg = substr_replace($msg, '', 0, 13);

if($newmsg == "") {
$catbotreply = "!confirmreply - Confirm an added reply to CatBot. <br />Usage: <br /> !confirmreply <b>confirmation code</b><br /><br />Example: !confirmreply YWxvaGEtKy1IZXkh";

} else {
//First, decode the base64 message
$newmsg = base64_decode($newmsg);

//Next, find the message starting at the string seperator (-+-)
$posfromleft = strpos($newmsg, "-+-");

if ($posfromleft === FALSE){
$catbotreply = "That code does not appear to be valid...";
} else {
$reply = substr($newmsg, $posfromleft+3);
$trigger = substr($newmsg, 0, $posfromleft);
}

//We're already connected to the database, no need to reconnect.

// Query the Database
$query = "INSERT INTO `strreplace` ( `str` , `replace` , `usercontrib` ) VALUES ('$trigger', '$reply', '1');";
$result = mysql_query($query);

$catbotreply = "<br /><b class='green'>Confirmed</b> the following trigger and reply set was added: <br /> <b>Trigger:</b> " . $trigger . "<br /><b>Reply:</b> " . $reply . "<br /><br /><b>PLEASE do NOT refresh.</b> It doesn't help any.";
}
?>