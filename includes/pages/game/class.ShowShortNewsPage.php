<?php
class ShowShortNewsPage extends AbstractPage 
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
		if(empty($_POST['ajaxpostone']) || !isset($_POST['ajaxpostone'])){
			$id = 1;
		}
		else{
			$id = $_POST['ajaxpostone'];
		}
		switch ($id){
			case 1 :
					echo "<span style=\"color:red;\"><b>Der neue </b><a href=\"http://space.landoflegends.de/index.php?page=SingleNews\" target=\"_blank\">Commanderbericht 13</a><b> ist erschienen</b></span>";
					break;
			case 2 :
					echo "<span style=\"color:gold;\">Wir suchen Tester und Scripter bei Intresse meldet euch via Support Ticket</span>";
					break;
			case 3 :
					echo "<span style=\"color:green;\">Commander wir beobachten mehere Piraten die sich im System ansiedeln, machen Sie sich bereit</span>";
					break;
			default:
					echo "<span style=\"color:white;\">Wir entschuldigen usn für den kurzfristigen ausfall des Spiels am Sonntag den, 20.10.2013</span>";
					break;		
		}
		
	}
}
?>