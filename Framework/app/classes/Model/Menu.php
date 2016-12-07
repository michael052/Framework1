<?php
class Model_Menu
{
    private function __construct(){}
    public static function go()
    {
        return Dbconnect::instance()->getConnect()->query("SELECT * FROM `menu`");
    }
}