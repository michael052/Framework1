<?php
    define("PEAR_NameScheme_ext", "php");
    define("PEAR_NameScheme_bar", "_");

    class PEAR_NameScheme{
        var $VERSION = "1.00";

        static function name2Path($classname, $absolutize = false){
            $fname = str_replace(PEAR_NameScheme_bar, '/', $classname)
                    .'.'.PEAR_NameScheme_ext;
            foreach (PEAR_NameScheme::getInc($absolutize) as $libDir) {
                $path = $libDir.'/'.$fname;
                if(file_exists($path)){
                    if(!$absolutize) return $fname;
                    else return $path;
                }
            }
            return false;
        }

        static function path2Name($path){
            if(preg_match('{^\w:|^[/\\\\]}s', $path)){
                $path = str_replace("\\", "/", realpath($path));
                $inc = PEAR_NameScheme::getInc(true);
                $found = false;
                foreach ($inc as $i) {
                    if(strpos($path, $i.'/') === 0){
                        $path = substr($path, strlen($i) + 1);
                        $found = true;
                        break;
                    }
                }
                if(!$found) return false;
            }
            $name = preg_replace("{[/\\\\]}s", PEAR_NameScheme_bar, $path);
            $name = preg_replace('/\.'.PEAR_NameScheme_ext.'$/s', '', $name);
            return $name;
        }

        static function getInc($absolutize = false){
            $sep = defined("PATH_SEPARATOR")? PATH_SEPARATOR :
                ((strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')? ";": ":");
            $inc = explode($sep, ini_get('include_path'));
            if($absolutize) $inc = array_map("realpath", $inc);
            return str_replace("\\", "/", $inc);
        }
    }