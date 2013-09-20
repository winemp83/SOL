<?php

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");


function ShowDMGutscheine()
{

	global $LNG, $USER, $LANG, $db, $DMGut;
	$id = HTTP::_GP('id', '');
	if($_GET['action'] == 'delete' && !empty($id))
		$GLOBALS['DATABASE']->query("DELETE FROM ".DMGut." WHERE `id` = '".$id."';");
	if($_GET['action'] == 'disable' && !empty($id))
		$GLOBALS['DATABASE']->query("UPDATE ".DMGut." SET `useable` = '0' WHERE `id` = '".$id."';");
	if($_GET['action'] == 'up' && !empty($id))
		{
			$checkdb = $GLOBALS['DATABASE']->query("SELECT `useable` FROM ".DMGut." WHERE `id` = '".$id."';");
			$check = $GLOBALS['DATABASE']->fetch_array($checkdb);
			$GLOBALS['DATABASE']->query("UPDATE ".DMGut." SET `useable` = '".$GLOBALS['DATABASE']->sql_escape($check['useable'] + 1)."' WHERE `id` = '".$id."';");
		}
	if($_GET['action'] == 'down' && !empty($id))
		{
			$checkdb = $GLOBALS['DATABASE']->query("SELECT `useable` FROM ".DMGut." WHERE `id` = '".$id."';");
			$check = $GLOBALS['DATABASE']->fetch_array($checkdb);
			if($check['useable'] > "-1")
			$GLOBALS['DATABASE']->query("UPDATE ".DMGut." SET `useable` = '".$GLOBALS['DATABASE']->sql_escape($check['useable'] - 1)."' WHERE `id` = '".$id."';");
		}		
	
	if (!empty($_POST))
    {
        $name                 = request_var('gutscheine_name', '', true);
        $gmineralien        = request_var('gutscheine_gutschrift_minerals', '', true);
        $gkristall            = request_var('gutscheine_gutschrift_kristall', '', true);
        $gdeuterium            = request_var('gutscheine_gutschrift_deuterium', '', true);
        $gdarkmatter        = request_var('gutscheine_gutschrift_dm', '', true);
        $guseable            = request_var('gutscheine_useable', '', true);
        $gkey                = request_var('gutscheine_key', '', true);
        $gexpday            = request_var('gutscheine_expire', '', true);
        $createday             = time();
        $createdaydb        = date("Y.m.d",$createday);
        $StrExpire            = time() + (60*60*24*$gexpday);
        $Expire             = date("Y.m.d", $StrExpire);
        $gexpday2            = time()+86400*$gexpday;
        if($name == "" || $gmineralien == "" || $gkristall == "" ||$gdeuterium == "" || $gdarkmatter == "" || $guseable == "" || $gkey == "" || $gexpday == "")
        {
        $template = new template();
        $template->message("".$LNG['mod_gutschein_admin_error1']."",2);
        }
        $speicher             = $db->query("INSERT INTO ".DMGut." (`name`, `mineralien`, `kristall`, `deuterium`, `matter`, `useable`, `key`, `expireday`, `createday`, `expiredayrl`) VALUES ( '".$db->sql_escape($name)."', '".$db->sql_escape($gmineralien)."', '".$db->sql_escape($gkristall)."', '".$db->sql_escape($gdeuterium)."', '".$db->sql_escape($gdarkmatter)."', '".$db->sql_escape($guseable)."', '".$db->sql_escape($gkey)."', '".$db->sql_escape($gexpday2)."', '".$db->sql_escape($createdaydb)."', '".$db->sql_escape($Expire)."')");
    }
	
	$query = $GLOBALS['DATABASE']->query("SELECT * FROM ".DMGut."");
	while($Gutschein = $GLOBALS['DATABASE']->fetch_array($query))
	{
		$Gutscheine[] = array(
		'id' 		=> $Gutschein['id'],
		'name'		=> $Gutschein['name'],
		'mineralien'=> $Gutschein['mineralien'],
		'kristall'	=> $Gutschein['kristall'],
		'deuterium' => $Gutschein['deuterium'],
		'dm'		=> $Gutschein['matter'],
		'useable'	=> $Gutschein['useable'],
		'used'		=> $Gutschein['usedby'],
		'key'		=> $Gutschein['key'],
		'expireday' => $Gutschein['expireday'],
		'createday' => $Gutschein['createday'],
		'expiredayrl'=>$Gutschein['expiredayrl']
		);
	}


	
	$template	= new template();

	$template->assign_vars(array(
		'Gutscheine'								=> $Gutscheine,
		'mod_gutscheine_headline'					=> $LNG['mod_gutscheine_headline'],
		'mod_gutschein_exists_id'					=> $LNG['mod_gutschein_exists_id'],
		'mod_gutschein_exists_name'					=> $LNG['mod_gutschein_exists_name'],
		'mod_gutschein_exists_minerals'				=> $LNG['mod_gutschein_exists_minerals'],
		'mod_gutschein_exists_kristall'				=> $LNG['mod_gutschein_exists_kristall'],
		'mod_gutschein_exists_deuterium'			=> $LNG['mod_gutschein_exists_deuterium'],
		'mod_gutschein_exists_dm'					=> $LNG['mod_gutschein_exists_dm'],
		'mod_gutschein_exists_key'					=> $LNG['mod_gutschein_exists_key'],
		'mod_gutschein_exists_used'					=> $LNG['mod_gutschein_exists_used'],
		'mod_gutschein_exists_useable'				=> $LNG['mod_gutschein_exists_useable'],
		'mod_gutschein_exists_delete'				=> $LNG['mod_gutschein_exists_delete'],
		'mod_gutschein_exists_disable'				=> $LNG['mod_gutschein_exists_disable'],
		'mod_gutscheine_erstellen'					=> $LNG['mod_gutscheine_erstellen'],
		'mod_gutscheine_name'						=> $LNG['mod_gutscheine_name'],
		'mod_gutscheine_gutschrift_minerals'		=> $LNG['mod_gutscheine_gutschrift_minerals'],
		'mod_gutscheine_gutschrift_kristall'		=> $LNG['mod_gutscheine_gutschrift_kristall'],
		'mod_gutscheine_gutschrift_deuterium'		=> $LNG['mod_gutscheine_gutschrift_deuterium'],
		'mod_gutscheine_gutschrift_DM'				=> $LNG['mod_gutscheine_gutschrift_DM'],
		'mod_gutscheine_useable'					=> $LNG['mod_gutscheine_useable'],
		'mod_gutscheine_key'						=> $LNG['mod_gutscheine_key'],
		'mod_save_gutscheine'						=> $LNG['mod_save_gutscheine'],

		'mod_gutschein_exists_expireday'			=> $LNG['mod_gutschein_exists_expireday'],
		'mod_gutschein_exists_createday'			=> $LNG['mod_gutschein_exists_createday'],
		'mod_gutscheine_expire'						=> $LNG['mod_gutscheine_expire']
	));
	
	$template->show('adm/DM-GutscheineBody.tpl');
}

?>