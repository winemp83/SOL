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
					echo "<span style=\"color:red;\"><b>Der neue </b><a href=\"http://space.landoflegends.de/index.php?page=SingleNews\" target=\"_blank\">Commanderbericht 12</a><b> ist erschienen</b></span>";
					break;
			case 2 :
					echo "<span style=\"color:gold;\">Meldet euch jetzt als Suporter und helft mit besser zu werden! Meldet euch jetzt via Support Ticket</span>";
					break;
			case 3 :
					echo "<span style=\"color:green;\">Commander wir haben ein Meteroitenschauer Entdeckt lesen sie mehr im Forum</span>";
					break;
			default:
					echo "<span style=\"color:white;\">Aktuelle Fortschritte vom Code-Audit zeigen wir euch immer im Forum</span>";
					break;		
		}
		
	}
}
?>