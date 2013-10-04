<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.3 (2013-05-19)
 * @info $Id: class.ShowAlliancePage.php 2640 2013-03-23 19:23:26Z slaver7 $
 * @link http://2moons.cc/
 */

class ShowAlliancePage extends AbstractPage
{
	public static $requireModule = MODULE_ALLIANCE;

	//Bonus Maximums
	//Maximal Stufen der Einzelnden Slots
	private	$Slots_max = 20;
	private	$Produ_max = 200;
	private $Build_max = 100;
	private $Reser_max = 100;
	private $Defen_max = 250;
	private $Attak_max = 250;
	private $Topics_max = 95;
	private $allianceData;
	private $ranks;
	private $rights;
	private $hasAlliance = false;
	private $hasApply = false;
	public $avalibleRanks	= array(
		'MEMBERLIST',
		'ONLINESTATE',
		'TRANSFER',
		'SEEAPPLY',
		'MANAGEAPPLY',
		'ROUNDMAIL',
		'ADMIN',
		'KICK',
		'DIPLOMATIC',
		'RANKS',
		'MANAGEUSERS',
		'EVENTS'
	);
	
	function __construct() 
	{
		global $USER;
		parent::__construct();
		$this->hasAlliance	= $USER['ally_id'] != 0;
		$this->hasApply		= $this->isApply();
		if($this->hasAlliance && !$this->hasApply) {
			$this->setAllianceData($USER['ally_id']);
		}
	}
	
	private function setAllianceData($allianceID)
	{
		global $USER;
		$this->allianceData	= $GLOBALS['DATABASE']->getFirstRow("SELECT * FROM ".ALLIANCE." WHERE id = ".$allianceID.";");
		
		if($USER['ally_id'] == $allianceID)
		{
			if ($this->allianceData['ally_owner'] == $USER['id']) {
				$this->rights	= array_combine($this->avalibleRanks, array_fill(0, count($this->avalibleRanks), true));
			} elseif($USER['ally_rank_id'] != 0) {
				$this->rights	= $GLOBALS['DATABASE']->getFirstRow("SELECT ".implode(", ", $this->avalibleRanks)." FROM ".ALLIANCE_RANK." WHERE allianceID = ".$allianceID." AND rankID = ".$USER['ally_rank_id'].";");
			}
			
			if(!isset($this->rights)) {
				$this->rights	= array_combine($this->avalibleRanks, array_fill(0, count($this->avalibleRanks), false));
			}
		
			if(isset($this->tplObj))
			{
				$this->tplObj->assign_vars(array(
					'rights'		=> $this->rights,
					'AllianceOwner'	=> $this->allianceData['ally_owner'] == $USER['id'],
				));
			}
		}
	}
	
	private function isApply()
	{
		global $USER;
		return $GLOBALS['DATABASE']->getFirstCell("SELECT COUNT(*) FROM ".ALLIANCE_REQUEST." WHERE userID = ".$USER['id'].";");
	}
	
	function info() 
	{
		global $LNG, $USER, $PLANET;
		
		$allianceID = HTTP::_GP('id', 0);
		
		$this->setAllianceData($allianceID);

		if(!isset($this->allianceData))
		{
			$this->printMessage($LNG['al_not_exists']);
		}
		
		require_once('includes/functions/BBCode.php');
		
		if ($this->allianceData['ally_diplo'] == 1)
		{
			$this->tplObj->assign_vars(array(
				'DiploInfo'			=> $this->getDiplomatic(),
			));
		}
		
		if ($this->allianceData['ally_stats'] == 1)
		{
			$StatsData 					= $GLOBALS['DATABASE']->getFirstRow("SELECT SUM(wons) as wons, SUM(loos) as loos, SUM(draws) as draws, SUM(kbmetal) as kbmetal, SUM(kbcrystal) as kbcrystal, SUM(lostunits) as lostunits, SUM(desunits) as desunits FROM ".USERS." WHERE ally_id='" . $this->allianceData['id'] . "';");

			$this->tplObj->assign_vars(array(
				'totalfight'	=> $StatsData['wons'] + $StatsData['loos'] + $StatsData['draws'],
				'fightwon'		=> $StatsData['wons'],
				'fightlose'		=> $StatsData['loos'],
				'fightdraw'		=> $StatsData['draws'],
				'unitsshot'		=> pretty_number($StatsData['desunits']),
				'unitslose'		=> pretty_number($StatsData['lostunits']),
				'dermetal'		=> pretty_number($StatsData['kbmetal']),
				'dercrystal'	=> pretty_number($StatsData['kbcrystal']),
			));
		}
		$sql = "SELECT * FROM ".ALLIBONUS." WHERE id='".$allianceID."'";
		$result = $GLOBALS['DATABASE']->query($sql);
		foreach($result as $data){
			$help = $data['slots'];
		}
		$alli_maxMember = $this->allianceData['ally_max_members'] + $help; 
		$this->tplObj->assign_vars(array(
			'ally_description' 				=> bbcode($this->allianceData['ally_description']),
			'ally_id'	 					=> $this->allianceData['id'],
			'ally_image' 					=> $this->allianceData['ally_image'],
			'ally_web'						=> $this->allianceData['ally_web'],
			'ally_member_scount' 			=> $this->allianceData['ally_members'],
			'ally_max_members' 				=> $alli_maxMember,
			'ally_name' 					=> $this->allianceData['ally_name'],
			'ally_tag' 						=> $this->allianceData['ally_tag'],
			'ally_stats' 					=> $this->allianceData['ally_stats'],
			'ally_diplo' 					=> $this->allianceData['ally_diplo'],
			'ally_request'              	=> !$this->hasAlliance && !$this->hasApply && $this->allianceData['ally_request_notallow'] == 0 && $this->allianceData['ally_max_members'] > $this->allianceData['ally_members'],
			'ally_request_min_points'		=> $USER['total_points'] >= $this->allianceData['ally_request_min_points'],
			'ally_request_min_points_info'  => sprintf($LNG['al_requests_min_points'], pretty_number($this->allianceData['ally_request_min_points']))
		));
		
		$this->display('page.alliance.info.tpl');
	}
	
	function show() 
	{
		if($this->hasAlliance) {
			$this->homeAlliance();
		} elseif($this->hasApply) {		
			$this->applyWaitScreen();
		} else {		
			$this->createSelection();
		}
	}
	
	private function redirectToHome()
	{
		$this->redirectTo('game.php?page=alliance');
	}
	
	private function getAction()
	{
		return HTTP::_GP('action', '');
	}
	
	private function applyWaitScreen()
	{
		global $USER, $LNG;
		
		$allianceResult = $GLOBALS['DATABASE']->getFirstRow("SELECT a.ally_tag FROM ".ALLIANCE_REQUEST." r INNER JOIN ".ALLIANCE." a ON a.id = r.allianceID WHERE r.userID = ".$USER['id'].";");
		$this->tplObj->assign_vars(array(
			'request_text'	=> sprintf($LNG['al_request_wait_message'], $allianceResult['ally_tag']),
		));     

		$this->display('page.alliance.applyWait.tpl');		
	}
	
	private function createSelection()
	{
		$this->display('page.alliance.createSelection.tpl');		
	}

	function search() 
	{
		global $UNI;
		if($this->hasApply) {
			$this->redirectToHome();
		}
		
		$searchText	= HTTP::_GP('searchtext', '', UTF8_SUPPORT);
		$searchList	= array();

		if (!empty($searchText))
		{
			$searchResult = $GLOBALS['DATABASE']->query("SELECT 
			id, ally_name, ally_tag, ally_members
			FROM ".ALLIANCE."
			WHERE ally_universe = ".$UNI." AND ally_name LIKE '%".$GLOBALS['DATABASE']->sql_escape($searchText, true)."%'
			ORDER BY (
			  IF(ally_name = '".$GLOBALS['DATABASE']->sql_escape($searchText, true)."', 1, 0)
			  + IF(ally_name LIKE '".$GLOBALS['DATABASE']->sql_escape($searchText, true)."%', 1, 0)
			) DESC,ally_name ASC LIMIT 25;");
			
			while($searchRow = $GLOBALS['DATABASE']->fetch_array($searchResult))
			{
				$searchList[]	= array(
					'id'		=> $searchRow['id'],
					'tag'		=> $searchRow['ally_tag'],
					'members'	=> $searchRow['ally_members'],
					'name'		=> $searchRow['ally_name'],
				);
			}
			
			$GLOBALS['DATABASE']->free_result($searchResult);
		}
		
		$this->tplObj->assign_vars(array(
			'searchText'	=> $searchText,
			'searchList'	=> $searchList,
		));	
		
		$this->display('page.alliance.search.tpl');	
	}
	
	function apply()
	{
		global $UNI, $LNG, $USER;
		
		if($this->hasApply) {
			$this->redirectToHome();
		}
		
		$text		= HTTP::_GP('text' , '', true);
		$allianceID	= HTTP::_GP('id', 0);
			
		$allianceResult = $GLOBALS['DATABASE']->getFirstRow("SELECT ally_tag, ally_request, ally_request_notallow, ally_members FROM ".ALLIANCE." WHERE id = ".$allianceID." AND ally_universe = ".$UNI.";");

		if (!isset($allianceResult)) {
			$this->redirectToHome();
		}
		
		$sql = $GLOBALS['DATABASE']->query("SELECT (slots) FROM ".ALLIBONUS." WHERE id='".$allianceID."'");
		foreach($sql as $data){
			$check_a = $data['slots'];
		}
		
		
		$check_a += 5;
		
		if($check_a <= $allianceResult['ally_members']){
			$this->printMessage($LNG['al_alliance_max_members']);
		}
		
		
		if($allianceResult['ally_request_notallow'] == 1)
		{
			$this->printMessage($LNG['al_alliance_closed']);
		}
		
		if (!empty($text))
		{
			$GLOBALS['DATABASE']->query("INSERT INTO ".ALLIANCE_REQUEST." SET 
			allianceID = ".$allianceID.", 
			text = '".$GLOBALS['DATABASE']->sql_escape($text)."', 
			time = ".TIMESTAMP.", 
			userID = ".$USER['id'].";");

			$this->printMessage($LNG['al_request_confirmation_message']);
		}
		
		$this->tplObj->assign_vars(array(
			'allyid'			=> $allianceID,
			'applytext'			=> $allianceResult['ally_request'],
			'al_write_request'	=> sprintf($LNG['al_write_request'], $allianceResult['ally_tag']),
		));	
		
		$this->display('page.alliance.apply.tpl');
	}
	
	function cancelApply()
	{
		global $UNI, $LNG, $USER;
		
		if(!$this->hasApply) {
			$this->redirectToHome();
		}
		
		$allyquery 	= $GLOBALS['DATABASE']->getFirstRow("SELECT a.ally_tag FROM ".ALLIANCE_REQUEST." r INNER JOIN ".ALLIANCE." a ON a.id = r.allianceID WHERE r.userID = ".$USER['id'].";");
		$GLOBALS['DATABASE']->query("DELETE FROM ".ALLIANCE_REQUEST." WHERE userID = ".$USER['id'].";");
		
		$this->printMessage(sprintf($LNG['al_request_deleted'], $allyquery['ally_tag']));
	}
	
	function create()
	{
		if($this->hasApply) {
			$this->redirectToHome();
		}
		
		$user_points = $GLOBALS['USER']['total_points'];
		$min_points = $GLOBALS['CONF']['alliance_create_min_points'];
		
		if($user_points >= $min_points)
		{
			$action    = $this->getAction();
		if($action == "send") {
			$this->createAlliance();
		} else {
			$this->display('page.alliance.create.tpl');
		}
	}
		else
		{
			$diff_points = $min_points - $user_points;
			$this->printMessage(sprintf($GLOBALS['LNG']['al_make_ally_insufficient_points'], pretty_number($min_points), pretty_number($diff_points)));
		}
	}
	
	private function createAlliance()
	{
		$action	= $this->getAction();
		if($action == "send") {
			$this->createAllianceProcessor();
		} else {
			$this->display('page.alliance.create.tpl');
		}
	}
		
	private function createAllianceProcessor() 
	{
		global $USER, $UNI, $LNG;
		$atag	= HTTP::_GP('atag' , '', UTF8_SUPPORT);
		$aname	= HTTP::_GP('aname', '', UTF8_SUPPORT);
		
		if (empty($atag)) {
			$this->printMessage($LNG['al_tag_required'], true, array("?page=alliance&mode=create", 3));
		}
		
		if (empty($aname)) {
			$this->printMessage($LNG['al_name_required'], true, array("?page=alliance&mode=create", 3));
		}
		
		if (!CheckName($aname) || !CheckName($atag)) {
			$this->printMessage($LNG['al_newname_specialchar'], true, array("?page=alliance&mode=create", 3));
		}
		
		$allianceCount = $GLOBALS['DATABASE']->getFirstCell("SELECT COUNT(*) FROM ".ALLIANCE." WHERE ally_universe = ".$UNI." AND (ally_tag = '".$GLOBALS['DATABASE']->sql_escape($atag)."' OR ally_name = '".$GLOBALS['DATABASE']->sql_escape($aname)."');");

		if ($allianceCount != 0) {
			$this->printMessage(sprintf($LNG['al_already_exists'], $aname), true, array("?page=alliance&mode=create", 3));
		}
		
		$GLOBALS['DATABASE']->multi_query("INSERT INTO ".ALLIANCE." SET
						ally_name				= '".$GLOBALS['DATABASE']->sql_escape($aname)."',
						ally_tag				= '".$GLOBALS['DATABASE']->sql_escape($atag)."' ,
						ally_owner				= ".$USER['id'].",
						ally_owner_range		= '".$LNG['al_default_leader_name']."',
						ally_members			= 1,
						ally_register_time		= ".TIMESTAMP.",
						ally_universe 			= ".$UNI.";
						SET @allianceID = LAST_INSERT_ID();
						UPDATE ".USERS." SET
						ally_id					= @allianceID,
						ally_rank_id			= 0,
						ally_register_time 		= ".TIMESTAMP."
						WHERE id = ".$USER['id'].";
						UPDATE ".STATPOINTS." SET
						id_ally 				= @allianceID
						WHERE id_owner = ".$USER['id'].";
						INSERT INTO ".ALLIBONUS." SET
						id 						= @allianceID;");
						
		$this->printMessage(sprintf($LNG['al_created'], $aname.' ['.$atag.']'), true, array('?page=alliance', 3));

	}
	
	private function getDiplomatic()
	{
		$Return	= array();
		$Diplos	= $GLOBALS['DATABASE']->query("SELECT d.level, d.accept, d.accept_text, d.id, a.id as ally_id, a.ally_name, a.ally_tag, d.owner_1, d.owner_2 FROM ".DIPLO." as d INNER JOIN ".ALLIANCE." as a ON IF(".$this->allianceData['id']." = d.owner_1, a.id = d.owner_2, a.id = d.owner_1) WHERE ".$this->allianceData['id']." = d.owner_1 OR ".$this->allianceData['id']." = d.owner_2");
		while($CurDiplo = $GLOBALS['DATABASE']->fetch_array($Diplos))
		{
			if($CurDiplo['accept'] == 0 && $CurDiplo['owner_2'] == $this->allianceData['id'])
				$Return[5][$CurDiplo['id']] = array($CurDiplo['ally_name'], $CurDiplo['ally_id'], $CurDiplo['level'], $CurDiplo['accept_text'], $CurDiplo['ally_tag']);
			elseif($CurDiplo['accept'] == 0 && $CurDiplo['owner_1'] == $this->allianceData['id'])
				$Return[6][$CurDiplo['id']] = array($CurDiplo['ally_name'], $CurDiplo['ally_id'], $CurDiplo['level'], $CurDiplo['accept_text'], $CurDiplo['ally_tag']);
			else
				$Return[$CurDiplo['level']][$CurDiplo['id']] = array($CurDiplo['ally_name'], $CurDiplo['ally_id'], $CurDiplo['owner_1'], $CurDiplo['ally_tag']);				
		}
		return $Return;
	}

	private function homeAlliance()
	{
		global $USER, $UNI, $LNG;
		require_once('includes/functions/BBCode.php');
		
		if ($this->allianceData['ally_owner'] == $USER['id']) {
			$rankName	= ($this->allianceData['ally_owner_range'] != '') ? $this->allianceData['ally_owner_range'] : $LNG['al_founder_rank_text'];
		} elseif ($USER['ally_rank_id'] != 0) {
			$rankName	= $GLOBALS['DATABASE']->getFirstCell("SELECT rankName FROM ".ALLIANCE_RANK." WHERE rankID = ".$USER['ally_rank_id'].";");	
		}
		
		if (empty($rankName)) {
			$rankName	= $LNG['al_new_member_rank_text'];
		}
		
		$checkally = $GLOBALS['DATABASE']->query("SELECT user.`username`, fleet.`fleet_owner`, fleet.`fleet_start_id`, fleet.`fleet_start_galaxy`, fleet.`fleet_start_system`, fleet.`fleet_start_planet`, fleet.`fleet_start_type`, fleet.`fleet_end_galaxy`, fleet.`fleet_end_system`, fleet.`fleet_end_planet`, fleet.`fleet_end_type` FROM `".USERS."` AS user INNER JOIN `".FLEETS."` AS fleet ON user.id = fleet.`fleet_target_owner` AND fleet.`fleet_mission` IN ('1', '2') WHERE user.`ally_id` = '".$USER['ally_id']."'; ");
		while ($AllyRow = $GLOBALS['DATABASE']->fetch_array($checkally)) {
			$name = $GLOBALS['DATABASE']->fetch_array($GLOBALS['DATABASE']->query("SELECT `username` FROM `".USERS."` WHERE `id` = ".$AllyRow['fleet_owner']));
			$Ally[] = array(
				'name'=> $AllyRow['username'],
				'koords' => $AllyRow['fleet_end_galaxy'].":".$AllyRow['fleet_end_system'].":".$AllyRow['fleet_end_planet'],
				'attackername' => $name['username'],
				'attackerkoord' => $AllyRow['fleet_start_galaxy'].":".$AllyRow['fleet_start_system'].":".$AllyRow['fleet_start_planet'],
				);
		}
		if(empty($Ally)){
			$Ally[] = array(
				"name" 		=> "",
				"koords" 	=> "",
				);
		}
		
		$StatsData 					= $GLOBALS['DATABASE']->getFirstRow("SELECT SUM(wons) as wons, SUM(loos) as loos, SUM(draws) as draws, 
														SUM(kbmetal) as kbmetal, SUM(kbcrystal) as kbcrystal, 
														SUM(lostunits) as lostunits, SUM(desunits) as desunits 
														FROM ".USERS." WHERE ally_id = ".$this->allianceData['id'].";");
														
		$ApplyCount					= $GLOBALS['DATABASE']->getFirstCell("SELECT COUNT(*) FROM ".ALLIANCE_REQUEST." WHERE allianceID = ".$this->allianceData['id'].";");
		
		
		
		$ally_events = array();
		
		if(!empty($this->allianceData['ally_events']))
		{
			$sql = "
			SELECT
				`id`,
				`username`
			FROM
				`". USERS ."`
			WHERE
				`ally_id` = ". $this->allianceData['id'] .";";
			
			$result = $GLOBALS['DATABASE']->query($sql);

			require_once('includes/classes/class.FlyingFleetsTable.php');
			$FlyingFleetsTable = new FlyingFleetsTable;
			
			$this->tplObj->loadscript('overview.js');
			
			while($row = $result->fetch_assoc())
			{
				$FlyingFleetsTable->setUser($row['id']);
				$FlyingFleetsTable->setMissions($this->allianceData['ally_events']);
				$ally_events[$row['username']] = $FlyingFleetsTable->renderTable();
			}
			
			$ally_events = array_filter($ally_events);
		}
		
		$ally_met	 = pretty_number($this->allianceData['ally_met']);
		$ally_krist	 = pretty_number($this->allianceData['ally_krist']);
		$ally_deut	 = pretty_number($this->allianceData['ally_deut']);
		$sql = "SELECT * FROM ".ALLIBONUS." WHERE id='".$this->allianceData['id']."'";
		$result = $GLOBALS['DATABASE']->query($sql);
		foreach($result as $data){
			$one 	= $data['slots'];
			$two 	= $data['produktion'];
			$tree 	= $data['research'];
			$four 	= $data['building'];
			$five 	= $data['defense'];
			$six 	= $data['attack'];
			$seven  = $data['topics'];
			$data['act_slo'] == 0 ? $deak_1 = false : $deak_1 = true;
			$data['act_pro'] == 0 ? $deak_2 = false : $deak_2 = true;
			$data['act_res'] == 0 ? $deak_3 = false : $deak_3 = true;
			$data['act_bui'] == 0 ? $deak_4 = false : $deak_4 = true;
			$data['act_def'] == 0 ? $deak_5 = false : $deak_5 = true;
			$data['act_att'] == 0 ? $deak_6 = false : $deak_6 = true;
			$data['act_top'] == 0 ? $deak_7 = false : $deak_7 = true;
		}
		$alli_maxMember = $this->allianceData['ally_max_members'] + $one; 
		$this->tplObj->assign_vars(array(
			'Ally'						=> $Ally,
			'DiploInfo'					=> $this->getDiplomatic(),
			'ally_web'					=> $this->allianceData['ally_web'],
			'ally_tag'	 				=> $this->allianceData['ally_tag'],
			'ally_members'	 			=> $alli_maxMember,
			'ally_max_members'	 		=> $this->allianceData['ally_members'],
			'ally_name'					=> $this->allianceData['ally_name'],
			'ally_image'				=> $this->allianceData['ally_image'],
			'ally_description'			=> bbcode($this->allianceData['ally_description']),
			'ally_text' 				=> bbcode($this->allianceData['ally_text']),
			'rankName'					=> $rankName,
			'requests'					=> sprintf($LNG['al_new_requests'], $ApplyCount),
			'applyCount'				=> $ApplyCount,
			'totalfight'				=> $StatsData['wons'] + $StatsData['loos'] + $StatsData['draws'],
			'fightwon'					=> $StatsData['wons'],
			'fightlose'					=> $StatsData['loos'],
			'fightdraw'					=> $StatsData['draws'],
			'unitsshot'					=> pretty_number($StatsData['desunits']),
			'unitslose'					=> pretty_number($StatsData['lostunits']),
			'dermetal'					=> pretty_number($StatsData['kbmetal']),
			'dercrystal'				=> pretty_number($StatsData['kbcrystal']),
			'isOwner'					=> $this->allianceData['ally_owner'] == $USER['id'],
			'ally_events'				=> $ally_events,
			'ally_met'					=> $ally_met,
			'ally_krist'				=> $ally_krist,
			'ally_deut'					=> $ally_deut,
			'one'						=> $one,
			'two'						=> $two,
			'tree'						=> $tree,
			'four'						=> $four,
			'five'						=> $five,
			'six'						=> $six,
			'seven'						=> $seven,
			'deakt_one'					=> $deak_1,
			'deakt_two'					=> $deak_2,
			'deakt_tree'				=> $deak_3,
			'deakt_four'				=> $deak_4,
			'deakt_five'				=> $deak_5,
			'deakt_six'					=> $deak_6,
			'deakt_seven'				=> $deak_7,
			
		));
		
		$this->display('page.alliance.home.tpl');
	}
	
	function memberList()
	{
		global $USER, $LNG;
		if (!$this->rights['MEMBERLIST']) {
			$this->redirectToHome();
		}
		
		$rankResult	= $GLOBALS['DATABASE']->query("SELECT rankID, rankName FROM ".ALLIANCE_RANK." WHERE allianceID = ".$this->allianceData['id'].";");
		$rankList	= array();
		
		while($rankRow = $GLOBALS['DATABASE']->fetch_array($rankResult))
			$rankList[$rankRow['rankID']]	= $rankRow['rankName'];
		
		$GLOBALS['DATABASE']->free_result($rankResult);
		
		$memberListResult = $GLOBALS['DATABASE']->query("SELECT DISTINCT u.id, u.username,u.galaxy, u.system, u.planet, u.ally_register_time, u.onlinetime, u.ally_rank_id, s.total_points 
										FROM ".USERS." u
										LEFT JOIN ".STATPOINTS." as s ON s.stat_type = '1' AND s.id_owner = u.id 
										WHERE ally_id = ".$this->allianceData['id'].";");

		$memberList	= array();
										
		while ($memberListRow = $GLOBALS['DATABASE']->fetch_array($memberListResult))
		{
			if ($this->allianceData['ally_owner'] == $memberListRow['id'])
				$memberListRow['ally_rankName'] = empty($this->allianceData['ally_owner_range']) ? $LNG['al_founder_rank_text'] : $this->allianceData['ally_owner_range'];
			elseif ($memberListRow['ally_rank_id'] != 0 && isset($rankList[$memberListRow['ally_rank_id']]))
				$memberListRow['ally_rankName'] = $rankList[$memberListRow['ally_rank_id']];
			else
				$memberListRow['ally_rankName'] = $LNG['al_new_member_rank_text'];
			
			$memberList[$memberListRow['id']]	= array(
				'username'		=> $memberListRow['username'],
				'galaxy'		=> $memberListRow['galaxy'],
				'system'		=> $memberListRow['system'],
				'planet'		=> $memberListRow['planet'],
				'register_time'	=> _date($LNG['php_tdformat'], $memberListRow['ally_register_time'], $USER['timezone']),
				'points'		=> pretty_number($memberListRow['total_points']),
				'rankName'		=> $memberListRow['ally_rankName'],
				'onlinetime'	=> floor((TIMESTAMP - $memberListRow['onlinetime']) / 60),
			);
		}		
		
		$GLOBALS['DATABASE']->free_result($memberListResult);
		
		$this->tplObj->assign_vars(array(
			'memberList'		=> $memberList,
			'al_users_list'		=> sprintf($LNG['al_users_list'], count($memberList)),
		));
		
		$this->display('page.alliance.memberList.tpl');
	}
	
	function close()
	{
		global $USER, $LNG;
		
		$GLOBALS['DATABASE']->multi_query("
		UPDATE ".USERS." SET ally_id = 0, ally_register_time = 0, ally_register_time = 5 WHERE id = ".$USER['id'].";
		UPDATE ".STATPOINTS." SET id_ally = 0 WHERE id_owner = ".$USER['id']." AND stat_type = 1;
		UPDATE ".ALLIANCE." SET ally_members = (SELECT COUNT(*) FROM ".USERS." WHERE ally_id = ".$this->allianceData['id'].") WHERE id = ".$this->allianceData['id'].";");
		
		$this->redirectTo('game.php?page=alliance');
	}
	
	function circular() 
	{
		global $LNG, $USER;

		if (!$this->rights['ROUNDMAIL'])
			$this->redirectToHome();
		
		$action	= HTTP::_GP('action', '');

		if ($action == "send")
		{
			$rankID		= HTTP::_GP('rankID', 0);
			$subject 	= HTTP::_GP('subject', '', true);
			$text 		= HTTP::_GP('text', $LNG['mg_no_subject'], true);
			
			if(empty($text)) {
				$this->sendJSON(array('message' => $LNG['mg_empty_text'], 'error' => true));
			}
			
			if($rankID == 0) {
				$sendUsersResult	= $GLOBALS['DATABASE']->query("SELECT id, username FROM ".USERS." WHERE ally_id = ".$this->allianceData['id'].";");
			} else {
				$sendUsersResult	= $GLOBALS['DATABASE']->query("SELECT id, username FROM ".USERS." WHERE ally_id = ".$this->allianceData['id']." AND ally_rank_id = ".$rankID.";");
			}
			
			$sendList 	= $LNG['al_circular_sended'];
			$title		= $LNG['al_circular_alliance'].$this->allianceData['ally_tag'];
			$text		= sprintf($LNG['al_circular_front_text'], $USER['username'])."\r\n".$text;
			
			while ($sendUsersRow = $GLOBALS['DATABASE']->fetch_array($sendUsersResult))
			{
				SendSimpleMessage($sendUsersRow['id'], $USER['id'], TIMESTAMP, 2, $title, $subject, makebr($text));
				$sendList	.= "\n".$sendUsersRow['username'];
			}
				
			$this->sendJSON(array('message' => $sendList, 'error' => false));
		}

		$this->initTemplate();
		$this->setWindow('popup');
		$RangeList[]	= $LNG['al_all_players'];

		if (is_array($this->ranks))
		{
			foreach($this->ranks as $id => $array)
			{
				$RangeList[$id + 1]	= $array['name'];
			}
		}
		
		$this->tplObj->assign_vars(array(
			'RangeList'						=> $RangeList,
		));
		
		$this->display('page.alliance.circular.tpl');
	}
	
	function admin() 
	{
		global $LNG;
		
		$action		= HTTP::_GP('action', 'overview');
		$methodName	= 'admin'.ucwords($action);
		
		if(!is_callable(array($this, $methodName))) {
			ShowErrorPage::printError($LNG['page_doesnt_exist']);
		}

		$this->{$methodName}();
	}
	
	private function adminOverview() 
	{
		global $LNG, $UNI, $USER;
		$send 		= HTTP::_GP('send', 0);
		$textMode  	= HTTP::_GP('textMode', 'external');
		if ($send && $this->allianceData['ally_owner'] == $USER['id'])
		{
			$this->allianceData['ally_owner_range'] 		= HTTP::_GP('owner_range', '', true);
			$this->allianceData['ally_web'] 				= filter_var(HTTP::_GP('web', ''), FILTER_VALIDATE_URL);
			$this->allianceData['ally_image'] 				= filter_var(HTTP::_GP('image', ''), FILTER_VALIDATE_URL);
			$this->allianceData['ally_request_notallow'] 	= HTTP::_GP('request_notallow', 0);
			$this->allianceData['ally_request_min_points']  = filter_var(HTTP::_GP('request_min_points', 0), FILTER_VALIDATE_INT);
			$this->allianceData['ally_stats'] 				= HTTP::_GP('stats', 0);
			$this->allianceData['ally_diplo'] 				= HTTP::_GP('diplo', 0);
			$this->allianceData['ally_events'] 				= implode(',', HTTP::_GP('events', array()));

			$new_ally_tag 	= HTTP::_GP('ally_tag', '', UTF8_SUPPORT);
			$new_ally_name	= HTTP::_GP('ally_name', '', UTF8_SUPPORT);
		
			if(!empty($new_ally_tag) && $this->allianceData['ally_tag'] != $new_ally_tag)
			{
				$allianceCount = $GLOBALS['DATABASE']->getFirstCell("SELECT COUNT(*) FROM ".ALLIANCE." WHERE ally_universe = ".$UNI." AND ally_tag = '".$GLOBALS['DATABASE']->sql_escape($new_ally_tag)."';");

				if($allianceCount != 0) 
				{
					$this->printMessage(sprintf($LNG['al_already_exists'], $new_ally_tag));
				}
				else
				{
					$this->allianceData['ally_tag'] = $new_ally_tag;
				}
			}
			
			if(!empty($new_ally_name) && $this->allianceData['ally_name'] != $new_ally_name)
			{
				$allianceCount = $GLOBALS['DATABASE']->getFirstCell("SELECT COUNT(*) FROM ".ALLIANCE." WHERE ally_universe = ".$UNI." AND ally_tag = '".$GLOBALS['DATABASE']->sql_escape($new_ally_name)."';");

				if($allianceCount != 0)
				{
					$this->printMessage(sprintf($LNG['al_already_exists'], $new_ally_name));
				}
				else
				{
					$this->allianceData['ally_name'] = $new_ally_name;
				}
			}
			
			if ($this->allianceData['ally_request_notallow'] != 0 && $this->allianceData['ally_request_notallow'] != 1) {
				$this->allianceData['ally_request_notallow']	= 0;
			}

			$text 		= HTTP::_GP('text', '', true);
			$textMode  	= HTTP::_GP('textMode', 'external');
			
			$textSQL	= "";
			
			switch($textMode)
			{
				case 'external':
					$textSQL	= "ally_description = '".$GLOBALS['DATABASE']->sql_escape($text)."', ";
				break;
				case 'internal':
					$textSQL	= "ally_text = '".$GLOBALS['DATABASE']->sql_escape($text)."', ";
				break;
				case 'apply':
					$textSQL	= "ally_request = '".$GLOBALS['DATABASE']->sql_escape($text)."', ";
				break;
			}
			if($this->allianceData['ally_owner'] == $USER['id']){
				$GLOBALS['DATABASE']->query("UPDATE ".ALLIANCE." SET
				".$textSQL."
				ally_tag = '".$GLOBALS['DATABASE']->sql_escape($this->allianceData['ally_tag'])."',
				ally_name = '".$GLOBALS['DATABASE']->sql_escape($this->allianceData['ally_name'])."',
				ally_owner_range = '".$GLOBALS['DATABASE']->sql_escape($this->allianceData['ally_owner_range'])."',
				ally_image = '".$GLOBALS['DATABASE']->sql_escape($this->allianceData['ally_image'])."',
				ally_web = '".$GLOBALS['DATABASE']->sql_escape($this->allianceData['ally_web'])."',
				ally_request_notallow = ".$this->allianceData['ally_request_notallow'].",
				ally_request_min_points = ".$this->allianceData['ally_request_min_points'].",
				ally_stats = ".$this->allianceData['ally_stats'].",
				ally_diplo = ".$this->allianceData['ally_diplo'].",
				ally_events = '".$this->allianceData['ally_events']."'
				WHERE id = ".$this->allianceData['id'].";");
			}
		} else {
			switch($textMode)
			{
				case 'internal':
					$text	= $this->allianceData['ally_text'];
				break;
				case 'apply':
					$text	= $this->allianceData['ally_request'];
				break;
				default:
					$text	= $this->allianceData['ally_description'];
				break;
			}
		}
		
		$this->tplObj->assign_vars(array(
			'RequestSelector'			=> array(0 => $LNG['al_requests_allowed'], 1 => $LNG['al_requests_not_allowed']),
			'YesNoSelector'				=> array(1 => $LNG['al_go_out_yes'], 0 => $LNG['al_go_out_no']),
			'textMode' 					=> $textMode,
			'text' 						=> $text,
			'ally_tag' 					=> $this->allianceData['ally_tag'],
			'ally_name'					=> $this->allianceData['ally_name'],
			'ally_web' 					=> $this->allianceData['ally_web'],
			'ally_image'				=> $this->allianceData['ally_image'],
			'ally_request_notallow' 	=> $this->allianceData['ally_request_notallow'],
			'ally_request_min_points'   => $this->allianceData['ally_request_min_points'],
			'ally_owner_range'			=> $this->allianceData['ally_owner_range'],
			'ally_stats_data'			=> $this->allianceData['ally_stats'],
			'ally_diplo_data'			=> $this->allianceData['ally_diplo'],
			'ally_events'				=> explode(',', $this->allianceData['ally_events']),
			'aviable_events'			=> $LNG['type_mission']
		));
		
		$this->display('page.alliance.admin.overview.tpl');
	}
	
	private function adminClose() {
		global $USER;
		if ($this->allianceData['ally_owner'] == $USER['id']) {
			$GLOBALS['DATABASE']->multi_query("UPDATE ".USERS." SET ally_id = '0' WHERE ally_id = ".$this->allianceData['id'].";
			UPDATE ".STATPOINTS." SET id_ally = '0' WHERE id_ally = ".$this->allianceData['id'].";
			DELETE FROM ".STATPOINTS." WHERE id_owner = ".$this->allianceData['id']." AND stat_type = 2;
			DELETE FROM ".ALLIANCE." WHERE id = ".$this->allianceData['id'].";
			DELETE FROM ".ALLIANCE_REQUEST." WHERE allianceID = ".$this->allianceData['id'].";
			DELETE FROM ".DIPLO." WHERE owner_1 = ".$this->allianceData['id']." OR owner_2 = ".$this->allianceData['id'].";
			DELETE FROM ".ALLYTOPIC." WHERE ally_id='".$this->allianceData['id']."';
			DELETE FROM ".TOPICANSWER." WHERE ally='".$this->allianceData['id']."';
			DELETE FROM ".ALLIBONUS." WHERE id='".$this->allianceData['id']."';
			");
		}
		
		$this->redirectToHome();
	}
	
	private function adminTransfer()
	{
		global $LNG, $USER;

		if($this->allianceData['ally_owner'] != $USER['id']){
			$this->redirectToHome();
			}
		$postleader = HTTP::_GP('newleader', 0);
		if (!empty($postleader))
		{
			$Rank = $GLOBALS['DATABASE']->getFirstRow("SELECT ally_rank_id FROM ".USERS." WHERE id = ".$postleader.";");
			$GLOBALS['DATABASE']->multi_query("UPDATE ".USERS." SET ally_rank_id = '".$Rank['ally_rank_id']."' WHERE id = '".$USER['id']."';
			UPDATE ".USERS." SET ally_rank_id = 0 WHERE id = ".$postleader.";UPDATE ".ALLIANCE." SET ally_owner = ".$postleader." WHERE id = ".$this->allianceData['id'].";");
			$this->redirectToHome();
		}
		else
		{
			$transferUserResult	= $GLOBALS['DATABASE']->query("SELECT u.id, r.rankName, u.username 
											  FROM ".USERS." u 
											  INNER JOIN ".ALLIANCE_RANK." r ON r.rankID = u.ally_rank_id AND r.TRANSFER = 1
											  WHERE u.ally_id = ".$this->allianceData['id']."
											  AND id != ".$this->allianceData['ally_owner'].";");
			$transferUserList	= array();

			while ($trasferUserRow = $GLOBALS['DATABASE']->fetch_array($transferUserResult))
			{
				$transferUserList[$trasferUserRow['id']]	= $trasferUserRow['username']." [".$trasferUserRow['rankName']."]";
			}
			
			$GLOBALS['DATABASE']->free_result($transferUserResult);

			$this->tplObj->assign_vars(array(
				'transferUserList'	=> $transferUserList,
			));	
			
			$this->display('page.alliance.admin.transfer.tpl');
		}
	}
	
	private function adminMangeApply()
	{
		global $LNG, $USER;
		if(!$this->rights['SEEAPPLY'] || !$this->rights['MANAGEAPPLY']) {
			$this->redirectToHome();
		}

		$applyResult	= $GLOBALS['DATABASE']->query("SELECT applyID, u.username, r.time FROM ".ALLIANCE_REQUEST." r INNER JOIN ".USERS." u ON r.userID = u.id WHERE r.allianceID = ".$this->allianceData['id'].";");
		$applyList		= array();
		
		while ($applyRow = $GLOBALS['DATABASE']->fetch_array($applyResult))
		{
			$applyList[]	= array(
				'username'	=> $applyRow['username'],
				'id'		=> $applyRow['applyID'],
				'time' 		=> _date($LNG['php_tdformat'], $applyRow['time'], $USER['timezone']),
			);
		}
		
		$GLOBALS['DATABASE']->free_result($applyResult);
		
		$this->tplObj->assign_vars(array(
			'applyList'		=> $applyList,
		));
		
		$this->display('page.alliance.admin.mangeApply.tpl');
	}
	
	private function adminDetailApply()
	{
		global $LNG, $USER;
    if(!$this->rights['SEEAPPLY'] || !$this->rights['MANAGEAPPLY']) {
        $this->redirectToHome();
    }

    $id    = HTTP::_GP('id', 0);

    $sql = "
    SELECT
        r.`applyID`, 
        r.`time`, 
        r.`text`, 
        u.`username`, 
        u.`register_time`, 
        u.`onlinetime`,
        u.`galaxy`,
        u.`system`,
        u.`planet`,
        CONCAT_WS(':', u.`galaxy`, u.`system`, u.`planet`) AS `coordinates`,
        @total_fights := u.`wons` + u.`loos` + u.`draws`,
        @total_fights_percentage := @total_fights / 100,
        @total_fights AS `total_fights`,
        u.`wons`,
        ROUND(u.`wons` / @total_fights_percentage, 2) AS `wons_percentage`,
        u.`loos`,
        ROUND(u.`loos` / @total_fights_percentage, 2) AS `loos_percentage`,
        u.`draws`,
        ROUND(u.`draws` / @total_fights_percentage, 2) AS `draws_percentage`,
        u.`kbmetal`,
        u.`kbcrystal`,
        u.`lostunits`,
        u.`desunits`,
        stat.`tech_rank`, 
        stat.`tech_points`,
        stat.`build_rank`, 
        stat.`build_points`, 
        stat.`defs_rank`, 
        stat.`defs_points`, 
        stat.`fleet_rank`, 
        stat.`fleet_points`,
        stat.`total_rank`,
        stat.`total_points`,
        p.`name`
    FROM 
        ". ALLIANCE_REQUEST ." AS r 
    LEFT JOIN 
        ". USERS ." AS u ON r.userID = u.id 
    INNER JOIN 
        ". STATPOINTS ." AS stat 
    LEFT JOIN 
        ". PLANETS ." AS p ON p.id = u.id_planet
    WHERE 
        applyID = ". $id .";";
    
    $applyDetail = $GLOBALS['DATABASE']->uniquequery($sql);

    if(empty($applyDetail)) {
        $this->printMessage($LNG['al_apply_not_exists']);
    }
    
    require_once(ROOT_PATH.'includes/functions/BBCode.php');
    $applyDetail['text']    = bbcode($applyDetail['text']);
    $applyDetail['kbmetal']    = pretty_number($applyDetail['kbmetal']);
    $applyDetail['kbcrystal']    = pretty_number($applyDetail['kbcrystal']);
    $applyDetail['lostunits']    = pretty_number($applyDetail['lostunits']);
    $applyDetail['desunits']    = pretty_number($applyDetail['desunits']);
    
    $this->tplObj->assign_vars(array(
        'applyDetail'        => $applyDetail,
        'apply_time'        => _date($LNG['php_tdformat'], $applyDetail['time'], $USER['timezone']),
        'register_time'        => _date($LNG['php_tdformat'], $applyDetail['register_time'], $USER['timezone']),
        'onlinetime'        => _date($LNG['php_tdformat'], $applyDetail['onlinetime'], $USER['timezone']),
    ));
    
    $this->display('page.alliance.admin.detailApply.tpl');
	}
	
	private function adminSendAnswerToApply()
	{
		global $LNG, $USER;
		if(!$this->rights['SEEAPPLY'] || !$this->rights['MANAGEAPPLY']) {
			$this->redirectToHome();
		}
	

		$text  		= makebr(HTTP::_GP('text', '', true));
		$answer		= HTTP::_GP('answer', '');
		
		$applyID	= HTTP::_GP('id', 0);
		$userID 	= $GLOBALS['DATABASE']->getFirstCell("SELECT id FROM ".ALLIANCE_REQUEST." LEFT JOIN ".USERS." ON userID = id WHERE applyID = ".$applyID.";");

		if ($answer == 'yes')
		{
			$GLOBALS['DATABASE']->multi_query("
				DELETE FROM ".ALLIANCE_REQUEST." WHERE applyID = ".$applyID.";
				UPDATE ".USERS." SET ally_id = ".$this->allianceData['id'].", ally_register_time = ".TIMESTAMP.", ally_rank_id = 0 WHERE id = ".$userID.";
				UPDATE ".STATPOINTS." SET id_ally = ".$this->allianceData['id']." WHERE id_owner = ".$userID." AND stat_type = 1;
				UPDATE ".ALLIANCE." SET ally_members = (SELECT COUNT(*) FROM ".USERS." WHERE ally_id = ".$this->allianceData['id'].") WHERE id = ".$this->allianceData['id'].";");

			SendSimpleMessage($userID, $USER['id'], TIMESTAMP, 2, $this->allianceData['ally_tag'], $LNG['al_you_was_acceted'] . $this->allianceData['ally_name'], $LNG['al_hi_the_alliance'] . $this->allianceData['ally_name'] . $LNG['al_has_accepted'] . $text);
		}
		elseif($answer == 'no')
		{
			$GLOBALS['DATABASE']->query("DELETE FROM ".ALLIANCE_REQUEST." WHERE applyID = ".$applyID.";");
			SendSimpleMessage($userID, $USER['id'], TIMESTAMP, 2, $this->allianceData['ally_tag'], $LNG['al_you_was_declined'] . $this->allianceData['ally_name'], $LNG['al_hi_the_alliance'] . $this->allianceData['ally_name'] . $LNG['al_has_declined'] . $text);
		}

		$this->redirectTo('game.php?page=alliance&mode=admin&action=mangeApply');
	}
	
	private function adminPermissions()
	{	
		if(!$this->rights['RANKS']) {
			$this->redirectToHome();
		}
		
		$rankResult	= $GLOBALS['DATABASE']->query("SELECT * FROM ".ALLIANCE_RANK." WHERE allianceID = ".$this->allianceData['id'].";");
		$rankList	= array();
		
		while($rankRow = $GLOBALS['DATABASE']->fetch_array($rankResult))
			$rankList[$rankRow['rankID']]	= $rankRow;
		
		$GLOBALS['DATABASE']->free_result($rankResult);

		$this->tplObj->assign_vars(array(
			'rankList'		=> $rankList,
			'ownRights'		=> $this->rights,
			'avalibleRanks'	=> $this->avalibleRanks,
		));	

		$this->display('page.alliance.admin.permissions.tpl');
	}
	
	private function adminPermissionsSend()
	{	
		if(!$this->rights['RANKS']) {
			$this->redirectToHome();
		}
		
		$newrank	= HTTP::_GP('newrank', array(), true);
		$delete		= HTTP::_GP('deleteRank', 0);
		$rankData	= HTTP::_GP('rank', array());
		
		if(!empty($newrank['rankName'])) 
		{
			$sql = "INSERT INTO `".ALLIANCE_RANK."` SET "; 

			foreach($newrank as $key => $value)
				$sql .= "`" . $GLOBALS['DATABASE']->sql_escape($key) ."` = '" . $GLOBALS['DATABASE']->sql_escape($value) . "',";
		
			$sql .= "`allianceID` = ".$this->allianceData['id']."";
				
			$GLOBALS['DATABASE']->query($sql);
		} else {
			if(!empty($delete)) 
			{
				$GLOBALS['DATABASE']->query("DELETE FROM ".ALLIANCE_RANK." WHERE rankID = ".$delete." AND allianceID = ".$this->allianceData['id'].";");
				$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET ally_rank_id = 0 WHERE ally_rank_id = ".$delete." AND ally_id = ".$this->allianceData['id'].";");
			}
			else
			{
				$Query = '';
				foreach ($rankData as $k => $rankRow)
				{
					$SQL	= array();
					foreach($this->avalibleRanks as $rankName) 
					{
						if(!$this->rights[$rankName])
							continue;
						
						$SQL[]	= $rankName." = ".(isset($rankRow[$rankName]) ? 1 : 0);
					}
					$SQL[]	= "rankName = '".$GLOBALS['DATABASE']->sql_escape($rankRow['name'])."'";
					$Query .= "UPDATE ".ALLIANCE_RANK." SET ".implode(", ", $SQL)." WHERE rankID = ".((int) $GLOBALS['DATABASE']->sql_escape($k))." AND allianceID = ".$this->allianceData['id'].";";
				}
				$GLOBALS['DATABASE']->multi_query($Query);
			}
		}
		
		$this->redirectTo('game.php?page=alliance&mode=admin&action=permissions');
	}
	
	private function adminMembers()
	{
		global $USER, $LNG;
		if (!$this->rights['MANAGEUSERS']) {
			$this->redirectToHome();
		}
		
		$rankResult		= $GLOBALS['DATABASE']->query("SELECT rankID, rankName FROM ".ALLIANCE_RANK." WHERE allianceID = ".$this->allianceData['id'].";");
		$rankList		= array();
		$rankList[0]	= $LNG['al_new_member_rank_text'];
		
		while($rankRow = $GLOBALS['DATABASE']->fetch_array($rankResult))
			$rankList[$rankRow['rankID']]	= $rankRow['rankName'];
		
		$GLOBALS['DATABASE']->free_result($rankResult);
		
		$memberListResult = $GLOBALS['DATABASE']->query("SELECT DISTINCT u.id, u.username,u.galaxy, u.system, u.planet, u.ally_register_time, u.onlinetime, u.ally_rank_id, s.total_points 
										FROM ".USERS." u
										LEFT JOIN ".STATPOINTS." as s ON s.stat_type = '1' AND s.id_owner = u.id 
										WHERE ally_id = ".$this->allianceData['id'].";");

		$memberList	= array();
										
		while ($memberListRow = $GLOBALS['DATABASE']->fetch_array($memberListResult))
		{
			if ($this->allianceData['ally_owner'] == $memberListRow['id'])
				$memberListRow['ally_rank_id'] = -1;
			elseif ($memberListRow['ally_rank_id'] != 0)
				$memberListRow['ally_rank_id'] = $memberListRow['ally_rank_id'];
			else
				$memberListRow['ally_rank_id'] = 0;
			
			$memberList[$memberListRow['id']]	= array(
				'username'		=> $memberListRow['username'],
				'galaxy'		=> $memberListRow['galaxy'],
				'system'		=> $memberListRow['system'],
				'planet'		=> $memberListRow['planet'],
				'register_time'	=> _date($LNG['php_tdformat'], $memberListRow['ally_register_time'], $USER['timezone']),
				'points'		=> $memberListRow['total_points'],
				'rankID'		=> $memberListRow['ally_rank_id'],
				'onlinetime'	=> floor((TIMESTAMP - $memberListRow['onlinetime']) / 60),
				'kickQuestion'	=> sprintf($LNG['al_kick_player'], $memberListRow['username'])
			);
		}
		
		$GLOBALS['DATABASE']->free_result($memberListResult);
			
		$this->tplObj->assign_vars(array(
			'memberList'	=> $memberList,
			'rankList'		=> $rankList,
			'founder'		=> empty($this->allianceData['ally_owner_range']) ? $LNG['al_founder_rank_text'] : $this->allianceData['ally_owner_range'],
			'al_users_list'	=> sprintf($LNG['al_users_list'], count($memberList)),
			'canKick'		=> $this->rights['KICK'],
		));
		
		$this->display('page.alliance.admin.members.tpl');
	}
	
	private function adminMembersSave()
	{
		global $USER, $LNG;
		if (!$this->rights['MANAGEUSERS']) {
			$this->redirectToHome();
		}
		
		$rankResult		= $GLOBALS['DATABASE']->query("SELECT rankID, ".implode(", ", $this->avalibleRanks)." FROM ".ALLIANCE_RANK." WHERE allianceID = ".$this->allianceData['id'].";");
		$rankList		= array();
		$rankList[0]	= array_combine($this->avalibleRanks, array_fill(0, count($this->avalibleRanks), true));
		
		while($rankRow = $GLOBALS['DATABASE']->fetch_array($rankResult))
			$rankList[$rankRow['rankID']]	= $rankRow;
			
		$userRanks	= HTTP::_GP('rank', array());
		foreach($userRanks as $userID => $rankID) {
			if($userID == $this->allianceData['ally_owner'] || !isset($rankList[$rankID])) {
				continue;
			}
			
			unset($rankList[$rankID]['rankID']);
			
			foreach($rankList[$rankID] as $permission => $value) {
				if($this->rights[$permission] < $value)
					continue;
			}
			
			$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET ally_rank_id = ".((int) $rankID)." WHERE id = ".((int) $userID)." AND ally_id = ".$this->allianceData['id'].";");
		}
		
		$this->redirectTo('game.php?page=alliance&mode=admin&action=members');
	}
	
	private function adminMembersKick()
	{
		global $USER, $LNG;
		if (!$this->rights['KICK']) {
			$this->redirectToHome();
		}
		
		$id	= HTTP::_GP('id', 0);
		
		$GLOBALS['DATABASE']->multi_query("
		UPDATE ".USERS." SET ally_id = 0, ally_register_time = 0, ally_rank_id = 0 WHERE id = ".$id.";
		UPDATE ".STATPOINTS." SET id_ally = 0 WHERE id_owner = ".$id." AND stat_type = 1;
		UPDATE ".ALLIANCE." SET ally_members = (SELECT COUNT(*) FROM ".USERS." WHERE ally_id = ".$this->allianceData['id'].") WHERE id = ".$this->allianceData['id'].";");
		
		$this->redirectTo('game.php?page=alliance&mode=admin&action=members');
	}
	
	private function adminDiplomacy()
	{
		global $USER, $LNG;
		if (!$this->rights['DIPLOMATIC']) {
			$this->redirectToHome();
		}
		
		$diploList	= array(
			0 => array(
				1 => array(),
				2 => array(),
				3 => array(),
				4 => array(),
				5 => array(),
				6 => array()
			),
			1 => array(
				1 => array(),
				2 => array(),
				3 => array(),
				4 => array(),
				5 => array(),
				6 => array()
			),
			2 => array(
				1 => array(),
				2 => array(),
				3 => array(),
				4 => array(),
				5 => array(),
				6 => array()
			)
		);
		
		$diploResult	= $GLOBALS['DATABASE']->query("SELECT d.id, d.level, d.accept, d.owner_1, d.owner_2, a.ally_name FROM ".DIPLO." d
		INNER JOIN ".ALLIANCE." a ON IF(".$this->allianceData['id']." = d.owner_1, a.id = d.owner_2, a.id = d.owner_1)
		WHERE owner_1 = ".$this->allianceData['id']." OR owner_2 = ".$this->allianceData['id'].";");
		
		while($diploRow = $GLOBALS['DATABASE']->fetch_array($diploResult)) {
			$own	= $diploRow['owner_1'] == $this->allianceData['id'];
			if($diploRow['accept'] == 1) {
				$diploList[0][$diploRow['level']][$diploRow['id']] = $diploRow['ally_name'];
			} elseif($own) {
				$diploList[2][$diploRow['level']][$diploRow['id']] = $diploRow['ally_name'];
			} else {
				$diploList[1][$diploRow['level']][$diploRow['id']] = $diploRow['ally_name'];
			}
		}
		
		
		$this->tplObj->assign_vars(array(
			'diploList'	=> $diploList,
		));
		
		$this->display('page.alliance.admin.diplomacy.default.tpl');
	}
	
	private function adminDiplomacyAccept()
	{
		if (!$this->rights['DIPLOMATIC']) {
			$this->redirectToHome();
		}
		
		$GLOBALS['DATABASE']->query("UPDATE ".DIPLO." SET accept = 1 WHERE id = ".HTTP::_GP('id', 0)." AND owner_2 = ".$this->allianceData['id'].";");
		$this->redirectTo('game.php?page=alliance&mode=admin&action=diplomacy');
	}
	
	private function adminDiplomacyDelete()
	{
		if (!$this->rights['DIPLOMATIC']) {
			$this->redirectToHome();
		}
		
		$GLOBALS['DATABASE']->query("DELETE FROM ".DIPLO." WHERE id = ".HTTP::_GP('id', 0)." AND (owner_1 = ".$this->allianceData['id']." OR owner_2 = ".$this->allianceData['id'].");");
		$this->redirectTo('game.php?page=alliance&mode=admin&action=diplomacy');
	}
	
	private function adminDiplomacyCreate()
	{
		global $USER, $LNG;
		if (!$this->rights['DIPLOMATIC']) {
			$this->redirectToHome();
		}
		
		$this->initTemplate();
		$this->setWindow('popup');
		
		$diploMode	= HTTP::_GP('diploMode', 0);
		
		$diploAlly	= $GLOBALS['DATABASE']->query("SELECT ally_tag,ally_name,id FROM ".ALLIANCE." WHERE id != ".$USER['ally_id']." ORDER BY ally_tag ASC;");
		$AllyList = array();
		$IdList = array();
		while ($i = $GLOBALS['DATABASE']->fetch_array($diploAlly))
		{
			$IdList[] = $i['id'];
			$AllyList[] = $i['ally_name'];
		}
		$this->tplObj->assign_vars(array(
			'diploMode'	=> $diploMode,
			'AllyList'	=> $AllyList,
			'IdList'	=> $IdList,
		));
		
		$this->display('page.alliance.admin.diplomacy.create.tpl');
	}
	
	private function adminDiplomacyCreateProcessor()
	{
		global $UNI, $LNG, $USER;
		if (!$this->rights['DIPLOMATIC']) {
			$this->redirectToHome();
		}
		
		$id	= HTTP::_GP('ally_id', '', UTF8_SUPPORT);
		
		$targetAlliance	= $GLOBALS['DATABASE']->getFirstRow("SELECT id, ally_name, ally_owner, ally_tag, (SELECT level FROM ".DIPLO." WHERE (owner_1 = ".$GLOBALS['DATABASE']->sql_escape($id)." AND owner_2 = ".$USER['ally_id'].") OR (owner_2 = ".$GLOBALS['DATABASE']->sql_escape($id)." AND owner_1 = ".$USER['ally_id'].")) as diplo FROM ".ALLIANCE." WHERE ally_universe = ".$UNI." AND id = '".$GLOBALS['DATABASE']->sql_escape($id)."';");
		
		if(empty($targetAlliance)) {
			$this->sendJSON(array(
				'error'		=> true,
				'message'	=> sprintf($LNG['al_diplo_no_alliance'], $targetAlliance['id']),
			));	
		}
		
		if(!empty($targetAlliance['diplo'])) {
			$this->sendJSON(array(
				'error'		=> true,
				'message'	=> sprintf($LNG['al_diplo_exists'], $targetAlliance['ally_name']),
			));	
		}
		if($targetAlliance['id'] == $this->allianceData['id']) {
			$this->sendJSON(array(
				'error'		=> true,
				'message'	=> $LNG['al_diplo_same_alliance'],
			));	
		}
		
		$this->setWindow('ajax');
		
		$level	= HTTP::_GP('level', 0);
		$text	= HTTP::_GP('text', '', true);
		
		if($level == 5)
		{
			SendSimpleMessage($targetAlliance['ally_owner'], $USER['id'], TIMESTAMP, 1, $LNG['al_circular_alliance'].$this->allianceData['ally_tag'], $LNG['al_diplo_war'], sprintf($LNG['al_diplo_war_mes'], "[".$this->allianceData['ally_tag']."] ".$this->allianceData['ally_name'], "[".$targetAlliance['ally_tag']."] ".$targetAlliance['ally_name'], $LNG['al_diplo_level'][$level], $text));
		}
		else
		{
			SendSimpleMessage($targetAlliance['ally_owner'], $USER['id'], TIMESTAMP, 1, $LNG['al_circular_alliance'].$this->allianceData['ally_tag'], $LNG['al_diplo_ask'], sprintf($LNG['al_diplo_ask_mes'], $LNG['al_diplo_level'][$level], "[".$this->allianceData['ally_tag']."] ".$this->allianceData['ally_name'], "[".$targetAlliance['ally_tag']."] ".$targetAlliance['ally_name'], $text));
		}
		
		$GLOBALS['DATABASE']->query("INSERT INTO ".DIPLO." SET 
			owner_1		= ".$this->allianceData['id'].",
			owner_2		= ".$targetAlliance['id'].", 
			level		= ".$level.", 
			accept		= 0, 
			accept_text	= '".$GLOBALS['DATABASE']->sql_escape($text)."', 
			universe	= ".$UNI.";");
		
		$this->sendJSON(array(
			'error'		=> false,
			'message'	=> $LNG['al_diplo_create_done'],
		));
	}

	function buyModul(){
		global $UNI, $LNG, $USER;
		if($USER['ally_id'] != 0){
			if(!$this->rights['SEEAPPLY'] || !$this->rights['MANAGEAPPLY']) {
        		$this->redirectToHome();
    		}
			$sql = "SELECT * FROM ".ALLIANCE." WHERE id='".$USER['ally_id']."'";
			$result = $GLOBALS['DATABASE']->query($sql);
			foreach ($result as $data){
				$ally_m = $data['ally_met'];
				$ally_k = $data['ally_krist'];
				$ally_d = $data['ally_deut'];
			}
			$sql = "SELECT * FROM ".ALLIBONUS." WHERE id='".$USER['ally_id']."'";
			$result = $GLOBALS['DATABASE']->query($sql);
			foreach ($result as $data){
				$one 	= $data['slots'];
				$two 	= $data['produktion'];
				$tree 	= $data['research'];
				$four 	= $data['building'];
				$five 	= $data['defense'];
				$six 	= $data['attack'];
				$seven	= $data['topics'];
				$d_1	= $data['act_slo'];
				$d_2	= $data['act_pro'];
				$d_3	= $data['act_res'];
				$d_4	= $data['act_bui'];
				$d_5	= $data['act_def'];
				$d_6	= $data['act_att'];
				$d_7	= $data['act_top'];
			}
			//Hilfsvariablen
			$one_h = $one;
			$two_h = $two;
			$tree_h = $tree;
			$four_h = $four;
			$five_h = $five;
			$six_h = $six;
			$seven_h = $seven;
			// Kontrolle ob modul deaktiviert ist
			$d_1 == 0 ? $deak_1 = false : $deak_1 = true;
			$d_2 == 0 ? $deak_2 = false : $deak_2 = true;
			$d_3 == 0 ? $deak_3 = false : $deak_3 = true;
			$d_4 == 0 ? $deak_4 = false : $deak_4 = true;
			$d_5 == 0 ? $deak_5 = false : $deak_5 = true;
			$d_6 == 0 ? $deak_6 = false : $deak_6 = true;
			$d_7 == 0 ? $deak_7 = false : $deak_7 = true;
			//Kontrolle das mindestens LvL 1 einen Preis hat
			$one == 0 ? $one = 1 : $one = $one;
			$two == 0 ? $two = 1 : $two = $two;
			$tree == 0 ? $tree = 1 : $tree = $tree;
			$four == 0 ? $four = 1 : $four = $four;
			$five == 0 ? $five = 1 : $five = $five;
			$six == 0 ? $six = 1 : $six = $six;
			$seven == 0 ? $seven = 1 : $seven = $seven;
			//Kosten für einen Slot
			$price_one_m = ceil(((($one*$one)*12500)/7)*sqrt(19*$one));
			$price_one_k = ceil(((($one*$one)*22500)/7)*sqrt(17*$one));
			$price_one_d = ceil(((($one*$one)*15500)/7)*sqrt(13*$one));
			//Kosten für 1% Produktions Steigerung
			$price_two_m = ceil(((($two*$two)*17500)/7)*sqrt(19*$two));
			$price_two_k = ceil(((($two*$two)*27500)/7)*sqrt(17*$two));
			$price_two_d = ceil(((($two*$two)*25500)/7)*sqrt(13*$two));
			//Kosten für 1% schnellere Forschung
			$price_tree_m = ceil(((($tree*$tree)*11568)/7)*sqrt(19*$tree));
			$price_tree_k = ceil(((($tree*$tree)*15179)/7)*sqrt(17*$tree));
			$price_tree_d = ceil(((($tree*$tree)*10378)/7)*sqrt(13*$tree));
			//Kosten für 1% schnelleres Bauen
			$price_four_m = ceil(((($four*$four)*25502)/7)*sqrt(19*$four));
			$price_four_k = ceil(((($four*$four)*27568)/7)*sqrt(17*$four));
			$price_four_d = ceil(((($four*$four)*23719)/7)*sqrt(13*$four));
			//Kosten für 1% mehr Verteidigung
			$price_five_m = ceil(((($five*$five)*12500)/7)*sqrt(19*$five));
			$price_five_k = ceil(((($five*$five)*15500)/7)*sqrt(17*$five));
			$price_five_d = ceil(((($five*$five)*17500)/7)*sqrt(13*$five));
			//Kosten für 1% mehr Angriffskraft
			$price_six_m = ceil(((($six*$six)*15500)/7)*sqrt(19*$six));
			$price_six_k = ceil(((($six*$six)*17500)/7)*sqrt(17*$six));
			$price_six_d = ceil(((($six*$six)*12500)/7)*sqrt(13*$six));
			//Kosten für 5 neue Topics
			$price_seven_m = ceil(((($seven*$seven)*19282)/7)*sqrt(18*$seven));
			$price_seven_k = ceil(((($seven*$seven)*25634)/7)*sqrt(21*$seven));
			$price_seven_d = ceil(((($seven*$seven)*19246)/7)*sqrt(11*$seven));
				
			$this->tplObj->assign_vars(array(
				'error'			=> false,
				'one_akt'		=> $one_h,
				'one_max'		=> $this->Slots_max,
				'one_m'			=> $price_one_m." Metall <br/>",
				'one_k'			=> $price_one_k." Kristall <br/>",
				'one_d'			=> $price_one_d." Deuterium",
				'two_akt'		=> $two_h,
				'two_max'		=> $this->Produ_max,
				'two_m'			=> $price_two_m." Metall <br/>",
				'two_k'			=> $price_two_k." Kristall <br/>",
				'two_d'			=> $price_two_d." Deuterium",
				'tree_akt'		=> $tree_h,
				'tree_max'		=> $this->Build_max,
				'tree_m'		=> $price_tree_m." Metall <br/>",
				'tree_k'		=> $price_tree_k." Kristall <br/>",
				'tree_d'		=> $price_tree_d." Deuterium",
				'four_akt'		=> $four_h,
				'four_max'		=> $this->Reser_max,
				'four_m'		=> $price_four_m." Metall <br/>",
				'four_k'		=> $price_four_k." Kristall <br/>",
				'four_d'		=> $price_four_d." Deuterium",
				'five_akt'		=> $five_h,
				'five_max'		=> $this->Defen_max,
				'five_m'		=> $price_five_m." Metall <br/>",
				'five_k'		=> $price_five_k." Kristall <br/>",
				'five_d'		=> $price_five_d." Deuterium",
				'six_akt'		=> $six_h,
				'six_max'		=> $this->Attak_max,
				'six_m'			=> $price_six_m." Metall <br/>",
				'six_k'			=> $price_six_k." Kristall <br/>",
				'six_d'			=> $price_six_d." Deuterium",
				'seven_akt'		=> $seven_h,
				'seven_max'		=> $this->Topics_max,
				'seven_m'		=> $price_seven_m." Metall <br/>",
				'seven_k'		=> $price_seven_k." Kristall <br/>",
				'seven_d'		=> $price_seven_d." Deuterium",
				'deakt_one'		=> $deak_1,
				'deakt_two'		=> $deak_2,
				'deakt_tree'	=> $deak_3,
				'deakt_four'	=> $deak_4,
				'deakt_five'	=> $deak_5,
				'deakt_six'		=> $deak_6,
				'deakt_seven'	=> $deak_7,

		));
		$this->display('allyBonus_buy_one.tpl');
		}
	}

	function buymod(){
		global $UNI, $LNG, $USER;
			if(!$this->rights['SEEAPPLY'] || !$this->rights['MANAGEAPPLY']) {
        		$this->redirectToHome();
    		}
			$sql = "SELECT * FROM ".ALLIANCE." WHERE id='".$USER['ally_id']."'";
			$result = $GLOBALS['DATABASE']->query($sql);
			foreach ($result as $data){
				$ally_m = $data['ally_met'];
				$ally_k = $data['ally_krist'];
				$ally_d = $data['ally_deut'];
			}
			$sql = "SELECT * FROM ".ALLIBONUS." WHERE id='".$USER['ally_id']."'";
			$result = $GLOBALS['DATABASE']->query($sql);
			foreach ($result as $data){
				$one 	= $data['slots'];
				$two 	= $data['produktion'];
				$tree 	= $data['research'];
				$four 	= $data['building'];
				$five 	= $data['defense'];
				$six 	= $data['attack'];
				$seven	= $data['topics'];
				$d_1	= $data['act_slo'];
				$d_2	= $data['act_pro'];
				$d_3	= $data['act_res'];
				$d_4	= $data['act_bui'];
				$d_5	= $data['act_def'];
				$d_6	= $data['act_att'];
				$d_7	= $data['act_top'];
			}
			//Hilfsvariablen
			$one_h = $one;
			$two_h = $two;
			$tree_h = $tree;
			$four_h = $four;
			$five_h = $five;
			$six_h = $six;
			$seven_h = $seven;
			// Kontrolle ob modul deaktiviert ist
			$d_1 == 0 ? $deak_1 = false : $deak_1 = true;
			$d_2 == 0 ? $deak_2 = false : $deak_2 = true;
			$d_3 == 0 ? $deak_3 = false : $deak_3 = true;
			$d_4 == 0 ? $deak_4 = false : $deak_4 = true;
			$d_5 == 0 ? $deak_5 = false : $deak_5 = true;
			$d_6 == 0 ? $deak_6 = false : $deak_6 = true;
			$d_7 == 0 ? $deak_7 = false : $deak_7 = true;
			//Kontrolle das mindestens LvL 1 einen Preis hat
			$one == 0 ? $one = 1 : $one = $one;
			$two == 0 ? $two = 1 : $two = $two;
			$tree == 0 ? $tree = 1 : $tree = $tree;
			$four == 0 ? $four = 1 : $four = $four;
			$five == 0 ? $five = 1 : $five = $five;
			$six == 0 ? $six = 1 : $six = $six;
			$seven == 0 ? $seven = 1 : $seven = $seven;
			//Kosten für einen Slot
			$price_one_m = ceil(((($one*$one)*12500)/7)*sqrt(19*$one));
			$price_one_k = ceil(((($one*$one)*22500)/7)*sqrt(17*$one));
			$price_one_d = ceil(((($one*$one)*15500)/7)*sqrt(13*$one));
			//Kosten für 1% Produktions Steigerung
			$price_two_m = ceil(((($two*$two)*17500)/7)*sqrt(19*$two));
			$price_two_k = ceil(((($two*$two)*27500)/7)*sqrt(17*$two));
			$price_two_d = ceil(((($two*$two)*25500)/7)*sqrt(13*$two));
			//Kosten für 1% schnellere Forschung
			$price_tree_m = ceil(((($tree*$tree)*11568)/7)*sqrt(19*$tree));
			$price_tree_k = ceil(((($tree*$tree)*15179)/7)*sqrt(17*$tree));
			$price_tree_d = ceil(((($tree*$tree)*10378)/7)*sqrt(13*$tree));
			//Kosten für 1% schnelleres Bauen
			$price_four_m = ceil(((($four*$four)*25502)/7)*sqrt(19*$four));
			$price_four_k = ceil(((($four*$four)*27568)/7)*sqrt(17*$four));
			$price_four_d = ceil(((($four*$four)*23719)/7)*sqrt(13*$four));
			//Kosten für 1% mehr Verteidigung
			$price_five_m = ceil(((($five*$five)*12500)/7)*sqrt(19*$five));
			$price_five_k = ceil(((($five*$five)*15500)/7)*sqrt(17*$five));
			$price_five_d = ceil(((($five*$five)*17500)/7)*sqrt(13*$five));
			//Kosten für 1% mehr Angriffskraft
			$price_six_m = ceil(((($six*$six)*15500)/7)*sqrt(19*$six));
			$price_six_k = ceil(((($six*$six)*17500)/7)*sqrt(17*$six));
			$price_six_d = ceil(((($six*$six)*12500)/7)*sqrt(13*$six));
			//Kosten für 5 neue Topics
			$price_seven_m = ceil(((($seven*$seven)*19282)/7)*sqrt(18*$seven));
			$price_seven_k = ceil(((($seven*$seven)*25634)/7)*sqrt(21*$seven));
			$price_seven_d = ceil(((($seven*$seven)*19246)/7)*sqrt(11*$seven));

			if(!isset($_POST['what'])){
				$_POST['what'] = 0;
			}
			$what = $_POST['what'];
			switch ($what){
				case 1: if($ally_m < $price_one_m){
							$error = false;
							$msg = $LNG['winemp_allyBonus_Error_M'];	
							break;
						}
						elseif ($ally_k < $price_one_k){
							$error = false;
							$msg = $LNG['winemp_allyBonus_Error_K'];
							break;	
						}
						elseif ($ally_d < $price_one_d){
							$error = false;
							$msg = $LNG['winemp_allyBonus_Error_D'];
							break;
						}
						else{
							$ally_m -= $price_one_m;
							$ally_k -= $price_one_k;
							$ally_d -= $price_one_d;
							$SQL = "UPDATE ".ALLIANCE." SET ally_met='".$ally_m."', ally_krist='".$ally_k."', ally_deut='".$ally_d."' WHERE id ='".$USER['ally_id']."'"; 
							$sql = "UPDATE ".ALLIBONUS." SET slots= slots+1 WHERE id='".$USER['ally_id']."'";;
							$GLOBALS['DATABASE']->query($SQL);
							$GLOBALS['DATABASE']->query($sql);
							$error = false;
							$msg = $LNG['winemp_allyBonus_allOkay'];
							break;
						}
				case 2: if($ally_m < $price_two_m){
							$error = false;
							$msg = $LNG['winemp_allyBonus_Error_M'];
							break;
						}
						elseif ($ally_k < $price_two_k){
							$error = false;
							$msg = $LNG['winemp_allyBonus_Error_K'];
							break;	
						}
						elseif ($ally_d < $price_two_d){
							$error = false;
							$msg = $LNG['winemp_allyBonus_Error_D'];
							break;
						}
						else{
							$ally_m -= $price_two_m;
							$ally_k -= $price_two_k;
							$ally_d -= $price_two_d;
							$SQL = "UPDATE ".ALLIANCE." SET ally_met='".$ally_m."', ally_krist='".$ally_k."', ally_deut='".$ally_d."' WHERE id ='".$USER['ally_id']."'"; 
							$sql = "UPDATE ".ALLIBONUS." SET produktion= produktion +1 WHERE id='".$USER['ally_id']."'";
							$GLOBALS['DATABASE']->query($SQL);
							$GLOBALS['DATABASE']->query($sql);
							$error = false;
							$msg = $LNG['winemp_allyBonus_allOkay'];
							break;
						}
				case 3: if($ally_m < $price_tree_m){
							$error = false;
							$msg = $LNG['winemp_allyBonus_Error_M'];
							break;
						}
						elseif ($ally_k < $price_tree_k){
							$error = false;
							$msg = $LNG['winemp_allyBonus_Error_K'];
							break;	
						}
						elseif ($ally_d < $price_tree_d){
							$error = false;
							$msg = $LNG['winemp_allyBonus_Error_D'];
							break;
						}
						else{
							$ally_m -= $price_tree_m;
							$ally_k -= $price_tree_k;
							$ally_d -= $price_tree_d;
							$SQL = "UPDATE ".ALLIANCE." SET ally_met='".$ally_m."', ally_krist='".$ally_k."', ally_deut='".$ally_d."' WHERE id ='".$USER['ally_id']."'"; 
							$sql = "UPDATE ".ALLIBONUS." SET research = research +1 WHERE id='".$USER['ally_id']."'";
							$GLOBALS['DATABASE']->query($SQL);
							$GLOBALS['DATABASE']->query($sql);
							$error = false;
							$msg = $LNG['winemp_allyBonus_allOkay'];
							break;
						}
				case 4: if($ally_m < $price_four_m){
							$error = false;
							$msg = $LNG['winemp_allyBonus_Error_M'];
							break;
						}
						elseif ($ally_k < $price_four_k){
							$error = false;
							$msg = $LNG['winemp_allyBonus_Error_K'];
							break;	
						}
						elseif ($ally_d < $price_four_d){
							$error = false;
							$msg = $LNG['winemp_allyBonus_Error_D'];
							break;
						}
						else{
							$ally_m -= $price_four_m;
							$ally_k -= $price_four_k;
							$ally_d -= $price_four_d;
							$SQL = "UPDATE ".ALLIANCE." SET ally_met='".$ally_m."', ally_krist='".$ally_k."', ally_deut='".$ally_d."' WHERE id ='".$USER['ally_id']."'"; 
							$sql = "UPDATE ".ALLIBONUS." SET building= building +1 WHERE id='".$USER['ally_id']."'";
							$GLOBALS['DATABASE']->query($SQL);
							$GLOBALS['DATABASE']->query($sql);
							$error = false;
							$msg = $LNG['winemp_allyBonus_allOkay'];
							break;
						}
				case 5: if($ally_m < $price_five_m){
							$error = false;
							$msg = $LNG['winemp_allyBonus_Error_K'];
							break;
						}
						elseif ($ally_k < $price_five_k){
							$error = false;
							$msg = $LNG['winemp_allyBonus_Error_D'];
							break;	
						}
						elseif ($ally_d < $price_five_d){
							$error = false;
							$msg = $LNG['winemp_allyBonus_allOkay'];
							break;
						}
						else{
						$ally_m -= $price_five_m;
						$ally_k -= $price_five_k;
						$ally_d -= $price_five_d;
						$SQL = "UPDATE ".ALLIANCE." SET ally_met='".$ally_m."', ally_krist='".$ally_k."', ally_deut='".$ally_d."' WHERE id ='".$USER['ally_id']."'"; 
						$sql = "UPDATE ".ALLIBONUS." SET defense = defense + 1 WHERE id='".$USER['ally_id']."'";
						$GLOBALS['DATABASE']->query($SQL);
						$GLOBALS['DATABASE']->query($sql);								
						$error = false;
						$msg = $LNG['winemp_allyBonus_allOkay'];
						break;
						}
				case 6: if($ally_m < $price_six_m){
							$error = false;
							$msg = $LNG['winemp_allyBonus_Error_M'];
							break;
						}
						elseif ($ally_k < $price_six_k){
							$error = false;
							$msg = $LNG['winemp_allyBonus_Error_K'];
							break;	
						}
						elseif ($ally_d < $price_six_d){
							$error = false;
							$msg = $LNG['winemp_allyBonus_Error_D'];
							break;
						}
						else{
							$ally_m -= $price_six_m;
							$ally_k -= $price_six_k;
							$ally_d -= $price_six_d;
							$SQL = "UPDATE ".ALLIANCE." SET ally_met='".$ally_m."', ally_krist='".$ally_k."', ally_deut='".$ally_d."' WHERE id ='".$USER['ally_id']."'"; 
							$sql = "UPDATE ".ALLIBONUS." SET attack = attack+ 1 WHERE id='".$USER['ally_id']."'";
							$GLOBALS['DATABASE']->query($SQL);
							$GLOBALS['DATABASE']->query($sql);
							$error = false;
							$msg = $LNG['winemp_allyBonus_allOkay'];
							break;
						}
				case 7: if($ally_m < $price_seven_m){
							$error = false;
							$msg = $LNG['winemp_allyBonus_Error_M'];
							break;
						}
						elseif ($ally_k < $price_seven_k){
							$error = false;
							$msg = $LNG['winemp_allyBonus_Error_K'];
							break;	
						}
						elseif ($ally_d < $price_seven_d){
							$error = false;
							$msg = $LNG['winemp_allyBonus_Error_D'];
							break;
						}
						else{
							$ally_m -= $price_seven_m;
							$ally_k -= $price_seven_k;
							$ally_d -= $price_seven_d;
							$SQL = "UPDATE ".ALLIANCE." SET ally_met='".$ally_m."', ally_krist='".$ally_k."', ally_deut='".$ally_d."' WHERE id ='".$USER['ally_id']."'"; 
							$sql = "UPDATE ".ALLIBONUS." SET topics = topics+ 5 WHERE id='".$USER['ally_id']."'";
							$GLOBALS['DATABASE']->query($SQL);
							$GLOBALS['DATABASE']->query($sql);
							$error = false;
							$msg = $LNG['winemp_allyBonus_allOkay'];
							break;
						}
				default:
						$error = true;
						$msg = '';
						break;
				}
				
			$this->tplObj->assign_vars(array(
				'error'			=> $error,
				'one_akt'		=> $one_h,
				'one_max'		=> $this->Slots_max,
				'one_m'			=> $price_one_m." Metall <br/>",
				'one_k'			=> $price_one_k." Kristall <br/>",
				'one_d'			=> $price_one_d." Deuterium",
				'two_akt'		=> $two_h,
				'two_max'		=> $this->Produ_max,
				'two_m'			=> $price_two_m." Metall <br/>",
				'two_k'			=> $price_two_k." Kristall <br/>",
				'two_d'			=> $price_two_d." Deuterium",
				'tree_akt'		=> $tree_h,
				'tree_max'		=> $this->Build_max,
				'tree_m'		=> $price_tree_m." Metall <br/>",
				'tree_k'		=> $price_tree_k." Kristall <br/>",
				'tree_d'		=> $price_tree_d." Deuterium",
				'four_akt'		=> $four_h,
				'four_max'		=> $this->Reser_max,
				'four_m'		=> $price_four_m." Metall <br/>",
				'four_k'		=> $price_four_k." Kristall <br/>",
				'four_d'		=> $price_four_d." Deuterium",
				'five_akt'		=> $five_h,
				'five_max'		=> $this->Defen_max,
				'five_m'		=> $price_five_m." Metall <br/>",
				'five_k'		=> $price_five_k." Kristall <br/>",
				'five_d'		=> $price_five_d." Deuterium",
				'six_akt'		=> $six_h,
				'six_max'		=> $this->Attak_max,
				'six_m'			=> $price_six_m." Metall <br/>",
				'six_k'			=> $price_six_k." Kristall <br/>",
				'six_d'			=> $price_six_d." Deuterium",
				'seven_akt'		=> $seven_h,
				'seven_max'		=> $this->Topics_max,
				'seven_m'		=> $price_seven_m." Metall <br/>",
				'seven_k'		=> $price_seven_k." Kristall <br/>",
				'seven_d'		=> $price_seven_d." Deuterium",
				'deakt_one'		=> $deak_1,
				'deakt_two'		=> $deak_2,
				'deakt_tree'	=> $deak_3,
				'deakt_four'	=> $deak_4,
				'deakt_five'	=> $deak_5,
				'deakt_six'		=> $deak_6,
				'deakt_seven'	=> $deak_7,
				'msg'			=> $msg,
				
				));
			$this->display('allyBonus_buy_two.tpl');
	}
}