<?php

require_once 'include/integrations/mailup/lib/DataFilter.php';
include_once 'vtlib/Vtiger/Net/Client.php';

class MailUpClient {

	private $clientId;
	private $secretKey;
	private $api = array();
	private $accessToken;
	private $refreshToken;
	private $tokenTime;
	private $errorUrl;

	const ACCESSTOKEN = 'mailup_access_token';
	const REFRESHTOKEN = 'mailup_refresh_token';
	const TOKENTIME = 'mailup_token_time';

	public function __construct($auth, $api = array()) {
		$this->clientId = $auth['client_id'];
		$this->secretKey = $auth['secret_key'];
		$this->api = $this->api();

		$this->loadToken();
	}

	public function getAccessToken() {
		return $this->accessToken;
	}

	public function getConsoleUrl() {
		return $this->api['console'];
	}

	public function getMailStatsUrl() {
		return $this->api['mail_stats'];
	}

	public function getErrorUrl() {
		return $this->errorUrl;
	}

	public function getTokenTime() {
		$time = $this->tokenTime;

		if (null !== $this->tokenTime) {
			$time = $this->tokenTime - time();
		}

		return $time;
	}

	public function logonByKey($callback) {
		$url = $this->api['logon'] . "?client_id=" . $this->clientId . "&client_secret=" . $this->secretKey . "&response_type=code&redirect_uri=" . $callback;
		header("Location: " . $url);
	}


	public function retrieveTokenByPassword($username, $password) {
		global $log;
		$username = DataFilter::convertToString($username);
		$password = DataFilter::convertToString($password);

		$body = 'grant_type=password&username=' . rawurlencode($username) . '&password=' . rawurlencode($password)
				. '&client_id=' .rawurlencode($this->clientId) .  rawurlencode($this->secretKey);
		$httpClient = new Vtiger_Net_Client($this->api['token']);
		$httpClient->setHeaders(array(
			'Content-type' => 'application/x-www-form-urlencoded',
			'Accept' => 'application/json',
			'Content-length' => strlen($body),
			'Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . $this->secretKey)
		));
		$httpClient->setBody($body);
		$result = $httpClient->doPost(false);
		$result = json_decode($result, true);

		$this->saveToken($result['access_token'], $result['refresh_token'], $result['expires_in']);
	}

	public function refreshToken() {
		global $log;
		$body = "client_id=" . rawurlencode($this->clientId) . "&client_secret=" . rawurlencode($this->secretKey)
				. "&refresh_token=" . rawurlencode($this->refreshToken) . "&grant_type=refresh_token";
		$httpClient = new Vtiger_Net_Client($this->api['token']);
		$httpClient->setHeaders(array(
			'Content-type' => 'application/x-www-form-urlencoded',
			'Accept' => 'application/json',
			'Content-length' => strlen($body),
		));
		$httpClient->setBody($body);
		$result = $httpClient->doPost(false);
		$result = json_decode($response, true);

		$this->saveToken($result['access_token'], $result['refresh_token'], $result['expires_in']);
	}


	public function makeRequest($method, $url, $content_type = "JSON", $body = "", $refresh = true) {
		global $log;
		$httpClient = new Vtiger_Net_Client($url);
		$content_type = ($content_type === "XML" ? "application/xml" : "application/json");
		$httpClient->setHeaders(array(
			'Content-type' => $content_type,
			'Accept' => $content_type,
			'Content-length' => strlen($body),
			'Authorization' =>'Bearer '. $this->accessToken,
		));
		$httpClient->setBody($body);
		$response = $httpClient->doPost(false);
		$response = json_decode($response, true);
		if (!empty($response['ErrorCode']) && $response['ErrorCode'] ==401) {
			$this->refreshToken();
			return $this->makeRequest($method, $url, $content_type, $body, false);
		}
		return $response;
	}

	private function loadToken() {
		$this->accessToken = coreBOS_Settings::getSetting(self::ACCESSTOKEN, '');
		$this->refreshToken = coreBOS_Settings::getSetting(self::REFRESHTOKEN, '');
		$this->tokenTime = coreBOS_Settings::getSetting(self::TOKENTIME, '');
	}

	private function clearToken() {
		$this->accessToken = null;
		$this->refreshToken = null;
		$this->tokenTime = null;

		coreBOS_Settings::setSetting(self::ACCESSTOKEN, $this->accessToken);
		coreBOS_Settings::setSetting(self::REFRESHTOKEN, $this->refreshToken);
		coreBOS_Settings::setSetting(self::TOKENTIME, $this->tokenTime);
	}

	private function saveToken($token, $refresh, $time) {
		$this->accessToken = $token;
		$this->refreshToken = $refresh;
		$this->tokenTime = time() + $time;
		coreBOS_Settings::setSetting(self::ACCESSTOKEN, $this->accessToken);
		coreBOS_Settings::setSetting(self::REFRESHTOKEN, $this->refreshToken);
		coreBOS_Settings::setSetting(self::TOKENTIME, $this->tokenTime);
	}

	public function getResult($method, $type, $body, $env, $ep, $text) {
		global $log;
		$url = "Console" === $env ? $this->api['console'] : $this->api['mail_stats'];
		$url = $url . $ep;
		$response = $this->makeRequest($method, $url, $type, $body);
		return $response;
	}

	private function api() {
		return array(
			'logon' => 'https://services.mailup.com/Authorization/OAuth/LogOn',
			'authorization' => 'https://services.mailup.com/Authorization/OAuth/Authorization',
			'token' => 'https://services.mailup.com/Authorization/OAuth/Token',
			'console' => 'https://services.mailup.com/API/v1.1/Rest/ConsoleService.svc',
			'mail_stats' => 'https://services.mailup.com/API/v1.1/Rest/MailStatisticsService.svc'
		);
	}
}