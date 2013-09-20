<?php
/**
 * Special-Planet-/TF-Event for 2Moons
 * @Mod for 2Moons 1.7.1 / Ref 2604
 * @author Racer <webmaster@myplanets.de>
 * @version 1.7.2 (20.01.2013)
 * @link http://www.myplanets.de
 */


if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;
function ShowEventplanet()
{
    global $db, $CONF, $LNG, $USER;
   
    $template    = new template();
    
	
    $template->assign_vars(array(
            'name'              => $LNG['ev_name'],
            'eventplaneten'     => $LNG['ev_eventplaneten'],
            'user_id'           => $LNG['ev_user_id'],
            'planeten_anzahl'   => $LNG['ev_planet_anzahl'],
            'position_von'      => $LNG['ev_position_von'],
            'position_bis'      => $LNG['ev_position_bis'],
            'rohstoffe_von'     => $LNG['ev_ress_von'],
            'rohstoffe_bis'     => $LNG['ev_ress_bis'],
			'verteidigung'		=> $LNG['ev_verteidigung'],
			'ev_angriff'		=> $LNG['ev_angriff'],			
			'schiffe'			=> $LNG['ev_schiffe'],
			'k_schildkuppel' 	=> $LNG['ma_small_protection_shield'],
			'gr_schildkuppel'	=> $LNG['ma_big_protection_shield'],
			'giga_schildkuppel'	=> $LNG['tech'][409],	
            'gausskanone'		=> $LNG['ma_gauss_canyon'],		
            'plasmawerfer'		=> $LNG['ma_buster_canyon'],	
			'l_jaeger'			=> $LNG['tech'][204],
			'schlachtschiff'	=> $LNG['tech'][207],
			'todesstern'		=> $LNG['tech'][214],	
			'lune'				=> $LNG['tech'][216],
			'planetdata'		=> $LNG['ev_planetdata'],
			'anzplanet'			=> $LNG['ev_anzplanet'],
			'ev_anzevtf'    	=> $LNG['ev_anzevtf'],			
			'ev_start'			=> $LNG['ev_start'],
			'ev_delempty'		=> $LNG['ev_delempty'],
			'ev_delall'			=> $LNG['ev_delall'],
			'ev_planet'			=> $LNG['ev_evplanet'],	
            'ev_tfplanet'		=> $LNG['ev_tfplanet'],
            'ev_attack'			=> $LNG['ev_attack'],			
			'ev_info'			=> $LNG['ev_info'],	
			'ev_infotext'		=> $LNG['ev_infotext'],						
			'ev_attackinfo'		=> $LNG['ev_attackinfo'],
			'ev_attackinfo_msg'	=> $LNG['ev_attackinfo_msg'],		
    		//neu
    		'KleineTransporter'	=> $LNG['tech'][202],
    		'GroßeTransporter'	=> $LNG['tech'][203],
    		'SchwereJaeger'	=> $LNG['tech'][205],
    		'Ionenkanonnen'	=> $LNG['tech'][405],
    		'Raketenwerfer'	=> $LNG['tech'][401],
    		'Schwerelaeser'	=> $LNG['tech'][403],
    		
    
            ));
    
    if($_POST['senden'])
    {

        $planet_name    =    HTTP::_GP('planet_name', '', true);
        $id_user        =    HTTP::_GP('id_user', '0');
        $anzahl         =    HTTP::_GP('anzahl', '0');
        $galaxy         =    HTTP::_GP('galaxy', '0');
        $system         =    HTTP::_GP('system', '0');
        $planet         =    HTTP::_GP('planet', '0');
        $galaxy2        =    HTTP::_GP('galaxy_2', '0');
        $system2        =    HTTP::_GP('system_2', '0');
        $planet2        =    HTTP::_GP('planet_2', '0');
        $ress_von       =    HTTP::_GP('ress_von', '0');
        $ress_bis       =    HTTP::_GP('ress_bis', '0');
		$planetevent    =    HTTP::_GP('planetevent', '0');
		$TF_Event       =    HTTP::_GP('TF_Event', '0');
		$ev_attack      =    HTTP::_GP('ev_attack', '0');
		$gauss_bis		=    HTTP::_GP('gauss_bis', '0');
		$plasma_bis		=    HTTP::_GP('plasma_bis', '0');
		$ljaeger_bis	=    HTTP::_GP('ljaeger_bis', '0');
		$schlachts_bis	=    HTTP::_GP('schlachts_bis', '0');
		$todesstern_bis	=    HTTP::_GP('todesstern_bis', '0');	
		$lune_bis		=    HTTP::_GP('lune_bis', '0');
		$k_schild  		=    HTTP::_GP('k_schild', '0');	
		$gr_schild  	=    HTTP::_GP('gr_schild', '0');	
		$g_schild  		=    HTTP::_GP('g_schild', '0');
		$ev_attval		=    HTTP::_GP('ev_attval', '0');
		$attack_mail	=    HTTP::_GP('ev_attack_mail', '0');
	    $universe = 1;
	    //neu
	    $ktrans_bis	=    HTTP::_GP('ktrans_bis', '0');
	    $gtrans_bis	=    HTTP::_GP('gtrans_bis', '0');
	    $sjaeger_bis	=    HTTP::_GP('sjaeger_bis', '0');
	    $raket_bis	=    HTTP::_GP('raket_bis', '0');
	    $slaser_bis	=    HTTP::_GP('slaser_bis', '0');
	    $ionen_bis	=    HTTP::_GP('ionen_bis', '0');

       
	   
     if($planetevent < 1 && $TF_Event < 1)
		{
			$template->Message($LNG['ev_erro1'],'admin.php?page=eventplanet');
			sleep(3);
			exit;
		}
	
		$ev_user = $GLOBALS['DATABASE']->uniquequery("SELECT `id`, `authlevel`, `username` FROM ".USERS." WHERE `id` = '".$id_user."' AND `universe` = '".$_SESSION['adminuni']."';");	  

	  //$username =$user[
		if(!isset($ev_user))
		{
			$template->Message($LNG['ev_erro3'],'admin.php?page=eventplanet');
			sleep(3);
			exit;
		}
		else
		{
		$ev_user_akt = $ev_user['username'];
		}
		
		
        if($galaxy <= 9 && $galaxy >= 1  && $system <= 499 && $system >= 1 && $planet <= 15 && $planet >= 1 && $galaxy2 <= 9 && $system2 <= 499 && $planet2 <= 15)
        {
	
		 for($i=0; $i < $anzahl; $i++)
            {
                $gala         =    mt_rand($galaxy,$galaxy2);
                $syst         =    mt_rand($system,$system2);
                $plan         =    mt_rand($planet,$planet2);
                $ress_metal   =    mt_rand($ress_von,$ress_bis);
                $ress_crystal =    mt_rand($ress_von,$ress_bis);
				$ress_deut	  =	   mt_rand($ress_von,$ress_bis);
				$field_max	  =    mt_rand(65,246);
				
			    $small_protection_shield =  mt_rand(0,$k_schild);
			    $big_protection_shield 	 =  mt_rand(0,$gr_schild);
			    $planet_protector 		 =  mt_rand(0,$g_schild);
				
				
				$lune_noir    =    mt_rand(0,$lune_bis);
                $gauss_canyon =	   mt_rand(0,$gauss_bis);
			    $buster_canyon =   mt_rand(0,$plasma_bis);
				$light_hunter  =   mt_rand(0,$ljaeger_bis);
			    $battle_ship =   mt_rand(0,$schlachts_bis);
				$dearth_star =   mt_rand(0,$todesstern_bis);
				//neu
				$heavy_hunter =   mt_rand(0,$sjaeger_bis);
				$small_ship_cargo =   mt_rand(0,$ktrans_bis);
				$big_ship_cargo =   mt_rand(0,$gtrans_bis);
				$big_laser =   mt_rand(0,$slaser_bis);
				$ionic_canyon =   mt_rand(0,$ionen_bis);
				$misil_launcher =   mt_rand(0,$raket_bis);
					
                $exists    =    $GLOBALS['DATABASE']->countquery("SELECT count(*) AS planet_count FROM ".PLANETS." WHERE galaxy = '".$GLOBALS['DATABASE']->sql_escape($gala)."' AND system = '".$GLOBALS['DATABASE']->sql_escape($syst)."' AND planet = '".$GLOBALS['DATABASE']->sql_escape($plan)."'");
              
				if($exists != 0)
			     {
                 $i--;
                }
                else
                {
                  if($planetevent == 1 && $TF_Event == 1) // Planeten- und TF-Event
				  {
				 	 $einf    =    $GLOBALS['DATABASE']->query("INSERT INTO ".PLANETS." SET name = '".$GLOBALS['DATABASE']->sql_escape($planet_name)."', id_owner = '".$GLOBALS['DATABASE']->sql_escape($id_user)."', universe = '".$GLOBALS['DATABASE']->sql_escape($universe)."', galaxy = '".$GLOBALS['DATABASE']->sql_escape($gala)."', system = '".$GLOBALS['DATABASE']->sql_escape($syst)."', planet = '".$GLOBALS['DATABASE']->sql_escape($plan)."', field_max = '".$GLOBALS['DATABASE']->sql_escape($field_max)."', der_metal = '".$GLOBALS['DATABASE']->sql_escape($ress_metal)."', der_crystal = '".$GLOBALS['DATABASE']->sql_escape($ress_crystal)."', lune_noir = '".$GLOBALS['DATABASE']->sql_escape($lune_noir)."', gauss_canyon = '".$GLOBALS['DATABASE']->sql_escape($gauss_canyon)."', buster_canyon = '".$GLOBALS['DATABASE']->sql_escape($buster_canyon)."', small_protection_shield = '".$GLOBALS['DATABASE']->sql_escape($small_protection_shield)."', big_protection_shield = '".$GLOBALS['DATABASE']->sql_escape($big_protection_shield)."', planet_protector = '".$GLOBALS['DATABASE']->sql_escape($planet_protector)."' , light_hunter = '".$GLOBALS['DATABASE']->sql_escape($light_hunter)."', battle_ship = '".$GLOBALS['DATABASE']->sql_escape($battle_ship)."', dearth_star = '".$GLOBALS['DATABASE']->sql_escape($dearth_star)."', metal = '".$GLOBALS['DATABASE']->sql_escape($ress_metal)."' , crystal = '".$GLOBALS['DATABASE']->sql_escape($ress_crystal)."' , deuterium = '".$GLOBALS['DATABASE']->sql_escape($ress_deut)."' , ev_planet = '1',  ev_attack = '".$GLOBALS['DATABASE']->sql_escape($ev_attack)."', ev_attval = '".$GLOBALS['DATABASE']->sql_escape($ev_attval)."', heavy_hunter = '".$GLOBALS['DATABASE']->sql_escape($heavy_hunter)."', big_ship_cargo = '".$GLOBALS['DATABASE']->sql_escape($big_ship_cargo)."', small_ship_cargo = '".$GLOBALS['DATABASE']->sql_escape($small_ship_cargo)."', big_laser = '".$GLOBALS['DATABASE']->sql_escape($big_laser)."', ionic_canyon = '".$GLOBALS['DATABASE']->sql_escape($ionic_canyon)."', misil_launcher = '".$GLOBALS['DATABASE']->sql_escape($misil_launcher)."'");
                
					$Subject = $LNG['ev_subject_pl_tf'];
					$Message = sprintf($LNG['ev_msg_pl_tf'], $ev_user_akt, $anzahl, $galaxy, $system, $planet, $galaxy2, $system2, $planet2);
					$ev_msg=10;
							
				 }
				 
				 if($planetevent == 1 && $TF_Event == 0) // Planeten-Event
				  {
				 	 $einf    =    $GLOBALS['DATABASE']->query("INSERT INTO ".PLANETS." SET name = '".$GLOBALS['DATABASE']->sql_escape($planet_name)."', id_owner = '".$GLOBALS['DATABASE']->sql_escape($id_user)."', universe = '".$GLOBALS['DATABASE']->sql_escape($universe)."', galaxy = '".$GLOBALS['DATABASE']->sql_escape($gala)."', system = '".$GLOBALS['DATABASE']->sql_escape($syst)."', planet = '".$GLOBALS['DATABASE']->sql_escape($plan)."', field_max = '".$GLOBALS['DATABASE']->sql_escape($field_max)."', lune_noir = '".$GLOBALS['DATABASE']->sql_escape($lune_noir)."', gauss_canyon = '".$GLOBALS['DATABASE']->sql_escape($gauss_canyon)."', buster_canyon = '".$GLOBALS['DATABASE']->sql_escape($buster_canyon)."', small_protection_shield = '".$GLOBALS['DATABASE']->sql_escape($small_protection_shield)."', big_protection_shield = '".$GLOBALS['DATABASE']->sql_escape($big_protection_shield)."', planet_protector = '".$GLOBALS['DATABASE']->sql_escape($planet_protector)."' , light_hunter = '".$GLOBALS['DATABASE']->sql_escape($light_hunter)."', battle_ship = '".$GLOBALS['DATABASE']->sql_escape($battle_ship)."', dearth_star = '".$GLOBALS['DATABASE']->sql_escape($dearth_star)."', metal = '".$GLOBALS['DATABASE']->sql_escape($ress_metal)."' , crystal = '".$GLOBALS['DATABASE']->sql_escape($ress_crystal)."' , deuterium = '".$GLOBALS['DATABASE']->sql_escape($ress_deut)."' , ev_planet = '1',  ev_attack = '".$GLOBALS['DATABASE']->sql_escape($ev_attack)."', ev_attval = '".$GLOBALS['DATABASE']->sql_escape($ev_attval)."', heavy_hunter = '".$GLOBALS['DATABASE']->sql_escape($heavy_hunter)."', big_ship_cargo = '".$GLOBALS['DATABASE']->sql_escape($big_ship_cargo)."', small_ship_cargo = '".$GLOBALS['DATABASE']->sql_escape($small_ship_cargo)."', big_laser = '".$GLOBALS['DATABASE']->sql_escape($big_laser)."', ionic_canyon = '".$GLOBALS['DATABASE']->sql_escape($ionic_canyon)."', misil_launcher = '".$GLOBALS['DATABASE']->sql_escape($misil_launcher)."'");

					$Subject = $LNG['ev_subject_pl'];
					$Message = sprintf($LNG['ev_msg_pl'], $ev_user_akt, $anzahl, $galaxy, $system, $planet, $galaxy2, $system2, $planet2);			
					$ev_msg=20;
                  }	
				  
				  if($planetevent == 0 && $TF_Event == 1) // TF-Event
				  {
				 	 $einf    =    $GLOBALS['DATABASE']->query("INSERT INTO ".PLANETS." SET name = '".$GLOBALS['DATABASE']->sql_escape($planet_name)."', id_owner = '".$GLOBALS['DATABASE']->sql_escape($id_user)."', universe = '".$GLOBALS['DATABASE']->sql_escape($universe)."', galaxy = '".$GLOBALS['DATABASE']->sql_escape($gala)."', system = '".$GLOBALS['DATABASE']->sql_escape($syst)."', planet = '".$GLOBALS['DATABASE']->sql_escape($plan)."', field_max = '0', der_metal = '".$GLOBALS['DATABASE']->sql_escape($ress_metal)."', der_crystal = '".$GLOBALS['DATABASE']->sql_escape($ress_crystal)."', ev_planet = '1',  ev_attack = '".$GLOBALS['DATABASE']->sql_escape($ev_attack)."'");
 
					$Subject = $LNG['ev_subject_tf'];
					$Message = sprintf($LNG['ev_msg_tf'], $galaxy, $system, $planet, $galaxy2, $system2, $planet2, $anzahl  );
					$ev_msg=30; 
                  }	
				  
				}
             }
  
			// e-Mail Erstellung		
            $Time        = TIMESTAMP;
            $From        = '<span style="color:red;">'.$LNG['user_level'][$USER['authlevel']].' '.$USER['username'].'</span>';
            $Subject     = '<span style="color:red;">'.$Subject.'</span>';
            $Message     = '<span style="color:red;font-weight:bold;">'.$Message.'</span>';

			$USERS		 = $GLOBALS['DATABASE']->query("SELECT `id` FROM ".USERS." WHERE `universe` = '".$_SESSION['adminuni']."'");
				while($UserData = $GLOBALS['DATABASE']->fetch_array($USERS)) {
				     SendSimpleMessage($UserData['id'], $USER['id'], TIMESTAMP, 50, $From, $Subject, $Message);
                          	}
          

			switch($ev_msg)
			{
			case '10':
				echo(sprintf($LNG['ev_msg_mail1'] , $anzahl ));
				break;
			case '20':
				echo(sprintf($LNG['ev_msg_mail2'], $anzahl ));
				break;
			case '30':
				echo(sprintf($LNG['ev_msg_mail3'], $anzahl ));
				break;
		    }
	  
        }
        else
		{
		$template->Message($LNG['ev_erro2'],'admin.php?page=eventplanet');
		sleep(3);
		exit;
		}
	}
    


	if($_POST['loeschen'])
		{
        $GLOBALS['DATABASE']->query("DELETE FROM ".PLANETS." WHERE ev_planet = '1'");
        echo($LNG['ev_del_info']);
		}
   
	if($_POST['delleertf'])
		{
        $GLOBALS['DATABASE']->query("DELETE FROM ".PLANETS." WHERE ev_planet = '1' and der_metal ='0' and der_crystal ='0' and metal = '0' and crystal = '0' and deuterium = '0'");
        echo($LNG['ev_del_info2']);
		}

   
    
	if($_POST['anzplanet'])
		{
        $ausanztf  =    $GLOBALS['DATABASE']->uniquequery("SELECT COUNT(*) as anztf FROM ".PLANETS." WHERE ev_planet = '1' ");
        $wert = $ausanztf['anztf']; 
        echo "Noch " .$wert. " Event-Planeten vorhanden!";
		}
    
     if($_POST['anztf'])
		{
        $ausanztf  =    $GLOBALS['DATABASE']->uniquequery("SELECT COUNT(*) as anztf FROM ".PLANETS." WHERE ev_planet = '1' and der_metal > '0' and der_crystal > '0'");
        $wert = $ausanztf['anztf']; 
        echo "Noch " .$wert. " Event-Trümmerfelder vorhanden!";
		}

    
    $template->show('Eventplanet.tpl');
}
?> 


