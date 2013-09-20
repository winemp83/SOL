<?php
/*
 * @MOD_Race_v0_01 for 2Moons 
 * @author winemp83 <koehne83@googlemail.com>
 * 
 * 
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 2Moons 1.7
 */
class ShowRacePage extends AbstractPage {
	
	private $miss = 0;
	private $mission = '';
		
		
	public static $requireModule = MODULE_SUPPORT;
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function show(){
		global $USER, $PLANET, $LNG, $UNI, $CONF, $db, $reslist, $resource;
		if ( $this->check24Hours()){
			if($this->checkStatus()){
				$this->tplObj->assign_vars(array(
						'wq_mod_quest_error'			=> 1,
						'wq_mod_quest_description'		=> $LNG['winemp_mod_quest_descA']."250".$LNG['winemp_mod_quest_descB'],
						'wq_mod_quest_submit'			=> $LNG['winemp_mod_quest_accept'],
						'wq_mod_quest_title'			=> $LNG['winemp_mod_quest_title'],
						'wq_mod_quest_missionA'			=> $LNG['winemp_mod_quest_mission'],
						'wq_mod_quest_missionB'			=> $this->mission,
						'wq_mod_quest_errormsg'			=> "kein Fehler",
						
					));
				$NewUser = 1;	
				$message = "Sie haben folgenden Auftrag beendet: ".$this->mission ." Dafür haben Sie 250 Dunkle Materie erhalten!";
				SendSimpleMessage($NewUser, 1, TIMESTAMP, 1, $LNG['winemp_mod_quest_sender'], $LNG['winemp_mod_quest_betreff'], $message);		
				$this->display('w_mod_quest.tpl');
			}
			else{
				$this->tplObj->assign_vars(array(
						'wq_mod_quest_error'			=> 1,
						'wq_mod_quest_description'		=> $LNG['winemp_mod_quest_descA']."250".$LNG['winemp_mod_quest_descB'],
						'wq_mod_quest_submit'			=> $LNG['winemp_mod_quest_accept'],
						'wq_mod_quest_title'			=> $LNG['winemp_mod_quest_title'],
						'wq_mod_quest_missionA'			=> $LNG['winemp_mod_quest_mission'],
						'wq_mod_quest_missionB'			=> $this->mission,
						'wq_mod_quest_errormsg'			=> 'Kein Fehler',
			
					));
				$NewUser = 1;	
				$message = "Sie haben folgenden Auftrag erhalten: ".$this->mission;
				SendSimpleMessage($NewUser, 1, TIMESTAMP, 1, $LNG['winemp_mod_quest_sender'], $LNG['winemp_mod_quest_betreff'], $message);		
				$this->display('w_mod_quest.tpl');
			}
		}
		else{
				$this->tplObj->assign_vars(array(
						'wq_mod_quest_error'			=> 2,
						'wq_mod_quest_description'		=> $LNG['winemp_mod_quest_descA']."250".$LNG['winemp_mod_quest_descB'],
						'wq_mod_quest_submit'			=> $LNG['winemp_mod_quest_accept'],
						'wq_mod_quest_title'			=> $LNG['winemp_mod_quest_title'],
						'wq_mod_quest_missionA'			=> $LNG['winemp_mod_quest_mission'],
						'wq_mod_quest_missionB'			=> $this->mission,
						'wq_mod_quest_errormsg'			=> $LNG['winemp_mod_quest_error'],
					));
		}
	} 
	
	function check24Hours(){
		$sql = "SELECT id FROM uni1_quest WHERE userid='".$USER['id']."' AND last > '".time()."' LIMIT 1";
		$result = $GLOBALS['DATABASE']->query($sql);
		if($result > 1){
			return false;
		}
		else{
			return true;
		}
	}
	
	function getQuest(){
		global $USER, $PLANET, $LNG, $UNI, $CONF, $db, $reslist, $resource;
		$sql = "SELECT mission FROM uni1_quest WHERE userid='".$USER['id']."' AND last > '".time()."'";
		$result = $GLOBALS['DATABASE']->query($sql);
		switch($result){
			case 1: $this->mission = $LNG['winemp83_quest_1']; // expedition
					break;
			case 2:	$this->mission = $LNG['winemp83_quest_2']; // angreifen
					break;
			case 3:	$this->mission = $LNG['winemp83_quest_3']; // Spionieren
					break;
		}
	}
	
	function checkStatus(){
		$sql = "SELECT id FROM uni1_quest WHERE userid='".$USER['id']."' AND last > '".time()."'";
		$result = $GLOBAls['DATABASE']->query($sql);
		if ($result > 1){
			if($this->checkQuest()){
				return true;
			}
			else{
			 	$this->setQuest();
				return false;
			}
		}
	}
	
	function checkQuest(){
	 	$sql = "SELECT `mission` FROM uni1_quest WHERE userid='".$USER['id']."' AND last > '".time()."'";
	 	$result = $GLOBALS['DATABASE']->query($sql);
	 	switch($result){
	 		case 1:	$sql = "SELECT `last` FROM uni1_quest WHERE userid='".$USER['id']."'";
		 			$result = $GLOBALS['DATABASE']->query($sql);
					$SQL = "SELECT `id` FROM uni1_log_fleets WHERE fleet_owner='".$USER['id']."' AND fleet_start_time>'".$result."' AND mission='15'";
		 			break;
			case 2:	$sql = "SELECT `last` FROM uni1_quest WHERE userid='".$USER['id']."'";
		 			$result = $GLOBALS['DATABASE']->query($sql);
					$SQL = "SELECT `id` FROM uni1_log_fleets WHERE fleet_owner='".$USER['id']."' AND fleet_start_time>'".$result."' AND mission='1'";
		 			break;
			case 3:	$sql = "SELECT `last` FROM uni1_quest WHERE userid='".$USER['id']."'";
		 			$result = $GLOBALS['DATABASE']->query($sql);
					$SQL = "SELECT `id` FROM uni1_log_fleets WHERE fleet_owner='".$USER['id']."' AND fleet_start_time>'".$result."' AND mission='6'";
		 			break;
	 	}	
		$result = $GLOBALS['DATABASE']->query($SQL);
		if($result < 475){
			$sql= "UPDATE uni1_quest SET done='".true."' WHERE userid='".$USER['id']."'";
			$GLOBALS['DATABASE']->query($sql);
			$USER[$ressource[921]] += 250;
			return true;
		}
		else{
			return false;	
		} 
	}
	
	function setQuest(){
		global $USER, $PLANET, $LNG, $UNI, $CONF, $db, $reslist, $resource;
		$this->miss = rand(1,3);
		$SQL = "INSERT INTO uni1_quest SET userid='".$USER['id']."', mission='".$this->miss."', last='".time()+(60*60*24)."', done='false'";
		$GLOBALS['DATABASE']->query($SQL);
		
	}
}
?>