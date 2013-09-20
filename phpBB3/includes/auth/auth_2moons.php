<?php
/**
*
* 2Moons auth plug-in for phpBB3
*
* @package login
* @version $Id$
* @copyright (c) 2012 Jan Kröpke
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

function init_2moons()
{
	global $config, $user;
	
	if(!function_exists('mysql_connect'))
	{
		return 'MySQL Module required';
	}
	
	$port	= isset($config['moons_dbport']) ? (int) $config['moons_dbport'] : 3306;
		
	$link	= @mysql_connect($config['moons_dbhost'].':'.$port, $config['moons_dbuser'], $config['moons_dbpassword']);
	
	if (!$link)
	{
		return 'MySQL Connection Error: '.mysql_error();
	}
	
	if ((@mysql_select_db($config['moons_dbtable'], $link)) === false)
	{
		return 'Can\'t select database '.$config['moons_dbtable'].': '.mysql_error();
	}
	
	$prefix	= str_replace('_', '\_', mysql_real_escape_string($config['moons_dbprefix'], $link));
	
	foreach(array('users', 'config', 'session') as $table)
	{
		$query			= mysql_query("SHOW TABLES LIKE '".$prefix.$table."'", $link);
		if (!$query)
		{
			return 'MySQL Query Error: '.mysql_error().'<br>'."SHOW TABLES LIKE '".$prefix.$table."'";
		}
		
		$tableExists	= mysql_num_rows($query);
		if($tableExists !== 1)
		{
			return 'Table'.$config['moons_dbprefix'].$table.' not found!';
		}
	}
	
	$query			= mysql_query("SELECT COUNT(*) FROM ".mysql_real_escape_string($config['moons_dbprefix'], $link)."config WHERE uni = ".((int) $config['moons_universe']).";", $link);
	if (!$query)
	{
		return 'MySQL Query Error: '.mysql_error().'<br>'."SELECT COUNT(*) FROM ".mysql_real_escape_string($config['moons_dbprefix'], $link)."config WHERE uni = ".((int) $config['moons_universe']).";";
	}
	$universeExists	= mysql_num_rows($query);
	
	if($universeExists !== 1)
	{
		return 'Universe '.((int) $config['moons_universe']).' does not exists!';
	}
	
	@mysql_close($link);
	
	return false;
}

/**
* Login function
*/
function login_2moons(&$username, &$password)
{
	
	global $db, $config, $user;

	// do not allow empty password
	if (!$password)
	{
		return array(
			'status'	=> LOGIN_ERROR_PASSWORD,
			'error_msg'	=> 'NO_PASSWORD_SUPPLIED',
			'user_row'	=> array('user_id' => ANONYMOUS),
		);
	}

	if (!$username)
	{
		return array(
			'status'	=> LOGIN_ERROR_USERNAME,
			'error_msg'	=> 'LOGIN_ERROR_USERNAME',
			'user_row'	=> array('user_id' => ANONYMOUS),
		);
	}

	$port	= isset($config['moons_dbport']) ? (int) $config['moons_dbport'] : 3306;
	
	$link	= @mysql_connect($config['moons_dbhost'].':'.$port, $config['moons_dbuser'], $config['moons_dbpassword']);
	
	$prefix	= mysql_real_escape_string($config['moons_dbprefix'], $link);
	
	if (!$link)
	{
		return array(
			'status'		=> LOGIN_ERROR_EXTERNAL_AUTH,
			'error_msg'		=> 'CONNECTION_FAILED',
			'user_row'		=> array('user_id' => ANONYMOUS),
		);
	}

	mysql_select_db($config['moons_dbtable'], $link);
	mysql_set_charset('utf8', $link); 
	
	$sql		= "SELECT id, username, password, universe, email_2 FROM ".$prefix."users WHERE universe = ".((int) $config['moons_universe'])." AND username = '".mysql_real_escape_string($username, $link)."' AND password = '".cryptPassword2Moons($password)."';";
	$query		= mysql_query($sql, $link);
	
	if (!$query)
	{
		trigger_error('MySQL Query Error: '.mysql_error().'<br>'.$sql);
	}
	
	$userExists	= mysql_num_rows($query);
	
	if ($userExists == 1)
	{
		$userData	= mysql_fetch_array($query, MYSQL_ASSOC);

		@mysql_free_result($query);		
		@mysql_close($link);

		$sql ='SELECT user_id, username, user_password, user_passchg, user_email, user_type
			FROM ' . USERS_TABLE . "
			WHERE username_clean = '" . $db->sql_escape(utf8_clean_string($username)) . "'";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if ($row)
		{
			unset($userExists);

			// User inactive...
			if ($row['user_type'] == USER_INACTIVE || $row['user_type'] == USER_IGNORE)
			{
				return array(
					'status'		=> LOGIN_ERROR_ACTIVE,
					'error_msg'		=> 'ACTIVE_ERROR',
					'user_row'		=> $row,
				);
			}
			
			setcookie('phpbb_2moonsautologin', implode('|', array($row['user_id'], md5(implode('::', $userData)))), time() + 60*60*24*30);
			
			// Successful login... set user_login_attempts to zero...
			return array(
				'status'		=> LOGIN_SUCCESS,
				'error_msg'		=> false,
				'user_row'		=> $row,
			);
		}
		else
		{
			// retrieve default group id
			$sql = 'SELECT group_id
				FROM ' . GROUPS_TABLE . "
				WHERE group_name = '" . $db->sql_escape('REGISTERED') . "'
					AND group_type = " . GROUP_SPECIAL;
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			if (!$row)
			{
				trigger_error('NO_GROUP');
			}
			
			// generate user account data
			$moons_user_row = array(
				'username'		=> $username,
				'user_password'	=> phpbb_hash($password),
				'user_email'	=> $userData['email_2'],
				'group_id'		=> (int) $row['group_id'],
				'user_type'		=> USER_NORMAL,
				'user_ip'		=> $user->ip,
				'user_new'		=> ($config['new_member_post_limit']) ? 1 : 0,
			);
			
			setcookie('phpbb_2moonsautologin', implode('|', array($row['user_id'], md5(implode('::', $userData)))), time() + 60*60*24*30);

			// this is the user's first login so create an empty profile
			return array(
				'status'		=> LOGIN_SUCCESS_CREATE_PROFILE,
				'error_msg'		=> false,
				'user_row'		=> $moons_user_row,
			);
		}
	}
	
	unset($userExists);
	@mysql_close($link);

	return array(
		'status'	=> LOGIN_ERROR_USERNAME,
		'error_msg'	=> 'LOGIN_ERROR_USERNAME',
		'user_row'	=> array('user_id' => ANONYMOUS),
	);
}

function autologin_2moons()
{
	global $db, $config, $user;
	
	if(!isset($_COOKIE['phpbb_2moonsautologin']))
	{
		return array();
	}
	
	$port	= isset($config['moons_dbport']) ? (int) $config['moons_dbport'] : 3306;
		
	$link	= @mysql_connect($config['moons_dbhost'].':'.$port, $config['moons_dbuser'], $config['moons_dbpassword']);
	
	$prefix	= mysql_real_escape_string($config['moons_dbprefix'], $link);
	
	if (!$link)
	{
		return array(
			'status'		=> LOGIN_ERROR_EXTERNAL_AUTH,
			'error_msg'		=> 'CONNECTION_FAILED',
			'user_row'		=> array('user_id' => ANONYMOUS),
		);
	}

	mysql_select_db($config['moons_dbtable'], $link);
	mysql_set_charset('utf8', $link); 
	
	list($userID, $hash) = explode('|', $_COOKIE['phpbb_2moonsautologin']);
	
	$sql	= "SELECT id FROM ".$prefix."users WHERE MD5(CONCAT_WS('::', id, username, password, universe, email_2)) = '".mysql_real_escape_string($hash, $link)."';";
	$query	= mysql_query($sql, $link);
	
	if (!$query)
	{
		trigger_error('MySQL Query Error: '.mysql_error().'<br>'.$sql);
	}
	
	$userExists	= mysql_num_rows($query);
	
	if ($userExists == 1)
	{
		@mysql_close($link);

		$sql ='SELECT user_id, username, user_password, user_passchg, user_email, user_type
			FROM ' . USERS_TABLE . "
			WHERE user_id = " . ((int) $userID) . "";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);


		if ($row)
		{
			setcookie('phpbb_2moonsautologin', $_COOKIE['phpbb_2moonsautologin'], 31536000);
			return ($row['user_type'] == USER_INACTIVE || $row['user_type'] == USER_IGNORE) ? array() : $row;
		} else {
			setcookie('phpbb_2moonsautologin', '', time() - 3600);
		}
	} else {
		@mysql_close($link);
	}
	
	unset($userExists);

	return array();
}

/**
* This function is used to output any required fields in the authentication
* admin panel. It also defines any required configuration table fields.
*/
function acp_2moons(&$new)
{
	global $user;

	$tpl = '

	<dl>
		<dt><label for="moons_dbhost">2Moons-Database-Host:</label></dt>
		<dd><input type="text" id="moons_dbhost" size="40" name="config[moons_dbhost]" value="' . $new['moons_dbhost'] . '" /></dd>
	</dl>
	<dl>
		<dt><label for="moons_dbport">2Moons-Database-Port:</label></dt>
		<dd><input type="text" id="moons_dbport" size="40" name="config[moons_dbport]" value="' . $new['moons_dbport'] . '" /></dd>
	</dl>
	<dl>
		<dt><label for="moons_dbuser">2Moons-Database-User:</label></dt>
		<dd><input type="text" id="moons_dbuser" size="40" name="config[moons_dbuser]" value="' . $new['moons_dbuser'] . '" /></dd>
	</dl>
	<dl>
		<dt><label for="moons_dbpassword">2Moons-Database-Password:</label></dt>
		<dd><input type="password" id="moons_dbpassword" size="40" name="config[moons_dbpassword]" value="' . $new['moons_dbpassword'] . '" autocomplete="off" /></dd>
	</dl>
	<dl>
		<dt><label for="moons_dbtable">2Moons-Database-Table:</label></dt>
		<dd><input type="text" id="moons_dbtable" size="40" name="config[moons_dbtable]" value="' . $new['moons_dbtable'] . '" /></dd>
	</dl>
	<dl>
		<dt><label for="moons_dbprefix">2Moons-Database-Prefix:</label></dt>
		<dd><input type="text" id="moons_dbprefix" size="40" name="config[moons_dbprefix]" value="' . $new['moons_dbprefix'] . '" /></dd>
	</dl>
	<dl>
		<dt><label for="moons_salt">2Moons-Passwort-Salt:</label><br /><span>Definded at ./includes/config.php in $salt</span></dt>
		<dd><input type="text" id="moons_salt" size="40" name="config[moons_salt]" value="' . $new['moons_salt'] . '" /></dd>
	</dl>
	<dl>
		<dt><label for="moons_universe">2Moons Universe:</label><br /><span>MultiUniverse is currently unsupported.<br>Default: 1</span></dt>
		<dd><input type="text" id="moons_universe" size="40" name="config[moons_universe]" value="' . $new['moons_universe'] . '"/></dd>
	</dl>
	';

	// These are fields required in the config table
	return array(
		'tpl'		=> $tpl,
		'config'	=> array('moons_dbhost', 'moons_dbport', 'moons_dbuser', 'moons_dbpassword', 'moons_dbtable', 'moons_dbprefix', 'moons_salt', 'moons_universe')
	);
}

// 2Moons functions

function cryptPassword2Moons($password)
{
	// http://www.phpgangsta.de/schoener-hashen-mit-bcrypt
	global $config;
	if(!CRYPT_BLOWFISH || !isset($config['moons_salt']))
	{
		return md5($password);
	} else {
		return crypt($password, '$2a$09$'.$config['moons_salt'].'$');
	}
}

?>