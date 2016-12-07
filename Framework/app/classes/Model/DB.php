<?php
class Model_DB{
    private function __construct(){}
	
	public static function queryRow($query)
    {
        return Dbconnect::instance()->getConnect()->selectRow($query);
    }
	
	public static function query($query)
    {
        return Dbconnect::instance()->getConnect()->query($query);
    }
}