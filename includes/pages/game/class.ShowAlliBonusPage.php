<?php
class ShowAlliBankPage extends AbstractPage 
{
	public static $requireModule = MODULE_SUPPORT;
	

	function __construct() 
	{
		parent::__construct();
		
	}
		
	function show()
	{
		global $USER, $PLANET, $LNG, $CONF, $reslist, $resource;
		if($USER['ally_id'] != 0){
			$sql = "SELECT * FROM ".ALLIBONUS." WHERE id='".$USER['ally_id']."'";
			$result = $GLOBALS['DATABASE']->query($sql);
			foreach($result as $bonus){
				$Produktion = $bonus['produktion'];
				$Defense    = $bonus['defense'];
				$Attack     = $bonus['attack'];
				$Research   = $bonus['research'];
				$Building   = $bonus['building'];
				$Slots      = $bonus['slots'];
			}
			$sql = "SELECT `ally_owner`";
			$this->tplObj->assign_vars(array(
				'pro'		=> $Produktion,
				'def'		=> $Defense,
				'atk'		=> $Attack,
				'res'		=> $Research,
				'bui'		=> $Building,
				'slo'		=> $Slots,
				'err'		=> false,
			));	
		}
		else{
			$this->tplObj->assign_vars(array(
				'pro'		=> 0,
				'def'		=> 0,
				'atk'		=> 0,
				'res'		=> 0,
				'bui'		=> 0,
				'slo'		=> 0,
				'err'		=> true,
			));
		}
		$this->display('allyBonus_overview.tpl');
	}
	
	function buy(){
		global $USER, $PLANET, $LNG, $CONF, $reslist, $resource;
		$action     	= HTTP::_GP('action', '');
		$what			= HTTP::_GP('what', '');
		if($USER['ally_id'] != 0){
			if($action == 'buy'){
				isset($what) ? $what = $what : $what = 9;
				switch ($what){
					case 1:
						break;
					case 2:
						break;
					case 3:
						break;
					case 4:	
						break;
					case 5:
						break;
					case 6:
						break;
					default:
						
						break;
				}
			}
		
		}
	}
}
?>