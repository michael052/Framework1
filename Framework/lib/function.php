<?php
// функция отправки письма с приложением
function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {
    $file = $path.$filename;
    $file_size = filesize($file);
    $handle = fopen($file, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $content = chunk_split(base64_encode($content));
    $uid = md5(uniqid(time()));
    $name = basename($file);
    $header = "From: ".$from_name." <".$from_mail.">\r\n";
    #$header .= "Reply-To: ".$replyto."\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
    $header .= "This is a multi-part message in MIME format.\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-type:text/html; charset=utf-8\r\n";
    $header .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
    $header .= $message."\r\n\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
    $header .= "Content-Transfer-Encoding: base64\r\n";
    $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
    $header .= $content."\r\n\r\n";
    $header .= "--".$uid."--";
    if (mail($mailto, $subject, "", $header)) {
        echo "mail send ... OK"."<br/>"; // or use booleans here
    } else {
        echo "mail send ... ERROR!";
    }
}

// функция генерации случайно строки
function generateString($length = 8){
  $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
  $numChars = strlen($chars);
  $string = '';
  for ($i = 0; $i < $length; $i++) {
    $string .= substr($chars, rand(1, $numChars) - 1, 1);
  }
  return $string;
}

 // функция превода текста с кириллицы в траскрипт
function encodestring($string){
    $table = array(
                'А' => 'A',
                'Б' => 'B',
                'В' => 'V',
                'Г' => 'G',
                'Д' => 'D',
                'Е' => 'E',
                'Ё' => 'Yo',
                'Ж' => 'Zh',
                'З' => 'Z',
                'И' => 'I',
                'Й' => 'J',
                'К' => 'K',
                'Л' => 'L',
                'М' => 'M',
                'Н' => 'N',
                'О' => 'O',
                'П' => 'P',
                'Р' => 'R',
                'С' => 'S',
                'Т' => 'T',
                'У' => 'U',
                'Ф' => 'F',
                'Х' => 'H',
                'Ц' => 'C',
                'Ч' => 'Ch',
                'Ш' => 'Sh',
                'Щ' => 'Csh',
                'Ь' => '',
                'Ы' => 'Y',
                'Ъ' => '',
                'Э' => 'E',
                'Ю' => 'Yu',
                'Я' => 'Ya',

                'а' => 'a',
                'б' => 'b',
                'в' => 'v',
                'г' => 'g',
                'д' => 'd',
                'е' => 'e',
                'ё' => 'yo',
                'ж' => 'zh',
                'з' => 'z',
                'и' => 'i',
                'й' => 'j',
                'к' => 'k',
                'л' => 'l',
                'м' => 'm',
                'н' => 'n',
                'о' => 'o',
                'п' => 'p',
                'р' => 'r',
                'с' => 's',
                'т' => 't',
                'у' => 'u',
                'ф' => 'f',
                'х' => 'h',
                'ц' => 'c',
                'ч' => 'ch',
                'ш' => 'sh',
                'щ' => 'csh',
                'ь' => '',
                'ы' => 'y',
                'ъ' => '',
                'э' => 'e',
                'ю' => 'yu',
                'я' => 'ya',
    );

    $output = str_replace(
        array_keys($table),
        array_values($table),$string
    );

    return $output;
} 

function calculate_time_difference($timestampl, $timestamp2, $time_unit)  { 
// Определяем разницу между двумя датами 
$timestampl = intval($timestampl); 
$timestamp2 = intval($timestamp2); 
if ($timestampl && $timestamp2)  {
$time_lapse = $timestamp2 - $timestampl;

$seconds_in_unit = array(
“second => 1,
“minute” => 60,
“hour” => 3600,
“day” => 86400,
“week” => 604800,
);

if ($seconds_in_unit[$time_unit])  {
return floor($time_lapse/$seconds_in_unit[$time_unit]);
}
}
return false; 
}

// генерация паролей
function generatePass(){
$chars="qazxswedcvfrtgbnhyujmkiolp1234567890";

// Количество символов в пароле.

$max=8;

// Определяем количество символов в $chars
$size=StrLen($chars)-1;

// Определяем пустую переменную, в которую и будем записывать символы.

$password=null;

// Создаём пароль.
while($max--)
	$password.=$chars[rand(0,$size)]; 
	
return $password;
}

function className2fileName($name){
    # замена символов для путей
    $fromSimple = array('_A','_B','_C','_D','_E','_F','_G','_H',
                        '_I','_J','_K','_L','_M','_N','_O','_P',
                        '_Q','_R','_S','_T','_U','_V','_W','_X',
                        '_Y','_Z');
    $fromCompound = array('A','B','C','D','E','F','G','H',
                        'I','J','K','L','M','N','O','P',
                        'Q','R','S','T','U','V','W','X',
                        'Y','Z','1','2','3','4','5','6','7','8','9','0');
    $toSimple = array(DS.'a',DS.'b',DS.'c',DS.'d',DS.'e',DS.'f',DS.'g',DS.'h',
        DS.'i',DS.'j',DS.'k',DS.'l',DS.'m',DS.'n',DS.'o',DS.'p',DS.'q',DS.'r',
        DS.'s',DS.'t',DS.'u',DS.'v',DS.'w',DS.'x',DS.'y',DS.'z');
   $toCompound = array('_a','_b','_c','_d','_e','_f','_g','_h',
        '_i','_j','_k','_l','_m','_n','_o','_p','_q','_r',
        '_s','_t','_u','_v','_w','_x','_y','_z','_1','_2','_3','_4',
       '_5','_6','_7','_8','_9','_0'); 
   $from = array_merge($fromSimple,$fromCompound);
   $to = array_merge($toSimple,$toCompound);
   $fileName = ltrim(str_replace($from, $to, $name),'_');
   return $fileName; # возвращение изменнёного пути
}

function _strtolower($string){
    $small = array('а','б','в','г','д','е','ё','ж','з','и','й',
                   'к','л','м','н','о','п','р','с','т','у','ф',
                   'х','ч','ц','ш','щ','э','ю','я','ы','ъ','ь',
                   'э', 'ю', 'я');
    $large = array('А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й',
                   'К','Л','М','Н','О','П','Р','С','Т','У','Ф',
                   'Х','Ч','Ц','Ш','Щ','Э','Ю','Я','Ы','Ъ','Ь',
                   'Э', 'Ю', 'Я');
    return str_replace($large, $small, $string); 
}

function errorPath($text){
		$controllerClass = 'Controller_Pages';
        $refl = new ReflectionClass($controllerClass);
        $controller = $refl->newInstance(); # создаём экземпляр класса $refl
        $action = $refl->getMethod('error'); # в переменную $action
                                            //возвращаем объект класса ReflectionMethod() 
        $action->invokeArgs($controller, array($text));
		exit();
}

function UpText($text){
	return str_replace("\n","<br/>",str_replace(array("\r\n", "\n\r"), "\n", str_replace(">", "&gt;", str_replace("<", "&lt;", $text))));
}

function UpText2($text){
	return str_replace("<br/>","</p><p>",$text);
}

// преобразует слово в столбик для HTML
function WordInCol($text)
{
	$otvet="";
	for($i=0;$i<mb_strlen($text,"utf-8");$i++)
	{
		$otvet .=  mb_substr($text,$i,1,"utf-8")."<br/>";
	}
	return $otvet;
}

function dispatch($route){
   #echo "<pre>"; echo var_dump($route); echo "</pre>";

    if(empty($route)){
	errorPath('Страница с таким адресом не существует. <br /> <br /> Код ошибки 4343 - Enter false rout.'); 
	# Если в качестве раута пришел false, то выведем сообщение о
    //несуществующей странице на экран и остановим дальнейшее выполнение сценария
        //exit('Error 404 - Страницы не существует.');
    }

    $controllerClass = 'Controller_'.$route['controller']; # формируем имя контроллера
                                                            //записываем в  переменную $controllerClass

    if(class_exists($controllerClass)) # если класс объявлен, создаём объект $refl
        $refl = new ReflectionClass($controllerClass);
    else
        errorPath('Страница с таким адресом не существует. <br /> <br /> Код ошибки 4332 - Class not found.');

    if ($refl->hasMethod($route['action'])){ # если есть метод действия в классе то продожаем работу
                                             // иначе прекращаем работу сценария
        $controller = $refl->newInstance(); # создаём экземпляр класса $refl
        $action = $refl->getMethod($route['action']); # в переменную $action
                                                        //возвращаем объект класса ReflectionMethod()

        if($action->getNumberOfRequiredParameters() > count($route['action'])) # проверка на количество параметров      
			errorPath('Страница с таким адресом не существует. <br /> <br /> Код ошибки 4321 -  Erroneous number of parameters.');  # прекращение сценария
        else{
			#echo "<pre>"; echo var_dump($controller, $action); echo "</pre>";
			$action->invokeArgs($controller,$route['params']);
		} # вызываем функцию аргументов
    }else{
		errorPath('Страница с таким адресом не существует. <br /> <br /> Код ошибки 4310 -  Error load controller and action.'); 
	}
        
}

/*
*	Функция обработки ошибок
*/
/*Проверяем параметр настройки
dev_mode, если значение установлено 1, то при помощи встроенной функции
ini_set() устанавливаем значение для
display_errors = On, а для log_errors = Off, т.е.
Если включен режим отладки, то включаем 
отображение ошибок на экране и отключаем ведение лог-файлов. 
Если отключен режим разработки (параметр dev_mode установлен = 0),
то ошибки (за исключением грубых, синтаксических) не выводим
на экран и устанавливаем каталог для хранения лог-файлов (в нашем случае это app/temp/logs).
Ошибки за отдельные дни будут собираться в отдельные файлы, для этого к имени файла добавлена
текущая дата.

В файле app/config/app_conf.php установите параметр настройки
dev_mode = 0, а настройки errors_in_files = 1. Все ошибки (не синтаксические)
теперь будут выводиться не на
экране, а записываться в лог-файл.
*/
function errorReporting(){
if (Config::instance()->get('dev_mode') == 1) {
    ini_set('display_errors', 'On');
    ini_set('log_errors' , 'Off') ;
} else {
ini_set('display_errors', 'Off' );
ini_set('error_log' , LOGS_ROOT.DS.'errors_'.date("Y_m-d").'.log');

    if (Config::instance()->get('errors_in_files') == 1){
        ini_set('log_errors','On');
    } else {
        ini_set('log_errors', 'Off');
    }
}
}

function databaseErrorHandler($message,$info){
    if(!errorReporting()) return;
    
    echo "SQL Error: $message<br /><pre>";
    print_r($info);
    echo "</pre>";
    exit();
}