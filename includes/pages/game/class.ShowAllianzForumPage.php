<?php
class ShowAllianzForumPage extends AbstractPage 
{
	public static $requireModule = MODULE_SUPPORT;
	
	private $topicList = array();
	private $topic = array();

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
		if(empty(HTTP::_GP('step',''))){
			$step = 1;
		}
		else{
			$step = HTTP::_GP('step','');
		}
		switch ($step){
			case 1 :
					$this->display('AllyForum_createTopic.tpl');
					break;
			case 2 :
					if(strlen($_POST['topicName']) >= 3 && strlen($_POST['text']) >= 10){
						$topicName = $_POST['topicName'];
						$user = $USER['username'];
						$text = $_POST['text'];
						$alli = $USER['ally_id'];
						$GLOBALS['DATABASE']->multi_query("INSERT INTO ".ALLYTOPIC." SET
							topic_name				= '".$GLOBALS['DATABASE']->sql_escape($topicName)."',
							ally_id					= '".$alli."',
							author					= '".$user."',
							createtime				= '".time()."',
							close					= '0' ;
							SET @topicID = LAST_INSERT_ID();
							INSERT INTO ".TOPICANSWER." SET 
							topic_id 				= @topicID,
							createtime				= '".time()."',
							author					= '".$user."',
							ally					= '".$alli."',
							text					= '".$GLOBALS['DATABASE']->sql_escape($text)."';"
						);
						$sql = "SELECT * FROM ".ALLYTOPIC." WHERE ally_id='".$alli."' AND author='".$user."'";
						$result = $GLOBALS['DATABASE']->query($sql);
						$help = 0;
						foreach($result as $data){
							$a = $data['id'];
							if($help < $a){
								$help = $a;
							}
						}
						$this->showTopic($help);
					}
					else{
						if(strlen($_POST['topicName']) <3){
							$this->error(2);
						}
						elseif(strlen($_POST['text']) < 10){
							$this->error(3);
						}
					}
					break;
			default:
					$this->display('AllyForum_createTopic.tpl');
					break;
		}
	}
	
	protected function answerTopic($id){
		global $USER;
		$sql = $GLOBALS['DATABASE']->query("SELECT * FROM ".TOPICANSWER." WHERE topic_id='".$id."'");
		$topic_name = $GLOBALS['DATABASE']->query("SELECT (topic_name) FROM ".ALLYTOPIC." WHERE id='".$id."'");
		$topic_close =	$GLOBALS['DATABASE']->query("SELECT (close) FROM ".ALLYTOPIC." WHERE id='".$id."'");						
		foreach($topic_name as $data){
			$topic_name = $data['topic_name'];
		}
		foreach($topic_close as $data){
			$topic_close = $data['close'];
		}
		while ($topicListRow = $GLOBALS['DATABASE']->fetch_array($sql))
		{
			$this->topic[] = array(
				'time'		=> date("d.m.Y H:i:s", $topicListRow['createtime']),
				'user'		=> $topicListRow['author'],
				'text'		=> $topicListRow['text'],
				'id'		=> $topicListRow['id'],
			);
		}
		
		$this->tplObj->assign_vars(array(
			'topic'			=> $this->sabsi($this->topic, 'id'),
			'topic_name'	=> $topic_name,
			'topic_close'	=> $topic_close,
			'topic_id'		=> $id,
		));
		
		if (HTTP::_GP('do_it', '') != 'yes'){
			$this->display('AllyForum_answer.tpl');
		}
		elseif ($id == 0){
			$this->display('AllyForum_answer.tpl');
		}
		else{
			$text = $_POST['text'];
			$user = $USER['username'];
			$time = time();
			$ally = $USER['ally_id'];
			
			if (strlen($text) < 5){
				$this->error(4);
			}
			else{
				$result = $GLOBALS['DATABASE']->query("SELECT `close` FROM ".ALLYTOPIC." WHERE id='".$id."'");
				foreach($result as $data){
					$result = $data['close'];
				}
				if($result != 1 ){
					$GLOBALS['DATABASE']->query("INSERT INTO ".TOPICANSWER." SET topic_id='".$id."', createtime='".$time."', author='".$user."', ally='".$ally."', text='".$GLOBALS['DATABASE']->sql_escape($text)."'");
					$this->showForum();
				}
				else{
					$this->error(6);
				}
			}
		}
	}
	
	protected function delAnswer($id){
		
	}
	
	protected function reopenTopic($id){
		if($id == 0){
			$this->error(5);
		}
		else{
			$GLOBALS['DATABASE']->query("UPDATE ".ALLYTOPIC." SET close='0' WHERE id='".$id."'");
			$this->showForum();
		}
	}
	
	protected function editAnswer($topic_id, $tread_id){
		global $USER;
		$tread = $GLOBALS['DATABASE']->query("SELECT * FROM ".TOPICANSWER." WHERE topic_id='".$topic_id."' AND id='".$tread_id."'");
		$topic_name = $GLOBALS['DATABASE']->query("SELECT (topic_name) FROM ".ALLYTOPIC." WHERE id='".$topic_id."'");
		$topic_close =	$GLOBALS['DATABASE']->query("SELECT (close) FROM ".ALLYTOPIC." WHERE id='".$topic_id."'");						
		foreach($topic_name as $data){
			$topic_name = $data['topic_name'];
		}
		foreach($topic_close as $data){
			$topic_close = $data['close'];
		}
		foreach($tread as $data)
		{
			$tread_text = $data['text'];
			$tread_id	= $data['id'];
			$tread_user	= $data['author'];
		}
		
		$this->tplObj->assign_vars(array(
			'tread_text'	=> $tread_text,
			'tread_id'		=> $tread_id,
			'user'			=> $tread_user,
			'topic_name'	=> $topic_name,
			'topic_close'	=> $topic_close,
			'topic_id'		=> $topic_id,
		));
		
		if (HTTP::_GP('do_it', '') != 'yes'){
			$this->display('AllyForum_editAnswer.tpl');
		}
		elseif ($tread_id == 0 || $topic_id == 0){
			$this->display('AllyForum.tpl');
		}
		else{
			$text = $_POST['text'];
			$user = $USER['username'];
			$time = time();
			$ally = $USER['ally_id'];
			
			if (strlen($text) < 5){
				$this->error(4);
			}
			else{
				$result = $GLOBALS['DATABASE']->query("SELECT `close` FROM ".ALLYTOPIC." WHERE id='".$topic_id."'");
				foreach($result as $data){
					$result = $data['close'];
				}
				if($result != 1 ){
					$GLOBALS['DATABASE']->query("UPDATE ".TOPICANSWER." SET createtime='".$time."', author='".$user."',  text='".$GLOBALS['DATABASE']->sql_escape($text)."' WHERE topic_id='".$topic_id."' AND id='".$tread_id."'");
					$this->showTopic($topic_id);
				}
				else{
					$this->error(6);
				}
			}
		}
	}
	
	protected function delTopic($id){
		if($id == 0){
			$this->error(5);
		}
		else{
			$GLOBALS['DATABASE']->query("DELETE FROM ".ALLYTOPIC." WHERE id='".$id."'");
			$GLOBALS['DATABASE']->query("DELETE FROM ".TOPICANSWER." WHERE topic_id='".$id."'");
			$this->showForum();
		}
	}

	protected function closeTopic($id){
		if($id == 0){
			$this->error(5);
		}
		else{
			$GLOBALS['DATABASE']->query("UPDATE ".ALLYTOPIC." SET close='1' WHERE id='".$id."'");
			$this->showForum();
		}
	}
	
	protected function showForum(){
		global $USER, $ALLY;
		$sql = $GLOBALS['DATABASE']->query("SELECT * FROM ".ALLYTOPIC." WHERE ally_id='".$USER['ally_id']."'");
		
		while ($topicListRow = $GLOBALS['DATABASE']->fetch_array($sql))
		{
			$dateRow = $GLOBALS['DATABASE']->query("SELECT `createtime` FROM ".TOPICANSWER." WHERE topic_id='".$topicListRow['id']."'");
			$help = 0;
			foreach($dateRow as $data){
				if ($data > $help){
					$help = $data;
				}
			}
			$this->topicList[]	= array(
				'time'			=> date("d.m.Y H:i:s", $topicListRow['createtime']),
				'topic_name'	=> htmlspecialchars($topicListRow['topic_name']),
				'author'		=> htmlspecialchars($topicListRow['author']),
				'id'			=> $topicListRow['id'],
				'close'			=> $topicListRow['close'],
				'lastinsert'	=> date("d.m.Y H:i:s", $help['createtime']),
			);
			
		}
		if(!empty($this->topicList)){
			$this->tplObj->assign_vars(array(
           		'topics'	=> $this->sabsi($this->topicList, 'id'),
           		'adm'		=> $this->checkadm(),	
			));
		}
		else{
			$this->tplObj->assign_vars(array(
           		'topics'	=> $this->topicList,
           		'adm'		=> $this->checkadm(),
			));
		}
		$this->display('AllyForum.tpl');		
	}
	
	protected function showTopic($id){
		global $USER;
		$sql = $GLOBALS['DATABASE']->query("SELECT * FROM ".TOPICANSWER." WHERE topic_id='".$id."'");
		$topic_name = $GLOBALS['DATABASE']->query("SELECT (topic_name) FROM ".ALLYTOPIC." WHERE id='".$id."'");
		$topic_close =	$GLOBALS['DATABASE']->query("SELECT (close) FROM ".ALLYTOPIC." WHERE id='".$id."'");						
		foreach($topic_name as $data){
			$topic_name = $data['topic_name'];
		}
		foreach($topic_close as $data){
			$topic_close = $data['close'];
		}
		while ($topicListRow = $GLOBALS['DATABASE']->fetch_array($sql))
		{
			if($topicListRow['author'] == $USER['username']){
				$help = true;
			}
			else{
				$help = false;
			}
			
			$this->topic[] = array(
				'time'		=> date("d.m.Y H:i:s", $topicListRow['createtime']),
				'user'		=> $topicListRow['author'],
				'text'		=> nl2br(htmlspecialchars($topicListRow['text'])),
				'id'		=> $topicListRow['topic_id'],
				'entry_id'	=> $topicListRow['id'],
				'usertest'  => $help,
			);
		}
		
		$this->tplObj->assign_vars(array(
			'topic'			=> $this->sabsi($this->topic, 'id'),
			'topic_name'	=> htmlspecialchars($topic_name),
			'topic_close'	=> $topic_close,
			'topic_id'		=> $id,
			'adm'			=> $this->checkadm(),
		));
		
		$this->display('AllyForum_topic.tpl');
	}

	protected function admForum(){
		global $USER;
		if($this->checkadm()){
			if(!empty($_POST['what'])){
				switch ($_POST['what']){
					case 1 : $this->delTopic($_POST['id']);
							 break;
					case 2 : $this->closeTopic($_POST['id']);
							 break;
					case 3 : $this->reopenTopic($_POST['id']);
							 break;
					case 4 : $this->delAnswer($_POST['id']);
							 break;
					default: $this->showForum();
							 break;
				}
			}
			else{
				$this->showForum();
			}
		}
		else{	
			$this->showForum();	
		}
	}
	
	protected function checkadm(){
		global $USER;
		$ally_id = $USER['ally_id'];
		
		$sql = "SELECT (ally_owner) FROM ".ALLIANCE." WHERE id='".$ally_id."'";
		$result = $GLOBALS['DATABASE']->query($sql);
		foreach($result as $data){
			$owner = $data['ally_owner'];
		}
		if($owner != $USER['id']){
			return false;
		}
		else{
			return true;
		}
	}
	
	protected function menue(){
		global $USER;
		$menue = HTTP::_GP('menue', '');
		$id = HTTP::_GP('id', '');
		if($USER['ally_id'] == 0){
			$menue = 10;	
		}
		switch ($menue){
			case 1 : $this->showTopic($_POST['id']);
					break;
			case 2 : $this->createTopic();
					break;
			case 3 : $this->answerTopic($_POST['id']);
					break;
			case 4 : $this->editAnswer($_POST['topic_id'], $_POST['tread_id']);
					break;
			case 5 : $this->admForum();
					break;
			case 10:
					 $this->error(1);
					break;
			default: $this->showForum();
					break; 
		}
	}
	
	protected function error($id){
		global $LNG;
		switch ($id){
			case 1 : $msg = $LNG['winemp_Forum_error_1']; // in keiner Allianz
					break;
			case 2 : $msg = $LNG['winemp_Forum_error_2']; // topic muss mehr als 3 zeichen haben
					break; 
			case 3 : $msg = $LNG['winemp_Forum_error_3']; // eintrag muss mehr als 10 zeichen haben
					break;
			case 4 : $msg = $LNG['winemp_Forum_error_4']; // Antworten müssen mehr als 5 Zeichen haben
					break;
			case 5 : $msg = $LNG['winemp_Forum_error_5']; // Topic nicht bekannt
					break;
			case 6 : $msg = $LNG['winemp_Forum_error_6']; // Topic gespeert
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
	