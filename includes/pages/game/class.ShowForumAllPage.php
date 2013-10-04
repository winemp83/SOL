<?php

class ShowForumAllPage extends AbstractPage{
	
	function __construct() 
	{
		parent::__construct();
		
	}
	
	function show(){
		$this->menue();
	}
	
	protected function menue(){
		if(isset($_POST['meneu']) || empty($_POST['menue'])){
			$menue = $_POST['menue'];
		}
		else{
			$menue = 0;
		}
		
		switch ($menue){
			// getTopic
			case 1 :
					$this->getTopic($kat_id);
					break;
			// getAnswer
			case 2 :
					$this->getAnswer($topic_id);
					break;
			// createTopic
			case 3 :
					break;
			// createAnswer
			case 4 :
					
					break;
			// dellTopic
			case 5 :
					$this->logAction('dell_topic', $player_id);
					$this->dellTopic($topic_id);
					break;
			// dellAnswer
			case 6 :
					$this->logAction('dell_answer', $player_id);
					$this->dellAnswer($answer_id);
					break;
			// closeTopic
			case 7 :
					$this->logAction($what, $player_id);
					break;
			// logAction
			/*
			 * TODO: Make a Function to answer from Team
			 * 
			 */
			case 8 :
					$this->logAction($what, $player_id);
					break;
			// logAction
			case 9 :
					$this->logAction($what, $player_id);
					break;
			// getLast
			// getKat
			default:
					$this->getKat();
					$this->getLast();
					break;
		}
	}
	
	protected function dellTopic($topic_id){
		
	}
	
	protected function dellAnswer($answer_id){
		
	}
	
	protected function logAction($what){
		
	}
	
	protected function getKat(){
		
	}
	
	protected function getTopic($kat_id){
		
	}
	
	protected function getAnswer($topic_id){
		
	}
	
	protected function getLast(){
		
	} 
	
}
?>