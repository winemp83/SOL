if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");
function ShowForumPage(){
	global $LNG, $USER, $LANG, $db, $DMGut;
	
	$id = HTTP::_GP('id', 0);
	
}
