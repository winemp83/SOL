<?php

class ShowForumAllPage extends AbstractPage{
	
	protected $kat 		= array();
	protected $top 		= array();
	protected $ans 		= array();
	protected $toplast 	= array();
	protected $logs		= array();
	protected $msg		= '';
	
	function __construct() 
	{
		parent::__construct();
		
	}
	
	function show(){
		$this->menue();
	}
	//done
	protected function menue(){
		if(isset($_POST['meneu']) || !empty($_POST['menue'])){
			$menue = $_POST['menue'];
		}
		else{
			$menue = 0;
		}
		if(isset($_POST['log']) || !empty($_POST['log'])){
			$log = $_POST['log'];
		}
		else{
			$log = 0;
		}
		
		switch ($menue){
			// DONE
			case 1 :
					$this->getTopic($_POST['kat_id']);
					$this->showPage(1);
					break;
			// DONE
			case 2 :
					$this->getAnswer($_POST['topic_id']);
					$this->showPage(2);
					break;
			// DONE
			case 3 :
					$this->createTopic($_POST['kat_id']) ;
					break;
			// DONE
			case 4 : 
				if (!isset($_POST['team']) || empty($_POST['team'])){	
					$this->createAnswer($_POST['topic_id']);
				}
				else{
					$this->createAdminAnswer($_POST['topic_id']);
					$this->logAction('admin answer');
				}
					break;
			// DONE
			case 5 :
					if($this->getUserMod()){
						if($this->checkclose($_POST['topic_id'])){
							$this->logAction('dell topic');
							$this->dellTopic($_POST['topic_id']);
							$_POST['menue'] = 0;
							$this->menue();
						}
						else{
							$this->get_Error(7);
						}
					}
					else{
						$this->logAction('unberechtigter Zugriff');
						$this->get_Error(1);
					}
					break;
			// DONE 
			case 6 :
					$this->logAction('dell answer');
					$this->dellAnswer($_POST['ans_id']);
					$_POST['menue'] = 0;
					$this->menue();
					break;
			// DONE
			case 7 :
				if($this->getUserMod()){
						$this->closeTopic($_POST['topic_id']);
						$this->logAction('topic close');
						$_POST['menue'] = 0;
						$this->menue();
						}
					else{
						$this->logAction('unberechtigter Zugriff');
						$this->get_Error(1);
					} 
					break;
			// DONE
			case 8 :
					$this->editAnswer($_POST['topic_id']);
					$this->logAction('answer_edit');
					break;
			// DONE
			case 9 :
					if($this->getUserMod()){
						$this->showLog($log);
						$this->showPage(3);
					}
					else{
						$this->logAction('unberechtigter Zugriff');
						$this->get_Error(1);
					}
					break;
			// DONE
			default:
					$this->getKat();
					$this->getLast();
					$this->showPage(0);
					break;
		}
	}

	//done
	protected function checkclose($topic_id){
		$result = $GLOBALS['DATABASE']->query("SELECT (close) FROM ".FORUM_TOP." WHERE id='".$topic_id."'");
		foreach($result as $DATA){
			if($DATA['close'] != 0){
				return true;
			}
			else{
				return false;
			}
		}
	}

	//done
	protected function getUserMod(){
		global $USER;
		if($USER['forum_adm'] == 0){
			return false;
		}
		else{
			return true;
		}
	}
	
	//done
	protected function closeTopic($topic_id){
		$GLOBALS['DATABASE']->query("UPDATE ".FORUM_TOP." SET close ='1' WHERE id='".$topic_id."'");
	}
	
	//done
	protected function showLog($nr){
		switch ($nr){
			case 1 :
					$result = $GLOBALS['DATABASE']->query("SELECT * FROM ".FORUM_LOG." WHERE action='unberechtigter Zugriff' ORDER BY id DESC");
					break;
			case 2 :
					$result = $GLOBALS['DATABASE']->query("SELECT * FROM ".FORUM_LOG." WHERE action='dell topic' ORDER BY id DESC");
					break;
			case 3 :
					$result = $GLOBALS['DATABASE']->query("SELECT * FROM ".FORUM_LOG." WHERE action='dell answer' ORDER BY id DESC");
					break;
			case 4 :
					$result = $GLOBALS['DATABASE']->query("SELECT * FROM ".FORUM_LOG." WHERE action='topic close' ORDER BY id DESC");
					break;
			case 5 :
					$result = $GLOBALS['DATABASE']->query("SELECT * FROM ".FORUM_LOG." WHERE action='admin answer' ORDER BY id DESC");
					break;
			default:
					$result = $GLOBALS['DATABASE']->query("SELECT * FROM ".FORUM_LOG." ORDER BY id DESC");
					break;
		}
		
		while ($logRow = $GLOBALS['DATABASE']->fetch_array($result)){
			$this->kat = array(
				'log_action' 	=> $logRow['action'],
				'log_name'		=> $logRow['player'],
				'log_create'	=> $logRow['create'],
				'log_id'		=> $logRow['id'], 
			);
		}
		$this->tplObj->assign_vars(array(
				'log'	=> $this->logs,
		));
	}
	
	//done
	protected function createAdminAnswer($topic_id){
	global $USER;
		global $USER;
		$step = $_POST['step'];
		$result = $GLOBALS['DATABASE']->query("SELECT * FROM ".FORUM_TOP." WHERE id='".$topic_id."'");
		foreach($result as $Data){
			$this->tplObj->assign_vars(array(
				'top_id'	=> $Data['id'],
				'top_name'	=> $Data['name'],
				'adm'		=> $this->getUserMod(),
			));
		}
		if($step == 1){
		$this->showPage(4);
		}
		elseif($step == 2){
			$result = $GLOBALS['DATABASE']->query("SELECT (close) FROM ".FORUM_TOP." WHERE id='".$topic_id."'");
			foreach($result as $Data){
				if($Data['close'] != 0){
					$help = true;	
				}
				else{
					$help = false;
				}
			}
			if ($help){
				$this->get_Error(6);
			}
			else{
				
				$text = $_POST['text'];
				if(strlen($text) > 5){
					$GLOBALS['DATABASE']->query("INSERT INTO ".FORUM_ANS." SET createtime='".time()."', edit='".time()."', user='".$USER['username']."', topic_id='".$topic_id."', text='".$GLOBALS['DATABASE']->sql_escape($text)."', adm='".$USER['forum_adm']."'");
					$GLOBALS['DATABASE']->query("UPDATE ".FORUM_TOP." SET lastchange='".time()."' WHERE id='".$topic_id."'");
					$_POST['menue'] = 0;
					$this->menue();
				}
				else{
					$this->get_Error(4);
				}
			}
		}
		else{
		$this->showPage(0);	
		}
	}
	
	//done
	protected function createTopic($kat_id){
	global $USER;
		if(empty(HTTP::_GP('step',''))){
			$step = 1;
		}
		else{
			$step = HTTP::_GP('step','');
		}
		switch ($step){
			case 1 :
					$this->tplObj->assign_vars(array(
						'kat'		=> $_POST['kat_id'],
						'kat_name' 	=> $_POST['kat_name'],
					));
					$this->showPage(5);
					break;
			case 2 :
					if(strlen($_POST['topicName']) >= 3 && strlen($_POST['text']) >= 10){
						$topicName = $_POST['topicName'];
						$user = $USER['username'];
						$text = $_POST['text'];
						$GLOBALS['DATABASE']->multi_query("INSERT INTO ".FORUM_TOP." SET
							name					= '".$GLOBALS['DATABASE']->sql_escape($topicName)."',
							kat_id					= '".$_POST['kat_id']."',
							user					= '".$user."',
							createtime				= '".time()."',
							lastchange				= '".time()."',
							close					= '0', 
							team					= '0';
							SET @topicID = LAST_INSERT_ID();
							INSERT INTO ".FORUM_ANS." SET 
							topic_id 				= @topicID,
							createtime				= '".time()."',
							edit					= '".time()."',
							user					= '".$user."',
							text					= '".$GLOBALS['DATABASE']->sql_escape($text)."',
							adm						= '0';"
						);
						$_POST['menue'] = 0;
						$this->menue();
					}
					else{
						if(strlen($_POST['topicName']) <3){
							$this->get_Error(2);
						}
						elseif(strlen($_POST['text']) < 10){
							$this->get_Error(3);
						}
					}
					break;
			default:
					$this->tplObj->assign_vars(array(
						'kat'	=> $_POST['kat_id'],
						'kat_name' 	=> $_POST['kat_name'],
					));
					$this->showPage(5);
					break;
		}
	}
	
	//done
	protected function createAnswer($topic_id){
		global $USER;
		$step = $_POST['step'];
		$result = $GLOBALS['DATABASE']->query("SELECT * FROM ".FORUM_TOP." WHERE id='".$topic_id."'");
		foreach($result as $Data){
			$this->tplObj->assign_vars(array(
				'top_id'	=> $Data['id'],
				'top_name'	=> $Data['name'],
				'adm'		=> $this->getUserMod(),
				'edit'		=> false,
			));
		}
		if($step == 1){
		$this->showPage(4);
		}
		elseif($step == 2){
			$result = $GLOBALS['DATABASE']->query("SELECT (close) FROM ".FORUM_TOP." WHERE id='".$topic_id."'");
			foreach($result as $Data){
				if($Data['close'] != 0){
					$help = true;	
				}
				else{
					$help = false;
				}
			}
			if ($help){
				$this->get_Error(6);
			}
			else{
				$text = $_POST['text'];
				if(strlen($text) > 5){
					$GLOBALS['DATABASE']->query("INSERT INTO ".FORUM_ANS." SET createtime='".time()."', edit='".time()."', user='".$USER['username']."', topic_id='".$topic_id."', text='".$GLOBALS['DATABASE']->sql_escape($text)."'");
					$GLOBALS['DATABASE']->query("UPDATE ".FORUM_TOP." SET lastchange='".time()."' WHERE id='".$topic_id."'");
					$_POST['menue'] = 0;
					$this->menue();
				}
				else{
					$this->get_Error(4);
				}
			}
		}
		else{
		$this->showPage(0);	
		}
	}

	protected function editAnswer($topic_id){
		global $USER;
		$step = $_POST['step'];
		$result = $GLOBALS['DATABASE']->query("SELECT * FROM ".FORUM_TOP." WHERE id='".$topic_id."'");
		foreach($result as $Data){
			$this->tplObj->assign_vars(array(
				'top_id'	=> $Data['id'],
				'top_name'	=> $Data['name'],
				'adm'		=> $this->getUserMod(),
				'edit'		=> true,
				'text'		=> htmlspecialchars($_POST['text']),
				'ans_id'	=> $_POST['ans_id'],
			));
		}
		if($step == 1){
		$this->showPage(4);
		}
		elseif($step == 2){
			$result = $GLOBALS['DATABASE']->query("SELECT (close) FROM ".FORUM_TOP." WHERE id='".$topic_id."'");
			foreach($result as $Data){
				if($Data['close'] != 0){
					$help = true;	
				}
				else{
					$help = false;
				}
			}
			if ($help){
				$this->get_Error(6);
			}
			else{
				$text = $_POST['text'];
				if(strlen($text) > 5){
					$GLOBALS['DATABASE']->query("UPDATE ".FORUM_ANS." SET createtime='".time()."', edit='".time()."', user='".$USER['username']."', topic_id='".$topic_id."', text='".$GLOBALS['DATABASE']->sql_escape($text)."' WHERE id='".$_POST['ans_id']."'");
					$GLOBALS['DATABASE']->query("UPDATE ".FORUM_TOP." SET lastchange='".time()."' WHERE id='".$topic_id."'");
					$_POST['menue'] = 0;
					$this->menue();
				}
				else{
					$this->get_Error(4);
				}
			}
		}
		else{
		$this->showPage(0);	
		}
	}
	
	//done
	protected function dellTopic($topic_id){
		$GLOBALS['DATABASE']->query("DELETE FROM ".FORUM_ANS." WHERE topic_id='".$topic_id."'");
		$GLOBALS['DATABASE']->query("DELETE FROM ".FORUM_TOP." WHERE id='".$topic_id."'");
	}
	
	//done
	protected function dellAnswer($answer_id){
		$GLOBALS['DATABASE']->query("DELETE FROM ".FORUM_ANS." WHERE id='".$answer_id."'");
	}
	
	//done
	protected function logAction($thing){
		global $USER;
		$GLOBALS['DATABASE']->query("INSERT INTO ".FORUM_LOG." SET createtime= '".time()."', player = '".$USER['username']."', what = '".$thing."';");
	}
	
	//done
	protected function getKat(){
		if($this->getUserMod()){
			$result = $GLOBALS['DATABASE']->query("SELECT * FROM ".FORUM_KAT."");
		}
		else{
			$result = $GLOBALS['DATABASE']->query("SELECT * FROM ".FORUM_KAT." WHERE team='0' ORDER BY position ASC");
		}
		while ($katRow = $GLOBALS['DATABASE']->fetch_array($result)){
			$Result = $GLOBALS['DATABASE']->query("SELECT COUNT(id) FROM ".FORUM_TOP." WHERE kat_id='".$katRow['id']."'");
			foreach($Result as $Data){
				$help = $Data['COUNT(id)'];
			}
			$this->kat[] = array(
				'kat_name' 			=> $katRow['name'],
				'kat_description'	=> htmlspecialchars($katRow['description']),
				'kat_id'			=> $katRow['id'],
				'kat_top_anzahl'	=> $help,
			);
		}
		$this->tplObj->assign_vars(array(
				'kat'	=> $this->kat,
		));
	}
	
	//done
	protected function getTopic($kat_id){
		if($this->getUserMod()){
			$result = $GLOBALS['DATABASE']->query("SELECT * FROM ".FORUM_TOP." WHERE kat_id='".$kat_id."'");
		}
		else{
			$result = $GLOBALS['DATABASE']->query("SELECT * FROM ".FORUM_TOP." WHERE kat_id='".$kat_id."' AND team='0' ");
		}
		while ($topRow = $GLOBALS['DATABASE']->fetch_array($result)){
			if($topRow['close'] != 0){
				$help = true;
			}
			else{
				$help = false;
			}
			$Result = $GLOBALS['DATABASE']->query("SELECT COUNT(id) FROM ".FORUM_ANS." WHERE topic_id='".$topRow['id']."'");
			foreach($Result as $Data){
				$help1 = $Data['COUNT(id)'];
			}
			$this->top[] = array(
				'top_name' 		=> htmlspecialchars($topRow['name']),
				'top_id'		=> $topRow['id'],
				'top_user'		=> $topRow['user'],
				'top_create'	=> date("d.m.Y H:i:s",$topRow['createtime']),
				'top_last'		=> date("d.m.Y H:i:s",$topRow['lastchange']),
				'top_kat_id'	=> $topRow['kat_id'],
				'top_close'		=> $help,
				'top_ans'		=> $help1,
			);
		}
		$Result = $GLOBALS['DATABASE']->query("SELECT (name) FROM ".FORUM_KAT." WHERE id='".$_POST['kat_id']."'");
		foreach ($Result as $Data){
			$kat_name = $Data['name'];
		}
		
		$this->tplObj->assign_vars(array(
				'top'		=> $this->sabsi($this->top, 'top_last'),
				'kat'		=> $_POST['kat_id'],
				'kat_name'	=> $kat_name,
				'adm'		=> $this->getUserMod(),
		));
	}
	
	//done
	protected function getAnswer($topic_id){
		global $USER;
		if($this->getUserMod()){
			$result = $GLOBALS['DATABASE']->query("SELECT * FROM ".FORUM_ANS." WHERE topic_id='".$topic_id."'");
		}
		else{
			$result = $GLOBALS['DATABASE']->query("SELECT * FROM ".FORUM_ANS." WHERE topic_id='".$topic_id."' AND team='0'");
		}
		while ($ansRow = $GLOBALS['DATABASE']->fetch_array($result)){
			$Result = $GLOBALS['DATABASE']->query("SELECT * FROM ".FORUM_TOP." WHERE id='".$topic_id."'");
			foreach($Result as $Data){
				$help = $Data['name'];
				$help2 = $Data['kat_id'];
			}
			$RESULT = $GLOBALS['DATABASE']->query("SELECT * FROM ".FORUM_KAT." WHERE id='".$help2."'");
			foreach($RESULT as $DATA){
				$kat = $DATA['name'];
			}
			if($ansRow['user'] == $USER['username']){
				$first = true;
			}
			else{
				$first = false;
			}
			$this->ans[] = array(
				'ans_text' 		=> htmlspecialchars($ansRow['text']),
				'ans_id'		=> $ansRow['id'],
				'ans_user'		=> $ansRow['user'],
				'ans_create'	=> date("d.m.Y H:i:s",$ansRow['createtime']),
				'ans_edit'		=> date("d.m.Y H:i:s",$ansRow['edit']),
				'ans_top_id'	=> $ansRow['topic_id'],
				'ans_adm'		=> $ansRow['adm'],
				'ans_admone'	=> $first,
			);
		} 
		
		$this->tplObj->assign_vars(array(
				'ans'		=> $this->sabsi($this->ans, 'ans_id'),
				'top_id'	=> $topic_id,
				'top_name'	=> $help,
				'adm'		=> $this->getUserMod(),
				'kat_name'	=> $kat,
		));
	}
	
	//done
	protected function getLast(){
		if($this->getUserMod()){
			$result = $GLOBALS['DATABASE']->query("SELECT * FROM ".FORUM_TOP." ORDER BY lastchange DESC LIMIT 5");
		}
		else{
			$result = $GLOBALS['DATABASE']->query("SELECT * FROM ".FORUM_TOP." WHERE team='0' ORDER BY lastchange DESC LIMIT 5");
		}
		while ($topRow = $GLOBALS['DATABASE']->fetch_array($result)){
			if($topRow['close'] != 0){
				$help = true;
			}
			else{
				$help = false;
			}
			$Result = $GLOBALS['DATABASE']->query("SELECT (name) FROM ".FORUM_KAT." WHERE id='".$topRow['kat_id']."'");
			foreach($Result as $data){
				$kat_name = $data['name'];
			}
			$this->toplast[] = array(
				'top_name' 		=> $topRow['name'],
				'top_id'		=> $topRow['id'],
				'top_user'		=> $topRow['user'],
				'top_create'	=> date("d.m.Y H:i:s",$topRow['createtime']),
				'top_last'		=> date("d.m.Y H:i:s",$topRow['lastchange']),
				'top_kat_id'	=> $topRow['kat_id'],
				'top_close'		=> $help,
				'kat_name'		=> $kat_name,
			);
		}
		$this->tplObj->assign_vars(array(
				'top'	=> $this->sabsi($this->toplast, 'top_last'),
		));
	} 
	
	//done
	protected function get_Error($id){
		global $LNG;
		if(!isset($id) || empty($id)){
			$id = 100;
		}
		switch ($id){
			case 1 : $this->msg = $LNG['winemp_Forum_error_8']; // kein Recht
					break;
			case 2 : $this->msg = $LNG['winemp_Forum_error_2']; // topic muss mehr als 3 zeichen haben
					break; 
			case 3 : $this->msg = $LNG['winemp_Forum_error_3']; // Erster Eintrag muss mehr als 10 zeichen haben
					break;
			case 4 : $this->msg = $LNG['winemp_Forum_error_4']; // Antworten müssen mehr als 5 Zeichen haben
					break;
			case 5 : $this->msg = $LNG['winemp_Forum_error_5']; // Topic nicht bekannt
					break;
			case 6 : $this->msg = $LNG['winemp_Forum_error_6']; // Topic gespeert
					break;
			case 7 : $this->msg = $LNG['winemp_Forum_error_9']; // Topic erst schliessen
					break;
			case 8 : $this->msg = $LNG['winemp_Forum_error_10']; // reserve
					break;
			default:
					$this->msg = $LNG['winemp_Forum_error_0'];
					break;
		}
		$this->tplObj->assign_vars(array(
				'msg'	=> $this->msg,
		));	
		$this->showPage(6);
	}
	
	protected function showPage($page){
		$this->tplObj->assign_vars(array(
				'adm'	=> $this->getUserMod(),
		));
		switch ($page){
			case 1 : // Show Topics 
					$this->display('com_Forum_topic.tpl');
					break;
			case 2 : // Show Topic answer
					$this->display('com_Forum_answer.tpl');
					break;
			case 3 : // Show log
					$this->display('com_Forum_logs.tpl');
					break;
			case 4 : // Show Answerform
					$this->display('com_Forum_answer_form.tpl');
					break;
			case 5 : // Show Answerform
					$this->display('com_Forum_topic_form.tpl');
					break;
			case 6 : // Show Answerform
					$this->display('com_Forum_error.tpl');
					break;
			default: // Show Mainpage
					$this->display('com_Forum_main.tpl');
					break;
		}
	}
	
	//done
	protected function sabsi ($array, $index, $order='asc', $natsort=FALSE, $case_sensitive=FALSE) {
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
?>