<?php
if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");

function ShowAllianzOverview(){
	$template	= new template();
	$alliance = array();
	if(!isset($_POST['menue']) || empty($_POST['menue'])){
		$menue = 0;
	}
	else{
		$menue = $_POST['menue'];
	}
	
	switch ($menue){
		case 1 :
				break;
		default:
				$sql = $GLOBALS['DATABASE']->query("SELECT * FROM uni1_alliance");
				while($result = $GLOBALS['DATABASE']->fetch_array($sql)){
					$sql1 = $GLOBALS['DATABASE']->query("SELECT * FROM uni1_alli_bonus WHERE id='".$result['id']."'");
					while($result2 = $GLOBALS['DATABASE']->fetch_array($sql1)){
						$bonus = array(
							'pro'		=> $result2['produktion'],
							'def'		=> $result2['defense'],
							'atk'		=> $result2['attack'],
							'res'		=> $result2['research'],
							'bui'		=> $result2['building'],
							'slo'		=> $result2['slots'],
							'top'		=> $result2['topics'],
						);
					}

					$dataRow =$GLOBALS['DATABASE']->query("SELECT COUNT(id) FROM uni1_ally_topic WHERE ally_id='".$result['id']."'");
					foreach($dataRow as $result3){
						$data = $result3['COUNT(id)'];
					}
					
					$alliance[] = array(
						'a_id' 		=> $result['id'],
						'a_name'	=> $result['ally_name'],
						'a_tag'		=> $result['ally_tag'],
						'a_owner'	=> getData(2, $result['ally_owner'], 0),
						'a_met'		=> $result['ally_met'],
						'a_kri'		=> $result['ally_krist'],
						'a_deu'		=> $result['ally_deut'],
						'a_akt_u'	=> $result['ally_members'],
						'a_akt_t'	=> $data,
						'a_max_u'	=> $bonus['slo'] + 5,
						'a_max_t'	=> $bonus['top'] + 5,
						'a_bo_pro'	=> $bonus['pro'],
						'a_bo_def'	=> $bonus['def'],
						'a_bo_atk'	=> $bonus['atk'],
						'a_bo_res'	=> $bonus['res'],
						'a_bo_bui'	=> $bonus['bui'],
						'a_bo_slo'	=> $bonus['slo'],
						'a_bo_top'	=> $bonus['top'],
					);
			
				}
				$template->assign_vars(array(
					'list'		=>$alliance,
					'bonus'		=>$bonus,
				));
				$template->show('AllianzOverview.tpl');
				break;
	}
}

function getData($menue, $owner, $allyID){
	if($menue == 0){
		error(0);
	}
	else{
		$sql1 = "SELECT (id) FROM uni1_alliance";
		switch ($menue){
			case 1 :
					$data = $GLOBALS['DATABASE']->query($sql1);
					return $data;
					break;
			case 2 :
					$dataRow = $GLOBALS['DATABASE']->query("SELECT (username) FROM uni1_users WHERE id='".$owner."'");
					foreach($dataRow as $row){
						$data = $row['username'];
					}
					return $data;
					break;
			case 3 :
					$data = $GLOBALS['DATABASE']->query("SELECT topics FROM uni1_alli_bonus WHERE id='".$allyID."'");
					return $data;
					break;
			case 4 :
					$dataRow =$GLOBALS['DATABASE']->query("SELECT COUNT(id) FROM uni1_ally_topic WHERE id='".$allyID."'");
					foreach($dataRow as $result){
						$data = $dataRow['COUNT(id)'];
						print_r($data);
					}
					return $data;
					break;
			default:
					break;
		}
	}
}

function setData($menue){
	
}
?>
	