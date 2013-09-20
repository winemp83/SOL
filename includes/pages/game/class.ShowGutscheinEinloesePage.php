<?php

class ShowGutscheinEinloesePage extends AbstractPage
{
	
    public static $requireModule = MODULE_SUPPORT;

	function __construct() 
	{
		parent::__construct();
	}
	
	public function show(){
	global $USER, $PLANET, $LNG, $UNI, $CONF, $db, $reslist, $resource, $DMGut;
	$mod_gutscheine_success = 0;
	if (!empty($_POST))
	{
	$gkey					= HTTP::_GP('gutscheine_key', '');
	if($gkey == NULL)
	{
	$errorcode = 1;
	
	$this->tplObj->assign_vars(array(
	'mod_gutscheine_success'					=> $mod_gutscheine_success,
	'mod_gutscheine_errorcode'					=> $errorcode,
	'mod_gutscheine_user_headline'				=> $LNG['mod_gutscheine_user_headline'],
	'mod_gutscheine_user_back'					=> $LNG['mod_gutscheine_user_back'],
	'mod_gutscheine_user_Fail'					=> $LNG['mod_gutscheine_user_Fail'],  //Fehler
	'mod_gutscheine_user_Fail1'					=> $LNG['mod_gutscheine_user_Fail1'], //Du hast keinen Gutscheincode eingetragen!
	'mod_gutscheine_user_Fail2'					=> $LNG['mod_gutscheine_user_Fail2'], //Du hast diesen Gutscheincode bereits verwendet!
	'mod_gutscheine_user_Fail3'					=> $LNG['mod_gutscheine_user_Fail3'], //Dieser Gutscheincode ist abgelaufen!
	));
	$this->display('ShowGutscheinError.tpl');
	exit();
	}
	
	$query = $GLOBALS['DATABASE']->query("SELECT * FROM ".DMGut." WHERE `key` = '".$GLOBALS['DATABASE']->sql_escape($gkey)."'");
	$Gutschein = $GLOBALS['DATABASE']->fetch_array($query);
	if($Gutschein['id'] == "" && $Gutschein['name'] == "")
	{
			$errorcode = 4;
			
			$this->tplObj->assign_vars(array(
			'mod_gutscheine_success'					=> $mod_gutscheine_success,
			'mod_gutscheine_errorcode'					=> $errorcode,
			'mod_gutscheine_user_back'					=> $LNG['mod_gutscheine_user_back'],
			'mod_gutscheine_user_headline'				=> $LNG['mod_gutscheine_user_headline'],
			'mod_gutscheine_user_Fail'					=> $LNG['mod_gutscheine_user_Fail'],  //Fehler
			'mod_gutscheine_user_Fail1'					=> $LNG['mod_gutscheine_user_Fail1'], //Du hast keinen Gutscheincode eingetragen!
			'mod_gutscheine_user_Fail2'					=> $LNG['mod_gutscheine_user_Fail2'], //Du hast diesen Gutscheincode bereits verwendet!
			'mod_gutscheine_user_Fail3'					=> $LNG['mod_gutscheine_user_Fail3'],
			'mod_gutscheine_user_Fail4'					=> $LNG['mod_gutscheine_user_Fail4'],			//Dieser Gutscheincode ist abgelaufen!
			));
			$this->display('ShowGutscheinError.tpl');
	}
	
	if($Gutschein['useable'] >= '1' || $Gutschein['useable'] == '-1')
	{
	
		$Useable = $Gutschein['useable'];
		if($Useable >= 1)
		$Useable = $Useable - 1;
		$LastUser = "".$Gutschein['usedby'].",'".$USER['id']."'";
		$DeineID = "'".$USER['id']."'";
		if(preg_match($DeineID,$Gutschein['usedby']))
		{
			$errorcode = 2;
			
			$this->tplObj->assign_vars(array(
			'mod_gutscheine_success'					=> $mod_gutscheine_success,
			'mod_gutscheine_errorcode'					=> $errorcode,
			'mod_gutscheine_user_back'					=> $LNG['mod_gutscheine_user_back'],
			'mod_gutscheine_user_headline'				=> $LNG['mod_gutscheine_user_headline'],
			'mod_gutscheine_user_Fail'					=> $LNG['mod_gutscheine_user_Fail'],  //Fehler
			'mod_gutscheine_user_Fail1'					=> $LNG['mod_gutscheine_user_Fail1'], //Du hast keinen Gutscheincode eingetragen!
			'mod_gutscheine_user_Fail2'					=> $LNG['mod_gutscheine_user_Fail2'], //Du hast diesen Gutscheincode bereits verwendet!
			'mod_gutscheine_user_Fail3'					=> $LNG['mod_gutscheine_user_Fail3'], //Dieser Gutscheincode ist abgelaufen!
			'mod_gutscheine_user_Fail5'					=> $LNG['mod_gutscheine_user_Fail5'],
			));
			$this->display('ShowGutscheinError.tpl');
			exit();
		}
		$StrExpire = strtotime($Gutschein['createday']);
		$dateExpire = $StrExpire + ($Gutschein['expireday']);
		$test = time();
		if($dateExpire < $test)
		{
			$errorcode = 5;
			$template = new template();
			
			$template->assign_vars(array(
			'mod_gutscheine_success'					=> $mod_gutscheine_success,
			'mod_gutscheine_errorcode'					=> $errorcode,
			'mod_gutscheine_user_back'					=> $LNG['mod_gutscheine_user_back'],
			'mod_gutscheine_user_headline'				=> $LNG['mod_gutscheine_user_headline'],
			'mod_gutscheine_user_Fail'					=> $LNG['mod_gutscheine_user_Fail'],  //Fehler
			'mod_gutscheine_user_Fail1'					=> $LNG['mod_gutscheine_user_Fail1'], //Du hast keinen Gutscheincode eingetragen!
			'mod_gutscheine_user_Fail2'					=> $LNG['mod_gutscheine_user_Fail2'], //Du hast diesen Gutscheincode bereits verwendet!
			'mod_gutscheine_user_Fail3'					=> $LNG['mod_gutscheine_user_Fail3'], //Dieser Gutscheincode ist abgelaufen!
			'mod_gutscheine_user_Fail5'					=> $LNG['mod_gutscheine_user_Fail5'],
			));
			$template->show('ShowGutscheinError.tpl');
			exit();
		}
		// Code by Robbyn - Thanks for this =)
		$GLOBALS['DATABASE']->query("
        UPDATE 
            ".DMGut." as dm, 
            ".PLANETS." as p,
            ".USERS." as u
        SET
            dm.`useable` = '".$GLOBALS['DATABASE']->sql_escape($Useable)."',
            dm.`usedby` = '".$GLOBALS['DATABASE']->sql_escape($LastUser)."',
            p.`metal` = p.`metal` + ".$Gutschein['metall'].",
            p.`crystal` = p.`crystal` + ".$Gutschein['kristall'].",
            p.`deuterium` = p.`deuterium` + ".$Gutschein['deuterium'].",
            u.`darkmatter` = u.`darkmatter` + ".$Gutschein['matter']."
        WHERE
            dm.`key` = '".$GLOBALS['DATABASE']->sql_escape($gkey)."' AND
           	p.`id` = '".$PLANET['id']."' AND
            u.`id` = '".$USER['id']."';");
		// Code by Robbyn - Thanks for this =)
	$mod_gutscheine_success = 1;
	
	$this->tplObj->assign_vars(array(
	'mod_gutscheine_success'					=> $mod_gutscheine_success,
	'mod_gutschein_name'						=> $Gutschein['name'],
	'mod_gutscheine_user_headline'				=> $LNG['mod_gutscheine_user_headline'],
	'mod_gutscheine_user_Successhead'			=> $LNG['mod_gutscheine_user_Successhead'], //Gratulation!
	'mod_gutscheine_user_back'					=> $LNG['mod_gutscheine_user_back'],
	'mod_gutscheine_recieve1'					=> $LNG['mod_gutscheine_recieve1'],  //Du hast durch diesen Gutschein
	'mod_gutscheine_recieve2'					=> $LNG['mod_gutscheine_recieve2'], // erhalten
	'mod_gutscheine_metall'						=> $Gutschein['metall'],
	'mod_gutscheine_crystall'					=> $Gutschein['kristall'],
	'mod_gutscheine_deuterium'					=> $Gutschein['deuterium'],
	'mod_gutscheine_matter'						=> $Gutschein['matter'],
	'mod_metal'									=> $LNG['Metal'],
	'mod_crystall'								=> $LNG['Crystal'],
	'mod_deuterium'								=> $LNG['Deuterium'],
	'mod_darkmatter'							=> $LNG['Darkmatter'],'mod_gutscheine_user_Fail'					=> $LNG['mod_gutscheine_user_Fail'],  //Fehler
	'mod_gutscheine_user_Fail1'					=> $LNG['mod_gutscheine_user_Fail1'], //Du hast keinen Gutscheincode eingetragen!
	'mod_gutscheine_user_Fail2'					=> $LNG['mod_gutscheine_user_Fail2'], //Du hast diesen Gutscheincode bereits verwendet!
	'mod_gutscheine_user_Fail3'					=> $LNG['mod_gutscheine_user_Fail3'], //Dieser Gutscheincode ist abgelaufen!
	'mod_gutscheine_user_Fail4'					=> $LNG['mod_gutscheine_user_Fail4'],			//Dieser Gutscheincode ist abgelaufen!
	'mod_gutscheine_user_Fail5'					=> $LNG['mod_gutscheine_user_Fail5'],			//Dieser Gutscheincode ist abgelaufen!
	));
	
	$this->display('ShowGutscheinError.tpl');
	exit();
	}
	$errorcode = 3;
	
	$this->tplObj->assign_vars(array(
	'mod_gutscheine_success'					=> $mod_gutscheine_success,
	'mod_gutscheine_errorcode'					=> $errorcode,
	'mod_gutscheine_user_headline'				=> $LNG['mod_gutscheine_user_headline'],
	'mod_gutscheine_user_back'					=> $LNG['mod_gutscheine_user_back'],
	'mod_gutscheine_user_Fail'					=> $LNG['mod_gutscheine_user_Fail'],  //Fehler
	'mod_gutscheine_user_Fail1'					=> $LNG['mod_gutscheine_user_Fail1'], //Du hast keinen Gutscheincode eingetragen!
	'mod_gutscheine_user_Fail2'					=> $LNG['mod_gutscheine_user_Fail2'], //Du hast diesen Gutscheincode bereits verwendet!
	'mod_gutscheine_user_Fail3'					=> $LNG['mod_gutscheine_user_Fail3'], //Dieser Gutscheincode ist abgelaufen!
	'mod_gutscheine_user_Fail4'					=> $LNG['mod_gutscheine_user_Fail4'],			//Dieser Gutscheincode ist abgelaufen!
	));
	$this->display('ShowGutscheinError.tpl');
	exit();
	
	}

	$this->tplObj->assign_vars(array(
		'mod_gutscheine_user_headline'				=> $LNG['mod_gutscheine_user_headline'],
		'mod_gutscheine_user_key'					=> $LNG['mod_gutscheine_user_key'],
		'mod_user_refund'							=> $LNG['mod_user_refund'],
	));
	
	$this->display('ShowDMEinloesPage.tpl');

}
}
?>