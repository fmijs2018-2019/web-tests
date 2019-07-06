<?php

use \Bramus\Router\Router;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('VIEWS_PATH', ROOT . DS . 'views');

require_once(ROOT . DS . 'vendor' . DS . 'autoload.php');
require_once(ROOT . DS . 'config' . DS . 'config.php');

$router = new Router();
$router->setBasePath('');

// auth routes
$router->mount('/auth', function () use ($router) {
	$contoller = new AuthController();

	$router->get('/login', function () use ($contoller) {
		$contoller->login();
	});

	$router->get('/logout', function () use ($contoller) {
		$contoller->logout();
	});

	$router->get('/callback', function () use ($contoller) {
		$contoller->callback();
	});

	$router->get('/profile', function () use ($contoller) {
		$contoller->profileView();
	});
});

$router->before('GET', '/auth/profile', function () {
	$auth = new Auth();
	$authController = new AuthController();
	if (!$auth->isAuthenticated()) { 
		$authController->_401View();
		exit();
	}
});

// home routes
$router->mount('/home', function () use ($router) {
	$contoller = new HomeController();

	$router->get('/about', function () use ($contoller) {
		$contoller->aboutView();
	});

	$router->get('/index', function () use ($contoller) {
		$contoller->indexView();
	});

	$router->get('/', function () use ($contoller) {
		$contoller->indexView();
	});
});

// result routes
$router->mount('/results', function () use ($router) {
	$contoller = new ResultController();

	$router->get('/(\d+)', function ($id) use ($contoller) {
		$contoller->detailedView($id);
	});

	$router->get('/index', function () use ($contoller) {
		// todo
		// $contoller->index();
	});

	$router->post('/submit', function () use ($contoller) {
		$contoller->submit();
	});
});

$router->before('GET|POST', '/results.*', function () {
	$auth = new Auth();
	$authController = new AuthController();
	if (!$auth->isAuthenticated()) { 
		$authController->_401View();
		exit();
	}
});

// test routes
$router->mount('/tests', function () use ($router) {
	$contoller = new TestController();

	$router->post('/upload', function () use ($contoller) {
		$contoller->upload();
	});

	$router->post('/(\d+)', function ($id) use ($contoller) {
		$contoller->update($id);
	});

	$router->get('/new', function () use ($contoller) {
		$contoller->uploadView();
	});

	$router->get('/(\d+)', function ($id) use ($contoller) {
		$contoller->solveView($id);
	});

	$router->get('/(\d+)/edit', function ($id) use ($contoller) {
		$contoller->editView($id);
	});

	$router->get('/', function () use ($contoller) {
		$contoller->indexView();
	});
});

$router->before('GET|POST', '/tests.*', function () {
	$auth = new Auth();
	$authController = new AuthController();
	if (!$auth->isAuthenticated()) { 
		$authController->_401View();
		exit();
	}
});

$router->get('', function () {
	$contoller = new HomeController();
	$contoller->indexView();
});


$router->run();
