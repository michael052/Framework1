<?php
Class Routing_Router{
    private static $_instance;
    
    private function __construct() {}
    private function __clone(){}
    
public static function instance(){
    if(empty (self::$_instance))
        self::$_instance = new self();
    return self::$_instance;
}

private $_routes = array();

public function connect($urlPattern, $route){
    $this->_routes[$urlPattern] = $route;
}
private $_controller = ''; #текущий контроллер
private $_action = ''; #текущее действие
private $_params = array(); #текущие параметры

public function getRoute($uri){
    $routes = $this->_routes; #заполнение $routes
    $baseUri = trim(Config::instance()->get('base_uri'),'/'); # обрезание пути до базового
    $uri = ltrim(substr(trim($uri, '/'),  strlen($baseUri)),'/'); # обрезание пути. путь без корневого каталога
	
    foreach($routes as $rUri => $rRoute){ # цикл для каждого элемента $routes
        $pattern = '`^'.$rUri.'$`i'; # задание маски для регулярного выражения
        
        if(preg_match($pattern, $uri)){  # сверка регулярного выражения с УРЛ          
            $route = preg_replace($pattern, $rRoute, $uri); # проводит замену в $uri по маске $pattern на $rRoute
            break;
        }
    }
    if(!isset($route)) # если пременная не существует возвращать false
        return false;
		
    $route = explode('/', $route); # строка $route разбивается на подстроки по разделителю /
    $this->_controller = ucfirst(array_shift($route)); # вырезаем элемент из массива и пишем большую первую букву
    $this->_action = array_shift($route); # вырезаем элемент из массива и тем самым сокращаем количество элементов массива
    $this->_params = $route; # вставляем то что осталось в _params
    return array( # возвращаем ассиативный массив как результат работы функции
        'controller' => $this->_controller,
        'action' => $this->_action,
        'params' => $this->_params
    );
}

public function controller(){
    return $this->_controller;
}
public function action(){
    return $this->_action;
}
public function params(){
    return $this->_params;
}
}