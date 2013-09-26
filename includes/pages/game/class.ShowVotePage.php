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
		switch ($menue){
			case 1 : 
					break;
			default: showVoteSite();
					break;
		} 
	}
	
	protected function error($id){
		global $LNG;
		switch ($id){
			case 1 : $msg = $LNG['winemp_Vote_error_1']; 
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
	
	protected function checkVote($vote_id){
		global $USER;
		$sql = $GLOBALS['DATABASE']->query("SELECT (votes) FROM ".VOTES." WHERE id='".$vote_id."'");
		while($result =$GLOBALS['DATABASE']->fetch_array($sql)){
			$this->user = unserialize($result['votes']);
		}
		$help = array_search($USER['id'], $this->user);
		if((!empty($help) || isset($help)) && $help != false ){
			return false;
		}
		else{
			return true;
		}
	}
	
	protected function showVoteSite(){
		$sql = $GLOBALS['DATABASE']->query("SELECT * FROM ".VOTES." ORDER BY DESC id LIMIT 1");
		while($votesResult = $GLOBALS['DATABASE']->fetch_array()){
				$this->vote_question = $votesResult['question'];
				$this->vote_id = $votesResult['id'];
				$this->vote_ig =  $votesResult['votes_ig'];
				$this->vote_one		= $votesResult['vote_one'];
				$this->vote_two		= $votesResult['vote_two'];
				$this->vote_tree	= $votesResult['vote_tree'];
				$this->votes[] = array(
				 'option_one' 	=> $voteResult['one'],
				 'option_two' 	=> $voteResult['two'],
				 'option_tree' 	=> $voteResult['tree'],
				 'desc_one' 	=> $voteResult['desc_one'],
				 'desc_two' 	=> $voteResult['desc_two'],
				 'desc_tree' 	=> $voteResult['desc_tree'], 
				); 
		}
		$help = $this->vote_ig / 100;
		$help_a = $this->vote_one / $help;
		$help_b = $this->vote_two / $help;
		$help_c = $this->vote_tree / $help;
		
		$this->tplObj->assign_vars(array(
			'vote'			=> $this->votes,
			'vote_name'		=> $vote_question,
			'usable'		=> $this->checkVote($this->vote_id),
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