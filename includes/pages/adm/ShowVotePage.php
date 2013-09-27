<?php
if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");
function ShowVotePage(){
	global $LNG, $USER, $LANG, $db;
	
	$menue = HTTP::_GP('menue', 0);
	
	$votes = array();
	
	$template 	= new template();
	
	switch ($menue){
		case 1 :
				$do_it = HTTP::_GP('do_it', 0);
				if($do_it != 1){
						$step		= 1;
						$error		= false;
						$msg		= '';
				}
				else{
					if(empty($_POST['question']) || !isset($_POST['question'])){
						$msg = 'Bitte eine Frage stellen!';
						$error = true;
					}
					elseif(empty($_POST['des_one']) || !isset($_POST['des_one'])){
						$msg = 'Bitte eine Beschreibung für die erste Antwort einfügen!';
						$error = true;
					}
					elseif(empty($_POST['des_two']) || !isset($_POST['des_two'])){
						$msg = 'Bitte eine Beschreibung für die zweite Antwort einfügen!';
						$error = true;
					}
					elseif(empty($_POST['des_tree']) || !isset($_POST['des_tree'])){
						$msg = 'Bitte eine Beschreibung für die dritte Antwort einfügen!';
						$error = true;
					}
					elseif(empty($_POST['ans_one']) || !isset($_POST['ans_one'])){
						$msg = 'Bitte die erste Antwort einfügen!';
						$error = true;
					}
					elseif(empty($_POST['ans_two']) || !isset($_POST['ans_two'])){
						$msg = 'Bitte die zweite Antwort einfügen!';
						$error = true;
					}
					elseif(empty($_POST['ans_tree']) || !isset($_POST['ans_tree'])){
						$msg = 'Bitte die dritte Antwort einfügen!';
						$error = true;
					}
					else{
						$msg = 'Vote erstellt';
						$error = false;
						$step = '2';
						$GLOBALS['DATABASE']->query("UPDATE ".VOTES." SET close='1'");
						$GLOBALS['DATABASE']->query("INSERT INTO ".VOTES." SET ans_one='".$GLOBALS['DATABASE']->sql_escape($_POST['ans_one'])."', ans_two='".$GLOBALS['DATABASE']->sql_escape($_POST['ans_two'])."', ans_tree='".$GLOBALS['DATABASE']->sql_escape($_POST['ans_tree'])."', desc_one='".$GLOBALS['DATABASE']->sql_escape($_POST['des_one'])."', desc_two='".$GLOBALS['DATABASE']->sql_escape($_POST['des_two'])."', desc_tree='".$GLOBALS['DATABASE']->sql_escape($_POST['des_tree'])."', question='".$GLOBALS['DATABASE']->sql_escape($_POST['question'])."'");
						$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET has_vote='0'");	
					}
					
					$template->assign_vars(array(
						'error'		=> $error,
						'msg'		=> $msg,
						'step'		=> $step,
					));
					$template->show('VoteCreate.tpl');
				}
				break;
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