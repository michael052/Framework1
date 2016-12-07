<?php

define('APP_PATH', realpath('../'));

define('LIB_PATH', realpath('../../lib'));

define('DS',DIRECTORY_SEPARATOR);

define('CACHE_ROOT',APP_PATH.DS.'temp'.DS.'cache');
define('LOGS_ROOT',APP_PATH.DS.'temp'.DS.'logs');
define('TEMP',APP_PATH.DS.'temp');

define('TABLE_PREFIX','');
define('SERVER','http://mypracticwork.esy.es/');
ini_set('session.cookie_lifetime', 0);

include_once APP_PATH.DS.'config'.DS.'bootstrap.php';