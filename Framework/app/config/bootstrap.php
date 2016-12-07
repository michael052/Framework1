<?php

$includePath = array(LIB_PATH, APP_PATH.DS.'classes', get_include_path());
$includePath = implode(PATH_SEPARATOR,$includePath);
set_include_path($includePath);

require_once 'PEAR'.DS.'NameScheme'.DS.'Autoload.php';

include_once APP_PATH.DS.'config'.DS.'app_conf.php';
include_once APP_PATH.DS.'config'.DS.'routes.php';
include_once LIB_PATH.DS.'function.php'; # подключение функции className2fileName и др. вспомогательных функций
include_once APP_PATH.DS.'config'.DS.'db_conf.php';

$router = Routing_Router::instance();
$route = $router->getRoute($_SERVER['REQUEST_URI']);

errorReporting();
dispatch($route); # запускаем функцию dispatch


 # запуск функции отчёта об ошибках
/* При dev_mode = 0 в зависимости от errors_in_files будут или не будут печататься
 * ошибки в файл
 * При dev_mode = 1, errors_in_files не влияет
 */