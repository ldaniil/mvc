<?php

ini_set('display_errors', 0);

// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';

$session = new \Core\Session();
$session->start();

// Настраиваем модель
$dbConfig = require __DIR__ . '/configs/db.php';
$pdo = new PDO($dbConfig['dsn'], $dbConfig['user'], $dbConfig['pass']);
\Core\Model::setDb($pdo);

// Роутинг
$router = new \Core\Router();
$router->setNamespace('\App\Controllers');

// Настраиваем шаблонизатор
$views = __DIR__ . '/app/views'; // it uses the folder app/views to read the templates
$cache = __DIR__ . '/runtime/template/cache'; // it uses the folder runtime/template/cache to compile the result.
$blade = new \eftec\bladeone\BladeOne($views, $cache, \eftec\bladeone\BladeOne::MODE_AUTO);

$auth = new \Core\Auth($session);

// Настраиваем application
$request = Core\Request::createFromGlobals();;
$view = new \Core\View($blade, $auth);

$application = \Core\Application::getInstance(function(\Core\Application $application) use ($request, $view, $auth, $session){
	$application->setSession($session);
	$application->setRequest($request);
	$application->setAuth($auth);
	$application->setView($view);
});

// Роуты
$router->get('/', 'SiteController@index');
$router->post('/', 'SiteController@createTask');
$router->get('/update', 'SiteController@taskForm');
$router->post('/update', 'SiteController@updateTask');
$router->get('/login', 'AdministrationController@loginForm');
$router->post('/login', 'AdministrationController@login');
$router->get('/logout', 'AdministrationController@logout');

// Поехали!!!
$router->run();

if ($application->responseType == \Core\Application::RESPONSE_TYPE_REDIRECT) {
	$response = new \Symfony\Component\HttpFoundation\RedirectResponse($application->responseContent);
} elseif ($application->responseType == \Core\Application::RESPONSE_TYPE_HTML) {
	$response = new Symfony\Component\HttpFoundation\Response(
		'Content',
		Symfony\Component\HttpFoundation\Response::HTTP_OK,
		['content-type' => 'text/html']
	);
	$response->setContent($application->responseContent);
}

$response->send();


