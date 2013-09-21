<?php
class ShowAlliBankPage extends AbstractPage 
{
	public static $requireModule = MODULE_SUPPORT;
	
	private $topicList = array();

	function __construct() 
	{
		parent::__construct();
		
	}
		
	function show()
	{
		$this->menue();
	}

	protected function createTopic(){
		global $USER;
		if(empty(HTTP::_GP('step'))){
			$step = 1;
		}
		else{
			$step = HTTP::_GP('step');
		}
		switch ($step){
			case 1 :
					break;
			case 2 :
					$topicName = HTTP::_GP('topicName', '');
					$user = $USER['name'];
					$text = HTTP::_GP('text', '');
					$alli = $USER['ally_id'];
					$GLOBALS['DATABASE']->multi_query("INSERT INTO ".ALLYTOPIC." SET
						topic_name				= '".$GLOBALS['DATABASE']->sql_escape($topicName)."',
						ally_id					= '".$alli."',
						author					= '".$user."',
						createtime				= '".time()."';
						SET @topicID = LAST_INSERT_ID();
						INSERT INTO ".TopicAnswer." SET 
						topic_id 				= @topicID,
						createtime				= '".time()."',
						author					= '".$user."',
						text					= '".$GLOBALS['DATABASE']->sql_escape($text)."';");
					break;
			default:
					break;
		}
	}
	
	protected function answerTopic(){
		
	}
	
	protected function delTopic(){
		
	}
	
	protected function showForum(){
		global $USER;
		$sql = "SELECT * FROM ".ALLYTOPIC." WHERE ally_id='".$USER['ally_id']."'";
		
		while ($topicListRow = $GLOBALS['DATABASE']->fetch_array($sql))
		{
			$this->topicList[]	= array(
				'time'			=> date("D.M.Y H:I:S", $topicListRow['createtime']),
				'topic_name'	=> $topicListRow['topicname'],
				'author'		=> $topicListRow['author'],
				'id'			=> $topicListRow['id'],
			);
		}
		$this->tplObj->assign_vars(array(
            'topics'	=> $this->sabsi($this->topicList, 'id'),	
		));

		$this->display('AllyForum_error.tpl');
		
	}
	
	protected function showTopic(){
		
	}
	
	protected function menue(){
		if($USER['ally_id'] == 0){
			$menue = 10;	
		}
		else{	
			if(!empty(HTTP::_GP('menue'))){
				$menue = 0;
			}
			else{
				$menue = HTTP::_GP('menue');
			}
		}
		switch ($menue){
			case 1 : $this->showTopic();
					break;
			case 2 : $this->createTopic();
					break;
			case 3 : $this->answerTopic();
					break;
			case 4 : $this->delTopic();
					break;
			case 10:
					 $this->error(1);
					break;
			default: $this->showForum();
					break; 
		}
	}
	
	protected function error($id){
		switch ($id){
			case 1 : $msg = $LNG['winemp_Forum_error_1'];
					break;
			default: $msg = $LNG['winemp_Forum_error_0'];
					break;
		}
		$this->tplObj->assign_vars(array(
            'msg'	=> $msg,	
		));

		$this->display('AllyForum_error.tpl');
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
	