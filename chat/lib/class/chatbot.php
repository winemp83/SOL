<?php
$usermessage = str_replace('/botty', ' ', $text);
$usermessage = trim($usermessage);
$logging = false;
$logfile = 'log.txt'; 
$allowcommands = true;
$default = FALSE;

//Don't allow HTML to be used
//Note that I'm not using striptags - because I want to keep any text that's inside tags (to prevent accidental deletion)
$htmlcharacters = array("<", ">", "&amp;", "&lt;", "&gt;", "&");
$usermessage = str_replace($htmlcharacters, "", $usermessage);

//Strip out the slashes
$msg = stripslashes($usermessage);

//Check if the input starts with an exclamation point -- Menu command
$isexpoint = $msg{0};

//If it's a command, do nothing. Otherwise take out a few characters and convert it to lowercase.
//Note - Make sure that you don't change the case of commands,
//Some rely on base64, which is case-sensitive.
//Also, we're removing punctuation for non-commands (easier string comparison)
if ($isexpoint == "!"){
} else {
$badthings = array("=", "#", "~", "!", "?", ".", ",", "<", ">", "/", ";", ":", '"', "'", "[", "]", "{", "}", "@", "$", "%", "^", "&", "*", "(", ")", "-", "_", "+", "|", "`");
$msg = str_replace($badthings, "", $msg);
$msg = mb_strtolower($msg);
}

//Converts contractions to full words, as well as taking out some common misspellings.
//Keep them in this order (for the most part), otherwise things get messed up, and...blah.
//For example, if "won't" was after "n't", then it would convert to "wo not" instead of "wouldn't". 
$contractions = array("can't", "won't", "n't", "'ll", "'d", "'re", "'ve", "i'm", "it's", "he's", "she's", "what's", "who's", " u ", " r ", " ur ", " im ");
$fullwords = array("cannot", "will not", " not", " will", " would", " are", " have", "i am", "it is", "he is", "she is", "what is", "who is", " you ", " are ", " you are ", " i am ");
$msg = str_replace($contractions, $fullwords, $msg);

//Explode the input and count the number of words - Used for other commands, don't delete this.
//I'm not using str_word_count because...well...I don't like it.
$msgarray = explode(" ", $msg);
$words = count($msgarray);



//If the input is a Command, include menu.php and forgo the regular database connection/string comparison crap.
if ($isexpoint == "!" && $allowcommands == TRUE) {
include 'commands/menu.php';
//Also, set the post that the last reply was a command. (This is for the reply addition system).
$command = 1;
} elseif ($isexpoint == "!" && $allowcommands == FALSE) {
$catbotreply = "Commands have been disabled.";
} else {


$command = 0;


//Since the input isn't a command, then
// Query the Database

//First, check for an exact match to the database.
$equery = "SELECT * FROM ".CHATBOT_REPLIES." WHERE `trigger` = '$msg';";
$exact = $GLOBALS['DATABASE']->query($equery);
//If it returns a row, use that.
if($GLOBALS['DATABASE']->numRows($exact) !== 0){
$result = $exact or die('Query failed: ' . mysql_error());
} else {
//Otherwise, go with a "Best match" method.
$query = "SELECT *, MATCH (`trigger`) AGAINST ('$msg') AS score FROM ".CHATBOT_REPLIES." WHERE MATCH (`trigger`) AGAINST ('$msg');";
$result = $GLOBALS['DATABASE']->query($query) or die('Query failed: ' . mysql_error());
}

$replyarray = $GLOBALS['DATABASE']->fetch_array($result);

//Check if someone has asked something. If not, assume they've just opened the window, and say "Connected!" back to them.
if (isset($usermessage)) {
$catbotreply = $replyarray['reply'];
} else {
$catbotreply = 'Connected!';
}

//If there's no reply found, choose a random autoreply.
$noreplyfound = array('...', 'lol', 'I see.', 'Er...', '?', 'What?');

//If CatBot can't find the reply, and the userinput is only 1 word, repeat the word with a question mark (to make him sound a little more intelligent.)
//If it's more than one word, use the auto-replies from above.
if($catbotreply == "" && $words == 1){
$catbotreply = ucfirst($msg) . "?";
} elseif($catbotreply == "") {
$catbotreply = $noreplyfound[rand(0,5)];
}

//If the message is more than 20 words, warn them.
if ($words > 20){
$catbotreply = "Whoa! This isn't an email! You don't need to type so much!";
}

}

/* End of Command/talk seperation */

//Reduce CatBot's replies down the same way we did before. (For "learning")
$simplecatbot = mb_strtolower($catbotreply);
$simplecatbot = str_replace($contractions, $fullwords, $simplecatbot);
$badthings = array("!", "?", ".", ",");
$simplecatbot = str_replace($badthings, "", $simplecatbot);


$lastcatbot = $catbotreply;
$lastwascomm  = 0;


//If this time isn't a command, and last time wasn't a command, and it's not the default message, log the user's reply.

if ($command == 0 && $lastwascomm == 0 && $default == FALSE){

//We've already connected to the database
//Check to see if the current trigger/response is already in the 'pending replies' database.
$query = "SELECT * FROM ".CHATBOT_PENDING." WHERE `trigger` = '$lastcatbot' AND `reply` = '$usermessage';";
$result = $GLOBALS['DATABASE']->query($query);
$alreadythere = $GLOBALS['DATABASE']->fetch_array($result);
if ($alreadythere == FALSE){
//If it's a new reply, add it into the pending database.
$query = "INSERT INTO ".CHATBOT_PENDING." ( `trigger` , `reply` , `rnumber` ) VALUES ('$lastcatbot', '$usermessage', '1');";
$GLOBALS['DATABASE']->query($query);

} else {
//Otherwise, increment the rnumber by 1
$query = "UPDATE ".CHATBOT_PENDING." SET rnumber=rnumber+1 WHERE `trigger` = '$lastcatbot';";
$result = $GLOBALS['DATABASE']->query($query);

//See if there are any replies that have been used at least 3 times.
//If they have, move them from the Pending database to the regular database.
//Replies learned this way have a usercontrib value of '3'
$query = "SELECT * FROM ".CHATBOT_PENDING." WHERE `rnumber` > 2;";
$result = $GLOBALS['DATABASE']->query($query);
$overtwo = $GLOBALS['DATABASE']->fetch_array($result);


if ($overtwo == FALSE){
} else {
$transfertrigger = $overtwo['trigger'];
$transferreply = $overtwo['reply'];
$rid = $overtwo['rid'];
$query = "INSERT INTO ".CHATBOT_REPLIES." ( `trigger`, `reply`, `usercontrib` ) VALUES ('$transfertrigger', '$transferreply', '3');";
$GLOBALS['DATABASE']->query($query);

$query = "DELETE FROM ".CHATBOT_PENDING." WHERE `rid` = '$rid';";
$GLOBALS['DATABASE']->query($query);
}

}

}

/* ---- Logging ----- */

//Check if it isn't the default message. If it is, start logging.
if($logging == FALSE || $default == TRUE || $command == TRUE){
}else{
//Get the Date/Time for the timestamp
$timestamp = date('M j, Y g:i.s a');
//Get the user's IP
$userip = $_SERVER["REMOTE_ADDR"];
//Define the log filename and the log entry.
$logentry = $timestamp . " --- " . $userip . " --- " . $msg . " --- " . $catbotreply . "\r\n";
//Open the log file
$handle = fopen($logfile, 'ab');
//Write the log entry
fwrite($handle, $logentry);
fclose($handle);
} 


    $this->insertChatBotMessage($this->getPrivateMessageID(), $catbotreply."\n");
// KEYWORD TRIGGER END

?>