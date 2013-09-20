<?php

class ShowWGutscheinModPage extends AbstractPage
{
	protected $keyA		= '';
	protected $error 	= '';
	protected $me 		= 0;
	protected $kr 		= 0;
	protected $du 		= 0;
	protected $da 		= 0;
	protected $kontroll ;
	protected $data;
	
	function __construct() 
	{
		parent::__construct();
	}
	
	public function show(){
		global $USER, $PLANET, $LNG, $UNI, $CONF, $db, $reslist, $resource;
			if(!empty($_POST)){
				$this->keyA = $_POST['gutscheineCode'];
			
				if($this->checkKey($this->keyA)){
					$this->giveRessource();
					$this->tplObj->assign_vars(array(
						'wg_mod_fail'					=> 	2,
						'WG_mod_error' 					=>	$this->error,
						'WG_mod_header'					=>	$LNG['Winemp_Gutschein_mod_Header'],
						'WG_mod_footer'					=> 	$LNG['winemp_Gutschein_mod_Footer'],
						'WG_mod_sucess1'				=>	$LNG['winemp_Gutschein_mod_sucess1'],
						'WG_mod_Fail_text'				=>	$LNG['winemp_Gutschein_mod_FAIL'],
						'WG_mod_code'					=>	$LNG['winemp_Gutschein_mod_code'],
						'WG_mod_sucess'					=>	$LNG['winemp_Gutschein_mod_sucess'],
						'WG_mod_submit'					=>	$LNG['winemp_Gutschein_mod_submit'],	
						'WG_mod_back'					=>  $LNG['winemp_Gutschein_mod_back'],
						'WG_mod_buy'                    =>  $LNG['winemp_Gutschein_mod_buy'],
						'WG_mod_metall'					=>	$this->me,
						'WG_mod_kristall'				=>	$this->kr,
						'WG_mod_deuterium'				=>	$this->du,
						'WG_mod_darkmatter'				=>	$this->da,
					));
				$this->display('wgModShow.tpl');
				}
				else{
					$this->tplObj->assign_vars(array(
						'wg_mod_fail'					=> 	3,
						'WG_mod_error' 					=>	$this->error."<br/>".print_r($this->kontroll),
						'WG_mod_header'					=>	$LNG['Winemp_Gutschein_mod_Header'],
						'WG_mod_footer'					=> 	$LNG['winemp_Gutschein_mod_Footer'],
						'WG_mod_sucess1'				=>	$LNG['winemp_Gutschein_mod_sucess1'],
						'WG_mod_Fail_text'				=>	$LNG['winemp_Gutschein_mod_FAIL'],
						'WG_mod_code'					=>	$LNG['winemp_Gutschein_mod_code'],
						'WG_mod_sucess'					=>	$LNG['winemp_Gutschein_mod_sucess'],
						'WG_mod_submit'					=>	$LNG['winemp_Gutschein_mod_submit'],
						'WG_mod_back'					=>  $LNG['winemp_Gutschein_mod_back'],
						'WG_mod_buy'                    =>  $LNG['winemp_Gutschein_mod_buy'],
						'WG_mod_metall'					=>	$this->me,
						'WG_mod_kristall'				=>	$this->kr,
						'WG_mod_deuterium'				=>	$this->du,
						'WG_mod_darkmatter'				=>	$this->da,
					));
				$this->display('wgModShow.tpl');
				}
			}
			else{
				$this->error(3);
				$this->tplObj->assign_vars(array(
					'wg_mod_fail'					=> 	1,
					'WG_mod_error' 					=>	$this->error,
					'WG_mod_error' 					=>	$this->error,
					'WG_mod_header'					=>	$LNG['Winemp_Gutschein_mod_Header'],
					'WG_mod_footer'					=> 	$LNG['winemp_Gutschein_mod_Footer'],
					'WG_mod_sucess1'				=>	$LNG['winemp_Gutschein_mod_sucess1'],
					'WG_mod_Fail_text'				=>	$LNG['winemp_Gutschein_mod_FAIL'],
					'WG_mod_code'					=>	$LNG['winemp_Gutschein_mod_code'],
					'WG_mod_sucess'					=>	$LNG['winemp_Gutschein_mod_sucess'],
					'WG_mod_submit'					=>	$LNG['winemp_Gutschein_mod_submit'],
					'WG_mod_back'					=>  $LNG['winemp_Gutschein_mod_back'],
					'WG_mod_buy'                    =>  $LNG['winemp_Gutschein_mod_buy'],
					'WG_mod_metall'					=>	$this->me,
					'WG_mod_kristall'				=>	$this->kr,
					'WG_mod_deuterium'				=>	$this->du,
					'WG_mod_darkmatter'				=>	$this->da,
				));
				$this->display('wgModShow.tpl');
			}
		}
	
	
	private function ifKeyUsable($key){
		global $USER, $PLANET, $LNG, $UNI, $CONF, $db, $reslist, $resource;
		$sql = ("SELECT id FROM ".DMGut." WHERE gkey='".$key."' AND  useable >= 1 LIMIT 1");
		$data = $GLOBALS['DATABASE']->query($sql);
		foreach($data as $fine){
			$this->kontroll = $fine;
			if($fine['id'] >= 1){
				return true;
			}
		}
		return false;
	}
	
	private function giveRessource(){
		global $USER, $PLANET, $LNG, $UNI, $CONF, $db, $reslist, $resource;
		$sql = ("SELECT `metall`, `kristall`, `deuterium`, `darkmatter` FROM ".DMGut." WHERE gkey='".$this->keyA."' AND useable >= '1' LIMIT 1 ;");
		$result = $GLOBALS['DATABASE']->query($sql);
		foreach($result as $Result)
		{
			$this->me =  $Result['metall'];
			$this->kr =  $Result['kristall'];
			$this->du =  $Result['deuterium'];
			$this->da =  $Result['darkmatter'];
		}

		
		$PLANET[$resource[901]] += $this->me;
		$PLANET[$resource[902]] += $this->kr;
		$PLANET[$resource[903]] += $this->du;
		$USER[$resource[921]]   += $this->da;
		$sql = ("UPDATE ".DMGut." SET useable=useable-1 WHERE gkey='".$this->keyA."'");
		$GLOBALS['DATABASE']->query($sql);
	}
	
	private function checkKey($key){
		global $USER, $PLANET, $LNG, $UNI, $CONF, $db, $reslist, $resource;
		$this->keyA = $key;
		$help = true;
		if(strlen($this->keyA) < 6){
			$help = false;
		}
		else{
			$empty = array();
		
			$i = preg_match_all('/[0-9]/', $this->keyA, $empty);
			if($i < 2){
				$help = false;
			}
		
		$i = preg_match_all('/[a-z]/', $this->keyA, $empty);
		if($i < 2){
			$help = false;
		}
		
		$i = preg_match_all('/[A-Z]/', $this->keyA, $empty);
		if($i < 2){
			$help = false;
		}
		if ($help == false){
			$this->error(1);
			return false;
		}		
		else{
			if($this->ifKeyUsable($this->keyA)){
				return true;
			}
			else{
				$this->error(2);
				return false;
			}
		}
		}	
	}
	
	private function error($key){
		global $USER, $PLANET, $LNG, $UNI, $CONF, $db, $reslist, $resource;
		switch ($key){
			case 1	:	$this->error = $LNG['winemp_Gutschein_ERROR_1']; //Key ist kein GültigerKey
						break;
			case 2	:	$this->error = $LNG['winemp_Gutschein_ERROR_2']; //Key ist nicht exsitent oder verbraucht
						break;
			case 3	:	$this->error = $LNG['winemp_Gutschein_ERROR_3']; //anderer Fehler
						break;
			case 4	:	$this->error  = $LNG['winemp_Gutschein_ERROR_4a']; // zuwenig Dunklematerie
						$this->error .= pretty_number($USER['total_points']);
						$this->error .= $LNG['winemp_Gutschein_ERROR_4b'];
						break;
			case 5	:	$this->error = $LNG['winemp_Gutschein_ERROR_5'];
						break;
			default	:	$this->error = $LNG['winemp_Gutschein_ERROR'];
						break;			
		}
	}
}
?>