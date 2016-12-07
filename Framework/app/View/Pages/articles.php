<?php
$DB = Dbconnect::instance()->getConnect();
    $user = $DB->select('SELECT * FROM `article`');
    echo ($user);
?>	