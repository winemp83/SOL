<?php
class ShowShoutboxPage extends AbstractPage 
{
	public static $requireModule = MODULE_SUPPORT;
	protected $help = '';	

	function __construct() 
	{
		parent::__construct();
		
	}
		
	function show()
	{
		global $USER;
		foreach($GLOBALS['DATABASE']->query("SELECT (lastonline) FROM ".SESSION." WHERE userID='".$USER['id']."'") as $data){
			$check = $data['lastonline'];
			$check_a = time()-(60*15);
			if($check < $check_a){
				header('Location: http://space.landoflegends.de');
				die();
			}
			else{
				$GLOBALS['DATABASE']->query("UPDATE ".SESSION." SET lastonline='".time()."' WHERE userID='".$USER['id']."'");
			}	
		}
		if($USER['ally_id'] == 0){
			echo "Sie müssen in einer Allianz sein!";
		}
		else{
				$this->getData($USER['ally_id']);
				echo $this->help;
			if(!empty($_POST['ajaxnews'])){
				$this->setData($_POST['ajaxnews'], $USER['username'], $USER['ally_id']);
				$this->help = '';
			}	
		}
		
	}
	
	protected function getData($ally_id){
		$result = $GLOBALS['DATABASE']->query("SELECT * FROM ".ALLYBOX." WHERE ally_id='".$GLOBALS['DATABASE']->sql_escape($ally_id)."' ORDER BY id DESC LIMIT 5");
		foreach($result as $Data){
			$this->help .= " <span style=\"color:red;\"> ".date("H:i:s",$Data['time'])."</span> <span style=\"color:gold;\">".htmlspecialchars($Data['user'])."</span><br/> &nbsp;".htmlspecialchars(substr($Data['news'], 0, 60))." <br/>";
		}
	}
	
	protected function setData($news, $user, $ally){
		$n = $news;
		$u = $user;
		$a = $ally; 
		$GLOBALS['DATABASE']->query("INSERT INTO ".ALLYBOX." SET 
				news		= '".$GLOBALS['DATABASE']->sql_escape($n)."',
				user		= '".$GLOBALS['DATABASE']->sql_escape($u)."',
				ally_id		= '".$GLOBALS['DATABASE']->sql_escape($a)."',
				time		= '".time()."'
				;");
	}
}
?>
		