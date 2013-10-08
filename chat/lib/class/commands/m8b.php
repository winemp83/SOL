<?php
//Seperate the question from the command
$question = mb_strtolower(substr($msg, 4));
//Check for no question and for questions that aren't yes/no.
if($question == "" || isset($msgarray[1]) == FALSE) {
$catbotreply = "You didn't ask a question.<br>Format:<br>!m8b <i>Question</i><br><br>Example:<br>!m8b Will I eat pie today?";
} elseif ($msgarray[1] == "do" || $msgarray[1] == "are" || $msgarray[1] == "is" || $msgarray[1] == "does" || $msgarray[1] == "did" || $msgarray[1] == "will" || $msgarray[1] == "am") {
//Make an array of possible answers.
$answers = array("Yes.", "Definitely.", "Without a doubt.", "It's possible.", "Very possible.", "It's probable.", "Very probable.", "Maybe.", "Try again.", "Not very probably.", "Not probabable.", "I doubt it.", "Very unlikely.", "Probably not.", "No.");
$magic8random = rand(0,14);
$catbotreply = $answers[$magic8random];

} else {
$catbotreply = "That isn't a yes or no question.";
}
?>