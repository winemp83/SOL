<?php

class ShowFacebookPage extends AbstractPage {
	public static $requireModule = MODULE_CHAT;

	function __construct() {
		parent::__construct();
	}

	function show() {
		$app_id = '280384735383118';
		$app_secret = '	198af0a823be26e34877ceb360ea619a';
		$canvas_page_url = 'https://www.facebook.com/appcenter/spacelandoflegends';

		// The Achievement URL
		$achievement = 'https://graph.facebook.com/me/spacelandoflegends:spielt?
access_token=ACCESS_TOKEN&
method=POST&
website=http%3A%2F%2Ftest.landoflegends.de';
		$achievement_display_order = 1;

		// The Score
		$score = '1';

		// Authenticate the user
		session_start();
		if (isset($_REQUEST["code"])) {
			$code = $_REQUEST["code"];
		}

		if (empty($code) && !isset($_REQUEST['error'])) {
			$_SESSION['state'] = md5(uniqid(rand(), TRUE));
			//CSRF protection
			$dialog_url = 'https://www.facebook.com/dialog/oauth?' . 'client_id=' . $app_id . '&redirect_uri=' . urlencode($canvas_page_url) . '&state=' . $_SESSION['state'] . '&scope=publish_actions';

			print('<script> top.location.href=\'' . $dialog_url . '\'</script>');
			exit ;
		} else if (isset($_REQUEST['error'])) {
			// The user did not authorize the app
			print($_REQUEST['error_description']);
			exit ;
		}
		;

		// Get the User ID
		$signed_request = parse_signed_request($_POST['signed_request'], $app_secret);
		$uid = $signed_request['user_id'];

		// Get an App Access Token
		$token_url = 'https://graph.facebook.com/oauth/access_token?' . 'client_id=' . $app_id . '&client_secret=' . $app_secret . '&grant_type=client_credentials';

		$token_response = file_get_contents($token_url);
		$params = null;
		parse_str($token_response, $params);
		$app_access_token = $params['access_token'];

		// Register an Achievement for the app
		print('Register Achievement:<br/>');
		$achievement_registration_URL = 'https://graph.facebook.com/' . $app_id . '/achievements';
		$achievement_registration_result = https_post($achievement_registration_URL, 'achievement=' . $achievement . '&display_order=' . $achievement_display_order . '&access_token=' . $app_access_token);
		print('<br/><br/>');

		// POST a user achievement
		print('Publish a User Achievement<br/>');
		$achievement_URL = 'https://graph.facebook.com/' . $uid . '/achievements';
		$achievement_result = https_post($achievement_URL, 'achievement=' . $achievement . '&access_token=' . $app_access_token);
		print('<br/><br/>');

		// POST a user score
		print('Publish a User Score<br/>');
		$score_URL = 'https://graph.facebook.com/' . $uid . '/scores';
		$score_result = https_post($score_URL, 'score=' . $score . '&access_token=' . $app_access_token);
		print('<br/><br/>');
		
		$this->tblObj->assign_vars(array(
		'result' => $score_result,
		));
		
		$this->display('test.tpl');
		

	}

function https_post($uri, $postdata) {
			$ch = curl_init($uri);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
			$result = curl_exec($ch);
			curl_close($ch);

			return $result;
		}

		function parse_signed_request($signed_request, $secret) {
			list($encoded_sig, $payload) = explode('.', $signed_request, 2);

			// decode the data
			$sig = base64_url_decode($encoded_sig);
			$data = json_decode(base64_url_decode($payload), true);

			if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
				error_log('Unknown algorithm. Expected HMAC-SHA256');
				return null;
			}

			// check sig
			$expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
			if ($sig !== $expected_sig) {
				error_log('Bad Signed JSON signature!');
				return null;
			}

			return $data;
		}

		function base64_url_decode($input) {
			return base64_decode(strtr($input, '-_', '+/'));
		}

}
?>