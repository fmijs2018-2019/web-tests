<?php

class AuthController extends Controller
{

	protected $auth;

	public function __construct()
	{
		$this->auth = new Auth();
	}

	public function login()
	{
		$auth = new Auth();
		$auth->login();
		echo 'login...';
	}

	public function logout()
	{
		$this->auth->logout();
		echo 'logout...';
	}

	public function callback()
	{
		$user = $this->auth->handleLogin();
		$url = Config::get('site_url');
		header("Location: $url/auth/profile");
		die();
	}

	public function profile()
	{
		$user = $this->auth->getUser();
		$accessToken = $this->auth->getAccessToken();
		$idToken = $this->auth->getIdToken();

		$data = array();
		$data['user'] = $user;
		$data['accessToken'] = $accessToken;
		$data['idToken'] = $idToken;

		$view = $this->withLayout(
			new View($data, VIEWS_PATH.DS.'auth'.DS.'profile.html')
		);
		$content = $view->render();
		echo $content;
	}
}
