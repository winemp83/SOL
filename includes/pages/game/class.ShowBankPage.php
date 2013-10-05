<?php

class ShowBankPage extends AbstractPage 
{
	
	public static $requireModule = MODULE_SUPPORT;
	

	function __construct() 
	{
		parent::__construct();
		
	}
		
function show()

{

	global $USER, $PLANET, $LNG, $CONF, $reslist, $resource;

   $transCoasts	= 25;
 $maxStorage		= pow($PLANET['bank'],4) * 50000 * $CONF['resource_multiplier'];
    $freeStorage	= $maxStorage - $PLANET['bankm'] - $PLANET['bankc'] - $PLANET['bankd'];

			

			$this->tplObj->assign_vars(array(	

				'bankm'			=> pretty_number($PLANET['bankm']),

				'bankc'			=> pretty_number($PLANET['bankc']),

				'bankd'			=> pretty_number($PLANET['bankd']),

				'transCoast'	=> $transCoasts,

				'maxStorage'	=> pretty_number($maxStorage),

				'freeStorage'	=> pretty_number($freeStorage),

				'bank'				=> $LNG['bank'],

				'bank_info'			=> $LNG['bank_info'],

				'bank_transCoast'	=> $LNG['bank_transCoast'],

				'bank_tcShort'		=> $LNG['bank_tcShort'],

				'bank_ress'			=> $LNG['bank_ress'],

				'bank_storage'		=> $LNG['bank_storage'],

				'bank_ressm'		=> $LNG['bank_ressm'],

				'bank_ressc'		=> $LNG['bank_ressc'],

				'bank_ressd'		=> $LNG['bank_ressd'],

				'bank_choice'		=> $LNG['bank_choice'],

				'bank_in'			=> $LNG['bank_in'],

				'bank_out'			=> $LNG['bank_out'],

			));

			$this->display('bank_overview.tpl');
}


function in()
	{
		global $USER, $PLANET, $LNG, $CONF, $reslist, $resource;
		$transCoasts	= 25;
		$maxStorage		= pow($PLANET['bank'],4) * 50000 * $CONF['resource_multiplier'];
		$freeStorage	= $maxStorage - $PLANET['bankm'] - $PLANET['bankc'] - $PLANET['bankd'];
		$action     	= HTTP::_GP('action', '');
		if ($USER['darkmatter'] < $transCoasts) {
			$this->redirectTo('game.php?page=bank');
		}
		
		
		
		
			$pMet			= $PLANET['metal'];

			$pCrys			= $PLANET['crystal'];

			$pDeut			= $PLANET['deuterium'];
	
			

			
		
			if ($action == 'in'){

				$bMet 				= max(0, round(HTTP::_GP('metal', 0.0)));

				$bCrys				= max(0, round(HTTP::_GP('kryst', 0.0)));

				$bDeut				= max(0, round(HTTP::_GP('deuta', 0.0)));

				$totalRess			= $bMet + $bCrys + $bDeut;

				

				if($bMet < '0'){$this->printMessage($LNG['error_1'], 'game.php?page=logout');}

				elseif($bCrys < '0'){$this->printMessage($LNG['error_1'], 'game.php?page=logout');}

				elseif($bDeut < '0'){$this->printMessage($LNG['error_1'], 'game.php?page=logout');}

				elseif($bMet == '0' && $bCrys == '0' && $bDeut == '0'){$this->printMessage($LNG['error_2'], 'game.php?page=bank');}

				elseif($bMet > $PLANET['metal']){$this->printMessage($LNG['error_in_1'], 'game.php?page=bank');}

				elseif($bCrys > $PLANET['crystal']){$this->printMessage($LNG['error_in_2'], 'game.php?page=bank');}

				elseif($bDeut > $PLANET['deuterium']){$this->printMessage($LNG['error_in_3'], 'game.php?page=bank');}

				elseif($transCoasts > $USER['darkmatter']){$this->printMessage($LNG['error_3'], 'game.php?page=bank');}

				elseif($freeStorage < $totalRess){$this->printMessage('Brak wystarczającej ilości miejsca.', 'game.php?page=bank');}

				else{
                    $PLANET[$resource[901]]	-= $bMet;
                    $PLANET[$resource[902]]	-= $bCrys;
                    $PLANET[$resource[903]]	-= $bDeut;
					$USER[$resource[921]]	-= $transCoasts;
					$GLOBALS['DATABASE']->query("UPDATE ".PLANETS." SET
                        bankm = bankm + $bMet,
                        bankc = bankc + $bCrys,
                        bankd = bankd + $bDeut 
                    WHERE id = ".$PLANET['id'].";");

					$this->printMessage( 'Sie haben Eingezahlt '. pretty_number($bMet) .' Metall, '. pretty_number($bCrys) .' Kristall und '. pretty_number($bDeut) .' Deuterium in die Bank.', 'game.php?page=bank');

				}

			}			

			

			$this->tplObj->assign_vars(array(	

				'transCoast'	=> $transCoasts,

				'bankm'				=> pretty_number($PLANET['bankm']),

				'bankc'				=> pretty_number($PLANET['bankc']),

				'bankd'				=> pretty_number($PLANET['bankd']),

				'maxStorage'	=> pretty_number($maxStorage),

				'freeStorage'	=> pretty_number($freeStorage),

				'bank_ress'			=> $LNG['bank_ress'],

				'bank_transCoast'	=> $LNG['bank_transCoast'],

				'bank_tcShort'		=> $LNG['bank_tcShort'],

				'bank_storage'		=> $LNG['bank_storage'],

				'bank_ressm'		=> $LNG['bank_ressm'],

				'bank_ressc'		=> $LNG['bank_ressc'],

				'bank_ressd'		=> $LNG['bank_ressd'],

				'bank_in_header'	=> $LNG['bank_in_header'],

				'bank_in_info'		=> $LNG['bank_in_info'],

				'bank_in'			=> $LNG['bank_in'],

			));

			$this->display('bank_in.tpl');
	}
function out()
{
	global $USER, $PLANET, $LNG, $CONF, $reslist, $resource;
		$transCoasts	= 25;
		$maxStorage		= pow($PLANET['bank'],4) * 50000 * $CONF['resource_multiplier'];
		$freeStorage	= $maxStorage - $PLANET['bankm'] - $PLANET['bankc'] - $PLANET['bankd'];
		$action     	= HTTP::_GP('action', '');
		if ($USER['darkmatter'] < $transCoasts) {
			$this->redirectTo('game.php?page=bank');
		}
		
		
			$pMet		= $PLANET['bankm'];

			$pCrys		= $PLANET['bankc'];

			$pDeut		= $PLANET['bankd'];

			$transCoasts	= 25;
		

			if ($action == 'out') {		

				$bMet 				= max(0, round(HTTP::_GP('metal', 0.0)));

				$bCrys				= max(0, round(HTTP::_GP('kryst', 0.0)));

				$bDeut				= max(0, round(HTTP::_GP('deuta', 0.0)));

				

				if($bMet < '0'){$this->printMessage($LNG['error_1'], 'game.php?page=logout');}

				elseif($bCrys < '0'){$this->printMessage($LNG['error_1'], 'game.php?page=logout');}

				elseif($bDeut < '0'){$this->printMessage($LNG['error_1'], 'game.php?page=logout');}

				elseif($bMet == '0' && $bCrys == '0' && $bDeut == '0'){$this->printMessage($LNG['error_2'], 'game.php?page=bank', 3);}

				elseif($bMet > $pMet){$this->printMessage($LNG['error_out_1'], 'game.php?page=bank', 3);}

				elseif($bCrys > $pCrys){$this->printMessage($LNG['error_out_2'], 'game.php?page=bank', 3);}

				elseif($bDeut > $pDeut){$this->printMessage($LNG['error_out_3'], 'game.php?page=bank', 3);}

				elseif($transCoasts > $USER['darkmatter']){$this->printMessage($LNG['error_3'], 'game.php?page=bank', 3);}

				else{
					 $PLANET[$resource[901]]	+= $bMet;
                    $PLANET[$resource[902]]	+= $bCrys;
                    $PLANET[$resource[903]]	+= $bDeut;
					$USER[$resource[921]]	-= $transCoasts;
					$GLOBALS['DATABASE']->query("UPDATE ".PLANETS." SET
                        bankm = bankm - $bMet,
                        bankc = bankc - $bCrys,
                        bankd = bankd - $bDeut 
                    WHERE id = ".$PLANET['id'].";");
					$this->printMessage( 'Sie haben Abgehoben '. pretty_number($bMet) .' Metall, '. pretty_number($bCrys) .' Kristall und '. pretty_number($bDeut) .' Deuterium .', 'game.php?page=bank', 3 );

				}

			}

			

			$this->tplObj->assign_vars(array(	

				'bankm'				=> pretty_number($PLANET['bankm']),

				'bankc'				=> pretty_number($PLANET['bankc']),

				'bankd'				=> pretty_number($PLANET['bankd']),

				'bank_ress'			=> $LNG['bank_ress'],

				'bank_ressm'		=> $LNG['bank_ressm'],

				'bank_ressc'		=> $LNG['bank_ressc'],

				'bank_ressd'		=> $LNG['bank_ressd'],

				'bank_out_header'	=> $LNG['bank_out_header'],

				'bank_out'			=> $LNG['bank_out'],

				

			));

			$this->display('bank_out.tpl');	
}
	

	


	

 
}
?>