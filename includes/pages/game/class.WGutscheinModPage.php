<?php

class MyGutscheinMod extends AbstractPage
{
	protected $keyA		= '';
	protected $error 	= '';
	protected $me 		= 0;
	protected $kr 		= 0;
	protected $du 		= 0;
	protected $da 		= 0;
	
	function __construct() 
	{
		parent::__construct();
	}
	
	public function show(){
		global $USER, $PLANET, $LNG, $UNI, $CONF, $db, $reslist, $resource;
		if(!empty($_POST)){
			$this->keyA = HTTP::_GP('gutscheinCode', '');
			
			if($this->checkKey($this->keyA)){
				$this->giveRessource();
				$this->tplObj->assign_vars(array(
					'WG_mod_fail'					=> 	2,
					'WG_mod_error' 					=>	$this->error,
					'WG_mod_header'					=>	$LNG['Winemp_Gutschein_mod_Header'],
					'WG_mod_footer'					=> 	$LNG['winemp_Gutschein_mod_Footer'],
					'WG_mod_sucess1'				=>	$LNG['winemp_Gutschein_mod_sucess1'],
					'WG_mod_Fail_text'				=>	$LNG['winemp_Gutschein_mod_FAIL'],
					'WG_mod_code'					=>	$LNG['winemp_Gutschein_mod_code'],
					'WG_mod_sucess'					=>	$LNG['winemp_Gutschein_mod_sucess'],
					'WG_mod_submit'					=>	$LNG['winemp_Gutschein_mod_submit'],	
					'WG_mod_back'					=>  $LNG['winemp_Gutschein_mod_back'],
					'WG_mod_metall'					=>	$this->me,
					'WG_mod_kristall'				=>	$this->kr,
					'WG_mod_deuterium'				=>	$this->du,
					'WG_mod_darkmatter'				=>	$this->da,
				));
			$this->display('WG_mod_show.tpl');
			}
			else{
				$this->tplObj->assign_vars(array(
					'wg_mod_fail'					=> 	3,
					'WG_mod_error' 					=>	$this->error,
					'WG_mod_header'					=>	$LNG['Winemp_Gutschein_mod_Header'],
					'WG_mod_footer'					=> 	$LNG['winemp_Gutschein_mod_Footer'],
					'WG_mod_sucess1'				=>	$LNG['winemp_Gutschein_mod_sucess1'],
					'WG_mod_Fail_text'				=>	$LNG['winemp_Gutschein_mod_FAIL'],
					'WG_mod_code'					=>	$LNG['winemp_Gutschein_mod_code'],
					'WG_mod_sucess'					=>	$LNG['winemp_Gutschein_mod_sucess'],
					'WG_mod_submit'					=>	$LNG['winemp_Gutschein_mod_submit'],
					'WG_mod_back'					=>  $LNG['winemp_Gutschein_mod_back'],
					'WG_mod_metall'					=>	$this->me,
					'WG_mod_kristall'				=>	$this->kr,
					'WG_mod_deuterium'				=>	$this->du,
					'WG_mod_darkmatter'				=>	$this->da,
				));
			$this->display('WG_mod_show.tpl');
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
				'WG_mod_metall'					=>	$this->me,
				'WG_mod_kristall'				=>	$this->kr,
				'WG_mod_deuterium'				=>	$this->du,
				'WG_mod_darkmatter'				=>	$this->da,
			));
			$this->display('WG_mod_show.tpl');
		}
	}
	
	
	private function ifKeyUsable($key){
		
		$sql = ("SELECT `id` FROM ".DMGut." WHERE key='".$key."' AND  useable >= 1 LIMIT 1");
		$data = $GLOBALS['DATABASE']->numRows($sql);
		if($data == 1){
			return true;
		}
		else{
			return false;
		}
	}
	
	private function giveRessource(){
		$sql = ("SELECT `metall`, `kristall`, `deuterium`, `matter` WHERE gkey='".$this->keyA."' AND useable >= '1' LIMIT 1 ;");
		while($result = $GLOBALS['DATABASE']->fetch_arry($sql))
		{
			$data[] = array(
			'metall' 		=> $result['metall'],
			'kristall' 		=> $result['kristall'],
			'deuterium'		=> $result['deuterium'],
			'dunklematerie'	=> $result['matter'],
			);
		}
		$this->me = $data['metall'];
		$this->kr = $data['kristall'];
		$this->du = $data['deuterium'];
		$this->da = $data['dunklematerie'];
		
		$PLANET[$resource[901]] += $data['metall'];
		$PLANET[$resource[902]] += $data['kristall'];
		$PLANET[$resource[903]] += $data['deuterium'];
		$PLANET[$resource[921]] += $data['dunklematerie'];
		
		$sql = ("UPDATE ".DMGut." SET usable= -1, used = +1, usedby='".$USER['username']."' WHERE key='".$this->keyA."'");
		$GLOBALS['DATABASE']->query($sql);
	}
	
	private function checkKey($key){
		$help = false;
		if(strlen($key) < 6){
			$help = false;
		}
		
		$empty = array();
		
		$i = preg_match_all('/0-9/', $key, $empty);
		if($i < 2){
			$help = false;
		}
		
		$i = preg_match_all('/a-z/', $key, $empty);
		if($i < 2){
			$help = false;
		}
		
		$i = preg_match_all('/A-Z/', $key, $empty);
		if($i < 2){
			$help = false;
		}
		if ($help == false){
			$this->error(1);
			$this->keyA = $key;
			return false;
		}
		else{
			if(!$this->checkKey($key)){
				$this->error(2);
				return false;
			}
			else{
				
				return true;
			}
		}
		
	}
	
	private function error($key){
		switch ($key){
			case 1	:	$this->error = $LNG['winemp_Gutschein_ERROR1']; //Key ist kein GültigerKey
						break;
			case 2	:	$this->error = $LNG['winemp_Gutschein_ERROR2']; //Key ist nicht exsitent oder verbraucht
						break;
			case 3	:	$this->error = $LNG['winemp_Gutschein_ERROR3']; //anderer Fehler
						break;
			case 4	:	$this->error = $LNG['winemp_Gutschein_ERROR4'];
						break;
			case 5	:	$this->error = $LNG['winemp_Gutschein_ERROR5'];
						break;
			default	:	$this->error = $LNG['winemp_Gutschein_ERROR'];
						break;			
		}
	}
}
?>