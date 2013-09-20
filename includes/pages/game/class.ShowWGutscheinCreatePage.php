<?php
class ShowWGutscheinCreatePage extends AbstractPage
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
				if($this->createKey()){
					$this->tplObj->assign_vars(array(
					
						'wg_mod_buy_choise'				=> 2,
						'wg_mod_buy_description'		=> $LNG['winemp_mod_buy_descA']."250".$LNG['winemp_mod_buy_descB'],
						'wg_mod_buy_submit'				=> $LNG['winemp_mod_buy_submit'],
						'wg_mod_buy_suecess'			=> $LNG['winemp_mod_buy_suecess'],
						'wg_mod_buy_keyA'				=> $LNG['winemp_mod_buy_keyA'],
						'wg_mod_buy_key'				=> $this->keyA,
						'wg_mod_buy_footer'				=> $LNG['winemp_mod_buy_footer'],
						'wg_mod_buy_error'              => $this->error,
						'wg_mod_buy_header'				=> $LNG['winemp_mod_buy_header'],
						'WG_mod_back'					=> $LNG['winemp_Gutschein_mod_back'],
			
					));
					$NewUser = $USER['id'];	
					$message = "Ihr Gutschein Code Lautet: ".$this->keyA;
					SendSimpleMessage($NewUser, 1, TIMESTAMP, 1, $LNG['winemp_mod_buy_sender'], $LNG['winemp_mod_buy_betreff'], $message);		
					$this->display('wgModCreate.tpl');
				}
				else{
					$this->tplObj->assign_vars(array(
					
						'wg_mod_buy_choise'				=> 3,
						'wg_mod_buy_description'		=> $LNG['winemp_mod_buy_descA']."250".$LNG['winemp_mod_buy_descB'],
						'wg_mod_buy_submit'				=> $LNG['winemp_mod_buy_submit'],
						'wg_mod_buy_suecess'			=> $LNG['winemp_mod_buy_suecess'],
						'wg_mod_buy_keyA'				=> $LNG['winemp_mod_buy_keyA'],
						'wg_mod_buy_key'				=> $this->keyA,
						'wg_mod_buy_footer'				=> $LNG['winemp_mod_buy_footer'],
						'wg_mod_buy_error'              => $this->error,
						'wg_mod_buy_header'				=> $LNG['winemp_mod_buy_header'],
						'WG_mod_back'					=> $LNG['winemp_Gutschein_mod_back'],
			
					));	
					$this->display('wgModCreate.tpl');
				}							
			}
			$this->tplObj->assign_vars(array(
					
						'wg_mod_buy_choise'				=> 1,
						'wg_mod_buy_description'		=> $LNG['winemp_mod_buy_descA']."250".$LNG['winemp_mod_buy_descB'],
						'wg_mod_buy_submit'				=> $LNG['winemp_mod_buy_submit'],
						'wg_mod_buy_suecess'			=> $LNG['winemp_mod_buy_suecess'],
						'wg_mod_buy_keyA'				=> $LNG['winemp_mod_buy_keyA'],
						'wg_mod_buy_key'				=> $this->keyA,
						'wg_mod_buy_footer'				=> $LNG['winemp_mod_buy_footer'],
						'wg_mod_buy_error'              => $this->error,
						'wg_mod_buy_header'				=> $LNG['winemp_mod_buy_header'],
						'WG_mod_back'					=> $LNG['winemp_Gutschein_mod_back'],
			
					));	
					$this->display('wgModCreate.tpl');
	}
	
	
	private function createKey(){
		global $USER, $PLANET, $LNG, $UNI, $CONF, $db, $reslist, $resource;
		$testA = $USER[$resource[921]];
		$help  = 250;
		$testB = $testA - $help;
		if ($testB >= 0){
			$pwd = '';
			while($this->checkKeyInsert($pwd) == false){
				for($i= 0; $i < 6; $i++){
					switch(rand(1,3))
					{
						case 1: $pwd =$pwd.chr(rand(65,90));
								break;
						case 2: $pwd =$pwd.chr(rand(97,122));
								break;
						case 3: $pwd =$pwd.rand(0,9);
								break;
					}
				}
			}
			if ($USER['total_points'] < 1000){
				$help = 2000;
			}
			else{
				$help = (($USER['total_points']*2)+($USER['total_points']/100)); 
			}
			$this->me = $this->randomRess($help);
			$this->kr = $this->randomRess($help);
			$this->du = $this->randomRess($help);
			$this->insertKey($this->keyA, $this->me, $this->kr, $this->du);
			$USER[$resource[921]] -= 250;				
							
			return true;
		}
		else{
			$this->error(4);
			return false;
		}
	}

	private function insertKey($key, $met, $kris, $deu){
		global $USER, $PLANET, $LNG, $UNI, $CONF, $db, $reslist, $resource;
		$sql = "INSERT INTO ".DMGut." (gkey, metall, kristall, deuterium, darkmatter, useable, userid) VALUES ('".$key."', '".$met."', '".$kris."', '".$deu."', '0', '1', ".$USER['id'].")";
		$GLOBALS['DATABASE']->query($sql);
	}
	
	private function randomRess($data){
		$help = $data;
		$help = rand(0,$help);
		return $help;
	}

	private function checkKeyInsert($key){
		global $USER, $PLANET, $LNG, $UNI, $CONF, $db, $reslist, $resource;
		$help = true;
		if(strlen($key) <= 6){
			return false;
		}
		else{
			$empty = array();
		
			$i = preg_match_all('/[0-9]/', $key, $empty);
			if($i < 2){
				return false;
			}
		
			$i = preg_match_all('/[a-z]/', $key, $empty);
			if($i < 2){
				return false;
			}
		
			$i = preg_match_all('/[A-Z]/', $key, $empty);
			if($i < 2){
				return false;
			}
			$sql = ("SELECT id FROM ".DMGut." WHERE gkey='".$key."' LIMIT 1");
			$data = $GLOBALS['DATABASE']->query($sql);
			foreach($data as $fine){
				$this->kontroll = $fine;
					if($fine['id'] >= 1){
						return false;
					}
				}
			$this->keyA = $key;
			return true;
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
						$this->error .= '500';
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