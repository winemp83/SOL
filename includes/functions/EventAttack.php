<?php
ob_start();
/**
 * Special-Planet-/TF-Event for 2Moons
 * @Mod for 2Moons 1.7.x
 * @author Racer <webmaster@myplanets.de>
 * @version 1.7.2  (20.01.2013)
 * @link http://www.myplanets.de
 */

require_once(ROOT_PATH . 'includes/classes/class.FleetFunctions.php');

function EventAttack($targetGalaxy, $targetSystem, $targetPlanet, $targetType, $targetMission, $fleetRessource, $fleetGroup, $fleetSpeed, $distance)
{
  global $USER, $PLANET, $resource, $pricelist, $reslist, $CONF, $LNG, $UNI;
	


$attackPlanetData = $GLOBALS['DATABASE']->uniquequery("SELECT id, id_owner, heavy_hunter, small_ship_cargo, big_ship_cargo, light_hunter, battle_ship, dearth_star, lune_noir , ally_deposit , ev_attack, ev_attval FROM ".PLANETS." WHERE universe = ".$UNI." AND galaxy = ".$targetGalaxy." AND system = ".$targetSystem." AND planet = ".$targetPlanet." AND planet_type = '".($targetType == 2 ? 1 : $targetType)."';");


if($attackPlanetData['ev_attack']==1)
	{
	$value = rand(1,100);
		if ($value< $attackPlanetData['ev_attval'])
			{
			$ev_attack =1;
			}
		else
			{
			$ev_attack =0;
			}
	}
		
if($attackPlanetData['ev_attack']==0)
	{
	$ev_attack =0;
	}
	
		
	
	$ev_attack_ships = $attackPlanetData['light_hunter']+$attackPlanetData['battle_ship']+ $attackPlanetData['dearth_star']+$attackPlanetData['lune_noir']+$attackPlanetData['heavy_hunter']+$attackPlanetData['small_ship_cargo']+$attackPlanetData['big_ship_cargo'];
		
	if($ev_attack == 1 and $ev_attack_ships > 0 ) 
		{
			$attackArray	= array();
			if($attackPlanetData['heavy_hunter'] > 0)
			{
				$attackArray[ '205' ] = $attackPlanetData['heavy_hunter'];
			}
				
			
			if($attackPlanetData['small_ship_cargo'] > 0)
			{
				$attackArray[ '202' ] = $attackPlanetData['small_ship_cargo'];
			}
				
			
			if($attackPlanetData['big_ship_cargo'] > 0)
			{
				$attackArray[ '203' ] = $attackPlanetData['big_ship_cargo'];
			}
			
			if($attackPlanetData['light_hunter'] > 0)
				{
				$attackArray[ '204' ] = $attackPlanetData['light_hunter'];
				}
		
			if($attackPlanetData['battle_ship'] > 0)
				{
				$attackArray[ '207' ] = $attackPlanetData['battle_ship'];
				}

		
			if($attackPlanetData['dearth_star'] > 0)
				{
				$attackArray[ '214' ] = $attackPlanetData['dearth_star'];
				}
				
			if($attackPlanetData['lune_noir'] > 0)
				{
				$attackArray[ '216' ] = $attackPlanetData['lune_noir'];
				}	
 
			$StayDuration = 0;
			$fleetMaxSpeedA	= FleetFunctions::GetFleetMaxSpeed($attackArray, $USER);
			$SpeedFactor  	= FleetFunctions::GetGameSpeedFactor();
			$durationA      = FleetFunctions::GetMissionDuration($fleetSpeed, $fleetMaxSpeedA, $distance, $SpeedFactor, $USER);

			$fleetStartTimeA	= $durationA + TIMESTAMP+1000;
			$fleetStayTimeA		= $fleetStartTimeA + $StayDuration;
			$fleetEndTimeA		= $fleetStayTimeA + $durationA;
 		
			FleetFunctions::sendFleet($attackArray, $targetMission, $attackPlanetData['id_owner'], $attackPlanetData['id'], $targetGalaxy, $targetSystem, $targetPlanet, $targetType, $USER['id'], $PLANET['id'], $PLANET['galaxy'], $PLANET['system'], $PLANET['planet'], $PLANET['planet_type'], $fleetRessource, $fleetStartTimeA, $fleetStayTimeA, $fleetEndTimeA, $fleetGroup);
			
			// Spezial-Event Attack e-Mail Erstellung
			
			$ev_user	= $GLOBALS['DATABASE']->getFirstRow("SELECT `id`,`username` FROM ".USERS." WHERE `id`= '".$attackPlanetData['id_owner']."'");

			$Subject = $LNG['ev_attack_sub'];
			$Message = sprintf($LNG['ev_attack_msg'], $ev_user['username'], $PLANET['galaxy'], $PLANET['system'], $PLANET['planet']);
			
			$Time        = TIMESTAMP;
			$From        = '<span style="color:red;">'.$LNG['ev_attack_mess_from'].'</span>';
			$Subject     = '<span style="color:red;">'.$Subject.'</span>';
			$Message     = '<span style="color:red;font-weight:bold;">'.$Message.'</span>';

			
			SendSimpleMessage($USER['id'], 0, TIMESTAMP, 50, $From, $Subject, $Message);
 		}
ob_flush();
ob_end_clean();
}