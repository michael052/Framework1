<?php
class Cache_Class{

private static $_instance;

private function __construct(){} # конструктор
private function __clone(){} # клонирование

public static function instance () {
    if(!isset(self::$_instance))
        self::$_instance = new self();
    return self::$_instance;
}

public function set($id, $data, $lifetime = 3600){ # устанавливает какие данные сколько будут хранится
#$id - �&#65533;дентификатор кеша, $data - данные, $lifetime - Время жизни кеша

$cacheFile = $this->cacheFullName($id); # по id получаем полное имя файла
file_put_contents($cacheFile, serialize($data)); # производим запись строки в файл
touch($cacheFile, (time() + intval($lifetime))); # Устанавливает время модификации файла на текущее + интервал

if(!is_file(CACHE_ROOT.DS.'cache_clean')){ # если файл не существует
    file_put_contents(CACHE_ROOT.DS.'cache_clean', ''); # создаём его
    touch(CACHE_ROOT.DS.'cache_clean' ,
    (time() + intval(Config::instance()->get('cache_lifetime'))));  # Устанавливает время модификации файла
}
}

public function get($id){ # загрузить данные из кэша и отобразить на экране

if(is_file(CACHE_ROOT.DS.'cache_clean') # если файл существует и время последнего именения меньше чем текущее
    AND filemtime(CACHE_ROOT.DS.'cache_clean') < time())
{
    $this->clean(); # производим очищение
}

$cacheFile = $this->cacheFullName($id); # по id получаем полное имя файла
if (file_exists($cacheFile)){ # при существовании файла
    if(filemtime($cacheFile) < time()) # и времени существовании меньше текущего времени
        $this->delete($id); # удаляем кэш файл по id
    else # иначе
        return unserialize(file_get_contents($cacheFile));
        # возвращаем PHP-значение из полученного содержимого файла
        //в виде одной строки
}
return false; # возвращаем false если файл не существет
}

public function delete($id){ # удаление кеша
$cacheFile = $this->cacheFullName($id); # получаем путь к файлу по id
unlink($cacheFile); # удаляем файл
}

private function cacheFullName($id) { # имя кэш файла
    return CACHE_ROOT.DS.rawurlencode($id).'.cache';
}

public function clean() { # очищение кэша через заданное время
// Получаем список всего, что есть в директории кэша 5
$files = scandir(CACHE_ROOT);
// Прокручиваем список в цикле
foreach ($files as $file){
// Удаляем все содержимое
if (($file !== '.' ) AND ($file !== '..'))
    unlink(CACHE_ROOT.DS.$file);
}

}
}