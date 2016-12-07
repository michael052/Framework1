<!DOCTYPE html> 
<html> 
<head> 
<title>Web-studio</title> 
<meta charset="utf-8"> 
<link rel="stylesheet" type="text/css" href="<?php echo SERVER; ?>style/style.css" /> 
</head> 
<body style="background-image:url(images/2.png); color:white; font-size:22px;";> 
<?php 
$DB = Dbconnect::instance()->getConnect(); 
$user = $DB->select('SELECT * FROM `article`'); 
foreach($user as $shit => $do) 
{ 
echo '<div class="aeticle">'; 
echo ("<h2>$do[title]</h2>"); 
echo("<h5>&#1057;&#1086;&#1079;&#1076;&#1072;&#1085;&#1086;: $do[created] | &#1048;&#1079;&#1084;&#1077;&#1085;&#1077;&#1085;&#1086;: $do[update]</h5>"); 
echo ("<p>$do[description]</p>"); 
echo '<div><br>'; 
} 
?>
<div class="menuu"><?php echo $menu;?></div>
</body> 
</html>
