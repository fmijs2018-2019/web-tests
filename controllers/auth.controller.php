<?php

class AuthController extends Controller
{

	protected $auth;
	protected $repo;

	public function __construct()
	{
		$this->auth = new Auth();
		$this->repo = new Repository();
	}

	public function login()
	{
		var_dump($_SESSION, $_COOKIE);
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
		$this->auth->handleLogin();
		$url = Config::get('site_url');
		header("Location: $url/auth/profile");
		die();
	}

	public function _401View()
	{
		$view = $this->withLayout(
			new View(array(), VIEWS_PATH . DS . 'auth' . DS . '401.html')
		);
		echo $view->render();
	}

	public function profileView()
	{
		$user = $this->auth->getUser();
		$accessToken = $this->auth->getAccessToken();
		$idToken = $this->auth->getIdToken();
		$testResults = $this->repo->getTestResultsByUserId($user['sub']);

		$data = array();
		$data['user'] = $user;
		$data['solvedTests'] = count($testResults);
		$data['testResults'] = $testResults;
		// $data['accessToken'] = $accessToken;
		// $data['idToken'] = $idToken;

		$view = $this->withLayout(
			new View($data, VIEWS_PATH . DS . 'auth' . DS . 'profile.html')
		);
		$content = $view->render();
		echo $content;
	}
}
