<?php

use Auth0\SDK\Auth0;
use Auth0\SDK\Exception\CoreException;
use Auth0\SDK\Exception\ApiException;
use Auth0\SDK\JWTVerifier;
use Auth0\SDK\API\Authentication;
use Firebase\JWT\JWT;

class Auth
{
	protected $auth;

	public function __construct()
	{
		$this->auth0 = new Auth0([
			'domain' => Config::get('auth_domain'),
			'client_id' => Config::get('auth_client_id'),
			'client_secret' => Config::get('auth_client_secret'),
			'redirect_uri' => Config::get('auth_login_url'),
			'persist_id_token' => true,
			'persist_access_token' => true,
			'persist_refresh_token' => true,

			// The scope determines what data is provided by the /userinfo endpoint.
			// There must be at least one valid scope included here.
			'scope' => 'openid profile email'
		]);
	}

	public function login()
	{
		try {
			$userinfo = $this->auth0->getUser();
		} catch (CoreException $e) {
			// Invalid state or session already exists.
			die($e->getMessage());
		} catch (ApiException $e) {
			// Access token not present.
			die($e->getMessage());
		}

		// No user information so redirect to the Universal Login Page.
		if (empty($userinfo)) {
			$this->auth0->login();
		}
	}

	public function logout()
	{
		$this->auth0->logout();

		$authentication = new Authentication(Config::get('auth_domain'));

		// Get the Auth0 logout URL to end the Auth0 session.
		$auth0_logout_url = $authentication->get_logout_link(
			Config::get('auth_logout_url'),
			Config::get('auth_client_id')
		);

		header('Location: ' . $auth0_logout_url);
		die();
	}

	public function handleLogin()
	{
		JWT::$leeway = 50;
		try {
			return $this->auth0->exchange();
		} catch (CoreException $e) {
			die($e->getMessage());
		} catch (ApiException $e) {
			die($e->getMessage());
		}
		// // Handle errors sent back by Auth0.
		// if (!empty($_POST['error']) || !empty($_POST['error_description'])) {
		// 	throw new Exception($_POST['error_description']);
		// }

		// // Nothing to do.
		// if (empty($_GET['code'])) {
		// 	throw new Exception('No authorization code found.');
		// }

		// // Validate callback state.
		// $session_store = new SessionStore();
		// $state_handler = new SessionStateHandler($session_store);
		// if (!isset($_GET['state']) || !$state_handler->validate($_GET['state'])) {
		// 	throw new Exception('Invalid state.');
		// }

		// // Instantiate the Authentication class with the client secret.
		// $auth0_api = new Authentication(
		// 	Config::get('auth_domain'),
		// 	Config::get('auth_client_id'),
		// 	Config::get('auth_client_secret'),
		// );

		// try {
		// 	// Attempt to get an access_token with the code returned and original redirect URI.
		// 	$code_exchange_result = $auth0_api->code_exchange($_GET['code'], Config::get('auth_login_url'));
		// 	var_dump($code_exchange_result);
		// } catch (Exception $e) {
		// 	// This could be an Exception from the SDK or the HTTP client.
		// 	die($e->getMessage());
		// }

		// try {
		// 	// Attempt to get an access_token with the code returned and original redirect URI.
		// 	$userinfo_result = $auth0_api->userinfo($code_exchange_result['access_token']);
		// } catch (Exception $e) {
		// 	die($e->getMessage());
		// }

		// // $session_store->set('user', $userinfo_result);
		// return $userinfo_result;
	}

	public function getUser()
	{
		try {
			return $this->auth0->getUser();
		} catch (CoreException $e) {
			return null;
		} catch (ApiException $e) {
			return null;
		}
	}

	public function getIdToken()
	{
		return $this->auth0->getIdToken();
	}

	public function getAccessToken()
	{
		return $this->auth0->getAccessToken();
	}


	public function getDecodedToken()
	{
		try {
			$verifier = new JWTVerifier([
				'supported_algs' => ['RS256'],
				'valid_audiences' => ['6e69b412-838a-4413-bdfb-29423dfcbf52'],
				'authorized_iss' => ['https://fmijs.eu.auth0.com/']
			]);

			$token = $this->getIdToken();
			return $verifier->verifyAndDecode($token);
		} catch (CoreException $e) {
			throw $e;
		}
	}

	public function isAuthenticated()
	{
		return $this->getUser() != null;
	}

	public function isAuthorized($scope)
	{
		$tokenInfo = $this->getDecodedToken();
		if ($tokenInfo) {
			$scopes = explode(" ", $this->tokenInfo->scope);
			foreach ($scopes as $s) {
				if ($s === $scope)
					return true;
			}
		}

		return false;
	}
}
