<?php
class View_Class{
    # выведется путь файла вида, который формируется в зависимости от занесённых роутов

    private $_conf; # перменная с конфигурацией
    
    private $_layout = ''; # пременная шаблона
    private $_view = '';   # пременная вида

    private $_vars = array(); # массив для хранения видов
    private $_render; # перменная для выяснения состояния рендера либо true либо false

    public function render($title, $meta_k = "", $meta_d = "", $render = true){
        if($render===false) # проверка какой параметр передан
            $this->_render = false; # если false тогда запсываем false во флаг состояния _render
        if($this->_render === false) # если _render равен false функция возвращает false
            return false;

        $ext = $this->_conf->get('view_ext'); # достаём из _conf по ключу 'view_ext' значение расширения
        
        $this->_layout = APP_PATH.DS.'View'.DS.'_layout'.DS.$this->_layout.$ext; # формируем путь для шаблона
        $this->_view = APP_PATH.DS.'View'.DS.$this->_view.$ext; # формируем путь для вида

        unset ($ext,$render); # выгружаем $ext и $render
        extract($this->_vars, EXTR_OVERWRITE); # при совпадении ключа в массиве _vars производить перезаписывания

        ob_start(); # включаем сохранения выводимого текста в буфер
        include $this->_view; # подключаем файл вида
        $content_for_layout = ob_get_clean(); # записываем в переменную то что хранится в буфере
                                    //и очищаем буфер вывода
		
		$files = scandir(APP_PATH.DS.'View'.DS.'_element'.DS);
		foreach($files as $val)
		{
			if($val!="." and $val != "..")
			{
				ob_start(); # включаем сохранения выводимого текста в буфер
				include APP_PATH.DS.'View'.DS.'_element'.DS.$val; # подключаем файл вида
				$variable[basename($val,".php")] = ob_get_clean();
			}
		}
		extract($variable, EXTR_OVERWRITE, "new_");
		/*ob_start(); # включаем сохранения выводимого текста в буфер
        include APP_PATH.DS.'View'.DS.'_element'.DS.'menu.php'; # подключаем файл вида
        $menu = ob_get_clean();

		ob_start(); # включаем сохранения выводимого текста в буфер
        include APP_PATH.DS.'View'.DS.'_element'.DS.'menu2.php'; # подключаем файл вида
        $menu2 = ob_get_clean();

		ob_start(); # включаем сохранения выводимого текста в буфер
        include APP_PATH.DS.'View'.DS.'_element'.DS.'menu3.php'; # подключаем файл вида
        $menu3 = ob_get_clean();
		
		ob_start(); # включаем сохранения выводимого текста в буфер
        include APP_PATH.DS.'View'.DS.'_element'.DS.'icon_menu.php'; # подключаем файл вида
        $icon_menu = ob_get_clean();
		*/
		
        if($this->_conf->get('qz_output')===1) # проверяем что хранится под ключом qz_output
                                                //(отвечает за включения сжатия)
            ob_start (); # включение записи в буфер
            //с параметром ob_qzhandler для облегчения предачи сжатых данных
            //в случае если php ниже 4.0.5 начинается просто запись в буфер
        else
            ob_start(); # просто включение записи в буфер если сжатие отключено
    
        include_once $this->_layout; # включение файла шаблона в буфер
  
        header('Content-length: '.ob_get_length()); # отправка шапки куда записана длина контента
        $this->_render = false; # выключение флага рендера
    }
	
    public function __construct($layout ='',$view = '') { # конструктор класса
        $this->_conf = config::instance(); # заполнение _conf из статической пременной
        $this->_layout = !empty($layout) ? $layout :
            $this->_conf->get('default_layout'); # если $layout пустой то по ключу вытаскиваем шаблон по умолчанию
        if(!empty ($view)){
            $this->_view = $view; # если $view не пустой то заносим в _view
        } else {
            $router = Routing_Router::instance();
            $this->_view = className2fileName($router->controller())
                    .DS.$router->action(); # иначе формируем при помощи роутов путь к виду
        }
    }
    
	public function set($var, $value = ''){ # функция для заполнения _vars
        if(is_array($var)){
            $keys = array_keys($var);
            $values = array_values($var);
            $this->_vars = array_merge($this->_vars,  
                                        array_combine($keys, $values));
        }else {
            $this->_vars[$var] = $value;
        }
    }
    
    public function __set($key,$value){ # функция для заполнения _vars
        $this->_vars[$key] = $value;        
    }

    public function view($view){
        $this->_view = $view;
    }
    
	public function layout($layout){
        $this->_layout = $layout;
    }
}