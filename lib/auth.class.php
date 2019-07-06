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


	public function checkJwt()
	{
		$requestHeaders = apache_request_headers();

		if (!isset($requestHeaders['authorization']) && !isset($requestHeaders['Authorization'])) {
			header('HTTP/1.0 401 Unauthorized');
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode(array("message" => "No token provided."));
			exit();
		}

		$authorizationHeader = isset($requestHeaders['authorization']) ? $requestHeaders['authorization'] : $requestHeaders['Authorization'];

		if ($authorizationHeader == null) {
			header('HTTP/1.0 401 Unauthorized');
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode(array("message" => "No authorization header sent."));
			exit();
		}

		$authorizationHeader = str_replace('bearer ', '', $authorizationHeader);
		$token = str_replace('Bearer ', '', $authorizationHeader);

		try {
			$verifier = new JWTVerifier([
				'supported_algs' => ['RS256'],
				'valid_audiences' => [Config::get('auth_client_id')],
				'authorized_iss' => [Config::get('auth_domain')]
			]);

			$this->tokenInfo = $verifier->verifyAndDecode($token);
		} catch (\Auth0\SDK\Exception\CoreException $e) {
			header('HTTP/1.0 401 Unauthorized');
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode(array("message" => $e->getMessage()));
			exit();
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
