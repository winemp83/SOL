<?php

class ShowConvidarPage extends AbstractPage 
{
	
	public static $requireModule = MODULE_SUPPORT;
	
	private $gutscheine = array();

	function __construct() 
	{
		parent::__construct();
		
	}
		
function show()

{
		global $USER, $LNG;

		$lista = $GLOBALS['DATABASE']->query("SELECT * FROM ".USERS." WHERE `ally_id` = '0' ORDER BY id");
		while($listau = $GLOBALS['DATABASE']->fetch_array($lista))
		{
			$sql = $GLOBALS['DATABASE']->query("SELECT * FROM ".STATPOINTS." WHERE id_owner='".$listau['id']."' AND stat_type='1'");
			while($points = $GLOBALS['DATABASE']->fetch_array($sql))
			{
				$this->Gutscheine[] = array(			
				'id' 		=> $listau['id'],
				'user'		=> $listau['username'],
				'platz'		=> $points['total_rank'],
				);
			}
		}
		
		;

			$this->tplObj->assign_vars(array(
            'winners'	=> $this->sabsi($this->Gutscheine, 'platz'),	
			));

			$this->display('convite_list.tpl');
   }   

function sabsi ($array, $index, $order='asc', $natsort=FALSE, $case_sensitive=FALSE) {
  if(is_array($array) && count($array)>0) {
    foreach(array_keys($array) as $key) $temp[$key]=$array[$key][$index];
    if(!$natsort) ($order=='asc')? asort($temp) : arsort($temp);
    else {
      ($case_sensitive)? natsort($temp) : natcasesort($temp);
      if($order!='asc') $temp=array_reverse($temp,TRUE);
    }
    foreach(array_keys($temp) as $key) (is_numeric($key))? $sorted[]=$array[$key] : $sorted[$key]=$array[$key];
    return $sorted;
  }
  return $array;
}
}
?>