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
		$contoller->profile();
	});
});

// home routes
$router->mount('/home', function () use ($router) {
	$contoller = new HomeController();

	$router->get('/index', function () use ($contoller) {
		$contoller->index();
	});

	$router->get('/', function () use ($contoller) {
		$contoller->index();
	});
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
		$contoller->solve($id);
	});

	$router->get('/(\d+)/edit', function ($id) use ($contoller) {
		$contoller->edit($id);
	});

	$router->get('/', function () use ($contoller) {
		$contoller->index();
	});
});

$router->get('', function () {
	$contoller = new HomeController();
	$contoller->index();
});


$router->run();
// App::run($_SERVER['REQUEST_URI']);
