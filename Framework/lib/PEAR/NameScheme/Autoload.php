<?php
    /*
     * Библиотека автозагрузки
     */

    require_once 'PHP/Autoload.php';
    require_once 'PEAR/NameScheme.php';

    class PEAR_NameScheme_Autoload{
        static function classAutoloader($classname){
            $fname = PEAR_NameScheme::name2path($classname);
            if($f = @fopen($fname, "r", true)){
                fclose($f);
                return include_once ($fname);
            }
            return false;
        }
    }

    PHP_Autoload::register(array("PEAR_NameScheme_Autoload", "classAutoloader"));

