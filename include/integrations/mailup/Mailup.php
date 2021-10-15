<?php
/*************************************************************************************************
 * Copyright 2021 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS customizations.
 * You can copy, adapt and distribute the work under the "Attribution-NonCommercial-ShareAlike"
 * Vizsage Public License (the "License"). You may not use this file except in compliance with the
 * License. Roughly speaking, non-commercial users may share and modify this code, but must give credit
 * and share improvements. However, for proper details please read the full License, available at
 * http://vizsage.com/license/Vizsage-License-BY-NC-SA.html and the handy reference for understanding
 * the full license at http://vizsage.com/license/Vizsage-Deed-BY-NC-SA.html. Unless required by
 * applicable law or agreed to in writing, any software distributed under the License is distributed
 * on an  "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and limitations under the
 * License terms of Creative Commons Attribution-NonCommercial-ShareAlike 3.0 (the License).
 *************************************************************************************************
 *  Module    : Hubspot Integration
 *  Version   : 1.0
 *  Author    : JPL TSolucio, S. L.
 *************************************************************************************************/
include_once 'vtlib/Vtiger/Module.php';
require_once 'include/Webservices/Revise.php';
require_once 'include/Webservices/Create.php';
require_once 'include/integrations/mailup/lib/MailUpClient.php';
require_once 'include/integrations/sendgrid/vendor/autoload.php';
require_once 'include/events/include.inc';
require 'vendor/autoload.php';


class corebos_mailup {
	// Configuration Properties
	private $API_URL = 'tsolucio';
	private $clientId = '';
	private $clientSecret = '';
	private $mailup_password = '';
	private $mailup_username = '';
	private $mailup;

	// Configuration Keys
	const KEY_ISACTIVE = 'mailup_isactive';
	const KEY_API_URL = 'mailup_apiurl';
	const USERNAME = 'mailup_username';
	const PASSWORD = 'mailup_password';
	const KEY_ACCESSID = 'mailup_client_id';
	const KEY_ACCESSSECRET = 'mailup_client_secret';

	// Debug
	const DEBUG = true;

	// Errors
	public static $ERROR_NONE = 0;
	public static $ERROR_NOTCONFIGURED = 1;
	public static $ERROR_NOACCESSTOKEN = 2;

	// Utilities
	private $zendeskapi = null;

	public function __construct() {
		$this->initGlobalScope();
	}



	public function initGlobalScope() {
		$this->API_URL = coreBOS_Settings::getSetting(self::KEY_API_URL, '');
		$this->mailup_client_id = coreBOS_Settings::getSetting(self::KEY_ACCESSID, '');
		$this->mailup_client_secret = coreBOS_Settings::getSetting(self::KEY_ACCESSSECRET, '');
		$this->mailup_username = coreBOS_Settings::getSetting(self::USERNAME, '');
		$this->mailup_password = coreBOS_Settings::getSetting(self::PASSWORD, '');
	}

	public function saveSettings($isactive, $API_URL, $clientId, $clientSecret, $mailup_username, $mailup_password) {
		coreBOS_Settings::setSetting(self::KEY_ISACTIVE, $isactive);
		coreBOS_Settings::setSetting(self::KEY_API_URL, $API_URL);
		coreBOS_Settings::setSetting(self::KEY_ACCESSID, $clientId);
		coreBOS_Settings::setSetting(self::KEY_ACCESSSECRET, $clientSecret);
		coreBOS_Settings::setSetting(self::USERNAME, $mailup_username);
		coreBOS_Settings::setSetting(self::PASSWORD, $mailup_password);

		$mailUp = new MailUpClient(self::authData($clientId, $clientSecret));
		$mailUp->retrieveTokenByPassword($mailup_username, $mailup_password);

		global $adb;
		$em = new VTEventsManager($adb);
		if (self::useEmailHook()) {
			$em->registerHandler('corebos.filter.systemEmailClass.getname', 'include/integrations/mailup/Mailup.php', 'corebos_mailup');
		} else {
			$em->unregisterHandler('corebos_mailup');
		}
	}

	public function getSettings() {
		return array(
			'isActive' => coreBOS_Settings::getSetting(self::KEY_ISACTIVE, ''),
			'API_URL' => coreBOS_Settings::getSetting(self::KEY_API_URL, 'https://services.mailup.com/Authorization/OAuth/LogOn'),
			'mailup_client_id' => coreBOS_Settings::getSetting(self::KEY_ACCESSID, ''),
			'mailup_client_secret' => coreBOS_Settings::getSetting(self::KEY_ACCESSSECRET, ''),
			'mailup_username' => coreBOS_Settings::getSetting(self::USERNAME, ''),
			'mailup_password' => coreBOS_Settings::getSetting(self::PASSWORD, '')
		);
	}

	public function isActive() {
		$isactive = coreBOS_Settings::getSetting(self::KEY_ISACTIVE, '0');
		return ($isactive=='1');
	}


	public static function sendEMail(
		$to_email,
		$from_name,
		$from_email,
		$subject,
		$contents,
		$cc = '',
		$bcc = '',
		$attachment = '',
		$emailid = '',
		$logo = '',
		$replyto = '',
		$qrScan = '',
		$brScan = ''
	) {
		global $adb, $log;
		$inBucketServeUrl = GlobalVariable::getVariable('Debug_Email_Send_To_Inbucket', "");
		if (!empty($inBucketServeUrl)) {
			require_once 'modules/Emails/mail.php';
			require_once 'modules/Emails/Emails.php';
			return send_mail('Email', $to_email, $from_name, $from_email, $subject, $contents, $cc, $bcc, $attachment, $emailid, $logo, $replyto, $qrScan, $brScan);
		} else {
			// CREATING MESSAGE
			$messageId = self::createEmailMessage($subject, $contents, $to_email, $from_name, $from_email);
			//ATTACHEMENTS

			//SEND
			$response = self::sendMessage($messageId, $to_email, $from_name, $from_email);

			return 1;
		}
	}

	public static function createEmailMessage($subject, $contents, $to_email, $from_name, $from_email) {
		global $log;
		if (self::sendVerify($to_email, $from_email)) {
			$message = array(
			"Subject" => $subject,
			"idList" => "1",
			"Content" => $contents,
			"Embed" => true,
			"IsConfirmation" =>true,
			"Fields" => [],
			"Notes" => "",
			"Tags" => [],
			"TrackingInfo" => array(
				"CustomParams" => "",
				"Enabled" => true,
				"Protocols" => [
					"http"
				]
			)
			);

			$response = static::mailUpServerCall(json_encode($message), '/Console/List/1/Email');
			return $response['idMessage'];
		}
	}

	private static function sendMessage($messageId, $to_email, $from_name, $from_email) {
		global $adb,$log;
		$rs = $adb->pquery('select first_name,last_name from vtiger_users where user_name=?', array($from_name));
		if ($adb->num_rows($rs) > 0) {
			$from_name = decode_html($adb->query_result($rs, 0, 'first_name').' '.$adb->query_result($rs, 0, 'last_name'));
		}
		if (!is_array($to_email)) {
			$to_email = trim($to_email, ',');
			$to_email = explode(',', $to_email);
		}
		if (empty($cc)) {
			$cc = array();
		}
		// if (!is_array($cc)) {
		// 	$cc = self::setSendGridCCAddress($cc);
		// }
		// if (empty($bcc)) {
		// 	$bcc = array();
		// }
		// if (!is_array($bcc)) {
		// 	$bcc = self::setSendGridCCAddress($bcc);
		// }

		if (self::sendVerify($to_email[0], $from_email)) {
			$data = array(
				"Email" => $to_email[0],
				"idMessage" => $messageId
			);

			return self::mailUpServerCall(json_encode($data), '/Console/Email/Send');
		}
	}

	private static function sendVerify($to_email, $from_email) {
		return $to_email == $from_email ? 0 : 1;
	}

	private static function authData($clientId, $clientSecret) {
		return array(
			'client_id' => $clientId,
			'secret_key' => $clientSecret,
			'callback_url' => self::callBackUrl(),
		);
	}

	private static function callBackUrl() {
		return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']
			=== 'on' ? "https" : "http") . "://" .
			$_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	}



	private static function mailUpServerCall($data, $path) {
		$mailUp = new MailUpClient(self::authData(coreBOS_Settings::getSetting(self::KEY_ACCESSID, ''), coreBOS_Settings::getSetting(self::KEY_ACCESSSECRET, '')));
		$result = $mailUp->getResult(
			"POST",
			"JSON",
			$data,
			"Console",
			$path,
			"testing"
		);
		return $result;
	}

	public static function emailServerCheck() {
		return self::useEmailHook();
	}

	public static function useEmailHook() {
		global $log;
		$sendgrid = coreBOS_Settings::getSetting(self::KEY_ISACTIVE, '0');
		$usetrans = coreBOS_Settings::getSetting(self::KEY_ACCESSID, '0');
		return ($sendgrid != '0' && $usetrans != '0');
	}

	public function handleFilter($handlerType, $parameter) {
		if ($handlerType == 'corebos.filter.systemEmailClass.getname' && corebos_mailup::useEmailHook()) {
			return array('corebos_mailup', 'include/integrations/mailup/Mailup.php');
		} else {
			return $parameter;
		}
	}
}
?>