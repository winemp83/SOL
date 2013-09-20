<?php
class ShowAuctionPage extends AbstractPage 
{
	private $sofort = false;
	private $error = false;
	private $units = 0;
	private $what = '';
	private $msg = '';
	private $met = 0;
	private $kri = 0;
	private $deu = 0;
	
	public static $requireModule = MODULE_SUPPORT;
	
	function __construct() 
	{
		parent::__construct();
		
	}
	
	public function show()
	{
		$this->delAuction();
		if(!isset($_POST['menue'])){
			$this->homeAuction();
		}
		else{
			$this->menueAuction($_POST['menue']);
		}
	}
	
	private function createAuction()
	{
		
	}
	
	private function homeAuction()
	{
		
	}
	
	
	private function bidAuction()
	{
		if($this->checkRessource($_POST['auction_id'])){
			if($this->sofort){
				$PLANET[$resource[901]] -= $this->met;
				$PLANET[$resource[902]] -= $this->kri;
				$PLANET[$resource[903]] -= $this->deu;
				$this->updatePlanet();
				$this->delAuction();
			}
			else{
				$PLANET[$resource[901]] -= ($this->deu + $_POST['b_m']);
				$PLANET[$resource[902]] -= ($this->deu + $_POST['b_k']);
				$PLANET[$resource[903]] -= ($this->deu + $_POST['b_d']);
				$this->updateAuction($_POST['auction_id']);
			}
		}
		else{
			
		}
	}
	
	private function updateAuction($id){
		$sql = "UPDATE ".EBAY." SET b_met='b_met + ".$_POST['b_m']."', b_kri='b_kri + ".$_POST['b_k']."', b_deu='b_deu + ".$_POST['b_d']."', b_planet='".$PLANT['id']."' WHERE id='".$id."'";
		$GLOBALS['DATABASE']->query($sql);
	}
	
	/*
	 * Update Planets set the right thinks on it
	 */
	private function updatePlanet(){
		$sql = "UPDATE ".PLANETS." SET ".$this->what."='".$this->what." + ".$this->units."' WHERE id='".$PLANET['id']."'";
		$GLOBALS['DATABASE']->query($sql);
	}
	
	/*
	 * checkRessource will give a boolean
	 * true = the user have enough resource to buy
	 * false = the planet haven't enough resource
	 * $msg will be the Data what failed 
	 * error will be true if checkRessource = false
	 * msg will be the data why failed
	 */
	 private function checkRessource($id)
	 {
	 	$p_m = $PLANET[$resource[901]];
		$p_k = $PLANET[$resource[902]];
		$p_d = $PLANET[$resource[903]];
	 	$sql = "SELECT * FROM ".EBAY." WHERE id='".$id."'";
		$result = $GLOBALS['DATABASE']->query($sql);
		foreach($result as $data){
			$this->met		= $data['b_met'];
			$this->kri		= $data['b_kri'];
			$this->deu		= $data['b_deu'];
			$this->sofort	= $data['sofort'];
			$this->what     = $this->whatAuction($data['what']);
			$this->units	= $data['units'];
		}
		if($this->sofort){
			$checka = $p_m - $this->met;
            $checkb = $p_k - $this->kri;
            $checkc = $p_d - $this->deu;
			if($checka <= 0){
				$this->error = true;
				$this->msg = $LNG['winemp_modAuction_error_ressource_m'];
				return false;
			}
			elseif($checkb <= 0){
				$this->error = true;
				$this->msg = $LNG['winemp_modAuction_error_ressource_k'];
				return false;
			}
			elseif($checkc <= 0) {
				$this->error = true;
				$this->msg = $LNG['winemp_modAuction_error_ressource_d'];
				return false;
			}
			else{
				$this->error = false;
				return true;
			}
		}
		else{
			$checka = $p_m - ($this->met + $_POST['b_m']);
            $checkb = $p_k - ($this->kri + $_POST['b_k']);
            $checkc = $p_d - ($this->deu + $_POST['b_d']);
			if($checka <= 0){
				$this->error = true;
				$this->msg = $LNG['winemp_modAuction_error_ressource_m'];
				return false;
			}
			elseif($checkb <= 0){
				$this->error = true;
				$this->msg = $LNG['winemp_modAuction_error_ressource_k'];
				return false;
			}
			elseif($checkc <= 0) {
				$this->error = true;
				$this->msg = $LNG['winemp_modAuction_error_ressource_d'];
				return false;
			}
			else{
				$this->error = false;
				return true;
			}
		}
	 }
	
	/*
	 * delAuction if the function to clear if a Auction finish
	 * it will be start at all Jumps to the *.tpl file 
	 * but this is a dirty hack we need a cronjob for this
	 * if somebody have time lock at this!
	 */
	private function delAuction($id = 0)
	{
		if($id == 0){
			$sql = "SELECT * FROM ".EBAY." WHERE time <='".time()."'";
			$result = $GLOBALS['DATABASE']->query($sql);
			foreach($result as $data){
				$this->whatAuction($data['what']);
				if($data['b_planet'] == 0){
					$sql = "UPDATE ".PLANETS." SET ".$this->what."='".$this->what." + ".$data['units']."' WHERE id='".$data['o_planet']."'";
				}
				else{
					$sql = "UPDATE ".PLANETS." SET ".$this->what."='".$this->what." + ".$data['units']."' WHERE id='".$data['b_planet']."'";
				}
				$GLOBALS['DATABASE']->query($sql);
				$sql = "DELETE * FROM ".EBAY." WHERE id='".$data['id']."'";
				$GLOBALS['DATABASE']->query($sql);
			}	
		}
		else{
			$sql = "DELETE * FROM ".EBAY." WHERE id='".$id."'";
			$GLOBALS['DATABASE']->query($sql);
		}
	}
	
	/*
	 * whatAuction clears Numbers to Text
	 * from 01-50 Ships
	 * from 50-99 Defense
	 * later will come buildings 
	 * they will have 100-150 
	 */
	private function whatAuction($id)
	{
		switch ($id){
			case 1: $this->what = 'small_ship_cargo';
					break;
			case 2: $this->what = 'big_ship_cargo';
					break;
			case 3: $this->what = 'light_hunter';
					break;
			case 4: $this->what = 'heavy_hunter';
					break;
			case 5: $this->what = 'crusher';
					break;
			case 6: $this->what = 'battle_ship';
					break;
			case 7: $this->what = 'colonizer';
					break;
			case 8: $this->what = 'recycler';
					break;
			case 9: $this->what = 'spy_sonde';
					break;
			case 10: $this->what = 'bomber_ship';
					break;
			case 11: $this->what = 'solar_satelit';
					break;
			case 12: $this->what = 'destructor';
					break;
			case 13: $this->what = 'dearth_star';
					break;
			case 14: $this->what = 'battleship';
					break;
			case 15: $this->what = 'lune_noir';
					break;
			case 16: $this->what = 'ev_transporter';
					break;
			case 17: $this->what = 'star_crasher';
					break;
			case 18: $this->what = 'giga_recykler';
					break;
			case 19: $this->what = 'dm_ship';
					break;
			case 50: $this->what = 'misil_launcher';
					break;
			case 51: $this->what = 'small_laser';
					break;
			case 52: $this->what = 'big_laser';
					break;
			case 53: $this->what = 'gauss_canyon';
					break;
			case 54: $this->what = 'ionic_canyon';
					break;
			case 55: $this->what = 'buster_canyon';
					break;
			case 56: $this->what = 'buster_canyon';
					break;
		} 
	}
	
	/*
	 * menueAuction is importent for the menu
	 * if you add something to this you don't need make a Mod jump you will only 
	 * enter in the .tpl file @ the hidden field the number 
	 * and enter here the function name in a new case
	 */
	private function menueAuction($id){
		switch ($id){
			case 1: $this->createAuction();
					break;
			case 2: $this->bidAuction();
					break;
			case 3: $this->delAuction();
					break;
			default: $this->homeAuction();	
					break;
		}
	}
}
?>