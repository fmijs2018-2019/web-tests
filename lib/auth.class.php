<?php

use Auth0\SDK\Auth0;
use Auth0\SDK\Exception\CoreException;
use Auth0\SDK\Exception\ApiException;
use Auth0\SDK\JWTVerifier;

class Auth
{
	protected $auth;

	public function __construct()
	{
		$this->auth0 = new Auth0([
			'domain' => Config::get('auth_domain'),
			'client_id' => Config::get('auth_client_id'),
			'client_secret' => Config::get('auth_client_secret'),
			'redirect_uri' => 'http://localhost/auth/callback',
			'persist_id_token' => true,
			'persist_access_token' => true,
			'persist_refresh_token' => true,
		]);
	}

	public function login()
	{
		$this->auth0->login();
	}

	public function logout()
	{
		$this->auth0->logout();
	}

	public function handleLogin()
	{
		// sleep(5);
		// usleep(100000);
		try {
			$user = $this->auth0->getUser();
			return $user;
		} catch (CoreException $e) {
			// Invalid state or session already exists.
			echo date("Y-m-d H:i:s");
			echo $e->getMessage();
			throw $e;
		} catch (ApiException $e) {
			// Access token not present.
			echo date("Y-m-d H:i:s");
			echo $e->getMessage();
			throw $e;
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
