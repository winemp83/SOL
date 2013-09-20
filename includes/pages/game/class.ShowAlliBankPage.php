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
			$sql = "SELECT * FROM ".ALLIANCE." WHERE id='".$USER['ally_id']."'";
			$result = $GLOBALS['DATABASE']->query($sql);
			$help = array();
			foreach ($result as $ally) {
				$help['met']			= $ally['ally_met'];
				$help['kri']			= $ally['ally_krist'];
				$help['deu']			= $ally['ally_deut'];
			}
			$this->tplObj->assign_vars(array(
				'error_code'			=> false,
				'ally_error'			=> '',
				'allyBank'				=> $LNG['allyBank'],
				'allyBank_metall'		=> $LNG['allyBank_metall'],
				'allyBank_kristall'		=> $LNG['allyBank_kristall'],
				'allyBank_deuterium'	=> $LNG['allyBank_deuterium'],
				'allyBank_in'			=> $LNG['allyBank_in'],
				'ally_bank_met'			=> $help['met'],
				'ally_bank_kri'			=> $help['kri'],
				'ally_bank_deu'			=> $help['deu'],
			));
			}
			else{
			$help['met']			= 0;
			$help['kri']			= 0;
			$help['deu']			= 0;
			
			$this->tplObj->assign_vars(array(
				'error_code'			=> true,
				'ally_error'			=> $LNG['allyBank_error_1'],
				'allyBank'				=> $LNG['allyBank'],
				'allyBank_metall'		=> $LNG['allyBank_metall'],
				'allyBank_kristall'		=> $LNG['allyBank_kristall'],
				'allyBank_deuterium'	=> $LNG['allyBank_deuterium'],
				'allyBank_in'			=> $LNG['allyBank_in'],
				'ally_bank_met'			=> $help['met'],
				'ally_bank_kri'			=> $help['kri'],
				'ally_bank_deu'			=> $help['deu'],
			));
			}	
			$this->display('allyBank_overview.tpl');
}


function in(){
	global $USER, $PLANET, $LNG, $CONF, $reslist, $resource;
	$action     	= HTTP::_GP('action', '');
		
	if($USER['ally_id'] != 0){
		$sql = "SELECT * FROM ".ALLIANCE." WHERE id='".$USER['ally_id']."'";
		$result = $GLOBALS['DATABASE']->query($sql);
		$help = array();
		foreach ($result as $ally) {
			$help['met']			= $ally['ally_met'];
			$help['kri']			= $ally['ally_krist'];
			$help['deu']			= $ally['ally_deut'];
		}
		
		if ($action == 'in'){
			$bMet 				= max(0, round(HTTP::_GP('metal', 0.0)));
			$bCrys				= max(0, round(HTTP::_GP('kryst', 0.0)));
			$bDeut				= max(0, round(HTTP::_GP('deuta', 0.0)));
					
			if($bMet < '0'){$this->printMessage($LNG['error_1'], 'game.php?page=logout');}

			elseif($bCrys < '0'){$this->printMessage($LNG['error_1'], 'game.php?page=logout');}

			elseif($bDeut < '0'){$this->printMessage($LNG['error_1'], 'game.php?page=logout');}

			elseif($bMet == '0' && $bCrys == '0' && $bDeut == '0'){$this->printMessage($LNG['error_2'], 'game.php?page=bank');}

			elseif($bMet > $PLANET['metal']){$this->printMessage($LNG['error_in_1'], 'game.php?page=bank');}

			elseif($bCrys > $PLANET['crystal']){$this->printMessage($LNG['error_in_2'], 'game.php?page=bank');}

			elseif($bDeut > $PLANET['deuterium']){$this->printMessage($LNG['error_in_3'], 'game.php?page=bank');}
	
			else{
            	$PLANET[$resource[901]]	-= $bMet;
                $PLANET[$resource[902]]	-= $bCrys;
                $PLANET[$resource[903]]	-= $bDeut;
				$GLOBALS['DATABASE']->query("UPDATE ".ALLIANCE." SET
                	ally_met = ally_met + $bMet,
                    ally_krist = ally_krist + $bCrys,
                    ally_deut = ally_deut + $bDeut 
                    WHERE id = ".$USER['ally_id'].";");
				$this->printMessage( 'Sie haben Eingezahlt '. $bMet .' Metall, '. $bCrys .' Kristall und '. $bDeut .' Deuterium in die Allianz Bank.', 'game.php?page=bank');
			}
		}			
		$this->tplObj->assign_vars(array(
			'error_code'			=> false,
			'ally_error'			=> $LNG['allyBank_error_1'],
			'allyBank'				=> $LNG['allyBank'],
			'allyBank_metall'		=> $LNG['allyBank_metall'],
			'allyBank_kristall'		=> $LNG['allyBank_kristall'],
			'allyBank_deuterium'	=> $LNG['allyBank_deuterium'],
			'allyBank_in'			=> $LNG['allyBank_in'],
			'allyBank_in_header'	=> $LNG['allyBank_in_header'],
			'allyBank_in_overview'	=> $LNG['allyBank_in_overview'],
			'allyBank_in_payin'		=> $LNG['allyBank_in_payin'],
			'ally_bank_met'			=> $help['met'],
			'ally_bank_kri'			=> $help['kri'],
			'ally_bank_deu'			=> $help['deu'],
		));
		$this->display('allyBank_in.tpl');
	}
	else{
		$this->tplObj->assign_vars(array(
			'error_code'			=> true,
			'ally_error'			=> $LNG['allyBank_error_1'],
			'allyBank'				=> $LNG['allyBank'],
			'allyBank_metall'		=> $LNG['allyBank_metall'],
			'allyBank_kristall'		=> $LNG['allyBank_kristall'],
			'allyBank_deuterium'	=> $LNG['allyBank_deuterium'],
			'allyBank_in'			=> $LNG['allyBank_in'],
			'allyBank_in_header'	=> $LNG['allyBank_in_header'],
			'allyBank_in_overview'	=> $LNG['allyBank_in_overview'],
			'allyBank_in_payin'		=> $LNG['allyBank_in_payin'],
			'ally_bank_met'			=> $help['met'],
			'ally_bank_kri'			=> $help['kri'],
			'ally_bank_deu'			=> $help['deu'],
		));
		$this->display('allyBank_in.tpl');
	}
}
}
?>