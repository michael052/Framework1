<?php
Class Controller_Menu{
    private function __construct() {}

    private static $_instance;
    public static function instance () {
		if(!isset(self::$_instance))
			self::$_instance = new self();
		return self::$_instance;
	}

	public function printIconHTML($row){
    for($i=0; $i<count($row);$i++){
		$strHtml .= '<a href="'.SERVER.$row[$i]['link'].'" 
					title="'.$row[$i]['title'].'" onclick="document.getElementById(\''.$row[$i]['link'].'\').style.display=\'inline\'; return false;" >
					<img src="'.SERVER.'images/'.$row[$i]['pic'].
					'"  alt="'.$row[$i]['title'].'" 
					height="55px"/>
					<span>'.$row[$i]['title'].'</span>
					<div class="clear"></div></a>'."\n";
	}
    return $strHtml;
    }

	public function printIconNav($row){
    for($i=0; $i<count($row);$i++){
	if($row[$i]['link']=="panel")
		$strHtml .= '<a id="panel" href="'.SERVER.$row[$i]['link'].'" 
					title="'.$row[$i]['title'].'" style="z-index:99;" onclick="showPanel(); return false;">
					<img src="'.SERVER.'images/'.$row[$i]['pic'].
					'"  alt="'.$row[$i]['title'].'" 
					height="50px" />
					<span id="SpnPnl">'.$row[$i]['title'].'</span>
					<div class="clear"></div></a>'."\n";
	else
		$strHtml .= '<a href="'.SERVER.$row[$i]['link'].'" 
				title="'.$row[$i]['title'].'">
				<img src="'.SERVER.'images/'.$row[$i]['pic'].
				'"  alt="'.$row[$i]['title'].'" 
				height="50px"/>
				<span>'.$row[$i]['title'].'</span>
				<div class="clear"></div></a>'."\n";
	}
    return $strHtml;
    }

	public function printIconHTML2($row){
    for($i=0; $i<count($row);$i++){
		$strHtml .= '<a href="'.SERVER.$row[$i]['link'].'" title="'.$row[$i]['title'].'">
					<img src="'.SERVER.'images/'.$row[$i]['pic'].
					'"  alt="'.$row[$i]['title'].'" 
					height="55px"/>
					<span>'.$row[$i]['title'].'</span>
					<div class="clear"></div></a>'."\n";
	}
    return $strHtml;
    }

    public function printHTML($row){
        $strHtml = "<ul>";
		$let="";
    foreach ($row as $key => $value){
	$DB = Dbconnect::instance()->getConnect();
	$type = $DB->SelectCell('SELECT typeLink FROM menu WHERE link="'.$value.'"');
	if($type == 0)
		$strHtml .= '<li><a href="'.SERVER.$value.'">'.$key.'</a></li>'."\n";
	else if($type==1)
		$strHtml .= '<li><a target="_blank" href="'.$value.'">'.$key.'</a></li>'."\n";
	else if($type==2)
		$strHtml .= '<li><a href="'.SERVER.$value.'" onmouseout="changeSel(\''.SERVER.'\');" onmouseover="showElement(\''.$value.'-menu\', this, \''.SERVER.'\');" >'.$key.'</a></li>'."\n";
    }

    $strHtml .= "</ul>";
    return $strHtml;
    }

    public function printHTMLArticle($row){
        $strHtml = "<ul>";
		$let="";
    foreach ($row as $key => $value){
	if($let!=mb_substr(ucfirst($key),0,1,'UTF-8'))
	{
		$let=mb_substr(ucfirst($key),0,1,'UTF-8');
		$strHtml .= '<h3 style="text-align:left;">'.$let.'</h3>';
	}
	$DB = Dbconnect::instance()->getConnect();
	$type = $DB->SelectCell('SELECT typeLink FROM menu WHERE link="'.$value.'"');
	if($type == 0)
		$strHtml .= '<li><a href="'.SERVER.$value.'">'.$key.'</a></li>'."\n";
	else if($type==1)
		$strHtml .= '<li><a target="_blank" href="'.$value.'">'.$key.'</a></li>'."\n";
	else if($type==2)
		$strHtml .= '<li><a href="'.SERVER.$value.'" onmouseout="changeSel(\''.SERVER.'\');" onmouseover="showElement(\''.$value.'-menu\', this, \''.SERVER.'\');" >'.$key.'</a></li>'."\n";
    }

    $strHtml .= "</ul>";
    return $strHtml;
    }

	public function CreateMenu($start, $finish ,$access)
	{
	$DB = Dbconnect::instance()->getConnect();
	$cat = $DB->select('SELECT Name, NumCat FROM Categoria WHERE NumCat >= '.$start.' AND NumCat <='.$finish);

	for ($i =0; $i<count($cat); $i++){

	$row = Model_Menu::query('SELECT title AS ARRAY_KEY, link FROM ?_menu WHERE idParent = '.$cat[$i]['NumCat'].' AND access<='.$access.' ORDER BY `order` ASC');
	if($row!=null)
	{
	$StrHTML .= '<h3>'.$cat[$i]['Name'].'</h3>';
	$text = Controller_Menu::instance();
	$StrHTML .= $text->printHTML($row);
	}
	}
	return $StrHTML;
	}

	public function CreateIconMenu($start, $finish ,$access)
	{
		$DB = Dbconnect::instance()->getConnect();
		$cat = $DB->select('SELECT Name, NumCat FROM Categoria WHERE NumCat >= '.$start.' AND NumCat <='.$finish);

		for ($i =0; $i<count($cat); $i++){
			$row = $DB->select('SELECT title, link, pic FROM icon_menu WHERE idParent = '.$cat[$i]['NumCat'].' AND access<='.$access.' ORDER BY `order` ASC');
			if($row!=null)
			{
				$StrHTML .= '<div class="pnl"><h3 style="text-align:left; font-size:26px;">'.$cat[$i]['Name'].'</h3>';
				$text = Controller_Menu::instance();
				$StrHTML .= $text->printIconHTML2($row).'<div class="cleare"></div></div>';
			}
		}
		return $StrHTML;
	}

	public function CreatePodMenu($start, $finish ,$access)
	{
	$DB = Dbconnect::instance()->getConnect();
	$cat = $DB->select('SELECT Name, NumCat FROM Categoria WHERE NumCat >= '.$start.' AND NumCat <='.$finish);

	for ($i =0; $i<count($cat); $i++){

	$row = Model_Menu::query('SELECT title AS ARRAY_KEY, link FROM ?_menu WHERE idParent = '.$cat[$i]['NumCat'].' AND access<='.$access.' ORDER BY `order` ASC');
	if($row!=null)
	{
	$StrHTML .= '<div class="podmenu"><h3>'.$cat[$i]['Name'].'</h3>';
	$text = Controller_Menu::instance();
	$StrHTML .= $text->printHTML($row).'</div>';
	}
	}
	return $StrHTML;
	}

    public function printHTMLH6($row){
    foreach ($row as $key => $value){
    $strHtml .= '<h6><a href="'.SERVER.$value.'">'.$key.'</a></h6>'."\n";
    $strHtml .= "<ul></ul>";
    }

    return $strHtml;
    }

    public function printHTMLNoAccess($row){
        $strHtml = "<ul>";

    foreach ($row as $key => $value){
    $strHtml .= '<li>'.$key.'</li>'."\n";
    }

    $strHtml .= "</ul>";
    return $strHtml;
    }

    public function printHTMLFriend($row){
        $strHtml = "<ul>";

    foreach ($row as $key => $value){
    $strHtml .= "<li><a target=\"_blank\" href=\"http://$value\">$key</a></li>";
    }

    $strHtml .= "</ul>";
    return $strHtml;
    }

    public function printHTMLTesting($row){
        $strHtml = "<ul>";
    $DB = Dbconnect::instance()->getConnect();

    foreach ($row as $key => $value){
    $row = $DB->selectcell('SELECT activate FROM ?_testing WHERE name="'.$key.'"');

        if ($value != "" or $key != "")
             if ($row!=0)
                  $strHtml .= '<li><a target="_blank" href="'.SERVER.$value.'">'.$key.'</a></li>'."\n";
             else
                  $strHtml .= '<li>'.$key.'     <img src="'.SERVER.'images/lock.gif" height="20px" weight="20px" title="���� ������ ��� �����������" /> </li>'."\n";

    }

    $strHtml .= "</ul>";
    return $strHtml;
    }


}