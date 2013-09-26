<?php
if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");
function ShowForumPage(){
	global $LNG, $USER, $LANG, $db;
	
	$id = HTTP::_GP('id', 0);
	$menue = HTTP::_GP('menue', 0);
	
	$topicList = array();
	$topic = array();
	
	$template 	= new template();

	
	switch ($menue){
		case 1 : $sql = $GLOBALS['DATABASE']->query("SELECT * FROM ".TOPICANSWER." WHERE topic_id='".$id."'");
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
				 	if($topicListRow['ally_id'] != 0){
				 		$AllianceRow = $GLOBALS['DATABASE']->query("SELECT (ally_name) FROM ".ALLIANCE." WHERE id='".$topicListRow['ally']."'");
					 	foreach($AllianceRow as $data_two){
					 		$alliance = $data_two['ally_name'];
					 	}
					 }
					else{
						$alliance = '-';
					}
					
					 $topic[] = array(
						'time'		=> date("d.m.Y H:i:s", $topicListRow['createtime']),
						'user'		=> $topicListRow['author'],
						'text'		=> nl2br(htmlspecialchars($topicListRow['text'])),
						'ally'		=> $alliance,
						'topic_id'	=> $topicListRow['topic_id'],
						'tread_id'	=> $topicListRow['id'],
			  		 );
				 }
		
				 $template->assign_vars(array(
					'tread'			=> true,		
					'list'			=> sabsi($topic, 'id'),
					'topic_name'	=> htmlspecialchars($topic_name),
					'topic_close'	=> $topic_close,
					'topic_id'		=> $id,
			     ));
				break;
		case 2 : $GLOBALS['DATABASE']->query("UPDATE ".TOPICANSWER." SET text='(Dieser Beitrag wurde von einen Administrator gelöscht)', createtime='".time()."' WHERE id='".$_POST['id']."'");
				 $sql = $GLOBALS['DATABASE']->query("SELECT * FROM ".ALLYTOPIC);
				 while($data = $GLOBALS['DATABASE']->fetch_array($sql)){
				 	if($data['ally_id'] != 0){
					 	$AllianceRow = $GLOBALS['DATABASE']->query("SELECT (ally_name) FROM ".ALLIANCE." WHERE id='".$data['ally_id']."'");
					 	foreach($AllianceRow as $data_two){
					 		$alliance = $data_two['ally_name'];
					 	}
					}
					else{
						$alliance = '-';
					}
					 $topicList[] = array(
						'id'		=> $data['id'],
						'create' 	=> date('d.m.Y H:i:s', $data['createtime']),
						'author'	=> $data['author'],
						'name'		=> $data['topic_name'],
						'ally'		=> $alliance,
						'close'		=> $data['close']
					 );
				 }
				 $template->assign_vars(array(
					'list'		=> $topicList,
					'tread'		=> false,
				 ));				
				break;
		case 3 : $GLOBALS['DATABASE']->query("INSERT INTO ".TOPICANSWER." SET text='(Dieser TOPIC wurde von einen Administrator geschlossen)',  createtime='".time()."', author='".$USER['username']."', ally='".$USER['ally_id']."', topic_id='".$_POST['id']."'");
				 $GLOBALS['DATABASE']->query("UPDATE ".ALLYTOPIC." SET close='1' WHERE id='".$_POST['id']."'");
				 $sql = $GLOBALS['DATABASE']->query("SELECT * FROM ".ALLYTOPIC);
				 while($data = $GLOBALS['DATABASE']->fetch_array($sql)){
					 $AllianceRow = $GLOBALS['DATABASE']->query("SELECT (ally_name) FROM ".ALLIANCE." WHERE id='".$data['ally_id']."'");
					 foreach($AllianceRow as $data_two){
					 	$alliance = $data_two['ally_name'];
					 }
					 $topicList[] = array(
						'id'		=> $data['id'],
						'create' 	=> date('d.m.Y H:i:s', $data['createtime']),
						'author'	=> $data['author'],
						'name'		=> $data['topic_name'],
						'ally'		=> $alliance,
						'close'		=> $data['close']
					 );
				 }
				 $template->assign_vars(array(
					'list'		=> $topicList,
					'tread'		=> false,
				 ));
				break;
		case 4 : $GLOBALS['DATABASE']->query("DELETE FROM ".TOPICANSWER." WHERE topic_id='".$_POST['id']."'");
				 $GLOBALS['DATABASE']->query("DELETE FROM ".ALLYTOPIC."  WHERE id='".$_POST['id']."'");
				 $sql = $GLOBALS['DATABASE']->query("SELECT * FROM ".ALLYTOPIC);
				 while($data = $GLOBALS['DATABASE']->fetch_array($sql)){
					 $AllianceRow = $GLOBALS['DATABASE']->query("SELECT (ally_name) FROM ".ALLIANCE." WHERE id='".$data['ally_id']."'");
					 foreach($AllianceRow as $data_two){
					 	$alliance = $data_two['ally_name'];
					 }
					 $topicList[] = array(
						'id'		=> $data['id'],
						'create' 	=> date('d.m.Y H:i:s', $data['createtime']),
						'author'	=> $data['author'],
						'name'		=> $data['topic_name'],
						'ally'		=> $alliance,
						'close'		=> $data['close']
					 );
				 }
				 $template->assign_vars(array(
					'list'		=> $topicList,
					'tread'		=> false,
				 ));
				break;
		default: $sql = $GLOBALS['DATABASE']->query("SELECT * FROM ".ALLYTOPIC);
				 while($data = $GLOBALS['DATABASE']->fetch_array($sql)){
					 $AllianceRow = $GLOBALS['DATABASE']->query("SELECT (ally_name) FROM ".ALLIANCE." WHERE id='".$data['ally_id']."'");
					 foreach($AllianceRow as $data_two){
					 	$alliance = $data_two['ally_name'];
					 }
					 $topicList[] = array(
						'id'		=> $data['id'],
						'create' 	=> date('d.m.Y H:i:s', $data['createtime']),
						'author'	=> $data['author'],
						'name'		=> $data['topic_name'],
						'ally'		=> $alliance,
						'close'		=> $data['close']
					 );
				 }
				 $template->assign_vars(array(
					'list'		=> $topicList,
					'tread'		=> false,
				 ));				
				break;
	}
	$template->show('ForumList.tpl');	
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