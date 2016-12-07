<?php
error_reporting(E_ALL ^ E_NOTICE);

$cnf = Config::instance();
$cnf->set('base_uri',''); # базовый урл от которого идёт сайт
$cnf->set('dev_mode',0);

$cnf->set('view_ext','.php'); # расширение для файлов вида
$cnf->set('default_layout','default'); # шаблон по умолчанию
$cnf->set('qz_output',1); # включение сжатия
$cnf->set('errors_in_files',1); # вывод ошибок в файл
$cnf->set('cache_lifetime',60*60*24); # максимальное время жизни кэша

unset($cnf);