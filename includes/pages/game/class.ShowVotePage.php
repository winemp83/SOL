<?php
class ShowVotePage extends AbstractPage 
{
	public static $requireModule = MODULE_SUPPORT;
	
	protected $user = array();	
	protected $votes = array();
	protected $vote_question = '';
	protected $vote_id = 0;
	protected $vote_one = 0;
	protected $vote_two = 0;
	protected $vote_tree = 0;
	protected $vote_ig = 0;
	
	function __construct() 
	{
		parent::__construct();
		
	}
		
	function show()
	{
		$this->menue();
	}
	
	protected function menue(){
		$menue = HTTP::_GP('menue', '');
		if(!empty($_POST['id'])){
			$id = $_POST['id'];
		}
		else{
			$id = 0;
		}
		
		switch ($menue){
			case 1 : $this->insertVote($id);
					break;
			default : $this->showVoteSite();
					break;
		}
	}
	
	protected function error($id){
		global $LNG;
		switch ($id){
			case 1 : $msg = $LNG['winemp_Vote_error_1']; //nix angegeben
					break;
			case 2 : $msg = $LNG['winemp_Vote_error_2']; 
					break; 
			case 3 : $msg = $LNG['winemp_Vote_error_3']; 
					break;
			case 4 : $msg = $LNG['winemp_Vote_error_4']; 
					break;
			case 5 : $msg = $LNG['winemp_Vote_error_5']; 
					break;
			case 6 : $msg = $LNG['winemp_Vote_error_6']; 
					break;
			default: $msg = $LNG['winemp_Vote_error_0']; // Du hast bereits gevotet
					break;
		}
		$this->tplObj->assign_vars(array(
            'msg'	=> $msg,	
		));
		
		$this->display('Vote_error.tpl');
	}
	
	protected function checkVote(){
		global $USER;
		if($USER['has_vote'] != 0){
			return false;
		}
		else{
			return true;
		}
	}
	
	protected function insertVote($id){
		global $USER;
		if($this->checkVote()){
			$sql  = $GLOBALS['DATABASE']->query("SELECT (votes_ig) FROM ".VOTES." WHERE id='".$id."'");
			foreach ($sql as $data){
				$number = $data['votes_ig']+1;
			}
			if($_POST['select'] == 1){
				$value = 'one';
			}
			elseif($_POST['select'] == 2){
				$value = 'two';
			}
			elseif($_POST['select'] == 3){
				$value = 'tree';
			}
			else{
				$this->error(1);
			}
			$USER['has_vote'] = 1;
			 $GLOBALS['DATABASE']->query("UPDATE ".USERS." SET has_vote='1' WHERE id='".$USER['id']."'");
			 $GLOBALS['DATABASE']->query("UPDATE ".VOTES." SET ".$value."=".$value."+1, votes_ig= votes_ig+1 WHERE id='".$id."'");
			 $this->showVoteSite();
		}
		else{
			$this->error(10);
		}
	}
	
	protected function showVoteSite(){
		
		$sql = $GLOBALS['DATABASE']->query("SELECT * FROM ".VOTES." WHERE close='0'");
		if(!empty($sql)){
			while($votesResult = $GLOBALS['DATABASE']->fetch_array($sql)){
					$this->vote_question 	= $votesResult['question'];
					$this->vote_id 			= $votesResult['id'];
					$this->vote_ig 			= $votesResult['votes_ig'];
					$this->vote_one			= $votesResult['one'];
					$this->vote_two			= $votesResult['two'];
					$this->vote_tree		= $votesResult['tree'];
					$this->votes[] = array(
				 	'option_one' 	=> $votesResult['ans_one'],
				 	'option_two' 	=> $votesResult['ans_two'],
				 	'option_tree' 	=> $votesResult['ans_tree'],
				 	'desc_one' 		=> $votesResult['desc_one'],
				 	'desc_two' 		=> $votesResult['desc_two'],
				 	'desc_tree' 	=> $votesResult['desc_tree'], 
					);
			} 
		}
		if($this->vote_ig == 0){
			$this->vote_ig = 1;
		}
		if($this->vote_ig != 0 ){
			$help = $this->vote_ig / 100;	
		}
		else{
			$help = 0;
		}
		if($this->vote_one != 0){
			$help_a = floor($this->vote_one / $help);
		}
		else{
			$help_a = 0;
		}
		if($this->vote_two != 0){
			$help_b = floor($this->vote_two / $help);
		}
		else{
			$help_b = 0;
		}
		if($this->vote_tree != 0){
			$help_c = floor($this->vote_tree / $help);
		}
		else{
			$help_c = 0;
		}
		$this->tplObj->assign_vars(array(
			'vote'			=> $this->votes,
			'vote_name'		=> $this->vote_question,
			'usable'		=> $this->checkVote(),
			'one'			=> $help_a,
			'two'			=> $help_b,
			'tree'			=> $help_c,
			'ig'			=> $this->vote_ig,
			'id'			=> $this->vote_id,
		));
		
		$this->display('Vote_show.tpl');
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
}