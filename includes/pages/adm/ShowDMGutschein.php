<?php

/**
 *  Gutscheine-Mod
 *  Copyright (C) 2011  DokDobler	
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons
 * @author DokDobler <dokdobler@hotmail.com>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.0
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function checkKeyInsert($key){
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
					if($fine['id'] >= 1){
						return false;
					}
				}
			return true;
		}
	}



function ShowDMGutscheine()
{

	global $LNG, $USER, $LANG, $db, $DMGut;
	
	$id = HTTP::_GP('id', 0);
	if($_GET['action'] == 'delete' && !empty($id))
		$GLOBALS['DATABASE']->query("DELETE FROM ".DMGut." WHERE `id` = '".$id."';");
	if($_GET['action'] == 'disable' && !empty($id))
		$GLOBALS['DATABASE']->query("UPDATE ".DMGut." SET `useable` = '0' WHERE `id` = '".$id."';");
	if($_GET['action'] == 'enable' && !empty($id))
		$GLOBALS['DATABASE']->query("UPDATE ".DMGut." SET `useable` = '1' WHERE `id` = '".$id."';");
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
        $gmineralien        = HTTP::_GP('gutscheine_gutschrift_minerals', '', 0);
        $gkristall            = HTTP::_GP('gutscheine_gutschrift_kristall', '', 0);
        $gdeuterium            = HTTP::_GP('gutscheine_gutschrift_deuterium', '', 0);
        $gdarkmatter        = HTTP::_GP('gutscheine_gutschrift_dm', '', 0);
        $guseable            = HTTP::_GP('gutscheine_useable', '', 0);

		$pwd = '';
		while(checkKeyInsert($pwd) == false){
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
		
		$gkey = $pwd;

        if($gmineralien == "" || $gkristall == "" ||$gdeuterium == "" || $gdarkmatter == "" || $guseable == "" || $gkey == "")
        {
        $template = new template();
        $template->message("".$LNG['mod_gutschein_admin_error1']."",2);
        }
        $speicher             = $GLOBALS['DATABASE']->query("INSERT INTO ".DMGut." (`metall`, `kristall`, `deuterium`, `darkmatter`, `useable`, `gkey`, `userid`) VALUES  ('".$GLOBALS['DATABASE']->sql_escape($gmineralien)."', '".$GLOBALS['DATABASE']->sql_escape($gkristall)."', '".$GLOBALS['DATABASE']->sql_escape($gdeuterium)."', '".$GLOBALS['DATABASE']->sql_escape($gdarkmatter)."', '".$GLOBALS['DATABASE']->sql_escape($guseable)."', '".$GLOBALS['DATABASE']->sql_escape($gkey)."',  '".$USER['id']."')");
    }
	
	$query = $GLOBALS['DATABASE']->query("SELECT * FROM ".DMGut."");
	while($Gutschein = $GLOBALS['DATABASE']->fetch_array($query))
	{
		$sql = $GLOBALS['DATABASE']->query("SELECT (username) FROM ".USERS." WHERE id=".$Gutschein['userid']."");
		foreach($sql as $data){
			$help = $data['username'];
			if(empty($help)){
				$help = 'unbekannt';
			}
		}
		$Gutscheine[] = array(
		'id' 		=> $Gutschein['id'],
		'metall'	=> $Gutschein['metall'],
		'kristall'	=> $Gutschein['kristall'],
		'deuterium' => $Gutschein['deuterium'],
		'dm'		=> $Gutschein['darkmatter'],
		'useable'	=> $Gutschein['useable'],
		'userid'	=> $help,
		'key'		=> $Gutschein['gkey'],
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
		'mod_gutscheine_gutschrift_minerals'		=> $LNG['mod_gutscheine_gutschrift_minerals'],
		'mod_gutscheine_gutschrift_kristall'		=> $LNG['mod_gutscheine_gutschrift_kristall'],
		'mod_gutscheine_gutschrift_deuterium'		=> $LNG['mod_gutscheine_gutschrift_deuterium'],
		'mod_gutscheine_gutschrift_DM'				=> $LNG['mod_gutscheine_gutschrift_DM'],
		'mod_gutscheine_useable'					=> $LNG['mod_gutscheine_useable'],
		'mod_gutscheine_key'						=> $LNG['mod_gutscheine_key'],
		'mod_save_gutscheine'						=> $LNG['mod_save_gutscheine'],

	));
	
	$template->show('DMGutscheineBody.tpl');
}

?>