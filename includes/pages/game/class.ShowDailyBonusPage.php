<?php
class ShowDailyBonusPage extends AbstractPage{
private $error_code = 0;
private $error_message = '';
private $data = array();
	function __construct() 
	{
		global $USER;
		parent::__construct();
	}
	
	public function show(){
		
	}
	
	private function getLastQuest(){
		$sql = "SELECT * FROM uni1_daily_quest WHERE user='".$USER['id']."'";
		$this->data = $GLOBALSE['DATABASE']->query($sql); 
	}
	
	private function checkQuestStatus(){
		if($this->checkFirstUse()){
			$this->newQuest();
		}
		else{
			$this->getLastQuest();
			if($this->data['time'] > time()){
				
			}
			else{
			}
		}
	}
	
	private function newQuest(){
		
	}
	
	private function error_show(){
		if ($this->error_code != 0){
			switch ($this->error_code){
				case   1	:	
								break;
				case   2	:	
								break;
				case   3	:	
								break;
				case   4	:	
								break; 
			}
			return false;
		}
		else{
			return true;
		}
	}
	
	private function getData(){
		$sql = "SELECT `user` FROM uni1_daily_quest";
		$this->data = $GLOBALS['DATABASE']->query($sql);
	}
	
	private function checkFirstUse(){
		$help = 0;
		foreach($data as $user){
			if($user['user'] == $USER['id']){
				$help = 1;
			}
		}
		if($help != 1){
			return true;
		}
		else{
			return false;
		}
	}
}
?>