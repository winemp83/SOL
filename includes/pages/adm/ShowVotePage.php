<?php
if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");
function ShowVotePage(){
	global $LNG, $USER, $LANG, $db;
	
	$menue = HTTP::_GP('menue', 0);
	
	$votes = array();
	
	$template 	= new template();
	
	switch (HTTP::_GP('menue', 0)){
		case 1 :
				createVote();
				break;
		case 2 : $GLOBALS['DATABASE']->query("UPDATE ".VOTES." SET close='1'");
		default:
				$sql = $GLOBALS['DATABASE']->query("SELECT * FROM ".VOTES);
					if(!empty($sql)){
						while($votesResult = $GLOBALS['DATABASE']->fetch_array($sql)){
							if($votesResult['votes_ig'] != 0 ){
								$help = $votesResult['votes_ig'] / 100;	
							}
							else{
								$help = 0;
							}
							if($votesResult['one'] != 0){
								$help_a = ceil($votesResult['one'] / $help);
							}
							else{
								$help_a = 0;
							}
							if($votesResult['two'] != 0){
								$help_b = ceil($votesResult['two'] / $help);
							}
							else{
								$help_b = 0;
							}
							if($votesResult['tree'] != 0){
								$help_c = ceil($votesResult['tree'] / $help);
							}
							else{
								$help_c = 0;
							}
							$votes[] = array(
				 				'option_one' 	=> $votesResult['ans_one'],
				 				'option_two' 	=> $votesResult['ans_two'],
				 				'option_tree' 	=> $votesResult['ans_tree'],
				 				'desc_one' 		=> $votesResult['desc_one'],
				 				'desc_two' 		=> $votesResult['desc_two'],
				 				'desc_tree' 	=> $votesResult['desc_tree'],
				 				'one'			=> $help_a,
								'two'			=> $help_b,
								'tree'			=> $help_c,
								'ig'			=> $help * 100,
								'id'			=> $votesResult['id'],
								'question'		=> $votesResult['question'],
								'close'			=> $votesResult['close'],
							);
						} 
					}
					$template->assign_vars(array(
						'list'		=> $votes,
					));
				$template->show('VoteList.tpl');
				break;
	}
}

function createVote(){
	$template 	= new template();
	if($_POST['step'] == 1){
		$step = 1;
		$msg = '';
		$error = false;
	}
	else{
		$step = 2;
		if(empty($_POST['question']) || !isset($_POST['question'])){
			$error = true;
			$msg = "Sie müssen eine Frage eingeben";
		}
		elseif(empty($_POST['ans1']) || !isset($_POST['ans1']) || empty($_POST['ans2']) || !isset($_POST['ans2']) || empty($_POST['ans3']) || !isset($_POST['ans3'])){
			$error = true;
			$msg = "Sie müssen für jede Auswahl eine Antwort eingeben";
		}
		elseif(empty($_POST['des1']) || !isset($_POST['des1']) || empty($_POST['des2']) || !isset($_POST['des2']) || empty($_POST['des3']) || !isset($_POST['des3'])){
			$error = true;
			$msg = "Sie müssen für jede Antwort eine Beschreibung eingeben";
		}
		else{
			$vote_deakt = "UPDATE ".VOTES." SET close='1'";
			$player_vote = "UPDATE ".USERS." SET has_vote='0'";
			$insert_vote = ("INSERT INTO ".VOTES." SET 
				question='".$_POST['question']."',
				ans_one='".$_POST['ans1']."',
				ans_two='".$_POST['ans2']."',
				ans_tree='".$_POST['ans3']."',
				desc_one='".$_POST['des1']."',
				desc_two='".$_POST['des2']."',
				desc_tree='".$_POST['des3']."'
				");
			$GLOBALS['DATABASE']->query($vote_deakt);
			$GLOBALS['DATABASE']->query($player_vote);
			$GLOBALS['DATABASE']->query($insert_vote);
		}	
	}
	$template->assign_vars(array(
		'step'		=> $step,
		'msg'		=> $msg,
		'error'		=> $error,
		));
	$template->show('VoteCreate.tpl');	
}

function sabsi ($array, $index, $order='asc', $natsort=FALSE, $case_sensitive=FALSE) {
  	if(is_array($array) && count($array)>0) {
    	foreach(array_keys($array) as $key) $temp[$key]=$array[$key][$index];
    	if(!$natsort) ($order=='asc')? asort($temp) : arsort($temp);
    	else {
      	($case_sensitive)? natsort($temp) : natcasesort($temp);
      		if($order!='asc') $temp=array_reverse($temp,TRUE);
    	}
    	foreach(array_keys($temp) as $key) (is_numeric($key))? $sorted[]=$array[$key] : $sorted[$key]=$array[$key];
    		return $sorted;
  		}
  	return $array;
}
	
?>