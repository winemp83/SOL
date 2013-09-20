<?php

class ShowConvitePage extends AbstractPage 
{
	function __construct() 
	{
		global $USER, $PLANET, $LNG, $allianceData, $db, $UNI, $CONF;
		parent::__construct();
		$mode = HTTP::_GP('mode', '');
		switch($mode){
			case 'index':
			default:
		 if($USER['ally_id'] == 0){
		 $this->printMessage("Sie müssen erst eine Allianz erstellen");
		 exit;
		 }

			$this->tplObj->assign_vars(array(
                'username'=> HTTP::_GP('username', ''),     
                'debug'=> (Config::get('debug') == 1) ? " checked='checked'/":'',
                ));
			$this->display("convite_body.tpl"); 
			break;
			
			case'change':
		global $USER, $PLANET, $LNG, $db, $UNI;
		$mode  = HTTP::_GP('mode', '');
   		if ($mode == 'change')    {
       // Yazdir gelsin
      	if (isset($_POST['username'])) {  
		  
         $sq      = $GLOBALS['DATABASE']->query("SELECT * FROM ".USERS." WHERE `username` = '".$_POST['username']."' ");
			while($StatRow = $GLOBALS['DATABASE']->fetch_array($sq)){
         $Time    = time();
		 $id = $StatRow['id'];

         $From    = "".$USER['username']."";
         $Subject = "Einladung in eine Allianz";
           $allianceCount = $GLOBALS['DATABASE']->query("SELECT DISTINCT ally_name FROM ".ALLIANCE.";");
			while($ally = $GLOBALS['DATABASE']->fetch_array($allianceCount)){
         $Message = '<center>Der Gründer der Allianz <font color=red>'.$ally['ally_name'].'</font><br><br>Lädt dich ein, seiner Allianz beizutretten<br><a href="game.php?page=alliance&mode=apply&allyid='.$USER['ally_id'].'"><font color=#00FF00>Klicke Hier um der Allianz bei zutretten </font></a></center>';
         $summery=0;   
         }
                     
          SendSimpleMessage ( $StatRow['id'], $USER['id'], TIMESTAMP, 1, $From, $Subject, $Message);
         }   
       // Yazdir bakalim nere kadar yazdircan daha
       $this->printMessage('<font color=#00FF00><<< Nachricht erfolgreich gesendet >>></font>', "game.php?page=overview", 2);
		 exit;
		 }
   }
   }
   }   }
?>