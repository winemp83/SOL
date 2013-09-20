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

    public static $requireModule = MODULE_SUPPORT;
	function __construct() 
	{
		parent::__construct();
	}

	function show()
	{
		global $USER, $PLANET, $LNG, $UNI, $CONF, $db, $reslist, $resource;
	}
	
	function checkRace(){
		global $USER, $PLANET, $LNG, $UNI, $CONF, $db, $reslist, $resource;
		
		$sql = "SELECT ";
	}
	
	function raceName(){
		
	}
}
?>