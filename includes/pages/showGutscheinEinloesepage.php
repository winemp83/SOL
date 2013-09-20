<?php

class Gutschein{

	function ShowDMEinloesePage (){
		global $LNG, $USER, $DMGut, $PLANET, $db, $LANG;
		if (!empty($_POST))
	{
	$gkey					= request_var('gutscheine_key', '');
	if($gkey == NULL)
	{
	$errorcode = 1;
	
	$template->tplObj->assign_vars(array(
	'mod_gutscheine_errorcode'					=> $errorcode,
	'mod_gutscheine_user_headline'				=> $LNG['mod_gutscheine_user_headline'],
	'mod_gutscheine_user_back'					=> $LNG['mod_gutscheine_user_back'],
	'mod_gutscheine_user_Fail'					=> $LNG['mod_gutscheine_user_Fail'],  //Fehler
	'mod_gutscheine_user_Fail1'					=> $LNG['mod_gutscheine_user_Fail1'], //Du hast keinen Gutscheincode eingetragen!
	'mod_gutscheine_user_Fail2'					=> $LNG['mod_gutscheine_user_Fail2'], //Du hast diesen Gutscheincode bereits verwendet!
	'mod_gutscheine_user_Fail3'					=> $LNG['mod_gutscheine_user_Fail3'], //Dieser Gutscheincode ist abgelaufen!
	));
	$template->display('ShowGutscheinError.tpl');
	exit();
	}
	
	$query = $GLOBALS['Database']->query("SELECT * FROM ".DMGut." WHERE `key` = '".$db->sql_escape($gkey)."'");
	$Gutschein = $GLOBALS['Database']->fetch_array($query);
	if($Gutschein['id'] == "" && $Gutschein['name'] == "")
	{
			$errorcode = 4;
			
			$template->tblObj->assign_vars(array(
			'mod_gutscheine_errorcode'					=> $errorcode,
			'mod_gutscheine_user_back'					=> $LNG['mod_gutscheine_user_back'],
			'mod_gutscheine_user_headline'				=> $LNG['mod_gutscheine_user_headline'],
			'mod_gutscheine_user_Fail'					=> $LNG['mod_gutscheine_user_Fail'],  //Fehler
			'mod_gutscheine_user_Fail1'					=> $LNG['mod_gutscheine_user_Fail1'], //Du hast keinen Gutscheincode eingetragen!
			'mod_gutscheine_user_Fail2'					=> $LNG['mod_gutscheine_user_Fail2'], //Du hast diesen Gutscheincode bereits verwendet!
			'mod_gutscheine_user_Fail3'					=> $LNG['mod_gutscheine_user_Fail3'],
			'mod_gutscheine_user_Fail4'					=> $LNG['mod_gutscheine_user_Fail4'],			//Dieser Gutscheincode ist abgelaufen!
			));
			$template->display('ShowGutscheinError.tpl');
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
			
			$template->tblObj->assign_vars(array(
			'mod_gutscheine_errorcode'					=> $errorcode,
			'mod_gutscheine_user_back'					=> $LNG['mod_gutscheine_user_back'],
			'mod_gutscheine_user_headline'				=> $LNG['mod_gutscheine_user_headline'],
			'mod_gutscheine_user_Fail'					=> $LNG['mod_gutscheine_user_Fail'],  //Fehler
			'mod_gutscheine_user_Fail1'					=> $LNG['mod_gutscheine_user_Fail1'], //Du hast keinen Gutscheincode eingetragen!
			'mod_gutscheine_user_Fail2'					=> $LNG['mod_gutscheine_user_Fail2'], //Du hast diesen Gutscheincode bereits verwendet!
			'mod_gutscheine_user_Fail3'					=> $LNG['mod_gutscheine_user_Fail3'], //Dieser Gutscheincode ist abgelaufen!
			'mod_gutscheine_user_Fail5'					=> $LNG['mod_gutscheine_user_Fail5'],
			));
			$template->display('ShowGutscheinError.tpl');
			exit();
		}
		$StrExpire = strtotime($Gutschein['createday']);
		$dateExpire = $StrExpire + (60*60*24*$Gutschein['expireday']);
		$test = time();
		if($dateExpire < $test)
		{
			$errorcode = 5;
			
			$template->tblObj->assign_vars(array(
			'mod_gutscheine_errorcode'					=> $errorcode,
			'mod_gutscheine_user_back'					=> $LNG['mod_gutscheine_user_back'],
			'mod_gutscheine_user_headline'				=> $LNG['mod_gutscheine_user_headline'],
			'mod_gutscheine_user_Fail'					=> $LNG['mod_gutscheine_user_Fail'],  //Fehler
			'mod_gutscheine_user_Fail1'					=> $LNG['mod_gutscheine_user_Fail1'], //Du hast keinen Gutscheincode eingetragen!
			'mod_gutscheine_user_Fail2'					=> $LNG['mod_gutscheine_user_Fail2'], //Du hast diesen Gutscheincode bereits verwendet!
			'mod_gutscheine_user_Fail3'					=> $LNG['mod_gutscheine_user_Fail3'], //Dieser Gutscheincode ist abgelaufen!
			'mod_gutscheine_user_Fail5'					=> $LNG['mod_gutscheine_user_Fail5'],
			));
			$template->display('ShowGutscheinError.tpl');
			exit();
		}
		// Code by Robbyn - Thanks for this =)
		$GLOBALS['Database']->query("
        UPDATE 
            ".DMGut." as dm, 
            ".PLANETS." as p,
            ".USERS." as u
        SET
            dm.`useable` = '".$db->sql_escape($Useable)."',
            dm.`usedby` = '".$db->sql_escape($LastUser)."',
            p.`metal` = p.`metal` + ".$Gutschein['mineralien'].",
            p.`crystal` = p.`crystal` + ".$Gutschein['kristall'].",
            p.`deuterium` = p.`deuterium` + ".$Gutschein['deuterium'].",
            u.`darkmatter` = u.`darkmatter` + ".$Gutschein['matter']."
        WHERE
            dm.`key` = '".$db->sql_escape($gkey)."' AND
            p.`id` = '".$USER['id']."' AND
            u.`id` = '".$USER['id']."';");
		// Code by Robbyn - Thanks for this =)
		$mod_gutscheine_success = 1;
	$template->tblObj->assign_vars(array(
	'mod_gutscheine_success'					=> $mod_gutscheine_success,
	'mod_gutschein_name'						=> $Gutschein['name'],
	'mod_gutscheine_user_headline'				=> $LNG['mod_gutscheine_user_headline'],
	'mod_gutscheine_user_Successhead'			=> $LNG['mod_gutscheine_user_Successhead'], //Gratulation!
	'mod_gutscheine_user_back'					=> $LNG['mod_gutscheine_user_back'],
	'mod_gutscheine_recieve1'					=> $LNG['mod_gutscheine_recieve1'],  //Du hast durch diesen Gutschein
	'mod_gutscheine_recieve2'					=> $LNG['mod_gutscheine_recieve2'], // erhalten
	'mod_gutscheine_metall'						=> $Gutschein['mineralien'],
	'mod_gutscheine_crystall'					=> $Gutschein['kristall'],
	'mod_gutscheine_deuterium'					=> $Gutschein['deuterium'],
	'mod_gutscheine_matter'						=> $Gutschein['matter'],
	'mod_metal'									=> $LNG['Metal'],
	'mod_crystall'								=> $LNG['Crystal'],
	'mod_deuterium'								=> $LNG['Deuterium'],
	'mod_darkmatter'							=> $LNG['Darkmatter'],
	'mod_gutscheine_user_Fail2'					=> $LNG['mod_gutscheine_user_Fail2'], //Du hast diesen Gutscheincode bereits verwendet!
	'mod_gutscheine_user_Fail3'					=> $LNG['mod_gutscheine_user_Fail3'], //Dieser Gutscheincode ist abgelaufen!
	));
	$template->display('ShowGutscheinError.tpl');
	exit();
	}
	$errorcode = 3;
	$template->tblObj->assign_vars(array(
	'mod_gutscheine_errorcode'					=> $errorcode,
	'mod_gutscheine_user_headline'				=> $LNG['mod_gutscheine_user_headline'],
	'mod_gutscheine_user_back'					=> $LNG['mod_gutscheine_user_back'],
	'mod_gutscheine_user_Fail'					=> $LNG['mod_gutscheine_user_Fail'],  //Fehler
	'mod_gutscheine_user_Fail1'					=> $LNG['mod_gutscheine_user_Fail1'], //Du hast keinen Gutscheincode eingetragen!
	'mod_gutscheine_user_Fail2'					=> $LNG['mod_gutscheine_user_Fail2'], //Du hast diesen Gutscheincode bereits verwendet!
	'mod_gutscheine_user_Fail3'					=> $LNG['mod_gutscheine_user_Fail3'], //Dieser Gutscheincode ist abgelaufen!
	));
	$template->display('ShowGutscheinError.tpl');
	exit();
	
	}
	$template->tblObj->assign_vars(array(
		'mod_gutscheine_user_headline'				=> $LNG['mod_gutscheine_user_headline'],
		'mod_gutscheine_user_key'					=> $LNG['mod_gutscheine_user_key'],
		'mod_user_refund'							=> $LNG['mod_user_refund'],
	));
	
	$template->display('ShowDMEinloesPage.tpl');
	}	
}
?>