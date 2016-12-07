<?php
$config = Dbconnect::instance();
$config->set(array(
    'host' => 'localhost',
    'user' => 'u489097905_admin',
    'pass' => '232962',
    'name' => 'u489097905_frime'
));
$config->connect();

unset($config);